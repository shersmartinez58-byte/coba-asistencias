<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    public function dashboard()
    {
        $tutor = Auth::user()->tutor;
        abort_unless($tutor, 403, "Sin tutor vinculado");

        $hijos = $tutor->estudiantes()
            ->withCount(["asistencias as faltas_mes" => function ($q) {
                $q->where("estado", "falta")->whereMonth("fecha", now()->month);
            }])
            ->get();

        foreach ($hijos as $h) {
            $h->promedio = $h->calificaciones()->avg("calificacion") ?? 0;
        }

        return view("portal.tutor.dashboard", compact("tutor", "hijos"));
    }

    public function hijo($matricula)
    {
        $tutor = Auth::user()->tutor;
        abort_unless($tutor, 403);

        // AQUI ESTA EL ARREGLO: especificamos "estudiantes.matricula"
        $hijo = $tutor->estudiantes()
            ->where("estudiantes.matricula", $matricula)
            ->firstOrFail();

        $promedio = $hijo->calificaciones()->avg("calificacion") ?? 0;
        $calificaciones = $hijo->calificaciones()->with("materia")->get()->groupBy("materia_id");
        $asistencias = $hijo->asistencias()->orderByDesc("fecha")->paginate(15);
        $reportes = $hijo->reportes()->orderByDesc("created_at")->get();
        
        $horarios = Horario::with("materia")
            ->where("semestre", $hijo->semestre)
            ->where("grupo", $hijo->grupo)
            ->where("turno", $hijo->turno)
            ->orderBy("dia_semana")
            ->orderBy("hora_inicio")
            ->get()
            ->groupBy("dia_semana");

        return view("portal.tutor.hijo",
            compact("hijo", "promedio", "calificaciones", "asistencias", "reportes", "horarios"));
    }
}
