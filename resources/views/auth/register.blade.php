@extends('layouts.auth_app')
@section('title')
    Register
@endsection
@section('content')
    <div class="card bg-dark text-white">
        <div class="card-header">
            <h4 class="text-white">Registrar un nuevo usuario</h4>
        </div>

        <div class="card-body pt-1">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                        <strong>Revise los campos! </strong>
                        <br />
                        @foreach ($errors->all() as $error)
                            <span class="text-danger">{{ $error }}</span>
                            <br />
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="first_name">Nombre(s) del usuario:</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    value="{{ old('first_name') }}" placeholder="Ingrese el nombre del usuario" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="last_name">Apellidos:</label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                    class="form-control" placeholder="Ingrese el apellido del usuario" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="gender">Nombre del usuario:</label>
                                <select name="gender" id="gender" class="form-control" value="{{ old('gender') }}">
                                    <option value="Masculino" selected>Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="date_of_birth">Fecha de nacimiento:</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                    id="date_of_birth" class="form-control" placeholder="Ingrese su fecha de nacimiento" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h3 align="center">Entre la calle</h3>
                            <div class="form-group">
                                <label class="text-white" for="address1">Calle:</label>
                                <input type="text" name="address1" value="{{ old('address1') }}" id="address1"
                                    class="form-control" placeholder="Ingrese el nombre de la calle" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h3 align="center">Y la calle</h3>
                            <div class="form-group">
                                <label class="text-white" for="address2">Calle:</label>
                                <input type="text" name="address2" id="address2" value="{{ old('address2') }}"
                                    class="form-control" placeholder="Ingrese el nombre de la calle" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="city">Ciudad:</label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}"
                                    class="form-control" placeholder="Ingrese el nombre de la ciudad" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="state">Estado:</label>
                                <input type="text" name="state" id="state" class="form-control"
                                    value="{{ old('state') }}" placeholder="Ingrese el nombre del estado" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="country">Pais:</label>
                                <input type="text" name="country" id="country" value="{{ old('country') }}"
                                    class="form-control" placeholder="Ingrese el nombre del pais" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="zip_code">Codigo postal:</label>
                                <input type="number" name="zip_code" id="zip_code" value="{{ old('zip_code') }}"
                                    class="form-control" placeholder="Ingrese el CP" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="mobile">Telefono celular:</label>
                                <input type="number" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                    class="form-control" placeholder="Ingrese el telefono" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="phone">Telefono fijo:</label>
                                <input type="number" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="form-control" placeholder="Ingrese el telefono" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="username">Username:</label>
                                <input type="text" name="username" id="username" value="{{ old('username') }}"
                                    class="form-control" placeholder="Ingrese el username" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="email">Correo electronico:</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control" placeholder="Ingrese el correo" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="password">Contraseña:</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Ingrese la contraseña" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="text-white" for="confirm-password">Repita la contraseña:</label>
                                <input type="password" name="confirm-password" id="confirm-password"
                                    class="form-control" placeholder="Ingrese la contraseña nuevamente" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-dark w-100">Guardar</button>
                        </div>
                    </div>
                </form>

            <br />
            <br />
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('img/icono.png') }}" width="70px" alt="">
                </div>
                <br />
                <div class="d-flex justify-content-center">
                    <p class="text-white">Power by Sumapp</p>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-secondary">Iniciar sesion</a>
    </div>
@endsection
