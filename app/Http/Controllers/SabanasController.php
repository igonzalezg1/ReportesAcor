<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SabanasController extends Controller
{
    public function index()
    {
        $listasabanas = [
            [
                'url' => "getsabanas19",
                'titulo' => '19. Revisión del 15% de las habitaciones del hotel'
            ],
            [
                'url' => "getsabanas21",
                'titulo' => '21. Realizacion del mantenimiento del 15% de las habitaciones del hotel aplicacion del formato técnico'
            ],
            [
                'url' => "getlimpieza",
                'titulo' => 'Limpieza'
            ]
        ];
        return view('sabanas.sabanas', compact('listasabanas'));
    }

    public function getsabanas21()
    {
        $idApp = 16;
        $punto = 21;
        $titulo_pregunta = "Numero de habitacion";
        $correo = \Auth::user()->email;

        $query = "SELECT id_sucursal FROM tb_sucursal WHERE id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='$correo' LIMIT 1) LIMIT 1";
        $idSucursal = DB::select($query);
        foreach ($idSucursal as $ids) {
            $idsuc = $ids->id_sucursal;
        }
        $query = "SELECT * FROM tb_habitaciones WHERE id_sucursal='$idsuc'";
        $habitaciones = DB::select($query);
        $query = "SELECT id_encuesta FROM tb_encuesta_bloque WHERE id_encuesta IN (SELECT id_encuesta FROM tb_encuesta WHERE id_app='$idApp') AND numero='$punto' LIMIT 1";
        $encuesta = DB::select($query);
        foreach ($encuesta as $enc) {
            $idEncuesta = $enc->id_encuesta;
        }
        $query = "SELECT id_bloque FROM tb_encuesta_bloque WHERE id_encuesta='$idEncuesta' AND numero='$punto' LIMIT 1";
        $bloque = DB::select($query);
        foreach ($bloque as $bloq) {
            $idBloque = $bloq->id_bloque;
        }
        $query = "SELECT id_pregunta FROM tb_encuesta_pregunta WHERE c_titulo_pregunta LIKE '%$titulo_pregunta%' AND c_tipo_pregunta='Numerico' AND id_encuesta='$idEncuesta' LIMIT 1";
        $pregunta = DB::select($query);
        foreach ($pregunta as $preg) {
            $idPregunta = $preg->id_pregunta;
        }
        $query = "SELECT
            clave_registro,
            respuesta,
            MAX(SUBSTR(fecha,1,10)) as fecha
            FROM tb_respuesta
            WHERE sucursal='$idsuc'
            AND idcuestionario='$idEncuesta'
            AND idbloque='$idBloque'
            AND idpregunta='$idPregunta'
            AND respuesta IS NOT NULL
            AND respuesta <> ''
            GROUP BY respuesta
            ORDER BY fecha DESC";

        $respuestas = DB::select($query);

        if (!$habitaciones) {
            return '<h3>No hay habitaciones registradas</h3>';
            exit;
        }
        $i = 1;
        foreach ($habitaciones as $habitacion) {
            if ($i == 1) {
                $pisos_base_datos = [];
                $pisos_reales = [];
                $cualquiera = json_decode(json_encode($habitacion), true);
                foreach (array_keys($cualquiera) as $key) {
                    if (substr($key, 0, 4) == 'piso') {
                        $pisos_base_datos[] = $key;
                    }
                }
                foreach ($pisos_base_datos as $piso) {
                    if ($habitacion->$piso != null and $habitacion != '') {
                        $pisos_reales[] = $piso;
                    }
                }
            }
            $i++;
        }
        $html = view('sabanas.templates.punto21', compact('pisos_reales', 'habitaciones', 'respuestas'))->render();
        return response()->json([
            'status' => true,
            'html' => $html,
            'message' => 'Se genero el codigo bien.',
        ]);
    }

    public function getsabanas19()
    {
        $idApp = 16;
        $punto = 19;
        $titulo_pregunta = "Numero de habitacion";
        $correo = \Auth::user()->email;

        $query = "SELECT id_sucursal FROM tb_sucursal WHERE id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='$correo' LIMIT 1) LIMIT 1";
        $idSucursal = DB::select($query);
        foreach ($idSucursal as $ids) {
            $idsuc = $ids->id_sucursal;
        }
        $query = "SELECT * FROM tb_habitaciones WHERE id_sucursal='$idsuc'";
        $habitaciones = DB::select($query);
        $query = "SELECT id_encuesta FROM tb_encuesta_bloque WHERE id_encuesta IN (SELECT id_encuesta FROM tb_encuesta WHERE id_app='$idApp') AND numero='$punto' LIMIT 1";
        $encuesta = DB::select($query);
        foreach ($encuesta as $enc) {
            $idEncuesta = $enc->id_encuesta;
        }
        $query = "SELECT id_bloque FROM tb_encuesta_bloque WHERE id_encuesta='$idEncuesta' AND numero='$punto' LIMIT 1";
        $bloque = DB::select($query);
        foreach ($bloque as $bloq) {
            $idBloque = $bloq->id_bloque;
        }
        $query = "SELECT id_pregunta FROM tb_encuesta_pregunta WHERE c_titulo_pregunta LIKE '%$titulo_pregunta%' AND c_tipo_pregunta='Numerico' AND id_encuesta='$idEncuesta' LIMIT 1";
        $pregunta = DB::select($query);
        foreach ($pregunta as $preg) {
            $idPregunta = $preg->id_pregunta;
        }
        $query = "
            SELECT
            clave_registro,
            respuesta,
            MAX(SUBSTR(fecha,1,10)) as fecha
            FROM tb_respuesta
            WHERE sucursal='$idsuc'
            AND idcuestionario='$idEncuesta'
            AND idbloque='$idBloque'
            AND idpregunta='$idPregunta'
            AND respuesta IS NOT NULL
            AND respuesta <> ''
            GROUP BY respuesta
            ORDER BY fecha DESC
        ";

        $respuestas = DB::select($query);

        if (!$habitaciones) {
            return '<h3>No hay habitaciones registradas</h3>';
            exit;
        }
        $i = 1;
        foreach ($habitaciones as $habitacion) {
            if ($i == 1) {
                $pisos_base_datos = [];
                $pisos_reales = [];
                $cualquiera = json_decode(json_encode($habitacion), true);
                foreach (array_keys($cualquiera) as $key) {
                    if (substr($key, 0, 4) == 'piso') {
                        $pisos_base_datos[] = $key;
                    }
                }
                foreach ($pisos_base_datos as $piso) {
                    if ($habitacion->$piso != null and $habitacion != '') {
                        $pisos_reales[] = $piso;
                    }
                }
            }
            $i++;
        }
        $html = view('sabanas.templates.punto19', compact('pisos_reales', 'habitaciones', 'respuestas'))->render();
        return response()->json([
            'status' => true,
            'html' => $html,
            'message' => 'Se genero el codigo bien.',
        ]);
    }

    public function getlimpieza()
    {
        $hostlimpieza = '162.248.52.79';
        $userlimpieza = 'UserCaOaSuMapp';
        $passwordlimpieza = 'Cctv*2022';
        $dblimpieza = 'ibis_limpieza';
        $idApp = 16;
        $correo = \Auth::user()->email;
        $query = "SELECT sucursal, id_sucursal as id FROM tb_sucursal WHERE id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='$correo' LIMIT 1) LIMIT 1";
        $suc = DB::select($query);
        foreach ($suc as $sucs) {
            $sucursal = $sucs;
        }
        $query = "SELECT * FROM tb_habitaciones WHERE id_sucursal='" . $sucursal->id . "'";
        $habitaciones = DB::select($query);
        $conexionlimpieza = @mysqli_connect($hostlimpieza, $userlimpieza, $passwordlimpieza, $dblimpieza);
        if (!$conexionlimpieza) {
            return "<h1>No se conecto</h1>";
        }
        $tickets = $conexionlimpieza->query("
                SELECT
                cuarto,
                MAX(fechaCheck) as fecha
                FROM limpieza
                WHERE hotel='" . $sucursal->sucursal . "'
                GROUP BY cuarto
                ORDER BY fechaCheck DESC
                ") or die($conexionlimpieza->error);

        if (!$habitaciones) {
            return '<h3>No hay habitaciones registradas</h3>';
            exit;
        }
        $i = 1;
        foreach ($habitaciones as $habitacion) {
            if ($i == 1) {
                $pisos_base_datos = [];
                $pisos_reales = [];
                $cualquiera = json_decode(json_encode($habitacion), true);
                foreach (array_keys($cualquiera) as $key) {
                    if (substr($key, 0, 4) == 'piso') {
                        $pisos_base_datos[] = $key;
                    }
                }
                foreach ($pisos_base_datos as $piso) {
                    if ($habitacion->$piso != null and $habitacion != '') {
                        $pisos_reales[] = $piso;
                    }
                }
            }
            $i++;
        }
        $html = view('sabanas.templates.limpieza', compact('pisos_reales', 'habitaciones', 'tickets'))->render();
        return response()->json([
            'status' => true,
            'html' => $html,
            'message' => 'Se genero el codigo bien.',
        ]);
    }

    public static function nombrePiso(String $nombrePiso)
    {
        $longitudNombre = strlen($nombrePiso);
        $nuevoNombre = 'Piso ' . substr($nombrePiso, 4, $longitudNombre);
        return $nuevoNombre;
    }

    public static function obtenerUltimaFecha($habitacion, $respuestas)
    {
        foreach ($respuestas as $respuesta) {
            if ($respuesta->respuesta == $habitacion) {
                return Carbon::parse($respuesta->fecha)->format('d-m-Y');
            }
        }

        return 'SIN REVISAR';
    }

    public static function obtenerUltimaFechat($habitacion, $tickets)
    {
        foreach ($tickets as $ticket) {
            if ($ticket['cuarto'] == $habitacion) {
                return Carbon::parse($ticket['fecha'])->format('d-m-Y');
            }
        }

        return 'SIN REVISAR';
    }


    public static function colorFecha($fecha)
    {
        if ($fecha == 'SIN REVISAR') {
            return 'text-danger';
        }

        $mesesTranscurridos = Carbon::createFromFormat('d-m-Y', $fecha)->diffInMonths() + 1;
        if ($mesesTranscurridos < 5) {
            return 'text-primary';
        }

        if ($mesesTranscurridos >= 5 and $mesesTranscurridos <= 6) {
            return 'text-success';
        }

        if ($mesesTranscurridos > 6) {
            return 'text-warning';
        }
    }

    public static function colorFechat($fecha)
    {
        if ($fecha == 'SIN REVISAR') {
            return 'text-danger';
        }

        $mesesTranscurridos = Carbon::createFromFormat('d-m-Y', $fecha)->diffInMonths() + 1;
        if ($mesesTranscurridos <= 1) {
            return 'text-primary';
        }

        if ($mesesTranscurridos > 1 and $mesesTranscurridos <= 2) {
            return 'text-success';
        }

        if ($mesesTranscurridos > 2) {
            return 'text-orange';
        }
    }
}
