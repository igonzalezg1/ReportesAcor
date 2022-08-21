<?php

namespace App\Http\Controllers;

use App\Models\tb_respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraficasController extends Controller
{
    public static function reportespmp()
    {
        $query = "SELECT SUBSTRING(fecha,1, 4) AS anio, COUNT(DISTINCT(clave_registro)) AS inspeciones FROM tb_respuesta GROUP BY anio;";
        $reportepmpA = DB::select($query);

        return $reportepmpA;
    }

    public static function getMeses($anio)
    {
        $query = "SELECT SUBSTRING(fecha,6, 2) AS mes, COUNT(DISTINCT(clave_registro)) AS inspeciones
            FROM tb_respuesta
            WHERE  fecha LIKE '%$anio%'
            GROUP BY mes";

        $mes = DB::select($query);

        return $mes;
    }

    public static function getIncidencias()
    {
        $query = "SELECT SUBSTRING(fecha,1, 4) AS anio, COUNT(DISTINCT(clave_registro)) AS inspeciones
                    FROM tb_respuesta
                    WHERE (respuesta= 'No' OR respuesta= 'Irregular' OR respuesta= '7' OR respuesta= '6' OR respuesta= '5')
                    GROUP BY anio";

        $anio = DB::select($query);

        return $anio;
    }

    public static function getIncidenciasMes($anio)
    {
        $query = "SELECT SUBSTRING(fecha,6, 2) AS mes, COUNT(DISTINCT(clave_registro)) AS inspeciones
                    FROM tb_respuesta
                    WHERE (respuesta= 'No' OR respuesta= 'Irregular' OR respuesta= '7' OR respuesta= '6' OR respuesta= '5')
                    AND fecha LIKE '%$anio%'
                    GROUP BY mes";

        $mes = DB::select($query);

        return $mes;
    }
}
