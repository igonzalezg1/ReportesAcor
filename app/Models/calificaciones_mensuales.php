<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calificaciones_mensuales extends Model
{
    protected $table = 'calificaciones_mensuales';

    protected $fillable = ['hotel','calificacion','avance_pmp','fecha_calificacion'];

    use HasFactory;
}
