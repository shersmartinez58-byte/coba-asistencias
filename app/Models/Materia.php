<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    protected $table = "materias";
    protected $fillable = ["nombre","clave","semestre"];

    public function calificaciones(): HasMany {
        return $this->hasMany(Calificacion::class, "materia_id", "id");
    }
    public function horarios(): HasMany {
        return $this->hasMany(Horario::class, "materia_id", "id");
    }
}
