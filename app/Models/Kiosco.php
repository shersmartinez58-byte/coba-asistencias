<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kiosco extends Model
{
    protected $table = "kioscos";
    protected $fillable = ["nombre","slug","ubicacion","token","activo"];
    protected $casts = ["activo" => "boolean"];
}
