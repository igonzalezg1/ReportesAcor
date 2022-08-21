<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_respuesta extends Model
{
    use HasFactory;

    protected $table = 'tb_respuesta';

    protected $fillable = ['usuario','longitud','latitud','idcuestionario','idbloque','idpregunta','sucursal',
                        'piso','sala','respuesta','evidencia','comentario','clave_registro','fecha','no_visita'];

    protected $primaryKey = 'idrespuesta';

    public function tb_cuestionario()
    {
        return $this->belongsTo('App\Models\tb_encuesta','idcuestionario','id_encuesta');
    }

    public function tb_encuesta_bloque()
    {
        return $this->belongsTo('App\Models\tb_encuesta_bloque','idbloque', 'id_bloque');
    }

    public function tb_encuesta_pregunta()
    {
        return $this->belongsTo('App\Models\tb_encuesta_pregunta', 'idpregunta','id_pregunta');
    }
}
