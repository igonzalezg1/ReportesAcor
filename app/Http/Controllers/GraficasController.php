<?php

namespace App\Http\Controllers;

use App\Models\tb_respuesta;
use Illuminate\Http\Request;
use DateTime;
use Carbon\Carbon;
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

    public static function getprogessday()
    {
        $sqldiario = "SELECT count(DISTINCT clave_registro) AS registros FROM tb_respuesta R
                        INNER JOIN tb_encuesta E ON E.id_encuesta=R.idcuestionario
                        WHERE usuario='" . \Auth::user()->email . "' AND E.c_nombre_encuesta='Diario' AND DAY(R.fecha)=DAY(NOW()) AND MONTH(R.fecha)=MONTH(NOW()) AND YEAR(R.fecha)=YEAR(NOW())  ";
        $querydiario = DB::select($sqldiario);
        $arraydiario = array(); // Array donde vamos a guardar los datos
        foreach ($querydiario as $row) {
            $arraydiario[] = $row;
        }

        foreach ($arraydiario as $diario) :
            $rdiario = $diario->registros;
        endforeach;

        if ($rdiario > 9) {
            $rdiario = 9;
        }

        return $rdiario;
    }

    public static function getprogressmonth()
    {
        $sqlmensual = "
                    SELECT count(DISTINCT idbloque) AS registros FROM tb_respuesta R
                    INNER JOIN tb_encuesta E ON E.id_encuesta=R.idcuestionario
                    WHERE usuario='" . \Auth::user()->email . "' AND E.c_nombre_encuesta='Mensual' AND MONTH(R.fecha)=MONTH(NOW()) AND YEAR(R.fecha)=YEAR(NOW())";
        $querymensual = DB::select($sqlmensual);
        $arraymensual = array(); // Array donde vamos a guardar los datos
        foreach ($querymensual as $row) {
            $arraymensual[] = $row;
        }

        foreach ($arraymensual as $mensual) :
            $rmensual = $mensual->registros;
        endforeach;

        return $rmensual;
    }

    public static function getprogressbimonth()
    {
        $sqlbimensual = "
        SELECT count(DISTINCT clave_registro) AS registros FROM tb_respuesta R
        INNER JOIN tb_encuesta E ON E.id_encuesta=R.idcuestionario
        WHERE usuario='" . \Auth::user()->email . "' AND E.c_nombre_encuesta='Bimensual (feb, abr, jun, ago, oct, dic)' AND YEAR(R.fecha)=YEAR(NOW()) AND MONTH(R.fecha)=MONTH(NOW())";
        $querybimensual = DB::select($sqlbimensual);
        $arraybimensual = array(); // Array donde vamos a guardar los datos
        foreach ($querybimensual as $row) {
            $arraybimensual[] = $row;
        }

        foreach ($arraybimensual as $bimensual) :
            $rbimensual = $bimensual->registros;
        endforeach;

        if ($rbimensual > 91) {
            $rbimensual = 91;
        }

        if ($rbimensual > 42) {
            $rbimensual = 42;
        }

        return $rbimensual;
    }

    public static function getprogresssemestral()
    {
        $sqlsemestral = "
                        SELECT count(DISTINCT clave_registro) AS registros FROM tb_respuesta R
                        INNER JOIN tb_encuesta E ON E.id_encuesta=R.idcuestionario
                        WHERE usuario='" . \Auth::user()->email . "' AND E.c_nombre_encuesta IN ('Anual y semestral (ENERO)','Anual y semestral (FEBRERO)','Anual y semestral (MARZO)','Anual y semestral (ABRIL)','Anual y Semestral (MAYO)','Anual y semestral (JULIO)','Anual y semestral (AGOSTO)','Anual y semestral (SEPTIEMBRE)','Anual y semestral (OCTUBRE)','Anual y Semestral (NOVIEMBRE)','Anual DICIEMBRE') AND YEAR(R.fecha)=YEAR(NOW()) AND MONTH(R.fecha)=MONTH(NOW())
        ";
        $querysemestral = DB::select($sqlsemestral);
        $arraysemestral = array(); // Array donde vamos a guardar los datos
        foreach ($querysemestral as $row) {
            $arraysemestral[] = $row;
        }

        foreach ($arraysemestral as $semestral) :
            $rsemestral = $semestral->registros;
        endforeach;

        return $rsemestral;
    }

    public static function gettablasemestral()
    {
        $fechaActual = Carbon::now('America/Mexico_City');
        $meses['01'] = 'Enero';
        $meses['02'] = 'Febrero';
        $meses['03'] = 'Marzo';
        $meses['04'] = 'Abril';
        $meses['05'] = 'Mayo';
        $meses['06'] = 'Junio';
        $meses['07'] = 'Julio';
        $meses['08'] = 'Agosto';
        $meses['09'] = 'Septiembre';
        $meses['10'] = 'Octubre';
        $meses['11'] = 'Noviembre';
        $meses['12'] = 'Diciembre';
        $mesActual = $fechaActual->format('m');
        $mesact = $meses[$mesActual];

        switch ($mesact) {
            case 'Enero':
                $idCuestionarioAS = 88;
                $trim = false;
                $bime = false;
                break;

            case 'Febrero':
                $idCuestionarioAS = 89;
                $trim = false;
                $bime = true;
                break;

            case 'Marzo':
                $idCuestionarioAS = 90;
                $trim = true;
                $bime = false;
                break;

            case 'Abril':
                $idCuestionarioAS = 91;
                $trim = false;
                $bime = true;
                break;

            case 'Mayo':
                $idCuestionarioAS = 92;
                $trim = false;
                $bime = false;
                break;

            case 'Junio':
                $trim = true;
                $bime = true;
                break;

            case 'Julio':
                $idCuestionarioAS = 94;
                $trim = false;
                $bime = false;
                break;

            case 'Agosto':
                $idCuestionarioAS = 95;
                $trim = false;
                $bime = true;
                break;

            case 'Septiembre':
                $idCuestionarioAS = 96;
                $trim = true;
                $bime = false;
                break;

            case 'Octubre':
                $idCuestionarioAS = 97;
                $trim = false;
                $bime = true;
                break;

            case 'Noviembre':
                $idCuestionarioAS = 98;
                $trim = false;
                $bime = false;
                break;

            case 'Diciembre':
                $idCuestionarioAS = 99;
                $trim = true;
                $bime = true;
                break;
        }

        $sucursal = \Auth::user()->username;
        $query = "
            SELECT id_sucursal as id FROM tb_sucursal WHERE sucursal='$sucursal' LIMIT 1";

        foreach (DB::select($query) as $row) {
            $idSucursal = $row->id;
        }

        $idModal = str_replace('/', '', str_replace(' ', '', strtolower('Anual/Semestral')));

        $query = "
            SELECT
                id_bloque as id,
                numero as punto,
                id_encuesta,
                c_nombre_bloque as titulo
                FROM tb_encuesta_bloque
                WHERE id_encuesta='$idCuestionarioAS'
                ORDER BY n_orden_bloque ASC ";

        $bloques = DB::select($query);

        $query =
            "
                SELECT
                idbloque as id_bloque,
                MAX(fecha)
                FROM tb_respuesta
                WHERE idbloque IN ('" .
            implode("', '", array_column($bloques, 'id')) .
            "')
                AND YEAR(fecha)=$fechaActual->yearIso
                AND MONTH(fecha)=$fechaActual->month
                AND sucursal=$idSucursal
                GROUP BY idbloque ASC
            ";

        $respuestas = DB::select($query);

        $bloques_resultado = [];
        foreach ($respuestas as $respuesta) {
            if (in_array($respuesta['id_bloque'], array_column($bloques, 'id'))) {
                $bloque_encontrado = $bloques[array_search($respuesta['id_bloque'], array_column($bloques, 'id'))];
                array_push($bloques_resultado, [
                    'id' => $bloque_encontrado['id'],
                    'punto' => $bloque_encontrado['punto'],
                    'titulo' => $bloque_encontrado['titulo'],
                    'contesto' => 'Si',
                ]);
            }
        }

        foreach ($bloques as $bloque) {
            if (!in_array($bloque->id, array_column($bloques_resultado, 'id'))) {
                array_push($bloques_resultado, [
                    'id' => $bloque->id,
                    'punto' => $bloque->punto,
                    'titulo' => $bloque->titulo,
                    'contesto' => 'No',
                ]);
            }
        }

        $correctos = count(
            array_filter($bloques_resultado, function ($item) {
                return $item['contesto'] == 'Si';
            }),
        );

        return $bloques_resultado;
    }

    public static function gettablasdiario()
    {
        $fechaActual = Carbon::now('America/Mexico_City');
        $meses['01'] = 'Enero';
        $meses['02'] = 'Febrero';
        $meses['03'] = 'Marzo';
        $meses['04'] = 'Abril';
        $meses['05'] = 'Mayo';
        $meses['06'] = 'Junio';
        $meses['07'] = 'Julio';
        $meses['08'] = 'Agosto';
        $meses['09'] = 'Septiembre';
        $meses['10'] = 'Octubre';
        $meses['11'] = 'Noviembre';
        $meses['12'] = 'Diciembre';
        $mesActual = $fechaActual->format('m');
        $mesact = $meses[$mesActual];

        switch ($mesact) {
            case 'Enero':
                $idCuestionarioAS = 88;
                $trim = false;
                $bime = false;
                break;

            case 'Febrero':
                $idCuestionarioAS = 89;
                $trim = false;
                $bime = true;
                break;

            case 'Marzo':
                $idCuestionarioAS = 90;
                $trim = true;
                $bime = false;
                break;

            case 'Abril':
                $idCuestionarioAS = 91;
                $trim = false;
                $bime = true;
                break;

            case 'Mayo':
                $idCuestionarioAS = 92;
                $trim = false;
                $bime = false;
                break;

            case 'Junio':
                $trim = true;
                $bime = true;
                break;

            case 'Julio':
                $idCuestionarioAS = 94;
                $trim = false;
                $bime = false;
                break;

            case 'Agosto':
                $idCuestionarioAS = 95;
                $trim = false;
                $bime = true;
                break;

            case 'Septiembre':
                $idCuestionarioAS = 96;
                $trim = true;
                $bime = false;
                break;

            case 'Octubre':
                $idCuestionarioAS = 97;
                $trim = false;
                $bime = true;
                break;

            case 'Noviembre':
                $idCuestionarioAS = 98;
                $trim = false;
                $bime = false;
                break;

            case 'Diciembre':
                $idCuestionarioAS = 99;
                $trim = true;
                $bime = true;
                break;
        }

        $sucursal = \Auth::user()->username;
        $query = "
            SELECT id_sucursal as id FROM tb_sucursal WHERE sucursal='$sucursal' LIMIT 1";

        foreach (DB::select($query) as $row) {
            $idSucursal = $row->id;
        }

        $query = "
            SELECT
                id_bloque as id,
                numero as punto,
                id_encuesta,
                c_nombre_bloque as titulo
                FROM tb_encuesta_bloque
                WHERE id_encuesta=84
                ORDER BY n_orden_bloque ASC ";

        $bloques = DB::select($query);

        $query =
            "
                SELECT
                idbloque as id_bloque,
                MAX(fecha)
                FROM tb_respuesta
                WHERE idbloque IN ('" .
            implode("', '", array_column($bloques, 'id')) .
            "')
                AND YEAR(fecha)=$fechaActual->yearIso
                AND MONTH(fecha)=$fechaActual->month
                AND DAY(fecha)=$fechaActual->day
                AND sucursal=$idSucursal
                GROUP BY idbloque ASC
            ";

        $respuestas = DB::select($query);

        $bloques_resultado = [];
        foreach ($respuestas as $respuesta) {
            if (in_array($respuesta['id_bloque'], array_column($bloques, 'id'))) {
                $bloque_encontrado = $bloques[array_search($respuesta['id_bloque'], array_column($bloques, 'id'))];
                array_push($bloques_resultado, [
                    'id' => $bloque_encontrado['id'],
                    'punto' => $bloque_encontrado['punto'],
                    'titulo' => $bloque_encontrado['titulo'],
                    'contesto' => 'Si',
                ]);
            }
        }

        foreach ($bloques as $bloque) {
            if (!in_array($bloque->id, array_column($bloques_resultado, 'id'))) {
                array_push($bloques_resultado, [
                    'id' => $bloque->id,
                    'punto' => $bloque->punto,
                    'titulo' => $bloque->titulo,
                    'contesto' => 'No',
                ]);
            }
        }

        $correctos = count(
            array_filter($bloques_resultado, function ($item) {
                return $item['contesto'] == 'Si';
            }),
        );

        return $bloques_resultado;
    }

    public static function gettablamensual()
    {
        $fechaActual = Carbon::now('America/Mexico_City');
        $meses['01'] = 'Enero';
        $meses['02'] = 'Febrero';
        $meses['03'] = 'Marzo';
        $meses['04'] = 'Abril';
        $meses['05'] = 'Mayo';
        $meses['06'] = 'Junio';
        $meses['07'] = 'Julio';
        $meses['08'] = 'Agosto';
        $meses['09'] = 'Septiembre';
        $meses['10'] = 'Octubre';
        $meses['11'] = 'Noviembre';
        $meses['12'] = 'Diciembre';
        $mesActual = $fechaActual->format('m');
        $mesact = $meses[$mesActual];

        switch ($mesact) {
            case 'Enero':
                $idCuestionarioAS = 88;
                $trim = false;
                $bime = false;
                break;

            case 'Febrero':
                $idCuestionarioAS = 89;
                $trim = false;
                $bime = true;
                break;

            case 'Marzo':
                $idCuestionarioAS = 90;
                $trim = true;
                $bime = false;
                break;

            case 'Abril':
                $idCuestionarioAS = 91;
                $trim = false;
                $bime = true;
                break;

            case 'Mayo':
                $idCuestionarioAS = 92;
                $trim = false;
                $bime = false;
                break;

            case 'Junio':
                $trim = true;
                $bime = true;
                break;

            case 'Julio':
                $idCuestionarioAS = 94;
                $trim = false;
                $bime = false;
                break;

            case 'Agosto':
                $idCuestionarioAS = 95;
                $trim = false;
                $bime = true;
                break;

            case 'Septiembre':
                $idCuestionarioAS = 96;
                $trim = true;
                $bime = false;
                break;

            case 'Octubre':
                $idCuestionarioAS = 97;
                $trim = false;
                $bime = true;
                break;

            case 'Noviembre':
                $idCuestionarioAS = 98;
                $trim = false;
                $bime = false;
                break;

            case 'Diciembre':
                $idCuestionarioAS = 99;
                $trim = true;
                $bime = true;
                break;
        }

        $sucursal = \Auth::user()->username;
        $query = "
            SELECT id_sucursal as id FROM tb_sucursal WHERE sucursal='$sucursal' LIMIT 1";

        foreach (DB::select($query) as $row) {
            $idSucursal = $row->id;
        }

        $idModal = str_replace('/', '', str_replace(' ', '', strtolower('Anual/Semestral')));

        $query = "
            SELECT
                id_bloque as id,
                numero as punto,
                id_encuesta,
                c_nombre_bloque as titulo
                FROM tb_encuesta_bloque
                WHERE id_encuesta=85
                ORDER BY n_orden_bloque ASC ";

        $bloques = DB::select($query);

        $query =
            "
                SELECT
                idbloque as id_bloque,
                MAX(fecha)
                FROM tb_respuesta
                WHERE idbloque IN ('" .
            implode("', '", array_column($bloques, 'id')) .
            "')
                AND YEAR(fecha)=$fechaActual->yearIso
                AND MONTH(fecha)=$fechaActual->month
                AND sucursal=$idSucursal
                GROUP BY idbloque ASC
            ";

        $respuestas = DB::select($query);

        $bloques_resultado = [];
        foreach ($respuestas as $respuesta) {
            if (in_array($respuesta['id_bloque'], array_column($bloques, 'id'))) {
                $bloque_encontrado = $bloques[array_search($respuesta['id_bloque'], array_column($bloques, 'id'))];
                array_push($bloques_resultado, [
                    'id' => $bloque_encontrado['id'],
                    'punto' => $bloque_encontrado['punto'],
                    'titulo' => $bloque_encontrado['titulo'],
                    'contesto' => 'Si',
                ]);
            }
        }

        foreach ($bloques as $bloque) {
            if (!in_array($bloque->id, array_column($bloques_resultado, 'id'))) {
                array_push($bloques_resultado, [
                    'id' => $bloque->id,
                    'punto' => $bloque->punto,
                    'titulo' => $bloque->titulo,
                    'contesto' => 'No',
                ]);
            }
        }

        $correctos = count(
            array_filter($bloques_resultado, function ($item) {
                return $item['contesto'] == 'Si';
            }),
        );

        return $bloques_resultado;
    }

    public static function gettablabimestral()
    {
        $fechaActual = Carbon::now('America/Mexico_City');
        $meses['01'] = 'Enero';
        $meses['02'] = 'Febrero';
        $meses['03'] = 'Marzo';
        $meses['04'] = 'Abril';
        $meses['05'] = 'Mayo';
        $meses['06'] = 'Junio';
        $meses['07'] = 'Julio';
        $meses['08'] = 'Agosto';
        $meses['09'] = 'Septiembre';
        $meses['10'] = 'Octubre';
        $meses['11'] = 'Noviembre';
        $meses['12'] = 'Diciembre';
        $mesActual = $fechaActual->format('m');
        $mesact = $meses[$mesActual];

        switch ($mesact) {
            case 'Enero':
                $idCuestionarioAS = 88;
                $trim = false;
                $bime = false;
                break;

            case 'Febrero':
                $idCuestionarioAS = 89;
                $trim = false;
                $bime = true;
                break;

            case 'Marzo':
                $idCuestionarioAS = 90;
                $trim = true;
                $bime = false;
                break;

            case 'Abril':
                $idCuestionarioAS = 91;
                $trim = false;
                $bime = true;
                break;

            case 'Mayo':
                $idCuestionarioAS = 92;
                $trim = false;
                $bime = false;
                break;

            case 'Junio':
                $trim = true;
                $bime = true;
                break;

            case 'Julio':
                $idCuestionarioAS = 94;
                $trim = false;
                $bime = false;
                break;

            case 'Agosto':
                $idCuestionarioAS = 95;
                $trim = false;
                $bime = true;
                break;

            case 'Septiembre':
                $idCuestionarioAS = 96;
                $trim = true;
                $bime = false;
                break;

            case 'Octubre':
                $idCuestionarioAS = 97;
                $trim = false;
                $bime = true;
                break;

            case 'Noviembre':
                $idCuestionarioAS = 98;
                $trim = false;
                $bime = false;
                break;

            case 'Diciembre':
                $idCuestionarioAS = 99;
                $trim = true;
                $bime = true;
                break;
        }

        $sucursal = \Auth::user()->username;
        $query = "
            SELECT id_sucursal as id FROM tb_sucursal WHERE sucursal='$sucursal' LIMIT 1";

        foreach (DB::select($query) as $row) {
            $idSucursal = $row->id;
        }

        $idModal = str_replace('/', '', str_replace(' ', '', strtolower('Anual/Semestral')));

        if($bime)
        {
            $select = 86;
        }
        else
        {
            $select = 87;
        }
        $query = "
            SELECT
                id_bloque as id,
                numero as punto,
                id_encuesta,
                c_nombre_bloque as titulo
                FROM tb_encuesta_bloque
                WHERE id_encuesta=$select
                ORDER BY n_orden_bloque ASC ";

        $bloques = DB::select($query);

        $query =
            "
                SELECT
                idbloque as id_bloque,
                MAX(fecha)
                FROM tb_respuesta
                WHERE idbloque IN ('" .
            implode("', '", array_column($bloques, 'id')) .
            "')
                AND YEAR(fecha)=$fechaActual->yearIso
                AND MONTH(fecha)=$fechaActual->month
                AND sucursal=$idSucursal
                GROUP BY idbloque ASC
            ";

        $respuestas = DB::select($query);

        $bloques_resultado = [];
        foreach ($respuestas as $respuesta) {
            if (in_array($respuesta['id_bloque'], array_column($bloques, 'id'))) {
                $bloque_encontrado = $bloques[array_search($respuesta['id_bloque'], array_column($bloques, 'id'))];
                array_push($bloques_resultado, [
                    'id' => $bloque_encontrado['id'],
                    'punto' => $bloque_encontrado['punto'],
                    'titulo' => $bloque_encontrado['titulo'],
                    'contesto' => 'Si',
                ]);
            }
        }

        foreach ($bloques as $bloque) {
            if (!in_array($bloque->id, array_column($bloques_resultado, 'id'))) {
                array_push($bloques_resultado, [
                    'id' => $bloque->id,
                    'punto' => $bloque->punto,
                    'titulo' => $bloque->titulo,
                    'contesto' => 'No',
                ]);
            }
        }

        $correctos = count(
            array_filter($bloques_resultado, function ($item) {
                return $item['contesto'] == 'Si';
            }),
        );

        return $bloques_resultado;
    }
}
