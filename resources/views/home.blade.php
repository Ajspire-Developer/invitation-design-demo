<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <title>Marathi Invitation Studio</title>

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-600 to-pink-500 min-h-screen text-white">
  @php $templates = isset($templates) ? collect($templates) : collect(); @endphp

  <div class="text-center py-12">
    <h1 class="text-4xl font-bold mb-2">💌 मराठी Invitation Studio</h1>
    <p class="opacity-80 mb-8">सुंदर निमंत्रण कार्ड तयार करा — सहज आणि जलद!</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto px-6">
    @forelse($templates as $tpl)
      <div onclick="window.location.href='{{ route('customize', ['template' => $tpl]) }}'"
           class="bg-white/10 rounded-xl p-6 text-center cursor-pointer hover:bg-white/20 transition">
        <div class="text-xl font-semibold mb-3">{{ pathinfo($tpl, PATHINFO_FILENAME) }}</div>
        <img src="{{ asset('svg_templates/'.$tpl) }}" onerror="this.style.display='none';"
             class="mx-auto w-48 h-48 object-contain rounded-lg bg-white/10 p-2 mb-4">
        <button class="bg-white/20 px-4 py-2 rounded-full hover:bg-white/30">Customize</button>
      </div>
    @empty
      <div class="col-span-full text-center text-white/80">No templates found.</div>
    @endforelse
  </div>
</body>
</html>
