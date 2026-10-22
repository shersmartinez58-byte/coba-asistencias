<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kiosco — {{ $kiosco->nombre }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex flex-col items-center justify-center text-white p-4">

    <h1 class="text-3xl font-bold mb-2">{{ $kiosco->nombre }}</h1>
    <p class="text-slate-400 mb-6">Escanea tu credencial QR</p>

    <div id="reader" class="w-full max-w-md rounded-xl overflow-hidden bg-black"></div>
    <div id="resultado" class="mt-6 text-center min-h-[120px]"></div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const KIOSCO_TOKEN = @json($kiosco->token);
        const REGISTRAR_URL = @json(route("kiosco.registrar", $kiosco->slug));
        const CSRF = @json(csrf_token());

        const scanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });

        scanner.render(async (texto) => {
            scanner.pause();
            try {
                const res = await fetch(REGISTRAR_URL, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": CSRF,
                        "X-Kiosco-Token": KIOSCO_TOKEN,
                    },
                    body: JSON.stringify({ token: texto })
                });
                const data = await res.json();

                const colores = {
                    ENTRADA: "text-green-400",
                    SALIDA:  "text-blue-400",
                    RETARDO: "text-yellow-400",
                    ERROR:   "text-red-400"
                };
                document.getElementById("resultado").innerHTML = `
                    <h2 class="text-5xl font-bold ${colores[data.accion] || "text-white"}">${data.accion}</h2>
                    <p class="text-2xl mt-2">${data.nombre || data.error}</p>
                    <p class="text-slate-400 mt-1">${data.hora || ""}</p>
                `;
            } catch (e) {
                document.getElementById("resultado").innerHTML = `<p class="text-red-400 text-xl">Error al escanear</p>`;
            }
            setTimeout(() => scanner.resume(), 2500);
        });
    </script>
</body>
</html>
