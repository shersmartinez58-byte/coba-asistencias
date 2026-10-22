@extends("portal.layout")
@section("title", "Detalle de hijo")

@section("content")
<a href="{{ route("tutor.dashboard") }}" class="text-emerald-700 text-sm">← Volver</a>

<h1 class="text-2xl font-bold mb-1 mt-2">{{ $hijo->nombre_completo }}</h1>
<p class="text-slate-600 mb-4">{{ $hijo->matricula }} · {{ $hijo->semestre }}° {{ $hijo->grupo }} · {{ $hijo->turno }}</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-slate-500">Promedio general</p>
        <p class="text-3xl font-bold text-emerald-700">{{ number_format($promedio, 1) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-sm text-slate-500">Reportes</p>
        <p class="text-3xl font-bold text-orange-600">{{ $reportes->count() }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-5 mb-4">
    <h2 class="font-bold mb-3">Calificaciones</h2>
    @forelse ($calificaciones as $items)
        @php $mat = $items->first()->materia; @endphp
        <div class="border-b py-2">
            <p class="font-semibold text-sm">{{ $mat->nombre }}</p>
            <div class="flex gap-3 mt-1">
                @foreach ($items as $c)
                    <span class="px-2 py-1 rounded text-xs {{ $c->calificacion >= 6 ? "bg-emerald-100 text-emerald-800" : "bg-red-100 text-red-800" }}">
                        P{{ $c->parcial }}: {{ $c->calificacion }}
                    </span>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-slate-500">Sin calificaciones</p>
    @endforelse
</div>

<div class="bg-white rounded-xl shadow p-5 mb-4">
    <h2 class="font-bold mb-3">Asistencias recientes</h2>
    <table class="w-full text-sm">
        <thead class="text-left text-slate-500 text-xs uppercase">
            <tr><th class="py-1">Fecha</th><th class="py-1">Entrada</th><th class="py-1">Salida</th><th class="py-1">Estado</th></tr>
        </thead>
        <tbody>
        @foreach ($asistencias as $a)
            <tr class="border-t">
                <td class="py-1">{{ $a->fecha->format("d/m/Y") }}</td>
                <td class="py-1">{{ $a->hora_entrada?->format("H:i") ?? "—" }}</td>
                <td class="py-1">{{ $a->hora_salida?->format("H:i") ?? "—" }}</td>
                <td class="py-1 text-xs uppercase">{{ $a->estado }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-2">{{ $asistencias->links() }}</div>
</div>

<div class="bg-white rounded-xl shadow p-5">
    <h2 class="font-bold mb-3">Reportes</h2>
    @forelse ($reportes as $r)
        <div class="border-b py-2">
            <p class="text-xs text-slate-500">{{ $r->created_at->format("d/m/Y H:i") }} · <span class="uppercase">{{ $r->tipo }}</span></p>
            <p>{{ $r->descripcion }}</p>
        </div>
    @empty
        <p class="text-slate-500">Sin reportes</p>
    @endforelse
</div>
@endsection
