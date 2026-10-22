@extends("portal.layout")
@section("title", "Panel tutor")

@section("content")
<h1 class="text-2xl font-bold mb-1">Hola, {{ $tutor->nombre_completo }}</h1>
<p class="text-slate-600 mb-6">Tienes {{ $hijos->count() }} {{ $hijos->count() === 1 ? "hijo" : "hijos" }} registrado(s)</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach ($hijos as $h)
        <a href="{{ route("tutor.hijo", $h->matricula) }}" class="bg-white rounded-xl shadow p-5 hover:bg-emerald-50 transition">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="font-bold text-lg">{{ $h->nombre_completo }}</p>
                    <p class="text-xs text-slate-500">{{ $h->matricula }} · {{ $h->semestre }}° {{ $h->grupo }} · {{ $h->turno }}</p>
                </div>
                <span class="text-emerald-700 font-bold text-2xl">{{ number_format($h->promedio, 1) }}</span>
            </div>
            <p class="text-sm text-slate-600">
                Faltas este mes: <strong class="text-red-600">{{ $h->faltas_mes }}</strong>
            </p>
            <p class="text-xs text-emerald-700 mt-2">Ver detalle →</p>
        </a>
    @endforeach
</div>
@endsection
