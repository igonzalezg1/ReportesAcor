<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_encuesta_bloque;
use App\Models\tb_encuesta_pregunta;
use App\Models\tb_respuesta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class Reportes19Controller extends Controller
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
        return view('reportes.reportes19', compact('respuestas', 'preguntas', 'carpeta2', 'bloque', 'id_bloque', 'id_encuesta', 'punto'));
    }


    //Consultar respuestas

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
            if($fila->pre12237 == $piso)
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


    private function consultaPunto9(array $preguntas, Int $idBloque, String $email)
    {
        $respuestas = $this->consultaGeneral($preguntas, $idBloque, $email, 'ASC');
        $preguntasExtra = [
            [
                'titulo' => 'Consumo Kwh',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12177'
            ],
            [
                'titulo' => 'Consumo intermedia Kwh',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12179'
            ],
            [
                'titulo' => 'Consumo punta Kwh',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12181'
            ],
            [
                'titulo' => 'Consumo total Kwh',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12183'
            ],
            [
                'titulo' => 'Consumo reactiva KVA',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12184'
            ],
            [
                'titulo' => 'Consumo real gas tanque 1',
                'grafica' => 'Gas',
                'id_pregunta_base' => '12194'
            ],
            [
                'titulo' => 'Consumo real gas tanque 2',
                'grafica' => 'Gas',
                'id_pregunta_base' => '12195'
            ],
            [
                'titulo' => 'Consumo real agua',
                'grafica' => 'Agua',
                'id_pregunta_base' => '12196'
            ]
        ];

        function obtenerRespuestaAnterior(array $respuestasFinal, $valorATomar, $posicionActual)
        {
            if ($posicionActual == 0) {
                return false;
            }

            return end($respuestasFinal)[$valorATomar];
        }

        $respuestasFinal = [];
        $i = 0;
        foreach ($respuestas as $respuesta) {
            foreach ($preguntasExtra as $extra) {
                if (array_key_exists($extra->titulo, $respuesta)) {
                    if (!$respuestaAnterior = obtenerRespuestaAnterior($respuestasFinal, $extra['id_pregunta_base'], $i)) {
                        $respuestaAnterior = $respuesta[$extra['id_pregunta_base']];
                    }
                    $extra2 = $extra->titulo;
                    $respuesta->extra2 = number_format(floatval($respuesta[$extra['id_pregunta_base']]) - floatval($respuestaAnterior), 2, '.', '');
                }
            }
            array_push($respuestasFinal, $respuesta);
            $i = $i + 1;
        }

        return $respuestasFinal;
    }

    //Consultar preguntas
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

    private function consultaPunto9P(Int $idEncuesta, Int $idBloque)
    {
        $preguntas = $this->consultaGeneralP($idEncuesta, $idBloque);
        $preguntasExtra = [
            [
                'titulo' => 'Consumo Kwh',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12177'
            ],
            [
                'titulo' => 'Consumo intermedia Kwh',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12179'
            ],
            [
                'titulo' => 'Consumo punta Kwh',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12181'
            ],
            [
                'titulo' => 'Consumo total Kwh',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12183'
            ],
            [
                'titulo' => 'Consumo reactiva KVA',
                'grafica' => 'Electricidad',
                'id_pregunta_base' => '12184'
            ],
            [
                'titulo' => 'Consumo real gas tanque 1',
                'grafica' => 'Gas',
                'id_pregunta_base' => '12194'
            ],
            [
                'titulo' => 'Consumo real gas tanque 2',
                'grafica' => 'Gas',
                'id_pregunta_base' => '12195'
            ],
            [
                'titulo' => 'Consumo real agua',
                'grafica' => 'Agua',
                'id_pregunta_base' => '12196'
            ]
        ];

        $preguntasFinal = [];
        foreach ($preguntas as $pregunta) {
            array_push($preguntasFinal, $pregunta);
            if (in_array($pregunta->id, array_column($preguntasExtra, 'id_pregunta_base'))) {
                $posicion = array_search($pregunta->id, array_column($preguntasExtra, 'id_pregunta_base'));
                $extra = $preguntasExtra[$posicion];
                array_push($preguntasFinal, [
                    'id' => $extra['titulo'],
                    'titulo' => $extra['titulo'],
                    'tipo' => 'Gráfica ' . $extra['grafica']
                ]);
            }
        }

        return $preguntasFinal;
    }

    public function filtrar_fechas($start_date, $end_date, $id_encuesta, $id_bloque, $punto)
    {
        $email = \Illuminate\Support\Facades\Auth::user()->email;
        $preguntas = self::obtenerPF($punto, $id_encuesta, $id_bloque);
        $respuestas = self::obtenerF($punto, $preguntas, $id_bloque, $email, $start_date, $end_date);

        return $respuestas;
    }

    static public function obtenerF(Int $punto, array $preguntas, Int $idBloque, String $email, String $start_date, String $end_date)
    {
        $self = new Self;
        switch ($punto) {
            case 9: //Lectura energeticos
                return $self->consultaGeneralF($preguntas, $idBloque, $email, $start_date, $end_date);
                break;

            default:
                return $self->consultaGeneralF($preguntas, $idBloque, $email, $start_date, $end_date);
                break;
        }
    }

    private function consultarF(String $consulta = '')
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

    private function consultaGeneralF(array $preguntas, Int $idBloque, String $email, String $start_date, String $end_date, String $OrderBy = 'DESC')
    {
        $consulta = "SELECT ";
        foreach ($preguntas as $pregunta) {
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
            AND fecha BETWEEN '$start_date' AND '$end_date'
            GROUP BY clave_registro
            ORDER BY SUBSTR(fecha,1,10) $OrderBy
        ";
        return $this->consultarF($consulta);
    }

    //Consultar preguntas
    static public function obtenerPF(Int $punto, Int $idEncuesta, Int $idBloque)
    {
        $self = new Self;
        switch ($punto) {
            case 9: //Lectura energeticos
                return $self->consultaGeneralPF($idEncuesta, $idBloque);
                break;

            default:
                return $self->consultaGeneralPF($idEncuesta, $idBloque);
                break;
        }
    }

    private function consultarPF(String $consulta)
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

    private function consultaGeneralPF(Int $idEncuesta, Int $idBloque, String $OrderBy = 'ASC')
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

        return $this->consultarPF($consulta);
    }
}
