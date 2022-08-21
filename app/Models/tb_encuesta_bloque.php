<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_encuesta_bloque extends Model
{
    use HasFactory;

    protected $table = 'tb_encuesta_bloque';

    protected $fillable = ['id_encuesta','n_orden_bloque','c_nombre_bloque',
                        'respuesta_predeternimada','valor','numero','d_borrado_bloque','ticket'];

    protected $primaryKey = 'id_bloque';

    public function tb_encuesta()
    {
        return $this->belongsTo('App\Models\tb_encuesta','id_encuesta','id_encuesta');
    }
}
