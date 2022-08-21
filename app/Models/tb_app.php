<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_app extends Model
{
    use HasFactory;

    protected $table = 'tb_app';

    protected $fillable = ['c_nombre_app','carpeta','d_borrado_app'];

    protected $primaryKey = 'id_app';
}
