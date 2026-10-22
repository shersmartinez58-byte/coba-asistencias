<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Estudiante extends Model
{
    protected $table = "estudiantes";
    protected $primaryKey = "matricula";
    public $incrementing = false;
    protected $keyType = "string";

    protected $fillable = [
        "matricula", "nombre", "apellido_paterno", "apellido_materno",
        "fecha_nacimiento", "curp", "telefono", "email",
        "semestre", "grupo", "turno", "activo",
    ];

    protected $casts = [
        "fecha_nacimiento" => "date",
        "activo" => "boolean",
    ];

    public function tutores(): BelongsToMany {
        return $this->belongsToMany(Tutor::class, "estudiante_tutor", "matricula", "tutor_id");
    }
    public function calificaciones(): HasMany {
        return $this->hasMany(Calificacion::class, "matricula", "matricula");
    }
    public function asistencias(): HasMany {
        return $this->hasMany(Asistencia::class, "matricula", "matricula");
    }
    public function reportes(): HasMany {
        return $this->hasMany(Reporte::class, "matricula", "matricula");
    }
    public function user(): HasOne {
        return $this->hasOne(User::class, "matricula", "matricula");
    }

    public function getNombreCompletoAttribute(): string {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }
    public function getGeneracionAttribute(): string {
        return substr($this->matricula, 0, 2);
    }
    public function getPlantelAttribute(): string {
        return substr($this->matricula, 2, 1);
    }
    public function horarioHoy() {
        return Horario::where("semestre", $this->semestre)
            ->where("grupo", $this->grupo)
            ->where("turno", $this->turno)
            ->where("dia_semana", now()->dayOfWeekIso)
            ->orderBy("hora_inicio")
            ->get();
    }
}
