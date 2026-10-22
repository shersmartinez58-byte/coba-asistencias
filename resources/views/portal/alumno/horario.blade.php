@extends("portal.layout")
@section("title", "Mi horario")

@section("content")
<h1 class="text-2xl font-bold mb-4">Mi horario — {{ $est->semestre }}° {{ $est->grupo }} ({{ $est->turno }})</h1>

@php $dias = [1=>"Lunes",2=>"Martes",3=>"Miércoles",4=>"Jueves",5=>"Viernes"]; @endphp

<div class="grid grid-cols-1 md:grid-cols-5 gap-3">
    @foreach ($dias as $num => $nombre)
        <div class="bg-white rounded-xl shadow p-3">
            <h2 class="font-bold text-emerald-700 mb-2 text-sm uppercase">{{ $nombre }}</h2>
            @forelse ($horarios[$num] ?? [] as $h)
                <div class="border-l-4 border-emerald-500 pl-2 mb-2">
                    <p class="text-sm font-semibold">{{ $h->materia->nombre }}</p>
                    <p class="text-xs text-slate-500">
                        {{ \Carbon\Carbon::parse($h->hora_inicio)->format("H:i") }}–{{ \Carbon\Carbon::parse($h->hora_fin)->format("H:i") }}
                    </p>
                </div>
            @empty
                <p class="text-xs text-slate-400">Sin clases</p>
            @endforelse
        </div>
    @endforeach
</div>
@endsection
