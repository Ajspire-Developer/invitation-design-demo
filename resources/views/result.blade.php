<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <title>Invitation Generated</title>

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center">
  <h1 class="text-3xl font-bold mb-4">✅ Invitation Ready!</h1>
  @isset($message)
    <p class="text-red-600 mb-4">{{ $message }}</p>
  @endisset

  <img src="{{ $image }}" alt="Invitation" class="border rounded-lg shadow-lg mb-6 max-w-lg">
  <a href="{{ $image }}" download class="bg-green-600 text-white px-5 py-2 rounded">Download Image</a>
</body>
</html>
