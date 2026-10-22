@extends("portal.layout")
@section("title", "Mis asistencias")

@section("content")
<h1 class="text-2xl font-bold mb-4">Mis asistencias</h1>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr>
                <th class="px-4 py-2">Fecha</th>
                <th class="px-4 py-2">Entrada</th>
                <th class="px-4 py-2">Salida</th>
                <th class="px-4 py-2">Estado</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($asistencias as $a)
            <tr class="border-b hover:bg-slate-50">
                <td class="px-4 py-2">{{ $a->fecha->format("d/m/Y") }}</td>
                <td class="px-4 py-2">{{ $a->hora_entrada?->format("H:i:s") ?? "—" }}</td>
                <td class="px-4 py-2">{{ $a->hora_salida?->format("H:i:s") ?? "—" }}</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded text-xs uppercase
                        @if($a->estado === "presente") bg-emerald-100 text-emerald-800
                        @elseif($a->estado === "retardo") bg-yellow-100 text-yellow-800
                        @elseif($a->estado === "falta") bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ $a->estado }}
                    </span>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="px-4 py-6 text-center text-slate-500">Sin asistencias registradas</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $asistencias->links() }}</div>
@endsection
