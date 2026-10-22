<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - COBAO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-2">COBAO Asistencias</h1>
        <p class="text-center text-slate-500 mb-6 text-sm">Ingresa tus credenciales</p>

        @if (session("status"))
            <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded">
                {{ session("status") }}
            </div>
        @endif

        <form method="POST" action="{{ route("login") }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old("email") }}" required autofocus
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none">
                @error("email")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none">
                @error("password")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center mb-6">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                <label for="remember_me" class="ml-2 text-sm text-slate-600">Recordarme</label>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-lg transition">
                Entrar
            </button>
        </form>
    </div>
</body>
</html>
