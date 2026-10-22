<?php

use App\Http\Controllers\KioscoController;
use App\Http\Controllers\Portal\AlumnoController;
use App\Http\Controllers\Portal\TutorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Lógica anti-bucle: Si no está logueado va a /login, si está logueado va a su portal
Route::get("/", function () {
    if (!Auth::check()) {
        return redirect("/login");
    }
    return match (Auth::user()->rol) {
        "admin" => redirect("/admin"),
        "alumno" => redirect("/alumno"),
        "tutor" => redirect("/tutor"),
        default => redirect("/login"),
    };
});

// Kioscos
Route::middleware("kiosco.auth")->group(function () {
    Route::get("/kiosco/{slug}", [KioscoController::class, "index"])->name("kiosco.index");
    Route::post("/kiosco/{slug}/registrar", [KioscoController::class, "registrar"])->name("kiosco.registrar");
});

// Portal alumno
Route::middleware(["auth", "role:alumno"])->prefix("alumno")->group(function () {
    Route::get("/", [AlumnoController::class, "dashboard"])->name("alumno.dashboard");
    Route::get("/calificaciones", [AlumnoController::class, "calificaciones"])->name("alumno.calificaciones");
    Route::get("/asistencias", [AlumnoController::class, "asistencias"])->name("alumno.asistencias");
    Route::get("/horario", [AlumnoController::class, "horario"])->name("alumno.horario");
});

// Portal tutor
Route::middleware(["auth", "role:tutor"])->prefix("tutor")->group(function () {
    Route::get("/", [TutorController::class, "dashboard"])->name("tutor.dashboard");
    Route::get("/hijo/{matricula}", [TutorController::class, "hijo"])->name("tutor.hijo");
});

// Ruta de redirección (la que usas después del login)
Route::get("/redirect", function () {
    return match (Auth::user()->rol) {
        "admin" => redirect("/admin"),
        "alumno" => redirect("/alumno"),
        "tutor" => redirect("/tutor"),
        default => redirect("/login"),
    };
})->middleware("auth")->name("redirect");

// Ruta para generar las credenciales en PDF
Route::middleware(["auth", "role:admin"])->get("/credenciales", [\App\Http\Controllers\CredencialController::class, "generar"])->name("credenciales.pdf");

require __DIR__."/../routes/auth.php";
