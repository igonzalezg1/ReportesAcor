@php
use App\Http\Controllers\OpcionesExtrasController;
$tickets = OpcionesExtrasController::getInfoTickets();
$rangeMonths = OpcionesExtrasController::getMesesHeader();
$usuario = OpcionesExtrasController::getUser();
$month = OpcionesExtrasController::getMonth();
@endphp
<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-lefht">

    @if (\Illuminate\Support\Facades\Auth::user())
        <li><a href="https://tickets.sumapp.cloud/auth/prueba/logueo/auto/{{ $tickets[0] }}/{{ $tickets[1] }}"
                class="nav-link nav-link-lg">
                <h5><abbr title="Tickets"><i class="fas fa-ticket-alt"></i></abbr></h5>
            </a></li>
        <!-- Calificacion mensual -->
        <li class="nav-item dropdown">
            <a href="" data-toggle="dropdown" class="nav-link nav-link-lg has-dropdown"><h5><abbr title="Calificacion mensual"><i class="far fa-calendar-alt"></i></abbr></h5></a>
            <ul class="dropdown-menu">
                @foreach ($rangeMonths as $k => $month)
                    <li class="nav-item"><a href="{{ route('getcalmensual', ['mes' => ($k+1)]) }}" class="nav-link text-primary" _msthash="1228461" _msttexthash="472654" _mstvisible="2"><i
                                class='far fa-calendar-check'></i> <span> {{ $month }}</span></a></li>
                @endforeach
            </ul>
        </li>

        <!-- Sabanas -->
        <li><a href="{{ asset('sabanas') }}" class="nav-link nav-link-lg">
                <h5><abbr title="Sabana"><i class="fas fa-hotel"></i></abbr></h5>
            </a></li>
        <li><a href="" class="nav-link nav-link-lg">
                <h5><abbr title="limpieza"><i class="fas fa-broom"></i></abbr></h5>
            </a></li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if (\Illuminate\Support\Facades\Auth::user()->profile_image != '')
                    <img alt="image" src="{{ \Illuminate\Support\Facades\Auth::user()->profile_image }}"
                        class="rounded-circle mr-10 thumbnail-rounded user-thumbnail ">
                @else
                    <img src="{{ asset('assets/images/usuario.png') }}" alt="Foto">
                @endif
                <div class="d-sm-none d-lg-inline-block">
                    Bienvenido, {{ \Illuminate\Support\Facades\Auth::user()->first_name }} ({{ \Illuminate\Support\Facades\Auth::user()->last_name }})</div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    Bienvenido, {{ \Illuminate\Support\Facades\Auth::user()->first_name }} ({{ \Illuminate\Support\Facades\Auth::user()->last_name }})</div>
                <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changeImageModal" href="#"
                    data-id="{{ \Auth::id() }}"><i class="fa fa-lock"> </i>Cambiar foto de perfil</a>
                <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changePasswordModal" href="#"
                    data-id="{{ \Auth::id() }}"><i class="fa fa-lock"> </i>Cambiar contraseña</a>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesion
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    @else
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{-- <img alt="image" src="#" class="rounded-circle mr-1"> --}}
                <div class="d-sm-none d-lg-inline-block">{{ __('messages.common.hello') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('messages.common.login') }}
                    / {{ __('messages.common.register') }}</div>
                <a href="{{ route('login') }}" class="dropdown-item has-icon">
                    <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('register') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
                </a>
            </div>
        </li>
    @endif
</ul>
