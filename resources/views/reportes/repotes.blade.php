@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">{{ $bloque->c_nombre_bloque }}</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="reportes" class="table table-striped table-bordered" style="width:100%"
                                       cellspacing="0">
                                    <thead>
                                    <th>Fecha</th>
                                    @foreach($preguntas as $pregunta)
                                        <th>{{ $pregunta->titulo }}</th>
                                    @endforeach
                                    <th>Ubicacion</th>
                                    </thead>
                                    <tbody>
                                    @foreach($respuestas as $respuesta)
                                        <tr>
                                            <td>{{\Carbon\Carbon::parse($respuesta->fecha_registro)->format('Y/m/d')}}</td>
                                            @foreach($preguntas as $pregunta)
                                                <?php
                                                    $preguntax = $pregunta->id
                                                ?>
                                                @if($pregunta->tipo == 'Evidencia')
                                                    <td>
                                                        <a data-sub-html="No" target="_blank" href="<?= (strlen($respuesta->$preguntax) != '') ? "https://fotos.sumapp.cloud/Sumapp/$carpeta2/" . $respuesta->$preguntax : '#' ?>" evidencia="<?= (strlen($respuesta->$preguntax) != '') ? 'true' :  'false' ?>">
                                                            <img style="border-radius:20%;" class="img-responsive thumbnail" width="35px" height="25px" src="<?= (strlen($respuesta->$preguntax) != '') ? "https://fotos.sumapp.cloud/Sumapp/$carpeta2/" . $respuesta->$preguntax : 'assets/images/sinimagen.png' ?>" />
                                                        </a>
                                                    </td>
                                                @else
                                                    <td>{{$respuesta->$preguntax}}</td>
                                                @endif
                                            @endforeach
                                            <td>
                                                @if($respuesta->latitud != '' and $respuesta->longitud != '')
                                                    <a class="btn btn-primary btn-md" href="https://maps.google.com/?q={{ $respuesta->latitud }},{{ $respuesta->longitud }}"><i class="fas fa-map-marked-alt"></i></a>
                                                @else
                                                    no se registro ubicacion
                                                @endif
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
