<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_encuesta extends Model
{
    use HasFactory;

    protected $table = 'tb_encuesta';

    protected $fillable = ['id_app','n_orden_cuestionario','c_nobre_encuesta',
                        'd_borrado','fecha_creacion','fecha_actualizacion','qr','periodicidad','tipo'];

    protected $primaryKey = 'id_encuesta';

    public function tb_app()
    {
        return $this->belongsTo('App\Models\tb_app','id_app','id_app');
    }
}
