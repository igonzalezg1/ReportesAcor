<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_habitaciones extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla a utilizar.
     *
     * @var string
     */
    protected $table = 'tb_habitaciones';

    /**
     * Llave primaria a utilizar.
     *
     * @var string
     */
    protected $primaryKey = 'id_habitaciones';


    /**
     * Deshabilitar timestamps de laravel
     *
     * @var string
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
}
