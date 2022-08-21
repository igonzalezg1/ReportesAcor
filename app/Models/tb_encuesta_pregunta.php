<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_encuesta_pregunta extends Model
{
    use HasFactory;

    protected $table = 'tb_encuesta_pregunta';

    protected $fillable = ['id_encuesta','id_bloque','c_tipo_pregunta','n_orden_pregunta',
                        'c_titulo_pregunta','d_borrado_pregunta','clave_pregunta','valor',
                        'no_aplica','requerido','min','max'];

    protected $primaryKey = 'id_pregunta';

    public function tb_encuesta()
    {
        return $this->belongsTo('App\Models\tb_encuesta', 'id_encuesta','id_encuesta');
    }

    public function  tb_encuesta_bloque()
    {
        return $this->belongsTo('App\Models\tb_encuesta_bloque', 'id_bloque','id_bloque');
    }
}
