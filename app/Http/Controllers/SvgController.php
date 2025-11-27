<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

class SvgController extends Controller
{
    public function index()
    {
        $dir = public_path('svg_templates');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $templates = collect(glob($dir . DIRECTORY_SEPARATOR . '*.svg'))
            ->map(fn($f) => basename($f))
            ->values();

        return view('home', compact('templates'));
    }

    public function customize($template)
    {
        $path = public_path('svg_templates/' . $template);
        abort_unless(is_file($path), 404);

        return view('form', compact('template'));
    }

    public function generate(Request $request)
    {
        // 1) Validate form data (फोटो field नावे form शी match)
        $data = $request->validate([
            'template'   => 'required|string',
            'gname'      => 'required|string|max:200',
            'bname'      => 'required|string|max:200',
            'gadd'       => 'required|string|max:200',
            'badd'       => 'required|string|max:200',
            'day_date'   => 'required|string|max:200',
            'engday'     => 'nullable|string|max:100',
            'halday'     => 'nullable|string|max:100',
            'venue'      => 'required|string|max:300',
            'inv'        => 'nullable|string|max:200',
            'pic-groom'  => 'nullable|image|max:4096', // ✅ groom photo
            'pic-bride'  => 'nullable|image|max:4096', // ✅ bride photo
        ]);

        $tplPath = public_path('svg_templates/' . $data['template']);
        abort_unless(is_file($tplPath), 404);

        // 2) SVG load
        $svg = file_get_contents($tplPath);

        // 3) फोटो base64 encode
        $groomPicVal = '';
        $bridePicVal = '';

        if ($request->hasFile('pic-groom')) {
            $mime = $request->file('pic-groom')->getMimeType();
            $groomPicVal = 'data:' . $mime . ';base64,' .
                base64_encode(file_get_contents($request->file('pic-groom')->getRealPath()));
        }

        if ($request->hasFile('pic-bride')) {
            $mime = $request->file('pic-bride')->getMimeType();
            $bridePicVal = 'data:' . $mime . ';base64,' .
                base64_encode(file_get_contents($request->file('pic-bride')->getRealPath()));
        }

        // 4) text normalize (newline / <br> / \n)
        $gname    = $this->normalizeLineBreaks($data['gname']);
        $bname    = $this->normalizeLineBreaks($data['bname']);
        $gadd     = $this->normalizeLineBreaks($data['gadd']);
        $badd     = $this->normalizeLineBreaks($data['badd']);
        $dayDate  = $this->normalizeLineBreaks($data['day_date']);
        $engday   = $this->normalizeLineBreaks($data['engday'] ?? '');
        $halday   = $this->normalizeLineBreaks($data['halday'] ?? '');
        $venue    = $this->normalizeLineBreaks($data['venue']);
        $inv      = $this->normalizeLineBreaks($data['inv'] ?? '');

        // 5) single-line placeholders replace (venue, inv नंतर handle करतो)
        $replacements = [
            '{gname}'      => e($gname),
            '{bname}'      => e($bname),
            '{gadd}'       => e($gadd),
            '{badd}'       => e($badd),
            '{day_date}'   => e($dayDate),
            '{engday}'     => e($engday),
            '{halday}'     => e($halday),

            // ✅ फोटो placeholders (त्यांना escape करू नये)
            '{pic-groom}'  => $groomPicVal,
            '{pic-bride}'  => $bridePicVal,
        ];

        $svg = str_replace(array_keys($replacements), array_values($replacements), $svg);

        // 6) मल्टीलाइन placeholders ({venue}, {inv}) साठी <tspan> generate करा
        $svg = $this->applyMultiline($svg, 'venue', $venue);
        $svg = $this->applyMultiline($svg, 'inv', $inv);

        // 7) output dir तयार करा
        $outputDir = public_path('generated');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $fileBase = uniqid('invitation_');
        $svgPath  = $outputDir . '/' . $fileBase . '.svg';
        $pngPath  = $outputDir . '/' . $fileBase . '.png';

        file_put_contents($svgPath, $svg);

        // 8) PNG साठी HTML wrapper
        $html = <<<HTML
<!doctype html>
<html lang="mr">
<head>
  <meta charset="utf-8">
  <meta name="color-scheme" content="light">
  <style>
    html, body {
      margin: 0;
      padding: 0;
      background: #ffffff;
    }
    svg {
      display: block;
    }
  </style>
</head>
<body>
  {$svg}
</body>
</html>
HTML;

        try {
            Browsershot::html($html)
                ->windowSize(1080, 1350)
                ->waitUntilNetworkIdle()
                ->save($pngPath);

            return view('result', [
                'image'   => url('generated/' . basename($pngPath)),
                'message' => null,
            ]);
        } catch (\Exception $e) {
            Log::error('Browsershot failed: ' . $e->getMessage());

            // PNG fail झाला तर SVG तरी देऊ
            return view('result', [
                'image'   => url('generated/' . basename($svgPath)),
                'message' => 'PNG conversion failed, SVG generated successfully.',
            ]);
        }
    }

    public function cleanup()
    {
        $outputDir = public_path('generated');
        $files = glob($outputDir . '/*');

        foreach ($files as $file) {
            if (is_file($file) && time() - filemtime($file) > 86400) {
                unlink($file);
            }
        }

        return response()->json(['message' => 'Old files cleaned']);
    }

    /**
     * textarea मधला Enter, \n, आणि <br> सगळं actual newline (\n) मध्ये convert करतो
     */
    protected function normalizeLineBreaks(?string $text): string
    {
        if (!$text) {
            return '';
        }

        // HTML <br> → newline
        $text = str_replace(['<br>', '<br/>', '<br />'], "\n", $text);

        // literal "\n" string → newline
        $text = str_replace("\\n", "\n", $text);

        // CRLF / CR → LF
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        return $text;
    }

    /**
     * दिलेल्या placeholder ({venue}, {inv}) साठी multiline <tspan> तयार करतो
     * आणि त्याला योग्य <text ...>{placeholder}</text> च्या जागी बसवतो.
     */
    protected function applyMultiline(string $svg, string $placeholder, string $text): string
    {
        $lines = array_filter(array_map('trim', explode("\n", $text)), fn($l) => $l !== '');
        if (empty($lines)) {
            // जर काही text नसेल तर placeholder रिकामा करा
            return str_replace('{'.$placeholder.'}', '', $svg);
        }

        // <text ... x="..." ...>{placeholder}</text> pattern शोधू
        $pattern = '/(<text\b[^>]*x="([^"]+)"[^>]*>\s*)\{'.$placeholder.'\}(\s*<\/text>)/u';

        return preg_replace_callback($pattern, function ($m) use ($lines) {
            $prefix = $m[1];   // <text ...>
            $x      = $m[2];   // x value
            $suffix = $m[3];   // </text>

            $tspans = [];
            foreach ($lines as $i => $line) {
                $dy   = $i === 0 ? '0em' : '1.2em';
                $safe = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
                $tspans[] = '<tspan x="'.$x.'" dy="'.$dy.'">'.$safe.'</tspan>';
            }

            return $prefix.implode('', $tspans).$suffix;
        }, $svg);
    }
}
