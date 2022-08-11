@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Blogs</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-blog')
                                <a class="btn btn-warning w-100" href="{{ route('blogs.create') }}">Nuevo</a>
                            @endcan
                            <br />
                            <br />
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%"
                                    cellspacing="0">
                                    <thead>
                                        <th>ID</th>
                                        <th>Titulo</th>
                                        <th>Contenido</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($blogs as $blog)
                                            <tr>
                                                <td>{{ $blog->id }}</td>
                                                <td>{{ $blog->titulo }}</td>
                                                <td>
                                                    @can('editar-blog')
                                                        <a class="btn btn-info"
                                                            href="{{ route('blogs.edit', $blog->id) }}">Editar</a>
                                                    @endcan
                                                    @can('borrar-blog')
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['blogs.destroy', $blog->id],
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
