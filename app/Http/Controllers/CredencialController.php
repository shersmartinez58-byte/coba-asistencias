<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CredencialController extends Controller
{
    public function generar(Request $request)
    {
        if ($request->has("matricula")) {
            $estudiantes = Estudiante::where("matricula", $request->matricula)->get();
        } else {
            $estudiantes = Estudiante::where("activo", true)->get();
        }

        $credenciales = $estudiantes->map(function ($est) {
            $qrData = encrypt($est->matricula);
            
            // Generamos el QR como imagen PNG y lo convertimos a base64
            $qrImage = base64_encode(\QrCode::format("png")->size(150)->margin(1)->generate($qrData));

            return [
                "estudiante" => $est,
                "qr_base64" => $qrImage,
            ];
        });

        $pdf = Pdf::loadView("pdf.credenciales", compact("credenciales"));
        $pdf->setPaper("letter", "portrait");

        return $pdf->stream("credenciales-cobao.pdf");
    }
}
