<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    protected $table = "calificaciones";
    protected $fillable = ["matricula","materia_id","parcial","calificacion","periodo"];

    public function estudiante(): BelongsTo {
        return $this->belongsTo(Estudiante::class, "matricula", "matricula");
    }
    public function materia(): BelongsTo {
        return $this->belongsTo(Materia::class, "materia_id", "id");
    }
}
