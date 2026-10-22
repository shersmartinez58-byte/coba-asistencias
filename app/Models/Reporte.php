<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reporte extends Model
{
    protected $table = "reportes";
    protected $fillable = ["matricula","tipo","descripcion","creado_por"];

    public function estudiante(): BelongsTo {
        return $this->belongsTo(Estudiante::class, "matricula", "matricula");
    }
    public function creador(): BelongsTo {
        return $this->belongsTo(User::class, "creado_por", "id");
    }
}
