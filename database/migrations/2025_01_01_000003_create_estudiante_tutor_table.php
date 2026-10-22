<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("estudiante_tutor", function (Blueprint $table) {
            $table->foreignId("tutor_id")->constrained("tutores")->cascadeOnDelete();
            $table->string("matricula", 20);
            $table->foreign("matricula")->references("matricula")->on("estudiantes")->cascadeOnDelete();
            $table->primary(["tutor_id", "matricula"]);
        });
    }
    public function down(): void { Schema::dropIfExists("estudiante_tutor"); }
};
