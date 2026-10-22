<?php

namespace App\Http\Middleware;

use App\Models\Kiosco;
use Closure;
use Illuminate\Http\Request;

class KioscoAuth
{
    public function handle(Request $request, Closure $next)
    {
        $slug = $request->route("slug");
        $token = $request->header("X-Kiosco-Token");

        // Buscamos el kiosco SOLO por el slug (la URL) para evitar que un token viejo en caché lo bloquee
        $kiosco = Kiosco::where("slug", $slug)->where("activo", true)->first();

        if (!$kiosco) {
            return response()->json(["accion" => "ERROR", "error" => "Kiosco no encontrado o inactivo"], 404);
        }

        // Si viene un token y NO coincide, lo bloqueamos
        if ($token && $token !== $kiosco->token) {
            return response()->json(["accion" => "ERROR", "error" => "Kiosco no autorizado"], 401);
        }

        $request->attributes->set("kiosco", $kiosco);
        return $next($request);
    }
}
