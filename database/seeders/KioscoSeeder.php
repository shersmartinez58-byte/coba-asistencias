<?php

namespace Database\Seeders;

use App\Models\Kiosco;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KioscoSeeder extends Seeder
{
    public function run(): void
    {
        $kioscos = [
            ["nombre" => "Prefectura", "slug" => "prefectura", "ubicacion" => "Entrada principal"],
            ["nombre" => "Dirección", "slug" => "direccion", "ubicacion" => "Edificio administrativo"],
            ["nombre" => "Subdirección", "slug" => "subdireccion", "ubicacion" => "Edificio administrativo"],
        ];

        foreach ($kioscos as $k) {
            Kiosco::updateOrCreate(
                ["slug" => $k["slug"]],
                [
                    "nombre" => $k["nombre"],
                    "ubicacion" => $k["ubicacion"],
                    "token" => Str::random(64),
                    "activo" => true,
                ]
            );
        }
    }
}
