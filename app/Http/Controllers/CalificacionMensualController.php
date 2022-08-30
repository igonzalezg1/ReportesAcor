<?php

namespace App\Http\Controllers;

use App\Models\CalificacionesMensuales;
use App\Models\tb_encuesta_bloque;
use App\Models\tb_respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CalificacionMensualController extends Controller
{
    public function index($mes)
    {
        $carbon = Carbon::now('America/Mexico_City');
        $client = new \GuzzleHttp\Client();
        $meses[1] = 'Enero';
        $meses[2] = 'Febrero';
        $meses[3] = 'Marzo';
        $meses[4] = 'Abril';
        $meses[5] = 'Mayo';
        $meses[6] = 'Junio';
        $meses[7] = 'Julio';
        $meses[8] = 'Agosto';
        $meses[9] = 'Septiembre';
        $meses[10] = 'Octubre';
        $meses[11] = 'Noviembre';
        $meses[12] = 'Diciembre';
        $anio = $carbon->yearIso;
        $inihotel = \Auth::user()->username;
        $datos = CalificacionMensualController::calificacion($mes, $inihotel, $anio);
        $habitaciones = OpcionesExtrasController::habitaciones15();
        $habitaciones15 = round((15/100) * $habitaciones, 0);
        $habitacion19 = OpcionesExtrasController::habitacion192($mes);
        $habitacion21 = OpcionesExtrasController::habitacion212($mes);
        $bloquesrealizados = CalificacionMensualController::getBloques($inihotel, $anio, $mes);
        return view('calificacionmensual\index', compact('datos', 'habitaciones', 'habitacion19', 'habitacion21', 'bloquesrealizados','meses','inihotel','mes','habitaciones15'));
    }
    public function calificacion($mes, $iniciales, $anio)
    {
        $data = CalificacionesMensuales::query()
            ->where('hotel', $iniciales)
            ->whereYear('fecha_calificacion', $anio)
            ->whereMonth('fecha_calificacion', $mes)
            ->first();
        return $data;
    }
    public function getBloques($iniciales, $anio, $month)
    {
        $query = "SELECT id_sucursal FROM tb_sucursal WHERE sucursal = '$iniciales' LIMIT 1";
        $hotelesres = DB::select($query);
        foreach ($hotelesres as $hr) {
            $id_sucursal = $hr->id_sucursal;
        }
        $pertenencia_hotel = CalificacionMensualController::getPertenencia($iniciales);
        $mes = CalificacionMensualController::parseString($month);
        switch ($pertenencia_hotel) {
            case 'Ibis':
                $cuestionarios = CalificacionMensualController::ibis($mes);
                break;
            case 'Novotel':
                $cuestionarios = CalificacionMensualController::novotel($mes);
                break;
            case 'Quality':
                $cuestionarios = CalificacionMensualController::quality($mes);
                break;
        }
        $bloques = tb_encuesta_bloque::query()
            ->selectRaw('id_bloque as id, id_encuesta, c_nombre_bloque as nombre, numero as punto, valor')
            ->whereIn('id_encuesta', $cuestionarios)
            ->groupBy('id_bloque')
            ->orderBy('n_orden_bloque', 'ASC')
            ->get();
        $respuestas = tb_respuesta::query()
            ->selectRaw('idrespuesta as id, idbloque, sucursal, MAX(fecha) as fecha')
            ->where('sucursal', $id_sucursal)
            ->whereIn('idbloque', $bloques->pluck('id'))
            ->whereYear('fecha', $anio)
            ->whereMonth('fecha', $mes)
            ->groupBy('idbloque')
            ->orderBy('fecha', 'DESC')
            ->get();
        $conteo_habitaciones_porcentaje_15 = (OpcionesExtrasController::habitaciones15() * 15) / 100;
        $conteo_habitaciones_punto_19 = OpcionesExtrasController::habitacion192($mes);
        $conteo_habitaciones_punto_21 = OpcionesExtrasController::habitacion212($mes);
        $resultado = [];
        foreach ($respuestas as $respuesta) {
            $bloque_encontrado = $bloques->where('id', $respuesta->idbloque)->first();
            if ($bloque_encontrado) {
                switch ($bloque_encontrado['punto']) {
                    case 19:
                        $temp_valor_resultado = ($conteo_habitaciones_punto_19 >= $conteo_habitaciones_porcentaje_15) ? $bloque_encontrado['valor'] : 0;
                        break;
                    case 21:
                        $temp_valor_resultado = ($conteo_habitaciones_punto_21 >= $conteo_habitaciones_porcentaje_15) ? $bloque_encontrado['valor'] : 0;
                        break;
                    default:
                        $temp_valor_resultado = $bloque_encontrado['valor'];
                        break;
                }
                array_push($resultado, [
                    'id_bloque' => $bloque_encontrado->id,
                    'id_encuesta' => $bloque_encontrado->id_encuesta,
                    'punto' => $bloque_encontrado->punto,
                    'nombre' => $bloque_encontrado->nombre,
                    'peso' => $bloque_encontrado->valor,
                    'resultado' => $temp_valor_resultado
                ]);
                unset($temp_valor);
                unset($bloque_encontrado);
            }
        }
        foreach ($bloques as $bloque) {
            if (!in_array($bloque->id, array_column($resultado, 'id_bloque'))) {
                array_push($resultado, [
                    'id_bloque' => $bloque->id,
                    'id_encuesta' => $bloque->id_encuesta,
                    'punto' => $bloque->punto,
                    'nombre' => $bloque->nombre,
                    'peso' => $bloque->valor,
                    'resultado' => 0
                ]);
            }
        }
        $resultado = collect($resultado);
        $resultado_final = $resultado->sortBy('punto', SORT_NUMERIC);
        return $resultado_final;
    }
    public function getPertenencia(String $inicialesHotel)
    {
        $primeraLetra = substr($inicialesHotel, 0, 1);
        switch ($primeraLetra) {
            case 'I':
                $pertenencia = 'Ibis';
                break;
            case 'N':
                $pertenencia = 'Novotel';
                break;
            case 'Q':
                $pertenencia = 'Quality';
                break;
            default:
                $pertenencia = 'Desconocido';
                break;
        }
        return $pertenencia;
    }
    public static function getByActualYear()
    {
        $self = new Self;
        $actualMonth = now()->month;
        $allMonths = $self->getAllMonths();
        $finalArray = [];
        for ($i = 1; $i <= $actualMonth; $i++) {
            array_push($finalArray, [
                'string' => $allMonths[$i],
                'int' => $i
            ]);
        }
        return $finalArray;
    }
    /**
     *  Retorna un arreglo con todos los meses del año
     */
    public static function getAllMonths()
    {
        return [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
    }
    /**
     * Numerico a string
     */
    public static function parseString(Int $mesNumerico)
    {
        $self = new Self;
        $meses = $self->getAllMonths();
        return $meses[$mesNumerico];
    }
    /**
     * String a numerico
     */
    public static function parseInt(String $mesEspañol)
    {
        $self = new Self;
        $meses = $self->getAllMonths();
        return array_search($mesEspañol, $meses);
    }
    public static function todos()
    {
        $self = new Self;
        $todos = [];
        foreach (CalificacionesMensuales::getAllMonths() as $mes) {
            foreach ($self->ibis($mes) as $cuestionario) {
                if (!in_array($cuestionario, $todos)) {
                    array_push($todos, $cuestionario);
                }
            }
            foreach ($self->novotel($mes) as $cuestionario) {
                if (!in_array($cuestionario, $todos)) {
                    array_push($todos, $cuestionario);
                }
            }
            foreach ($self->quality($mes) as $cuestionario2) {
                if (!in_array($cuestionario2, $todos)) {
                    array_push($todos, $cuestionario2);
                }
            }
        }
        return $todos;
    }
    /**
     * @return Array
     */
    public static function ibis(String $mes)
    {
        switch ($mes) {
            case 'Enero':
                $coleccionCuestionarios = [84, 85, 88];
                break;
            case 'Febrero':
                $coleccionCuestionarios = [84, 85, 86, 89];
                break;
            case 'Marzo':
                $coleccionCuestionarios = [84, 85, 87, 90];
                break;
            case 'Abril':
                $coleccionCuestionarios = [84, 85, 91];
                break;
            case 'Mayo':
                $coleccionCuestionarios = [84, 85, 86, 92];
                break;
            case 'Junio':
                $coleccionCuestionarios = [84, 85, 86, 87];
                break;
            case 'Julio':
                $coleccionCuestionarios = [84, 85, 94];
                break;
            case 'Agosto':
                $coleccionCuestionarios = [84, 85, 86, 95];
                break;
            case 'Septiembre':
                $coleccionCuestionarios = [84, 85, 87, 96];
                break;
            case 'Octubre':
                $coleccionCuestionarios = [84, 85, 86, 97];
                break;
            case 'Noviembre':
                $coleccionCuestionarios = [84, 85, 98];
                break;
            case 'Diciembre':
                $coleccionCuestionarios = [84, 85, 86, 87, 99];
                break;
            default:
                $coleccionCuestionarios = [];
                break;
        }
        return $coleccionCuestionarios;
    }
    /**
     * @return Array
     */
    public static function novotel(String $mes)
    {
        switch ($mes) {
            case 'Enero':
                $coleccionCuestionarios = [170, 185, 188];
                break;
            case 'Febrero':
                $coleccionCuestionarios = [170, 185, 186, 189];
                break;
            case 'Marzo':
                $coleccionCuestionarios = [170, 185, 187, 190];
                break;
            case 'Abril':
                $coleccionCuestionarios = [170, 185, 191];
                break;
            case 'Mayo':
                $coleccionCuestionarios = [170, 185, 186, 192];
                break;
            case 'Junio':
                $coleccionCuestionarios = [170, 185, 186, 187];
                break;
            case 'Julio':
                $coleccionCuestionarios = [170, 185, 193];
                break;
            case 'Agosto':
                $coleccionCuestionarios = [170, 185, 186, 194];
                break;
            case 'Septiembre':
                $coleccionCuestionarios = [170, 185, 187, 195];
                break;
            case 'Octubre':
                $coleccionCuestionarios = [170, 185, 186, 196];
                break;
            case 'Noviembre':
                $coleccionCuestionarios = [170, 185, 197];
                break;
            case 'Diciembre':
                $coleccionCuestionarios = [170, 185, 186, 187, 198];
                break;
            default:
                $coleccionCuestionarios = [];
                break;
        }
        return $coleccionCuestionarios;
    }
    /**
     * @return Array
     */
    public static function quality(String $mes)
    {
        switch ($mes) {
            case 'Enero':
                $coleccionCuestionarios = [5, 6, 19];
                break;
            case 'Febrero':
                $coleccionCuestionarios = [5, 6, 11, 20];
                break;
            case 'Marzo':
                $coleccionCuestionarios = [5, 6, 8, 80];
                break;
            case 'Abril':
                $coleccionCuestionarios = [5, 6, 82];
                break;
            case 'Mayo':
                $coleccionCuestionarios = [5, 6, 11, 83];
                break;
            case 'Junio':
                $coleccionCuestionarios = [5, 6, 11, 8];
                break;
            case 'Julio':
                $coleccionCuestionarios = [5, 6, 81];
                break;
            case 'Agosto':
                $coleccionCuestionarios = [5, 6, 11, 79];
                break;
            case 'Septiembre':
                $coleccionCuestionarios = [5, 6, 8, 9];
                break;
            case 'Octubre':
                $coleccionCuestionarios = [5, 6, 11, 10];
                break;
            case 'Noviembre':
                $coleccionCuestionarios = [5, 6, 12];
                break;
            case 'Diciembre':
                $coleccionCuestionarios = [5, 6, 11, 8, 13];
                break;
            default:
                $coleccionCuestionarios = [];
                break;
        }
        return $coleccionCuestionarios;
    }
}
