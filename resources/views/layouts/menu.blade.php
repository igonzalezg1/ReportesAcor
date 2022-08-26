@php
use App\Http\Controllers\OpcionesExtrasController;
$encuestas = OpcionesExtrasController::getEncuestas();
$encuestas3 = OpcionesExtrasController::getAnualBim();
@endphp
<li class="active">
    <a class="nav-link text-white miclasex" href="/home"><i class=" fas fa-building"></i><span>Inicio</span></a>
</li>
<li class="menu-header">Reportes Accor</li>
@foreach ($encuestas as $encuesta)
    <li class="dropdown">
        <a href="" class="nav-link has-dropdown text-white miclasex"><i
                class=" fas fa-file-alt"></i><span>{{ substr($encuesta->c_nombre_encuesta, 0, 10) }}</span></a>
        <ul class="dropdown-menu" style="display:none;" _mstvisible="0">
            @foreach (OpcionesExtrasController::getBloques($encuesta->id_encuesta) as $bloque)
                <li _mstvisible="1">
                    <a href="{{ route('getRespuestas', ['id_encuesta' => $encuesta->id_encuesta, 'id_bloque' => $bloque->id_bloque, 'punto' => $bloque->c_nombre_bloque]) }}"
                        class="nav-link text-white miclasey" _msthash="1228461" _msttexthash="472654"
                        _mstvisible="2">{{ $bloque->c_nombre_bloque }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endforeach
<li class="dropdown">
    <a href="" class="nav-link has-dropdown text-white miclasex"><i class=" fas fa-file-alt"></i><span>Anual y
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
                                class="nav-link text-white miclasey">{{ $bloque->c_nombre_bloque }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</li>
