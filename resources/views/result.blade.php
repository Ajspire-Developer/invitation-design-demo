<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <title>Invitation Generated</title>

  {{-- 🔹 Google Font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>

  {{-- 🔹 CANVG (working UMD build) --}}
  <script src="https://cdn.jsdelivr.net/npm/canvg@3.0.7/lib/umd.js"></script>

  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">

  <h1 class="text-3xl font-bold mb-4">Invitation Preview</h1>

  {{-- Raw SVG (hidden) --}}
  <div id="svgContainer" class="hidden">
      {!! $svg !!}
  </div>

  {{-- PNG Preview (काहीही crop होणार नाही, फक्त scale होईल) --}}
  <div class="border bg-white rounded shadow mb-6 max-w-2xl w-full p-3">
      <img id="pngPreview"
           class="w-full h-auto mx-auto rounded"
           alt="Invitation Preview">
  </div>

  {{-- Hidden Canvas --}}
  <canvas id="invitationCanvas" class="hidden"></canvas>

  <button id="downloadBtn"
          class="bg-green-600 text-white px-6 py-2 rounded disabled:opacity-50"
          disabled>
      Download PNG
  </button>

<script>
window.addEventListener('load', async () => {

    const canvas      = document.getElementById('invitationCanvas');
    const previewImg  = document.getElementById('pngPreview');
    const downloadBtn = document.getElementById('downloadBtn');

    const origSvg = document.querySelector('#svgContainer svg');
    if (!origSvg) {
        alert("SVG सापडला नाही.");
        return;
    }

    // 1️⃣ SVG clone
    const svgClone = origSvg.cloneNode(true);

    // 2️⃣ Size ठरवणे: आधी viewBox, नसेल तर width/height, नसेल तर default
    let width  = 0;
    let height = 0;

    if (origSvg.viewBox && origSvg.viewBox.baseVal &&
        origSvg.viewBox.baseVal.width && origSvg.viewBox.baseVal.height) {

        width  = origSvg.viewBox.baseVal.width;
        height = origSvg.viewBox.baseVal.height;

    } else {
        const wAttr = svgClone.getAttribute("width");
        const hAttr = svgClone.getAttribute("height");

        if (wAttr && hAttr) {
            width  = parseFloat(wAttr);
            height = parseFloat(hAttr);
        } else {
            width  = 1080;
            height = 1920;
        }
    }

    // 3️⃣ SVG मध्ये font style घालतो (Google font)
    const styleEl = document.createElementNS("http://www.w3.org/2000/svg", "style");
    styleEl.textContent = `
        text, tspan {
            font-family: 'Poppins', sans-serif;
        }
    `;
    svgClone.insertBefore(styleEl, svgClone.firstChild);

    // 4️⃣ SVG → string
    const serializer = new XMLSerializer();
    const svgString  = serializer.serializeToString(svgClone);

    // 5️⃣ Canvas size = full SVG size (इथेच full card decide होतो)
    canvas.width  = width;
    canvas.height = height;

    const ctx = canvas.getContext("2d");
    ctx.setTransform(1, 0, 0, 1, 0, 0);   // कोणतीही extra scale नाही
    ctx.clearRect(0, 0, width, height);

    // 6️⃣ Fonts load होईपर्यंत wait
    if (document.fonts && document.fonts.ready) {
        await document.fonts.ready;
    }

    // 7️⃣ CANVG वापरून पूर्ण SVG area render करतो
    const { Canvg } = canvg;
    const v = await Canvg.fromString(ctx, svgString, {
        ignoreMouse: true,
        ignoreAnimation: true,
        ignoreDimensions: true,     // SVG चे internal width/height override करतो
        scaleWidth:  width,
        scaleHeight: height
    });

    await v.render();

    // 8️⃣ Canvas → PNG
    const pngUrl = canvas.toDataURL("image/png");

    // Preview दाखवतो (Tailwind चा w-full h-auto फक्त scale करतो, crop नाही)
    previewImg.src = pngUrl;

    // 9️⃣ Download enable
    downloadBtn.disabled = false;
    downloadBtn.onclick = () => {
        const a = document.createElement("a");
        a.href = pngUrl;
        a.download = "invitation.png";
        document.body.appendChild(a);
        a.click();
        a.remove();
    };

});
</script>

</body>
</html>
