<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SvgController extends Controller
{
    // Show all templates
    public function index()
    {
        $dir = public_path('svg_templates');
        if (!is_dir($dir)) mkdir($dir, 0775, true);

        $templates = collect(glob($dir . DIRECTORY_SEPARATOR . '*.svg'))
            ->map(fn($f) => basename($f))
            ->values();

        return view('home', compact('templates'));
    }

    // Show form for selected template
    public function customize($template)
    {
        $path = public_path('svg_templates/' . $template);
        abort_unless(is_file($path), 404);
        return view('form', compact('template'));
    }

    // Generate Poster
    public function generate(Request $request)
    {
        $data = $request->validate([
            'template' => 'required|string',
            'name'     => 'required|string|max:120',
            'date'     => 'required|string|max:120',
            'time'     => 'nullable|string|max:120',
            'venue'    => 'required|string|max:400',
            'host'     => 'required|string|max:160',
            'photo'    => 'nullable|image|max:4096',
        ]);

        $tplPath = public_path('svg_templates/' . $data['template']);
        abort_unless(is_file($tplPath), 404);

        // Load SVG template
        $svg = file_get_contents($tplPath);

        // Replace placeholders
        $replacements = [
            '{name}'   => e($data['name']),
            '{date}'   => e($data['date']),
            '{time}'   => e($data['time'] ?? ''),
            '{venue}'  => e($data['venue']),
            '{host}'   => e($data['host']),
            '{accent}' => '#E91E63',
        ];
        $svg = str_replace(array_keys($replacements), array_values($replacements), $svg);

        // Handle photo
        if ($request->hasFile('photo')) {
            $imgData = base64_encode(file_get_contents($request->file('photo')->getRealPath()));
            $mimeType = $request->file('photo')->getMimeType();
            $svg = str_replace('{photo}', "data:{$mimeType};base64,{$imgData}", $svg);
        } else {
            // Use base64 encoded default image
            $defaultImagePath = public_path('images/default.png');
            if (file_exists($defaultImagePath)) {
                $defaultImgData = base64_encode(file_get_contents($defaultImagePath));
                $svg = str_replace('{photo}', "data:image/png;base64,{$defaultImgData}", $svg);
            } else {
                // Create a simple gradient placeholder
                $svg = str_replace('{photo}', '#FFFFFF', $svg);
            }
        }

        // Save filled SVG
        $outputDir = public_path('generated');
        if (!is_dir($outputDir)) mkdir($outputDir, 0775, true);

        $fileBase = uniqid('poster_');
        $svgPath = $outputDir . '/' . $fileBase . '.svg';
        $pngPath = $outputDir . '/' . $fileBase . '.png';

        file_put_contents($svgPath, $svg);

        // Convert SVG → PNG using Browsershot
        try {
            Browsershot::html($svg)
                ->setNodeBinary('C:\Program Files\nodejs\node.EXE')
                ->setNpmBinary('C:\Program Files\nodejs\npm.CMD')
                ->windowSize(1080, 1350)
                ->waitUntilNetworkIdle()
                ->setDelay(2000)
                ->timeout(60000)
                ->noSandbox()
                ->ignoreHttpsErrors()
                ->save($pngPath);

            Log::info("Poster generated successfully: " . $pngPath);

        } catch (\Exception $e) {
            Log::error('Browsershot failed: ' . $e->getMessage());
            
            // Return SVG as fallback
            return view('result', [
                'image' => url('generated/' . basename($svgPath)),
                'message' => 'PNG conversion failed, but SVG was generated successfully. You can download the SVG version.'
            ]);
        }

        // Return result page
        $publicUrl = url('generated/' . basename($pngPath));
        return view('result', ['image' => $publicUrl]);
    }

    // Clean up old generated files (optional)
    public function cleanup()
    {
        $outputDir = public_path('generated');
        $files = glob($outputDir . '/*');
        $now = time();
        $maxAge = 24 * 60 * 60; // 24 hours

        foreach ($files as $file) {
            if (is_file($file) && ($now - filemtime($file)) >= $maxAge) {
                unlink($file);
            }
        }

        return response()->json(['message' => 'Cleanup completed']);
    }
}