<?php
use App\Http\Controllers\OpcionesExtrasController;

$encuestas = OpcionesExtrasController::getEncuestas();

$encuestas2 = OpcionesExtrasController::getEncuestasN();


?>
<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link text-dark" href="/home">
        <i class=" fas fa-building"></i><span>Inicio</span>
    </a>
    @can('ver-user')
    <a class="nav-link text-dark" href="/usuarios">
        <i class=" fas fa-users"></i><span>Usuarios</span>
    </a>
    @endcan
    @can('ver-rol')
    <a class="nav-link text-dark" href="/roles">
        <i class=" fas fa-user-lock"></i><span>Roles</span>
    </a>
    @endcan
    @can('accor')
        @foreach($encuestas as $encuesta)
            <a class="nav-link text-dark" href=""><i class="fas fa-file"></i><span>{{ $encuesta->c_nombre_encuesta }}</span></a>
                @foreach(OpcionesExtrasController::getBloques($encuesta->id_encuesta) as $bloque)
                    <li>{{ $bloque->c_nombre_bloque }}</li>
                @endforeach
        @endforeach
    @endcan
    @can('accor-novotel')
        @foreach($encuestas2 as $encuesta)
            <a class="nav-link text-dark" href=""><i class="fas fa-file"></i><span>{{ $encuesta->c_nombre_encuesta }}</span></a>
            <ul>
                @foreach(OpcionesExtrasController::getBloques($encuesta->id_encuesta) as $bloque)
                    <li>{{ $bloque->c_nombre_bloque }}</li>
                @endforeach
            </ul>
        @endforeach
    @endcan
</li>
