<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Invitation - Marathi</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', 'Noto Sans Devanagari', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .form-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .sample-text {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-white/70 hover:text-white mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Templates
            </a>
            <h1 class="text-4xl font-bold text-white mb-2">Customize Your Invitation</h1>
            <p class="text-white/70">Fill in the details to create your perfect invitation poster</p>
        </div>

        <!-- Form -->
        <form action="{{ route('generate') }}" method="POST" enctype="multipart/form-data" class="form-card rounded-3xl p-8">
            @csrf
            <input type="hidden" name="template" value="{{ $template }}">

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-white font-semibold mb-2">
                        🎯 Person's Name (व्यक्तीचे नाव)
                    </label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-4 py-3 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent"
                           placeholder="Enter person's name (व्यक्तीचे नाव टाइप करा)"
                           value="आदर्श पाटील">
                    <p class="sample-text">Sample: आदर्श पाटील, स्मिता जोशी, राहुल देशपांडे</p>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-white font-semibold mb-2">
                        📅 Date (दिनांक)
                    </label>
                    <input type="text" id="date" name="date" required
                           class="w-full px-4 py-3 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent"
                           placeholder="e.g., १५ डिसेंबर २०२४"
                           value="१५ डिसेंबर २०२४">
                    <p class="sample-text">Sample: १५ डिसेंबर २०२४, २५ जानेवारी २०२५, ८ मार्च २०२४</p>
                </div>

                <!-- Time -->
                <div>
                    <label for="time" class="block text-white font-semibold mb-2">
                        ⏰ Time (वेळ)
                    </label>
                    <input type="text" id="time" name="time"
                           class="w-full px-4 py-3 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent"
                           placeholder="e.g., संध्याकाळी ६:०० वाजता"
                           value="संध्याकाळी ६:०० वाजता">
                    <p class="sample-text">Sample: संध्याकाळी ६:०० वाजता, सकाळी ११:०० वाजता, रात्री ८:३० वाजता</p>
                </div>

                <!-- Venue -->
                <div>
                    <label for="venue" class="block text-white font-semibold mb-2">
                        🏠 Venue (स्थळ)
                    </label>
                    <textarea id="venue" name="venue" required rows="2"
                              class="w-full px-4 py-3 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent resize-none"
                              placeholder="Enter venue address (स्थळाचा पत्ता टाइप करा)">शिवाजी नगर, पुणे - ४११००५</textarea>
                    <p class="sample-text">Sample: शिवाजी नगर, पुणे | होटल ग्रँड हायट, मुंबई | रेसिडेंसी हॉल, नागपूर</p>
                </div>

                <!-- Host -->
                <div>
                    <label for="host" class="block text-white font-semibold mb-2">
                        👨‍👩‍👧‍👦 Host (आयोजक)
                    </label>
                    <input type="text" id="host" name="host" required
                           class="w-full px-4 py-3 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent"
                           placeholder="Enter host name (आयोजकाचे नाव टाइप करा)"
                           value="पाटील कुटुंब">
                    <p class="sample-text">Sample: पाटील कुटुंब, शर्मा परिवार, जोशी फॅमिली, राव कुटुंब</p>
                </div>

                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-white font-semibold mb-2">
                        📸 Photo (छायाचित्र)
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*"
                           class="w-full px-4 py-3 rounded-2xl bg-white/10 border border-white/20 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white/20 file:text-white hover:file:bg-white/30">
                    <p class="text-white/50 text-sm mt-2">Optional: Upload a photo (JPEG, PNG, max 4MB)</p>
                    <p class="sample-text">Leave empty to use default profile image</p>
                </div>

          

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold text-lg py-4 px-8 rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Invitation Poster
                    </button>
                </div>
            </div>
        </form>

      

        <!-- Preview Note -->
        <div class="text-center mt-6">
            <p class="text-white/50 text-sm">
                Your poster will be generated with beautiful Marathi typography using Google Fonts
            </p>
        </div>
    </div>

    <script>
        // Quick Fill Templates
        function fillBirthdayTemplate() {
            document.getElementById('name').value = 'आर्यन शर्मा';
            document.getElementById('date').value = '२० डिसेंबर २०२४';
            document.getElementById('time').value = 'सकाळी ११:०० वाजता';
            document.getElementById('venue').value = 'शिवाजी नगर, पुणे';
            document.getElementById('host').value = 'शर्मा कुटुंब';
            showToast('Birthday template filled! 🎂');
        }

        function fillWeddingTemplate() {
            document.getElementById('name').value = 'आदित्य आणि प्रियांका';
            document.getElementById('date').value = '१४ फेब्रुवारी २०२५';
            document.getElementById('time').value = 'संध्याकाळी ६:३० वाजता';
            document.getElementById('venue').value = 'टॅज बनquets, कोथरूड, पुणे';
            document.getElementById('host').value = 'जोशी आणि पाटील कुटुंब';
            showToast('Wedding template filled! 💍');
        }

        function fillAnniversaryTemplate() {
            document.getElementById('name').value = 'राजेश आणि माधुरी';
            document.getElementById('date').value = '८ मार्च २०२४';
            document.getElementById('time').value = 'रात्री ८:०० वाजता';
            document.getElementById('venue').value = 'ग्रँड हायट, साधन नगर, पुणे';
            document.getElementById('host').value = 'देशपांडे कुटुंब';
            showToast('Anniversary template filled! 💑');
        }

        function fillHousewarmingTemplate() {
            document.getElementById('name').value = 'विकास आणि सुनिता';
            document.getElementById('date').value = '२५ जानेवारी २०२५';
            document.getElementById('time').value = 'दुपारी ४:०० वाजता';
            document.getElementById('venue').value = 'नवीन निवास, वाकडेवाडी, पुणे';
            document.getElementById('host').value = 'कापसे कुटुंब';
            showToast('Housewarming template filled! 🏡');
        }

        // Toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-2xl shadow-2xl z-50 transform translate-x-full transition-transform duration-300';
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 100);

            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Auto-focus on first field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name').focus();
        });

        // Clear sample text on focus
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('ring-2', 'ring-white/50');
            });
            
            input.addEventListener('blur', function() {
                this.classList.remove('ring-2', 'ring-white/50');
            });
        });
    </script>
</body>
</html>