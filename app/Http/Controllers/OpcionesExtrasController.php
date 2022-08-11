<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\tb_encuesta_bloque;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\tb_encuesta;

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
        $encuestas = tb_encuesta::where('id_app', 16)->get();

        return $encuestas;
    }

    public static function getBloques($id_encuesta)
    {
        $bloques = tb_encuesta_bloque::where('id_encuesta', $id_encuesta)->get();

        return $bloques;
    }

    public static function getEncuestasN()
    {
        $encuestas2 = tb_encuesta::where('id_app', 24)->get();

        return $encuestas2;
    }
}
