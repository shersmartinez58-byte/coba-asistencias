<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table("users", function (Blueprint $table) {
            $table->enum("rol", ["admin", "alumno", "tutor"])->default("alumno")->after("email");
            $table->string("matricula", 20)->nullable()->unique()->after("rol");
            $table->foreign("matricula")->references("matricula")->on("estudiantes")->nullOnDelete();
            $table->foreignId("tutor_id")->nullable()->unique()->after("matricula")->constrained("tutores")->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table("users", function (Blueprint $table) {
            $table->dropForeign(["matricula"]);
            $table->dropForeign(["tutor_id"]);
            $table->dropColumn(["rol", "matricula", "tutor_id"]);
        });
    }
};
