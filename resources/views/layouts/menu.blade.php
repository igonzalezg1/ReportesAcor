<?php

use App\Http\Controllers\OpcionesExtrasController;

$encuestas = OpcionesExtrasController::getEncuestas();

$encuestas3 = OpcionesExtrasController::getAnualBim();


?>

<style>
    .miclasex {
        background-color: #414956 !important;
    }

    .miclasey {
        background-color: #414956 !important;
        padding: 50px !important;
    }

    .miclasey:hover {
        background-color: #D8B465 !important;
    }

    .miclasex:hover {
        background-color: #D8B465 !important;
    }
</style>

<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link text-white miclasex" href="/home"><i class=" fas fa-building"></i><span>Inicio</span></a>
    @can('ver-user')
        <a class="nav-link text-white miclasex" href="/usuarios"><i class=" fas fa-users"></i><span>Usuarios</span></a>
    @endcan

    @can('ver-rol')
        <a class="nav-link text-white miclasex" href="/roles"><i class=" fas fa-user-lock"></i><span>Roles</span></a>
    @endcan

        <li class="menu-header">Reportes Accor</li>
        <li class="dropdown">
            @foreach($encuestas as $encuesta)
                <li class="dropdown">
                    <a href="" class="nav-link has-dropdown text-white miclasex"><i class=" fas fa-file-alt"></i><span>{{ substr($encuesta->c_nombre_encuesta, 0, 10) }}</span></a>
                    <ul class="dropdown-menu">
                        @foreach(OpcionesExtrasController::getBloques($encuesta->id_encuesta) as $bloque)
                            <li><a href="{{ route('getRespuestas', ['id_encuesta'=> $encuesta->id_encuesta, 'id_bloque'=> $bloque->id_bloque, 'punto'=> $bloque->c_nombre_bloque]) }}" class="nav-link text-white miclasey">{{ $bloque->c_nombre_bloque }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </li>

        <li class="nav-item dropdown">
            <li class="nav-item dropdown">
                    <a href="" class="nav-link has-dropdown text-white miclasex"><i class=" fas fa-file-alt"></i><span>Anual y semestral</span></a>
                    <ul class="dropdown-menu">
                        <li class="nav-item dropdown">
                            @foreach($encuestas3 as $encuesta)
                                <li class="dropdown nav-item">
                                    <a href="" class="nav-link has-dropdown text-white miclasex"><span>{{ substr($encuesta->c_nombre_encuesta, 18) }}</span></a>
                                    <ul class="dropdown-menu">
                                        @foreach(OpcionesExtrasController::getBloques($encuesta->id_encuesta) as $bloque)
                                            <li class="nav-item">
                                                <a href="{{ route('getRespuestas', ['id_encuesta'=> $encuesta->id_encuesta, 'id_bloque'=> $bloque->id_bloque, 'punto'=> $bloque->c_nombre_bloque]) }}" class="nav-link text-white miclasey">{{ $bloque->c_nombre_bloque }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </li>
                    </ul>
            </li>
        </li>
</li>
