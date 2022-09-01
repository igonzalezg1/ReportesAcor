@php
use App\Http\Controllers\OpcionesExtrasController;
$encuestas = OpcionesExtrasController::getEncuestas();
$encuestas3 = OpcionesExtrasController::getAnualBim();
$stps = OpcionesExtrasController::getStps([89, 85, 90, 93, 101]);
$proteccionIncendios = OpcionesExtrasController::getStps([1, 17, 22, 23, 24, 27, 39, 42, 47, 52, 78, 140, 50]);
$proteccionCivil = OpcionesExtrasController::getStps([5, 6, 8, 25, 30, 31, 79, 81, 84, 85, 87, 88, 91, 95, 96, 98]);
$tickets = OpcionesExtrasController::getInfoTickets();
$salubridad = OpcionesExtrasController::getStps([11, 18, 37, 38, 40, 43, 45, 46, 74, 81, 83, 88, 100]);
@endphp
<li class="active">
    <a class="nav-link text-white miclasex" href="/home"><i class="fas fa-tachometer-alt"></i><span>Tablero</span></a>
</li>
<li class="active">
    <a class="nav-link text-white miclasex"
        href="https://tickets.sumapp.cloud/auth/prueba/logueo/auto/{{ $tickets[0] }}/{{ $tickets[1] }}"><i
            class="fas fa-ticket-alt"></i><span>Tickets</span></a>
</li>
<li class="menu-header">Reportes Accor</li>
@foreach ($encuestas as $encuesta)
    <li class="dropdown">
        <a href="" class="nav-link has-dropdown text-white miclasex"><i
                class="far fa-file-alt"></i><span>{{ substr($encuesta->c_nombre_encuesta, 0, 10) }}</span></a>
        <ul class="dropdown-menu" style="display:none;" _mstvisible="0">
            @foreach (OpcionesExtrasController::getBloques($encuesta->id_encuesta) as $bloque)
                <li _mstvisible="1">
                    @if (Str::length($bloque->c_nombre_bloque) < 24)
                        <a href="{{ route('getRespuestas', ['id_encuesta' => $encuesta->id_encuesta, 'id_bloque' => $bloque->id_bloque, 'punto' => $bloque->c_nombre_bloque]) }}"
                            class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                            data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                            _mstvisible="2">{{ Str::substr($bloque->c_nombre_bloque, 0, 22) }}
                        </a>
                    @else
                        <a href="{{ route('getRespuestas', ['id_encuesta' => $encuesta->id_encuesta, 'id_bloque' => $bloque->id_bloque, 'punto' => $bloque->c_nombre_bloque]) }}"
                            class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                            data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                            _mstvisible="2">{{ Str::substr($bloque->c_nombre_bloque, 0, 22) }}...
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </li>
@endforeach
<li class="dropdown">
    <a href="" class="nav-link has-dropdown text-white miclasex"><i class="far fa-file-alt"></i><span>Anual y
            semestral</span></a>
    <ul class="dropdown-menu" style="display:none;" _mstvisible="0">
        @foreach ($encuestas3 as $encuesta)
            <li class="dropdown nav-item">
                <a href=""
                    class="nav-link has-dropdown text-white miclasex"><span>{{ substr($encuesta->c_nombre_encuesta, 18) }}</span></a>
                <ul class="dropdown-menu">
                    @foreach (OpcionesExtrasController::getBloques($encuesta->id_encuesta) as $bloque)
                        <li class="nav-item">
                            <a href="{{ route('getRespuestas', ['id_encuesta' => $encuesta->id_encuesta, 'id_bloque' => $bloque->id_bloque, 'punto' => $bloque->c_nombre_bloque]) }}"
                                class="nav-link text-white miclasey" data-bs-toggle="mensaje" data-bs-placement="right"
                                title="{{ $bloque->c_nombre_bloque }}">{{ $bloque->c_nombre_bloque }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown">
    <a href="" class="nav-link has-dropdown text-white miclasex"><i
            class="far fa-file-alt"></i><span>STPS</span></a>
    <ul class="dropdown-menu" style="display: none;" _mstvisible="0">
        @foreach ($stps as $stps)
            <li _mstvisible="1">
                @if (Str::length($stps->nombre) < 24)
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $stps->ide, 'id_bloque' => $stps->id_bloque, 'punto' => $stps->nombre]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                        _mstvisible="2">{{ Str::substr($stps->nombre, 0, 22) }}</a>
                    </a>
                @else
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $stps->ide, 'id_bloque' => $stps->id_bloque, 'punto' => $stps->nombre]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                        _mstvisible="2">{{ Str::substr($stps->nombre, 0, 22) }}...</a>
                @endif
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown">
    <a href="" class="nav-link has-dropdown text-white miclasex"><i class="far fa-file-alt"></i><span>Proteccion
            contra incendios</span></a>
    <ul class="dropdown-menu" style="display: none;" _mstvisible="0">
        @foreach ($proteccionIncendios as $stps)
            <li _mstvisible="1">
                @if (Str::length($stps->nombre) < 24)
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $stps->ide, 'id_bloque' => $stps->id_bloque, 'punto' => $stps->nombre]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                        _mstvisible="2">{{ Str::substr($stps->nombre, 0, 22) }}</a>
                    </a>
                @else
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $stps->ide, 'id_bloque' => $stps->id_bloque, 'punto' => $stps->nombre]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                        _mstvisible="2">{{ Str::substr($stps->nombre, 0, 22) }}...</a>
                @endif
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown">
    <a href="" class="nav-link has-dropdown text-white miclasex"><i
            class="far fa-file-alt"></i><span>Proteccion
            civil</span></a>
    <ul class="dropdown-menu" style="display: none;" _mstvisible="0">
        @foreach ($proteccionCivil as $stps)
            <li _mstvisible="1">
                @if (Str::length($stps->nombre) < 24)
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $stps->ide, 'id_bloque' => $stps->id_bloque, 'punto' => $stps->nombre]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                        _mstvisible="2">{{ Str::substr($stps->nombre, 0, 22) }}</a>
                    </a>
                @else
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $stps->ide, 'id_bloque' => $stps->id_bloque, 'punto' => $stps->nombre]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                        _mstvisible="2">{{ Str::substr($stps->nombre, 0, 22) }}...</a>
                @endif
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown">
    <a href="" class="nav-link has-dropdown text-white miclasex"><i
            class="far fa-file-alt"></i><span>Salubridad</span></a>
    <ul class="dropdown-menu" style="display: none;" _mstvisible="0">
        @foreach ($salubridad as $stps)
            <li _mstvisible="1">
                @if (Str::length($stps->nombre) < 24)
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $stps->ide, 'id_bloque' => $stps->id_bloque, 'punto' => $stps->nombre]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                        _mstvisible="2">{{ Str::substr($stps->nombre, 0, 22) }}</a>
                    </a>
                @else
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $stps->ide, 'id_bloque' => $stps->id_bloque, 'punto' => $stps->nombre]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        data-bs-toggle="mensaje" data-bs-placement="right" title="{{ $bloque->c_nombre_bloque }}"
                        _mstvisible="2">{{ Str::substr($stps->nombre, 0, 22) }}...</a>
                @endif
            </li>
        @endforeach
    </ul>
</li>
