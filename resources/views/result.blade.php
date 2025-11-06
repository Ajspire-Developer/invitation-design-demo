<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poster Generated Successfully - Marathi</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', 'Noto Sans Devanagari', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .bounce {
            animation: bounce 2s infinite;
        }
        
        .poster-shadow {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="max-w-4xl w-full">
        <!-- Success Header -->
        <div class="text-center mb-8 fade-in-up">
            <div class="bounce inline-block text-6xl mb-4">🎉</div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Poster Generated Successfully!
            </h1>
            <p class="text-xl text-white/80 max-w-2xl mx-auto">
                Your beautiful invitation poster is ready! Preview it below and download instantly.
            </p>
        </div>

        <!-- Poster Preview -->
        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 md:p-8 poster-shadow fade-in-up mb-8">
            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-2xl">
                @if(str_ends_with($image, '.svg'))
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <p class="text-amber-700 font-medium">
                                PNG conversion failed, but SVG version is available. The image may not display Marathi text correctly in some browsers.
                            </p>
                        </div>
                    </div>
                @endif
                
                <img src="{{ $image }}" 
                     alt="Generated Invitation Poster"
                     class="w-full h-auto rounded-xl border-4 border-pink-100 shadow-lg max-h-[600px] object-contain bg-white">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col md:flex-row gap-4 justify-center items-center fade-in-up mb-8">
            <!-- Download Button -->
            <a href="{{ $image }}" download="invitation-poster-{{ time() }}.png"
               class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold text-lg px-8 py-4 rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center min-w-[200px]">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download Poster
            </a>

            <!-- Create Another Button -->
            <a href="{{ route('home') }}"
               class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold text-lg px-8 py-4 rounded-2xl border-2 border-white/30 hover:border-white/50 shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center min-w-[200px]">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Another
            </a>
        </div>

        <!-- Success Message -->
        @isset($message)
            <div class="bg-red-500/20 backdrop-blur-sm border border-red-400/30 rounded-2xl p-6 text-center fade-in-up">
                <p class="text-red-100 text-lg font-medium">{{ $message }}</p>
            </div>
        @else
            <div class="text-center fade-in-up">
                <p class="text-white/80 text-lg">
                    🎊 Your invitation poster is ready to share with friends and family!
                </p>
            </div>
        @endisset

        <!-- Footer -->
        <footer class="text-center mt-12 pt-8 border-t border-white/20">
            <p class="text-white/60 text-sm">
                © {{ date('Y') }} Marathi Invitation Studio | 
                Designed with ❤️ by Marathi Team
            </p>
        </footer>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const downloadBtn = document.querySelector('a[download]');
            if (downloadBtn) {
                downloadBtn.addEventListener('click', function() {
                    this.innerHTML = '<svg class="w-6 h-6 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path></svg> Downloading...';
                    setTimeout(() => {
                        this.innerHTML = '<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Downloaded!';
                    }, 1500);
                });
            }
        });
    </script>
</body>
</html>