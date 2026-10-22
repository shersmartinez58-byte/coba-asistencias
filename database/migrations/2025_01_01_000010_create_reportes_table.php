<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("reportes", function (Blueprint $table) {
            $table->id();
            $table->string("matricula", 20);
            $table->foreign("matricula")->references("matricula")->on("estudiantes")->cascadeOnDelete();
            $table->enum("tipo", ["conducta", "academico", "medico", "otro"]);
            $table->text("descripcion");
            $table->foreignId("creado_por")->constrained("users");
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("reportes"); }
};
