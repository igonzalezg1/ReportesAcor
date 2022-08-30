<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionesMensuales extends Model
{
    use HasFactory;

    protected $table = 'calificaciones_mensuales';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'hotel',
        'calificacion',
        'fecha_calificacion'
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'calificacion' => 'double',
        'avance_pmp' => 'double',
        'fecha_calificacion' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'año',
        'mes'
    ];

    /**
     * Accesores y atributos
     */
    public function getAñoAttribute()
    {
        return Carbon::parse($this->fecha_calificacion)->format('Y');
    }

    public function getMesAttribute()
    {
        return ucfirst(Carbon::parse($this->fecha_calificacion)->isoFormat('MMMM'));
    }
}
