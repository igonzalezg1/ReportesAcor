@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Roles</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-rol')
                                <a class="btn btn-warning w-100" href="{{ route('roles.create') }}">Nuevo</a>
                            @endcan
                            <br />
                            <br />
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%"
                                    cellspacing="0">
                                    <thead>
                                        <th>ID</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @can('editar-rol')
                                                        <a class="btn btn-info"
                                                            href="{{ route('roles.edit', $role->id) }}">Editar</a>
                                                    @endcan
                                                    @can('borrar-rol')
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['roles.destroy', $role->id],
                                                            'style' => 'display: inline',
                                                        ]) !!}
                                                        {!! Form::submit('borrar', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
