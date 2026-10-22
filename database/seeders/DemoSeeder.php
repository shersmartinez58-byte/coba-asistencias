<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Materia;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Materias del semestre 3
        $materias = [
            ["clave" => "MAT301", "nombre" => "Matemáticas III", "semestre" => "3"],
            ["clave" => "FIS301", "nombre" => "Física II", "semestre" => "3"],
            ["clave" => "QUI301", "nombre" => "Química II", "semestre" => "3"],
            ["clave" => "ESP301", "nombre" => "Literatura", "semestre" => "3"],
            ["clave" => "HIS301", "nombre" => "Historia de México", "semestre" => "3"],
        ];
        foreach ($materias as $m) {
            Materia::updateOrCreate(["clave" => $m["clave"]], $m);
        }

        // Estudiantes
        $alumnos = [
            ["matricula" => "24B4405001", "nombre" => "Juan", "paterno" => "Pérez", "materno" => "López"],
            ["matricula" => "24B4405002", "nombre" => "María", "paterno" => "García", "materno" => "Hernández"],
            ["matricula" => "24B4405003", "nombre" => "Luis", "paterno" => "Ramírez", "materno" => "Sánchez"],
        ];
        foreach ($alumnos as $i => $a) {
            $est = Estudiante::updateOrCreate(
                ["matricula" => $a["matricula"]],
                [
                    "nombre" => $a["nombre"],
                    "apellido_paterno" => $a["paterno"],
                    "apellido_materno" => $a["materno"],
                    "fecha_nacimiento" => "2008-0" . ($i + 1) . "-15",
                    "semestre" => "3",
                    "grupo" => "A",
                    "turno" => "Matutino",
                    "activo" => true,
                ]
            );

            // Usuario alumno
            User::updateOrCreate(
                ["email" => strtolower($a["nombre"]) . "@coba.edu.mx"],
                [
                    "name" => $est->nombre_completo,
                    "password" => Hash::make("alumno1234"),
                    "rol" => "alumno",
                    "matricula" => $est->matricula,
                ]
            );

            // Calificaciones
            foreach (Materia::all() as $mat) {
                foreach ([1, 2, 3] as $parcial) {
                    Calificacion::updateOrCreate(
                        ["matricula" => $est->matricula, "materia_id" => $mat->id, "parcial" => $parcial, "periodo" => "2025-2026-1"],
                        ["calificacion" => rand(6, 10)]
                    );
                }
            }
        }

        // Tutor con 2 hijos
        $tutor = Tutor::updateOrCreate(
            ["email" => "tutor@coba.edu.mx"],
            [
                "nombre" => "Roberto",
                "apellido_paterno" => "Pérez",
                "apellido_materno" => "Gómez",
                "telefono" => "9511234567",
                "parentesco" => "Padre",
            ]
        );
        $tutor->estudiantes()->sync(["24B4405001", "24B4405002"]);

        User::updateOrCreate(
            ["email" => "tutor@coba.edu.mx"],
            [
                "name" => $tutor->nombre_completo,
                "password" => Hash::make("tutor1234"),
                "rol" => "tutor",
                "tutor_id" => $tutor->id,
            ]
        );

        // Horarios del grupo 3°A Matutino
        $horarioBase = [
            ["dia" => 1, "ini" => "07:00:00", "fin" => "08:40:00", "clave" => "MAT301"],
            ["dia" => 1, "ini" => "08:50:00", "fin" => "10:30:00", "clave" => "FIS301"],
            ["dia" => 1, "ini" => "10:40:00", "fin" => "12:20:00", "clave" => "ESP301"],
            ["dia" => 2, "ini" => "07:00:00", "fin" => "08:40:00", "clave" => "QUI301"],
            ["dia" => 2, "ini" => "08:50:00", "fin" => "10:30:00", "clave" => "HIS301"],
            ["dia" => 3, "ini" => "07:00:00", "fin" => "08:40:00", "clave" => "MAT301"],
            ["dia" => 3, "ini" => "08:50:00", "fin" => "10:30:00", "clave" => "FIS301"],
            ["dia" => 4, "ini" => "07:00:00", "fin" => "08:40:00", "clave" => "ESP301"],
            ["dia" => 4, "ini" => "08:50:00", "fin" => "10:30:00", "clave" => "QUI301"],
            ["dia" => 5, "ini" => "07:00:00", "fin" => "08:40:00", "clave" => "HIS301"],
        ];
        foreach ($horarioBase as $h) {
            $mat = Materia::where("clave", $h["clave"])->first();
            Horario::updateOrCreate(
                [
                    "semestre" => "3", "grupo" => "A", "turno" => "Matutino",
                    "dia_semana" => $h["dia"], "hora_inicio" => $h["ini"],
                ],
                [
                    "hora_fin" => $h["fin"],
                    "materia_id" => $mat->id,
                    "docente" => "Prof. " . $mat->nombre,
                ]
            );
        }
    }
}
