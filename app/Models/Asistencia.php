<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    protected $table = "asistencias";
    protected $fillable = [
        "matricula","fecha","hora_entrada","hora_salida","estado",
        "kiosco_entrada_id","kiosco_salida_id","observacion",
    ];
    protected $casts = [
        "fecha" => "date",
        "hora_entrada" => "datetime",
        "hora_salida" => "datetime",
    ];

    public function estudiante(): BelongsTo {
        return $this->belongsTo(Estudiante::class, "matricula", "matricula");
    }
    public function kioscoEntrada(): BelongsTo {
        return $this->belongsTo(Kiosco::class, "kiosco_entrada_id", "id");
    }
    public function kioscoSalida(): BelongsTo {
        return $this->belongsTo(Kiosco::class, "kiosco_salida_id", "id");
    }
}
