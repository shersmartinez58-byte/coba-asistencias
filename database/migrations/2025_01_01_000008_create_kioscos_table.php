<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create("kioscos", function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 50);
            $table->string("slug", 50)->unique();
            $table->string("ubicacion", 100)->nullable();
            $table->string("token", 64)->unique();
            $table->boolean("activo")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("kioscos"); }
};
