<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KioscoController extends Controller
{
    public function index(Request $request, $slug)
    {
        $kiosco = $request->attributes->get("kiosco");
        return view("kiosco.index", compact("kiosco"));
    }

    public function registrar(Request $request, $slug)
    {
        $kiosco = $request->attributes->get("kiosco");
        $request->validate(["token" => "required|string"]);

        try {
            $matricula = decrypt($request->token);
        } catch (\Throwable $e) {
            return response()->json(["accion" => "ERROR", "error" => "QR inválido"], 422);
        }

        $est = Estudiante::where("matricula", $matricula)->where("activo", true)->first();
        if (!$est) {
            return response()->json(["accion" => "ERROR", "error" => "Estudiante no encontrado"], 404);
        }

        $hoy = now()->toDateString();
        $asist = Asistencia::firstOrCreate(
            ["matricula" => $matricula, "fecha" => $hoy],
            ["estado" => "falta"]
        );

        if (!$asist->hora_entrada) {
            $estado = $this->calcularEstado($est, now());
            $asist->update([
                "hora_entrada" => now(),
                "estado" => $estado,
                "kiosco_entrada_id" => $kiosco->id,
            ]);
            return response()->json([
                "accion" => $estado === "retardo" ? "RETARDO" : "ENTRADA",
                "nombre" => $est->nombre_completo,
                "hora" => now()->format("H:i:s"),
            ]);
        }

        if (!$asist->hora_salida) {
            $asist->update([
                "hora_salida" => now(),
                "kiosco_salida_id" => $kiosco->id,
            ]);
            return response()->json([
                "accion" => "SALIDA",
                "nombre" => $est->nombre_completo,
                "hora" => now()->format("H:i:s"),
            ]);
        }

        return response()->json([
            "accion" => "ERROR",
            "error" => "Ya registró entrada y salida hoy",
        ], 422);
    }

    private function calcularEstado(Estudiante $est, Carbon $hora): string
    {
        $primer = Horario::where("semestre", $est->semestre)
            ->where("grupo", $est->grupo)
            ->where("turno", $est->turno)
            ->where("dia_semana", now()->dayOfWeekIso)
            ->orderBy("hora_inicio")
            ->first();

        if (!$primer) return "presente";

        $limite = Carbon::parse($primer->hora_inicio)->addMinutes(10);
        return $hora->gt($limite) ? "retardo" : "presente";
    }
}
