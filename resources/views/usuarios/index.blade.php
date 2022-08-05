@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Usuarios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-user')
                                <a class="btn btn-warning w-100" href="{{ route('usuarios.create') }}">Nuevo ususario</a>
                            @endcan
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #ffff;">ID</th>
                                    <th style="color: #ffff;">Nombre</th>
                                    <th style="color: #ffff;">Correo</th>
                                    <th style="color: #ffff;">Rol</th>
                                    <th style="color: #ffff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->user_id }}</td>
                                        <td>{{ $usuario->first_name }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>
                                            @if (!empty($usuario->getRoleNames()))
                                                @foreach ($usuario->getRoleNames() as $rolname)
                                                    <h5><span class="badge badge-dark">{{ $rolname }}</span></h5>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @can('editar-user')
                                                <a class="btn btn-info" href="{{ route('usuarios.edit', $usuario->user_id) }}">Editar</a>
                                            @endcan
                                            @can('borrar-borrar')
                                                {!! Form::open(['method'=> 'DELETE', 'route'=> ['usuarios.destroy', $usuario->user_id], 'style'=>'display: inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {{ $usuarios->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
