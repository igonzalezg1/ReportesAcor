<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_encuesta_bloque;
use App\Models\tb_encuesta_pregunta;
use App\Models\tb_respuesta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class Reportes21Controller extends Controller
{
    public function getRespuestas($id_encuesta, $id_bloque, $punto, $piso)
    {
        $email = \Illuminate\Support\Facades\Auth::user()->email;
        $carpeta = DB::select("SELECT A.carpeta from tb_usuario as U INNER JOIN tb_app as A ON A.id_app=U.id_app WHERE U.correo='$email'");
        if ($punto == "SITE") {
            $punto = 139;
        } else {
            $punto = filter_var($punto, FILTER_SANITIZE_NUMBER_INT);
        }
        $carpeta2 = "";

        $bloque = tb_encuesta_bloque::find($id_bloque);
        $preguntas = self::obtenerP($punto, $id_encuesta, $id_bloque);
        $respuestas = self::obtener($punto, $preguntas, $id_bloque, $email, $piso);

        foreach ($carpeta as $item) {
            $carpeta2 = $item->carpeta;
        }

        //return $preguntas;
        return view('reportes.reportes21', compact('respuestas', 'preguntas', 'carpeta2', 'bloque', 'id_bloque', 'id_encuesta', 'punto'));
    }

    static public function obtenerP(Int $punto, Int $idEncuesta, Int $idBloque)
    {
        $self = new Self;
        switch ($punto) {
            case 9: //Lectura energeticos
                return $self->consultaGeneralP($idEncuesta, $idBloque);
                break;

            default:
                return $self->consultaGeneralP($idEncuesta, $idBloque);
                break;
        }
    }

    private function consultarP(String $consulta)
    {
        if ($consulta == '') {
            return [];
        }
        $resultadoConsulta = DB::select($consulta);
        $resultadoFinal = [];
        foreach ($resultadoConsulta as $fila) {
            array_push($resultadoFinal, $fila);
        }
        return $resultadoFinal;
    }

    private function consultaGeneralP(Int $idEncuesta, Int $idBloque, String $OrderBy = 'ASC')
    {
        $consulta = "
            SELECT
                id_pregunta as id,
                c_titulo_pregunta as titulo,
                c_tipo_pregunta as tipo
            FROM tb_encuesta_pregunta
            WHERE c_tipo_pregunta!='Separador'
            AND id_encuesta='$idEncuesta'
            AND id_bloque='$idBloque'
            ORDER BY n_orden_pregunta $OrderBy
        ";

        return $this->consultarP($consulta);
    }

    static public function obtener(Int $punto, array $preguntas, Int $idBloque, String $email, int $piso)
    {
        $self = new Self;
        switch ($punto) {
            case 9: //Lectura energeticos
                return $self->consultaGeneral($preguntas, $idBloque, $email, $piso);
                break;

            default:
                return $self->consultaGeneral($preguntas, $idBloque, $email, $piso);
                break;
        }
    }

    private function consultar(String $consulta = '', Int $piso)
    {
        if ($consulta == '') {
            return [];
        }
        $resultadoConsulta = DB::select($consulta);

        $resultadoFinal = [];

        foreach ($resultadoConsulta as $fila) {
            if($fila->pre12277 == $piso)
            {
                array_push($resultadoFinal, $fila);
            }
        }
        return $resultadoFinal;
    }

    private function consultaGeneral(array $preguntas, Int $idBloque, String $email, Int $piso, String $OrderBy = 'DESC')
    {
        $consulta = "SELECT ";
        foreach ($preguntas as $pregunta) {
            if ($pregunta->tipo == 'Evidencia') {
                $consulta .= "MAX(CASE WHEN idpregunta='" . $pregunta->id . "' THEN evidencia ELSE NULL END) as '" . "pre".$pregunta->id . "', ";
            } else {
                $consulta .= "MAX(CASE WHEN idpregunta='" . $pregunta->id . "' THEN respuesta ELSE NULL END) as '" . "pre".$pregunta->id . "', ";
            }

            if ($pregunta->tipo == 'Evidencia') {
                $consulta .= "MAX(CASE WHEN idpregunta='" . $pregunta->id . "' THEN evidencia ELSE NULL END) as '" . $pregunta->id . "', ";
            } else {
                $consulta .= "MAX(CASE WHEN idpregunta='" . $pregunta->id . "' THEN respuesta ELSE NULL END) as '" . $pregunta->id . "', ";
            }
        }
        $consulta .= "
              clave_registro as id_respuesta,
              SUBSTR(fecha,1,10) AS fecha_registro,
              latitud,
              longitud
            FROM tb_respuesta
            WHERE idbloque='$idBloque'
            AND usuario='$email'
            GROUP BY clave_registro
            ORDER BY SUBSTR(fecha,1,10) $OrderBy
        ";
        return $this->consultar($consulta, $piso);
    }
}
