@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta de ususarios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Revise los campos! </strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="text-white">{{ $error }}</span>
                                        <br />
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            {!! Form::open(['route' => 'usuarios.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="first_name">Nombre(s) del usuario:</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control"
                                            value="{{ old('first_name') }}" placeholder="Ingrese el nombre del usuario" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="last_name">Apellidos:</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control"
                                            value="{{ old('last_name') }}" placeholder="Ingrese el apellido del usuario" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="gender">Nombre del usuario:</label>
                                        <select name="gender" id="gender" class="form-control"
                                            value="{{ old('gender') }}">
                                            <option value="Masculino" selected>Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="date_of_birth">Fecha de nacimiento:</label>
                                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                            value="{{ old('date_of_birth') }}"
                                            placeholder="Ingrese su fecha de nacimiento" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <h3 align="center">Entre la calle</h3>
                                    <div class="form-group">
                                        <label for="address1">Calle:</label>
                                        <input type="text" name="address1" id="address1" class="form-control"
                                            value="{{ old('address1') }}" placeholder="Ingrese el nombre de la calle" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <h3 align="center">Y la calle</h3>
                                    <div class="form-group">
                                        <label for="address2">Calle:</label>
                                        <input type="text" name="address2" id="address2" class="form-control"
                                            value="{{ old('address2') }}" placeholder="Ingrese el nombre de la calle" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="city">Ciudad:</label>
                                        <input type="text" name="city" id="city" class="form-control"
                                            value="{{ old('city') }}" placeholder="Ingrese el nombre de la ciudad" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="state">Estado:</label>
                                        <input type="text" name="state" id="state" class="form-control"
                                            value="{{ old('state') }}" placeholder="Ingrese el nombre del estado" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="country">Pais:</label>
                                        <input type="text" name="country" id="country" class="form-control"
                                            value="{{ old('country') }}" placeholder="Ingrese el nombre del pais" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="zip_code">Codigo postal:</label>
                                        <input type="number" name="zip_code" id="zip_code" class="form-control"
                                            value="{{ old('zip_code') }}" placeholder="Ingrese el CP" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="mobile">Telefono celular:</label>
                                        <input type="number" name="mobile" id="mobile" class="form-control"
                                            value="{{ old('mobile') }}" placeholder="Ingrese el telefono" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="phone">Telefono fijo:</label>
                                        <input type="number" name="phone" id="phone" class="form-control"
                                            value="{{ old('phone') }}" placeholder="Ingrese el telefono" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                            value="{{ old('username') }}" placeholder="Ingrese el username" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="email">Correo electronico:</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ old('email') }}" placeholder="Ingrese el correo" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="password">Contraseña:</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Ingrese la contraseña" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="confirm-password">Repita la contraseña:</label>
                                        <input type="password" name="confirm-password" id="confirm-password"
                                            class="form-control" placeholder="Ingrese la contraseña nuevamente" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="roles">Roles del usuario:</label>
                                        {!! Form::select('roles[]', $roles, [], ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="profile_image">Imagen del usuario:</label>
                                        <input type="file" name="profile_image" accept="image/*" id="profile_image"
                                            class="form-control" />
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
