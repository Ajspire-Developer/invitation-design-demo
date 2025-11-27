<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <title>Customize Invitation</title>

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Poppins', system-ui, sans-serif;
    }
    input, textarea, button, label {
      font-family: inherit;
    }
  </style>
</head>

<body class="bg-gray-100 min-h-screen">
  <div class="max-w-3xl mx-auto py-10">
    <h2 class="text-3xl font-bold text-center mb-8">🖋️ Invitation Details</h2>

    <form id="invitationForm" method="POST" action="{{ route('generate') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-8 space-y-6">
      @csrf
      <input type="hidden" name="template" value="{{ $template }}">

      <!-- Sample Data Directly Filled -->
      @php
        $sample = [
            'gname'   => 'गणेश',
            'bname'   => 'स्नेहा',
            'gadd'    => 'बारामती, पुणे',
            'badd'    => 'सासवड, पुणे',
            'day_date'=> '१२ डिसेंबर २०२५',
            'engday'  => 'Friday',
            'halday'  => 'Wednesday (हळद समारंभ)',
            'venue'   => "शिवराय लॉन्स,\nबारामती",
            'inv'     => "आपल्या उपस्थितीत गणेश आणि स्नेहा यांच्या\nविवाहाचा शुभमुहूर्त साजरा करूया!"
        ];
      @endphp

      <div>
        <label class="font-semibold">वराचं नाव:</label>
        <input type="text" name="gname" value="{{ $sample['gname'] }}" class="w-full border rounded px-3 py-2">
      </div>

      <div>
        <label class="font-semibold">वधूचं नाव:</label>
        <input type="text" name="bname" value="{{ $sample['bname'] }}" class="w-full border rounded px-3 py-2">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="font-semibold">वराचा पत्ता:</label>
          <textarea name="gadd" rows="2" class="w-full border rounded px-3 py-2">{{ $sample['gadd'] }}</textarea>
        </div>
        <div>
          <label class="font-semibold">वधूचा पत्ता:</label>
          <textarea name="badd" rows="2" class="w-full border rounded px-3 py-2">{{ $sample['badd'] }}</textarea>
        </div>
      </div>

      <div>
        <label class="font-semibold">दिनांक / तारीख:</label>
        <input type="text" name="day_date" value="{{ $sample['day_date'] }}" class="w-full border rounded px-3 py-2">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="font-semibold">English Day:</label>
          <input type="text" name="engday" value="{{ $sample['engday'] }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
          <label class="font-semibold">हळदी / इतर दिवस:</label>
          <input type="text" name="halday" value="{{ $sample['halday'] }}" class="w-full border rounded px-3 py-2">
        </div>
      </div>

      <div>
        <label class="font-semibold">स्थळ (Venue):</label>
        <textarea name="venue" rows="2" class="w-full border rounded px-3 py-2">{{ $sample['venue'] }}</textarea>
      </div>

      <div>
        <label class="font-semibold">निमंत्रण संदेश:</label>
        <textarea name="inv" rows="3" class="w-full border rounded px-3 py-2">{{ $sample['inv'] }}</textarea>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="font-semibold">वराचा फोटो:</label>
          <input type="file" name="pic-groom" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>
        <div>
          <label class="font-semibold">वधूचा फोटो:</label>
          <input type="file" name="pic-bride" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>
      </div>

      <div class="text-center">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
          Generate Invitation
        </button>
      </div>

    </form>
  </div>
</body>
</html>
