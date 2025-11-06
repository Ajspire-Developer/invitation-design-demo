<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marathi - Create Beautiful Invitations</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', 'Noto Sans Devanagari', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .template-card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .template-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="text-center py-12 px-4">
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-4">
            🎊 Marathi Invitation Studio
        </h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto">
            Create stunning Marathi invitations with beautiful Devanagari fonts. Perfect for birthdays, weddings, and special occasions.
        </p>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 pb-16">
        <!-- Templates Grid -->
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
    @forelse($templates as $template)
        <div class="template-card rounded-2xl p-6 text-center cursor-pointer group"
             onclick="window.location.href='{{ route('customize', $template) }}'">
            <div class="bg-white rounded-xl p-4 mb-4 shadow-lg group-hover:shadow-xl transition-shadow overflow-hidden">
                <div class="aspect-[3/4] rounded-lg flex items-center justify-center bg-gray-100">
                    <!-- Actual SVG Template Preview -->
                    <img src="{{ asset('svg_templates/' . $template) }}" 
                         alt="{{ $template }}"
                         class="w-full h-full object-contain p-2"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    
                    <!-- Fallback if SVG doesn't load -->
                    <div class="hidden flex-col items-center justify-center text-gray-400">
                        <span class="text-4xl mb-2">🎴</span>
                        <span class="text-sm">Preview not available</span>
                    </div>
                </div>
            </div>
            <h3 class="text-white font-semibold text-lg mb-2">
                {{ pathinfo($template, PATHINFO_FILENAME) }}
            </h3>
            <p class="text-white/60 text-sm mb-4">
                {{-- Show template size --}}
                @php
                    $filePath = public_path('svg_templates/' . $template);
                    $fileSize = file_exists($filePath) ? round(filesize($filePath) / 1024, 1) : 0;
                @endphp
                Template • {{ $fileSize }}KB
            </p>
            <button class="bg-white/20 hover:bg-white/30 text-white font-medium py-2 px-6 rounded-full transition-all group-hover:scale-105">
                Customize Template
            </button>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <div class="text-6xl mb-4">😔</div>
            <h3 class="text-2xl font-bold text-white mb-2">No Templates Found</h3>
            <p class="text-white/60">Please add some SVG templates to the public/svg_templates directory.</p>
            <div class="mt-6 bg-white/10 rounded-2xl p-6 max-w-md mx-auto">
                <p class="text-white/80 text-sm mb-4">To get started, add your SVG files to:</p>
                <code class="bg-black/30 text-white/90 px-3 py-2 rounded-lg text-sm">
                    public/svg_templates/
                </code>
            </div>
        </div>
    @endforelse
</div>

        <!-- Features Section -->
        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-8">Why Choose Marathi?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-white">
                    <div class="text-4xl mb-4">🎨</div>
                    <h3 class="text-xl font-semibold mb-2">Beautiful Designs</h3>
                    <p class="text-white/70">Professionally designed templates with perfect Marathi typography</p>
                </div>
                <div class="text-white">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold mb-2">Instant Generation</h3>
                    <p class="text-white/70">Create high-quality invitation posters in seconds</p>
                </div>
                <div class="text-white">
                    <div class="text-4xl mb-4">📱</div>
                    <h3 class="text-xl font-semibold mb-2">Easy Sharing</h3>
                    <p class="text-white/70">Download and share your invitations easily</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-8 border-t border-white/20">
        <p class="text-white/60">
            © {{ date('Y') }} Marathi Invitation Studio | Made with ❤️ for the Marathi community
        </p>
    </footer>
</body>
</html>