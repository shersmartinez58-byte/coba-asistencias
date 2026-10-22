<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("estudiantes", function (Blueprint $table) {
            $table->string("matricula", 20)->primary();
            $table->string("nombre", 100);
            $table->string("apellido_paterno", 100);
            $table->string("apellido_materno", 100)->nullable();
            $table->date("fecha_nacimiento");
            $table->string("curp", 18)->unique()->nullable();
            $table->string("telefono", 15)->nullable();
            $table->string("email")->unique()->nullable();
            $table->string("semestre", 5);
            $table->string("grupo", 5);
            $table->enum("turno", ["Matutino", "Vespertino"]);
            $table->boolean("activo")->default(true);
            $table->timestamps();
            $table->index(["semestre", "grupo", "turno"]);
        });
    }
    public function down(): void { Schema::dropIfExists("estudiantes"); }
};
