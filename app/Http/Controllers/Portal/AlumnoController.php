<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Calificacion;
use App\Models\Horario;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    public function dashboard()
    {
        $est = Auth::user()->estudiante;
        abort_unless($est, 403, "Sin alumno vinculado");

        $promedio = $est->calificaciones()->avg("calificacion") ?? 0;
        $faltasMes = $est->asistencias()
            ->where("estado", "falta")
            ->whereMonth("fecha", now()->month)
            ->count();
        $clasesHoy = $est->horarioHoy();

        return view("portal.alumno.dashboard", compact("est", "promedio", "faltasMes", "clasesHoy"));
    }

    public function calificaciones()
    {
        $est = Auth::user()->estudiante;
        abort_unless($est, 403);

        $calificaciones = Calificacion::with("materia")
            ->where("matricula", $est->matricula)
            ->orderBy("materia_id")
            ->orderBy("parcial")
            ->get()
            ->groupBy("materia_id");

        return view("portal.alumno.calificaciones", compact("est", "calificaciones"));
    }

    public function asistencias()
    {
        $est = Auth::user()->estudiante;
        abort_unless($est, 403);

        $asistencias = $est->asistencias()
            ->orderByDesc("fecha")
            ->paginate(20);

        return view("portal.alumno.asistencias", compact("est", "asistencias"));
    }

    public function horario()
    {
        $est = Auth::user()->estudiante;
        abort_unless($est, 403);

        $horarios = Horario::with("materia")
            ->where("semestre", $est->semestre)
            ->where("grupo", $est->grupo)
            ->where("turno", $est->turno)
            ->orderBy("dia_semana")
            ->orderBy("hora_inicio")
            ->get()
            ->groupBy("dia_semana");

        return view("portal.alumno.horario", compact("est", "horarios"));
    }
}
