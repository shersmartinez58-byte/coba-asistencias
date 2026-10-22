@extends("portal.layout")
@section("title", "Mis calificaciones")

@section("content")
<h1 class="text-2xl font-bold mb-4">Mis calificaciones</h1>

@forelse ($calificaciones as $materiaId => $items)
    @php $materia = $items->first()->materia; @endphp
    <div class="bg-white rounded-xl shadow p-5 mb-4">
        <h2 class="font-bold mb-3">{{ $materia->nombre }} <span class="text-xs text-slate-500">({{ $materia->clave }})</span></h2>
        <div class="grid grid-cols-3 gap-3">
            @foreach ($items as $c)
                <div class="border rounded-lg p-3 text-center">
                    <p class="text-xs text-slate-500">Parcial {{ $c->parcial }}</p>
                    <p class="text-2xl font-bold {{ $c->calificacion >= 6 ? "text-emerald-700" : "text-red-600" }}">{{ $c->calificacion }}</p>
                </div>
            @endforeach
        </div>
    </div>
@empty
    <p class="text-slate-500">Sin calificaciones registradas</p>
@endforelse
@endsection
