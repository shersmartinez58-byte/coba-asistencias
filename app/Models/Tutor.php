<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tutor extends Model
{
    protected $table = "tutores";
    protected $fillable = ["nombre","apellido_paterno","apellido_materno","telefono","email","parentesco"];

    public function estudiantes(): BelongsToMany {
        return $this->belongsToMany(Estudiante::class, "estudiante_tutor", "tutor_id", "matricula");
    }
    public function user(): HasOne {
        return $this->hasOne(User::class, "tutor_id", "id");
    }
    public function getNombreCompletoAttribute(): string {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }
}
