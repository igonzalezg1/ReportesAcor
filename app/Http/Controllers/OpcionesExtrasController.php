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
use Carbon\Carbon;
use GuzzleHttp\Client;

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
        $punto19 = 0;
        $carbon = Carbon::now('America/Mexico_City');
        $client = new \GuzzleHttp\Client();

        $res = $client->get(
            'https://dashboard.sumapp.cloud/api/helpers/habitaciones-punto',
            ['query' => [
                'iniciales_hotel' => \Auth::user()->username,
                'punto' => 19,
                'año' => $carbon->yearIso,
                'mes' => $carbon->month
            ]]
        );

        if ($res->getStatusCode() == 200) {
            $punto19 = $res->getBody();
        }

        return "Hola mundo";
    }

    public static function habitacion21()
    {
        $punto21 = 0;
        $carbon = Carbon::now('America/Mexico_City');
        $client = new \GuzzleHttp\Client();

        $res = $client->get(
            'https://dashboard.sumapp.cloud/api/helpers/habitaciones-punto',
            ['query' => [
                'iniciales_hotel' => \Auth::user()->username,
                'punto' => 21,
                'año' => $carbon->yearIso,
                'mes' => $carbon->month
            ]]
        );

        if ($res->getStatusCode() == 200) {
            $punto21 = $res->getBody();
        }

        return "Hola mundo";
    }

    public static function habitacion15()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->get('https://dashboard.sumapp.cloud/api/helpers/habitaciones', [
            'query' => [
                'iniciales_hotel' => \Auth::user()->username
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            $habitaciones = json_decode($res->getBody());
            $habitaciones15 = round((15 / 100) * $habitaciones, 0);
        }

        return $habitaciones15;
    }
}
