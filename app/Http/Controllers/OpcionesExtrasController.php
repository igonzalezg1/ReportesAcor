<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\tb_encuesta_bloque;
use App\Models\tb_encuesta_pregunta;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\tb_encuesta;
use App\Models\calificaciones_mensuales;

class OpcionesExtrasController extends Controller
{
    public function cambiarcontrasena(Request $request){
        $this->validate($request, [
            'password'=> 'required|same:confirm-password',
            'passwordold' =>'required',
        ]);

        $pasword = $request->passwordold;
        $usuario = \Auth::user()->password;
        if(Hash::check($pasword, $usuario))
        {
            $cambio = \Auth::user()->user_id;
            $usuarioc = User::find($cambio);
            $pasword = $request->password;
            $usuarioc->update([
                'password'=> Hash::make($pasword)
            ]);
            $usuarioc->save();
            return back()->with('resultado', 'okcontra');
        }else{
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
        $encuestas = tb_encuesta::where('id_app', 16)->where('c_nombre_encuesta','NOT LIKE', '%Anual%')->get();

        return $encuestas;
    }

    public static function getBloques($id_encuesta)
    {
        $bloques = tb_encuesta_bloque::where('id_encuesta', $id_encuesta)->get();

        return $bloques;
    }

    public static function getAnualBim()
    {
        $encuestas3 = tb_encuesta::where('id_app', 16)->where('c_nombre_encuesta','LIKE', '%Anual%')->get();

        return $encuestas3;
    }

    public static function getCalMens()
    {
        $hotel = \Auth::user()->description;

        $consulta = "SELECT * FROM calificaciones_mensuales WHERE fecha_calificacion = (SELECT max(fecha_calificacion) FROM calificaciones_mensuales) AND hotel = '$hotel'";

        $calificacionMensual = DB::select($consulta);

        foreach ($calificacionMensual as $cm){
            $calif = $cm;
        }
        return $calif;
    }
}
