<?php

namespace App\Http\Controllers;

use App\Models\tb_respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraficasController extends Controller
{
    public static function reportespmp()
    {
        $email = \Auth::user()->email;
        $query = "SELECT YEAR(SUBSTR(fecha,1,10)) as year, count(DISTINCT R.clave_registro) inspections FROM tb_respuesta  R INNER JOIN tb_usuario U ON U.correo=R.usuario WHERE U.id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='" . $email . "')  GROUP BY year";
        $reportepmpA = DB::select($query);

        return $reportepmpA;
    }

    public static function getMeses($anio)
    {
        $email = \Auth::user()->email;

        $query = "SELECT MONTH(SUBSTR(fecha,1,10)) as mes, count(DISTINCT R.clave_registro) inspeciones FROM tb_respuesta R INNER JOIN tb_usuario U ON U.correo=R.usuario WHERE U.id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='$email') AND YEAR(SUBSTR(fecha,1,10))=$anio GROUP BY mes";

        $mes = DB::select($query);

        return $mes;
    }

    public static function getMesEsp($anio, $mes)
    {
        $email = \Auth::user()->email;
        $query = "SELECT C.c_nombre_encuesta as cuestionario, count(DISTINCT R.clave_registro) inspections FROM tb_respuesta R INNER JOIN tb_usuario U ON U.correo=R.usuario INNER JOIN tb_encuesta C ON C.id_encuesta=R.idcuestionario WHERE U.id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='" . $email . "')  AND YEAR(SUBSTR(fecha,1,10))=$anio AND MONTH(SUBSTR(fecha,1,10))= $mes GROUP BY cuestionario";

        $mesesp = DB::select($query);

        return $mesesp;
    }

    public static function getCuestionario($anio, $mes, $cuestionario)
    {
        $email = \Auth::user()->email;
        $query = "
        SELECT B.c_nombre_bloque as bloque, count(DISTINCT R.clave_registro) inspections FROM tb_respuesta R
INNER JOIN tb_usuario U ON U.correo=R.usuario
INNER JOIN tb_encuesta_bloque B ON B.id_bloque=R.idbloque
INNER JOIN tb_encuesta C ON C.id_encuesta=R.idcuestionario
WHERE U.id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='" . $email . "')  AND YEAR(SUBSTR(fecha,1,10))=$anio AND MONTH(SUBSTR(fecha,1,10))=$mes AND C.c_nombre_encuesta='$cuestionario' GROUP BY bloque
          ";

        $cuestionarios = DB::select($query);

        return $cuestionarios;
    }

    public static function getIncidencias()
    {
        $email = \Auth::user()->email;
        $query = "SELECT YEAR(SUBSTR(fecha,1,10)) as anio, count(DISTINCT R.clave_registro) inspeciones FROM tb_respuesta  R
        INNER JOIN tb_usuario U ON U.correo=R.usuario
        WHERE U.id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='" . $email . "') AND R.respuesta='No' GROUP BY anio ";

        $anio = DB::select($query);

        return $anio;
    }

    public static function getIncidenciasMes($anio)
    {
        $email = \Auth::user()->email;
        $query = "SELECT MONTH(SUBSTR(fecha,1,10)) as mes, count(DISTINCT R.clave_registro) inspeciones FROM tb_respuesta  R
        INNER JOIN tb_usuario U ON U.correo=R.usuario
        WHERE U.id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='" . $email . "') AND R.respuesta='No' AND YEAR(SUBSTR(fecha,1,10))= $anio GROUP BY mes ";

        $mes = DB::select($query);

        return $mes;
    }

    public static function getIncidenciasMesEsp($anio, $mes)
    {
        $email = \Auth::user()->email;
        $query = "SELECT C.c_nombre_encuesta as cuestionario, count(DISTINCT R.clave_registro) inspeciones FROM tb_respuesta R
        INNER JOIN tb_usuario U ON U.correo=R.usuario
        INNER JOIN tb_encuesta C ON C.id_encuesta=R.idcuestionario
        WHERE U.id_sucursal=(SELECT id_sucursal FROM tb_usuario WHERE correo='" . $email . "') AND R.respuesta='No' AND YEAR(SUBSTR(fecha,1,10))= $anio AND MONTH(SUBSTR(fecha,1,10))= $mes GROUP BY cuestionario";
        $cuestionarios = DB::select($query);

        return $cuestionarios;
    }

    public static function getResumen()
    {
        $email = \Auth::user()->email;
        $query = "SELECT  YEAR(SUBSTR(fecha,1,10)) as anio,count(DISTINCT clave_registro) as inspeciones
        FROM tb_respuesta WHERE usuario='" . $email . "'
        GROUP BY anio ";
        $anios = DB::select($query);

        return $anios;
    }

    public static function getMesResumen($anio)
    {
        $email = \Auth::user()->email;
        $query = "SELECT MONTH(SUBSTR(fecha,1,10)) as mes, count( DISTINCT clave_registro) as inspeciones
        FROM tb_respuesta
        WHERE usuario='" . $email . "' AND YEAR(SUBSTR(fecha,1,10))=$anio
        GROUP BY mes";
        $mes = DB::select($query);

        return $mes;
    }

    public static function getMesEspResumen($anio, $mes)
    {
        $email = \Auth::user()->email;
        $query = "SELECT SUBSTR(fecha,1,10) AS Fecha, DAY(fecha) as day,count(DISTINCT clave_registro) as inspeciones
        FROM tb_respuesta
        WHERE
            usuario='" . $email . "'
            AND
            YEAR(SUBSTR(fecha,1,10))=$anio
            AND
            MONTH(SUBSTR(fecha,1,10))=$mes
        GROUP BY day";
        $reportes = DB::select($query);

        return $reportes;
    }
}
