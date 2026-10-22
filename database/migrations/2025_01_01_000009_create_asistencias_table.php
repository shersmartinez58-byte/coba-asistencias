<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("asistencias", function (Blueprint $table) {
            $table->id();
            $table->string("matricula", 20);
            $table->foreign("matricula")->references("matricula")->on("estudiantes")->cascadeOnDelete();
            $table->date("fecha");
            $table->timestamp("hora_entrada")->nullable();
            $table->timestamp("hora_salida")->nullable();
            $table->enum("estado", ["presente", "retardo", "falta", "justificada"])->default("falta");
            $table->foreignId("kiosco_entrada_id")->nullable()->constrained("kioscos")->nullOnDelete();
            $table->foreignId("kiosco_salida_id")->nullable()->constrained("kioscos")->nullOnDelete();
            $table->text("observacion")->nullable();
            $table->timestamps();
            $table->unique(["matricula", "fecha"]);
            $table->index("fecha");
        });
    }
    public function down(): void { Schema::dropIfExists("asistencias"); }
};
