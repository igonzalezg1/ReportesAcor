<?php

use Illuminate\Support\Facades\Route;
//Controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\OpcionesExtrasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});



Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('cambiarcontrasena', [App\Http\Controllers\OpcionesExtrasController::class, 'cambiarcontrasena'])->name('cambiarcontrasena');
Route::post('cambiarfotop', [App\Http\Controllers\OpcionesExtrasController::class, 'cambiarfotop'])->name('cambiarfotop');
Route::group(['middleware'=> ['auth']], function(){
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('roles', RolController::class);

    //Rutas de reportes

    Route::get('getRespuestas/{id_encuesta}/{id_bloque}/{punto}', [App\Http\Controllers\ReportesController::class, 'getRespuestas'])->name('getRespuestas');

    Route::get('getRespuestas19/{id_encuesta}/{id_bloque}/{punto}/{piso}', [App\Http\Controllers\Reportes19Controller::class, 'getRespuestas'])->name('getRespuestas19');

    Route::get('getRespuestas21/{id_encuesta}/{id_bloque}/{punto}/{piso}', [App\Http\Controllers\Reportes21Controller::class, 'getRespuestas'])->name('getRespuestas21');

    Route::get('filtrar_fechas/{start_date}/{end_date}/{id_encuesta}/{id_bloque}/{punto}', [App\Http\Controllers\ReportesController::class, 'filtrar_fechas'])->name('filtrar_fechas');

    Route::get('sabanas',[App\Http\Controllers\SabanasController::class, 'index'])->name('sabanas');

    Route::get('mostrarlasg',[App\Http\Controllers\GraficasController::class, 'index'])->name('mostrarlasg');

    Route::post('getsabanas21',[App\Http\Controllers\SabanasController::class, 'getsabanas21'])->name('getsabanas21');

    Route::post('getsabanas19',[App\Http\Controllers\SabanasController::class, 'getsabanas19'])->name('getsabanas19');

    Route::post('getPreguntaEsp', [App\Http\Controllers\SabanasController::class, 'getPreguntaEsp'])->name('getPreguntaEsp');

    Route::post('getlimpieza',[App\Http\Controllers\SabanasController::class, 'getlimpieza'])->name('getlimpieza');

    Route::get('getcalmensual/{mes}', [App\Http\Controllers\CalificacionMensualController::class, 'index'])->name('getcalmensual');
});
