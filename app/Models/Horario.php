<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    protected $table = "horarios";
    protected $fillable = ["semestre","grupo","turno","dia_semana","hora_inicio","hora_fin","materia_id","docente"];

    public function materia(): BelongsTo {
        return $this->belongsTo(Materia::class, "materia_id", "id");
    }
    public function getDiaNombreAttribute(): string {
        return ["1"=>"Lunes","2"=>"Martes","3"=>"Miércoles","4"=>"Jueves","5"=>"Viernes"][$this->dia_semana] ?? "";
    }
}
