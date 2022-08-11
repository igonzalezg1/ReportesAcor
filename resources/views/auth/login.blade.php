@extends('layouts.auth_app')
@section('title')
    Admin Login
@endsection
@section('content')
    <div class="card bg-dark text-white">
        <div class="card-header">
            <h4 class="text-white">Iniciar sesion</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="email" class="text-white">Correo: </label>
                    <input aria-describedby="emailHelpBlock" id="email" type="email"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                        placeholder="Ingresa tu correo" tabindex="1"
                        value="{{ Cookie::get('email') !== null ? Cookie::get('email') : old('email') }}" autofocus
                        required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label text-white">Contraseña</label>
                        <div class="float-right">
                            <!--<a href="{{ route('password.request') }}" class="text-small">Forgot Password?</a> -->
                        </div>
                    </div>
                    <input aria-describedby="passwordHelpBlock" id="password" type="password"
                        value="{{ Cookie::get('password') !== null ? Cookie::get('password') : null }}"
                        placeholder="Ingresa el Password"
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                        tabindex="2" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>

                <div class="form-group">
                    <!-- <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                       id="remember"{{ Cookie::get('remember') !== null ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">Recordar usuario</label>
                            </div>
                            -->
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-lg btn-block">
                        Iniciar sesion
                    </button>
                </div>
            </form>
            <div class="d-flex justify-content-center">
                <img src="{{ asset('img/icono.png') }}" width="70px" alt="">
            </div>
            <br />
            <div class="d-flex justify-content-center">
                <p class="text-white">Power by Sumapp</p>
            </div>
        </div>
    </div>
@endsection
