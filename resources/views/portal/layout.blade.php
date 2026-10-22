<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Portal COBAO")</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
    <nav class="bg-emerald-700 text-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="text-xl font-bold">COBAO Asistencias</a>
            <div class="flex items-center gap-4 text-sm">
                <span>{{ auth()->user()->name }}</span>
                <span class="bg-emerald-900 px-2 py-1 rounded text-xs uppercase">{{ auth()->user()->rol }}</span>
                <form method="POST" action="{{ route("logout") }}">
                    @csrf
                    <button type="submit" class="underline hover:no-underline">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-6">
        @yield("content")
    </main>
</body>
</html>
