<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\tb_encuesta_bloque;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\tb_encuesta;
use App\Models\tb_habitaciones;
use App\Models\tb_respuesta;
use Carbon\Carbon;
use GuzzleHttp\Client;
use DateTime;

class OpcionesExtrasController extends Controller
{
    public function cambiarcontrasena(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|same:confirm-password',
            'passwordold' => 'required',
        ]);

        $pasword = $request->passwordold;
        $usuario = \Auth::user()->password;
        if (Hash::check($pasword, $usuario)) {
            $cambio = \Auth::user()->user_id;
            $usuarioc = User::find($cambio);
            $pasword = $request->password;
            $usuarioc->update([
                'password' => Hash::make($pasword)
            ]);
            $usuarioc->save();
            return back()->with('resultado', 'okcontra');
        } else {
            return back()->with('resultado', 'nocontra');
        }
    }

    public function cambiarfotop(Request $request)
    {
        $this->validate($request, [
            'profile_image' => 'required|image',
        ]);

        $imagen = $request->file('profile_image')->store('public/fotosperfil');
        $url = Storage::url($imagen);
        $cambio = \Auth::user()->user_id;
        $usuarioc = User::find($cambio);
        $usuarioc->update([
            'profile_image' => $url,
        ]);

        return back()->with('resultado', 'imgcamb');
    }

    public static function getEncuestas()
    {
        $encuestas = tb_encuesta::where('id_app', 16)->where('c_nombre_encuesta', 'NOT LIKE', '%Anual%')->get();

        return $encuestas;
    }

    public static function getBloques($id_encuesta)
    {
        $bloques = tb_encuesta_bloque::where('id_encuesta', $id_encuesta)->get();

        return $bloques;
    }

    public static function getAnualBim()
    {
        $encuestas3 = tb_encuesta::where('id_app', 16)->where('c_nombre_encuesta', 'LIKE', '%Anual%')->get();

        return $encuestas3;
    }

    public static function getCalMens()
    {
        $fechaact = Carbon::now();
        $calif = ['avance_pmp','fecha_calificacion'];
        $hotel = \Auth::user()->description;

        $consulta = "SELECT * FROM calificaciones_mensuales WHERE fecha_calificacion = (SELECT max(fecha_calificacion) FROM calificaciones_mensuales) AND hotel = '$hotel'";

        $calificacionMensual = DB::select($consulta);

        foreach ($calificacionMensual as $cm) {
            $calif = $cm;
        }
        return $calif;
    }

    public static function habitacion19()
    {
        $carbon = Carbon::now('America/Mexico_City');
        $iniciales = \Auth::user()->username;
        $punto = 19;
        $anio = $carbon->yearIso;
        $mes = $carbon->month;

        $res = OpcionesExtrasController::getHabitacion19($iniciales, $punto, $anio, $mes);

        return $res;
    }

    public static function habitacion192($mes)
    {
        $carbon = Carbon::now('America/Mexico_City');
        $iniciales = \Auth::user()->username;
        $punto = 19;
        $anio = $carbon->yearIso;

        $res = OpcionesExtrasController::getHabitacion19($iniciales, $punto, $anio, $mes);

        return $res;
    }

    public static function habitaciones15()
    {
        $iniciales = \Auth::user()->username;
        $query = "SELECT id_sucursal FROM tb_sucursal WHERE sucursal = '$iniciales' LIMIT 1";
        $hotelesres = DB::select($query);
        foreach ($hotelesres as $hr) {
            $hotel = $hr->id_sucursal;
        }

        $habitaciones = tb_habitaciones::query()
            ->where('id_sucursal', $hotel)
            ->get();

        $habitaciones = $habitaciones->toArray();

        $primer_habitacion = $habitaciones[0];
        $pisos_base_datos = [];
        $pisos_reales = [];
        foreach (array_keys($primer_habitacion) as $key) {
            if (substr($key, 0, 4) == 'piso') {
                $pisos_base_datos[] = $key;
            }
        }

        foreach ($pisos_base_datos as $piso) {
            if ($primer_habitacion[$piso] != null) {
                $pisos_reales[] = $piso;
            }
        }

        if (count($pisos_reales) == 0) {
            return [];
        }

        $habitaciones_real = [];
        foreach ($habitaciones as $habitacion) {
            foreach ($pisos_reales as $piso) {
                if ($habitacion[$piso] != null) {
                    array_push($habitaciones_real, $habitacion[$piso]);
                }
            }
        }

        return count($habitaciones_real);
    }

    public static function habitacion21()
    {
        $carbon = Carbon::now('America/Mexico_City');
        $iniciales = \Auth::user()->username;
        $punto = 21;
        $anio = $carbon->yearIso;
        $mes = $carbon->month;

        $res = OpcionesExtrasController::getHabitacion19($iniciales, $punto, $anio, $mes);

        return $res;
    }

    public static function habitacion212($mes)
    {
        $carbon = Carbon::now('America/Mexico_City');
        $iniciales = \Auth::user()->username;
        $punto = 21;
        $anio = $carbon->yearIso;

        $res = OpcionesExtrasController::getHabitacion19($iniciales, $punto, $anio, $mes);

        return $res;
    }

    //ID app 16
    public static function getStps(array $arraypuntos)
    {
        $query = 'SELECT id_bloque, c_nombre_bloque as nombre, numero, id_encuesta as ide
        FROM tb_encuesta_bloque
        WHERE id_encuesta IN (SELECT id_encuesta FROM tb_encuesta WHERE id_app=' . 16 . ')
        AND numero IN (\'' . implode("', '", $arraypuntos) . '\')
        GROUP BY numero
        ORDER BY n_orden_bloque ASC ';

        $stps = DB::select($query);

        return $stps;
    }

    public static function getInfoTickets()
    {
        $username = \Auth::user()->username;
        $query = "SELECT U.id_sucursal , U.id_empresa FROM tb_usuario U INNER JOIN tb_sucursal S ON S.id_sucursal=U.id_sucursal
        INNER JOIN tb_empresa E ON E.id_empresa=U.id_empresa WHERE S.sucursal='" . $username . "' GROUP BY S.sucursal";

        $sttickets = DB::select($query);

        foreach ($sttickets as $ticket) {
            $valores = [$ticket->id_empresa, $ticket->id_sucursal];
        }

        return $valores;
    }

    public static function getMesesHeader()
    {
        $allmonth = array(
            "ENERO",
            "FEBRERO",
            "MARZO",
            "ABRIL",
            "MAYO",
            "JUNIO",
            "JULIO",
            "AGOSTO",
            "SEPTIEMBRE",
            "OCTUBRE",
            "NOVIEMBRE",
            "DICIEMBRE"
        );
        $now = new DateTime();
        $thismonth = $now->format('n') - 1;
        if ($thismonth == 0) {
            $thismonth = 12;
        }
        $rangeMonths = array_slice($allmonth, 0, $thismonth);

        return $rangeMonths;
    }

    public static function getMonth()
    {
        $now = new DateTime();
        $thismonth = $now->format('n') - 1;
        if ($thismonth == 0) {
            $thismonth = 12;
        }

        return $thismonth;
    }

    public static function getUser()
    {
        $usuario = \Auth::user();

        return $usuario;
    }

    public static function getHabitacion19($iniciales, $punto, $anio, $mes)
    {
        $query = "SELECT id_sucursal FROM tb_sucursal WHERE sucursal = '$iniciales' LIMIT 1";
        $hotelesres = DB::select($query);
        foreach ($hotelesres as $hr) {
            $hotel = $hr->id_sucursal;
        }
        $query = "SELECT  A.id_app as id_app, S.id_sucursal as id_sucursal, E.id_encuesta as id_encuesta, B.id_bloque as id_bloque, P.id_pregunta as id_pregunta
        FROM tb_encuesta_pregunta as P
        INNER JOIN tb_encuesta_bloque as B ON B.id_bloque = P.id_bloque
        INNER JOIN tb_encuesta AS E ON E.id_encuesta = B.id_encuesta
        INNER JOIN tb_app AS A ON A.id_app = E.id_app
        INNER JOIN tb_sucursal as S ON S.id_app = A.id_app
        WHERE S.id_sucursal=$hotel
        AND E.periodicidad='Diario'
        AND B.numero=$punto
        AND P.n_orden_pregunta=1
        LIMIT 1";

        $preguntas = DB::select($query);
        foreach ($preguntas as $pr) {
            $pregunta = $pr;
        }

        $respuestas = tb_respuesta::query()
            ->select('respuesta')
            ->where('sucursal', $pregunta->id_sucursal)
            ->whereYear('fecha', $anio)
            ->whereMonth('fecha', $mes)
            ->where('idcuestionario', $pregunta->id_encuesta)
            ->where('idbloque', $pregunta->id_bloque)
            ->where('idpregunta', $pregunta->id_pregunta)
            ->groupBy('clave_registro')
            ->get();

        return $respuestas->count();
    }
}
