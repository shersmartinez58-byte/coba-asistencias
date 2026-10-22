<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("materias", function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 100);
            $table->string("clave", 20)->unique();
            $table->string("semestre", 5);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("materias"); }
};
