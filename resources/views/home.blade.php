@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Inicio</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h1>Usuarios</h1>
                                            @php
                                                use App\Models\User;
                                                use Spatie\Permission\Models\Role;
                                                use App\Models\Blog;

                                                $blogs = Blog::count();
                                                $cantidad = User::count();
                                                $roles = Role::count();
                                            @endphp
                                        </div>
                                        <div class="card-body">
                                            <h2 class="text-right"><i
                                                    class="fa fa-users f-left"></i><span>{{ $cantidad }}</span></h2>
                                            <a href="/usuarios" class="btn btn-primary text-white w-100">Ver mas</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h1>Roles</h1>
                                        </div>
                                        <div class="card-body">
                                            <h2 class="text-right"><i class="fa fa-user-lock f-left"></i><span>{{ $roles }}</span></h2>
                                            <a href="/roles" class="btn btn-success text-white w-100">Ver mas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
