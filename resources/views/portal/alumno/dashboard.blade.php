@extends("portal.layout")
@section("title", "Mi panel")

@section("content")
<h1 class="text-2xl font-bold mb-1">Hola, {{ $est->nombre_completo }}</h1>
<p class="text-slate-600 mb-6">Matrícula: <strong>{{ $est->matricula }}</strong> · {{ $est->semestre }}° {{ $est->grupo }} · {{ $est->turno }}</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-slate-500">Promedio general</p>
        <p class="text-3xl font-bold text-emerald-700">{{ number_format($promedio, 1) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-slate-500">Faltas este mes</p>
        <p class="text-3xl font-bold text-red-600">{{ $faltasMes }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-slate-500">Clases hoy</p>
        <p class="text-3xl font-bold text-blue-600">{{ $clasesHoy->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">
    <a href="{{ route("alumno.calificaciones") }}" class="bg-white rounded-xl shadow p-4 hover:bg-emerald-50 transition">
        <p class="font-semibold">Calificaciones</p>
        <p class="text-xs text-slate-500">Ver por materia y parcial</p>
    </a>
    <a href="{{ route("alumno.asistencias") }}" class="bg-white rounded-xl shadow p-4 hover:bg-emerald-50 transition">
        <p class="font-semibold">Asistencias</p>
        <p class="text-xs text-slate-500">Entradas y salidas</p>
    </a>
    <a href="{{ route("alumno.horario") }}" class="bg-white rounded-xl shadow p-4 hover:bg-emerald-50 transition">
        <p class="font-semibold">Horario</p>
        <p class="text-xs text-slate-500">Semanal por grupo</p>
    </a>
</div>

<div class="bg-white rounded-xl shadow p-5">
    <h2 class="font-bold mb-3">Clases de hoy</h2>
    @forelse ($clasesHoy as $c)
        <div class="border-b py-2 flex justify-between">
            <div>
                <p class="font-semibold">{{ $c->materia->nombre }}</p>
                <p class="text-xs text-slate-500">{{ $c->docente }}</p>
            </div>
            <p class="text-sm">{{ \Carbon\Carbon::parse($c->hora_inicio)->format("H:i") }} – {{ \Carbon\Carbon::parse($c->hora_fin)->format("H:i") }}</p>
        </div>
    @empty
        <p class="text-slate-500">No hay clases hoy</p>
    @endforelse
</div>
@endsection
