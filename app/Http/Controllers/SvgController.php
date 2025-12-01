<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'pic-groom'  => 'nullable|image|max:4096',
            'pic-bride'  => 'nullable|image|max:4096',
        ]);

        $tplPath = public_path('svg_templates/' . $data['template']);
        abort_unless(is_file($tplPath), 404);

        // 1) SVG template load
        $svg = file_get_contents($tplPath);

        // 2) Photos base64
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

        // 3) Normalize text
        $gname    = $this->normalizeLineBreaks($data['gname']);
        $bname    = $this->normalizeLineBreaks($data['bname']);
        $gadd     = $this->normalizeLineBreaks($data['gadd']);
        $badd     = $this->normalizeLineBreaks($data['badd']);
        $dayDate  = $this->normalizeLineBreaks($data['day_date']);
        $engday   = $this->normalizeLineBreaks($data['engday'] ?? '');
        $halday   = $this->normalizeLineBreaks($data['halday'] ?? '');
        $venue    = $this->normalizeLineBreaks($data['venue']);
        $inv      = $this->normalizeLineBreaks($data['inv'] ?? '');

        // 4) Simple placeholders
        $replacements = [
            '{gname}'      => e($gname),
            '{bname}'      => e($bname),
            '{gadd}'       => e($gadd),
            '{badd}'       => e($badd),
            '{day_date}'   => e($dayDate),
            '{engday}'     => e($engday),
            '{halday}'     => e($halday),
            '{pic-groom}'  => $groomPicVal,
            '{pic-bride}'  => $bridePicVal,
        ];

        $svg = str_replace(array_keys($replacements), array_values($replacements), $svg);

        // 5) Multiline placeholders
        $svg = $this->applyMultiline($svg, 'venue', $venue);
        $svg = $this->applyMultiline($svg, 'inv', $inv);

        return view('result', [
            'svg' => $svg,
        ]);
    }

    protected function normalizeLineBreaks(?string $text): string
    {
        if (!$text) return '';

        $text = str_replace(['<br>', '<br/>', '<br />'], "\n", $text);
        $text = str_replace("\\n", "\n", $text);
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        return $text;
    }

    protected function applyMultiline(string $svg, string $placeholder, string $text): string
    {
        $lines = array_filter(array_map('trim', explode("\n", $text)), fn($l) => $l !== '');
        if (empty($lines)) {
            return str_replace('{'.$placeholder.'}', '', $svg);
        }

        $pattern = '/(<text\b[^>]*x="([^"]+)"[^>]*>\s*)\{'.$placeholder.'\}(\s*<\/text>)/u';

        return preg_replace_callback($pattern, function ($m) use ($lines) {
            $prefix = $m[1];
            $x      = $m[2];
            $suffix = $m[3];

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
