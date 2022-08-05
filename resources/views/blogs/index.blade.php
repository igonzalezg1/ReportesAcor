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
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #ffff;">ID</th>
                                    <th style="color: #ffff;">Titulo</th>
                                    <th style="color: #ffff;">Contenido</th>
                                    <th style="color: #ffff;">Acciones</th>
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
                            <div class="pagination justify-content-end">
                                {{ $blogs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
