<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curp extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre','apellido_p','apellido_m','fecha_nacimiento','sexo','estado','curp', 
    ];

}
