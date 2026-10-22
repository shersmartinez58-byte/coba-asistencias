<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("calificaciones", function (Blueprint $table) {
            $table->id();
            $table->string("matricula", 20);
            $table->foreign("matricula")->references("matricula")->on("estudiantes")->cascadeOnDelete();
            $table->foreignId("materia_id")->constrained("materias")->cascadeOnDelete();
            $table->tinyInteger("parcial");
            $table->decimal("calificacion", 4, 1);
            $table->string("periodo", 20);
            $table->timestamps();
            $table->unique(["matricula", "materia_id", "parcial", "periodo"]);
        });
    }
    public function down(): void { Schema::dropIfExists("calificaciones"); }
};
