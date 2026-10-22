<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $fillable = ["name","email","password","rol","matricula","tutor_id"];
    protected $hidden = ["password","remember_token"];
    protected $casts = ["email_verified_at" => "datetime","password" => "hashed"];

    public function estudiante(): BelongsTo {
        return $this->belongsTo(Estudiante::class, "matricula", "matricula");
    }
    public function tutor(): BelongsTo {
        return $this->belongsTo(Tutor::class, "tutor_id", "id");
    }

    public function canAccessPanel(Panel $panel): bool {
        return $this->rol === "admin";
    }
}
