@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="col-sm-4">
                <h3 class="page__heading">{{ $bloque->c_nombre_bloque }}</h3>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-warning float-right" onclick="tutorialreportes();"><i class="fa fa-play-circle" aria-hidden="true"></i><span> Iniciar tutorial</span></button>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-primary" id="daterange-btn">
                                        <i class="far fa-calendar-alt"></i> <span>Selecciona la fecha</span> <i
                                            class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                            <br />
                            <div class="table-responsive">
                                <table id="DataTable" class="table table-striped table-bordered" style="width:100%"
                                    cellspacing="0">
                                    <thead>
                                        <th>Fecha</th>
                                        @foreach ($preguntas as $pregunta)
                                            <th>{{ $pregunta->titulo }}</th>
                                        @endforeach
                                        <th>Ubicacion</th>
                                    </thead>
                                    <tbody id="cuerpotabla">
                                        @foreach ($respuestas as $respuesta)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($respuesta->fecha_registro)->format('Y/m/d') }}
                                                </td>
                                                @foreach ($preguntas as $pregunta)
                                                    <?php
                                                    $preguntax = $pregunta->id;
                                                    ?>
                                                    @if ($pregunta->tipo == 'Evidencia')
                                                        <td>
                                                            @if ($carpeta2 == '')
                                                                <img style="border-radius:20%;"
                                                                    class="img-responsive thumbnail" width="35px"
                                                                    height="25px"
                                                                    src="{{ asset('assets/images/sinimagen.png') }}"
                                                                    alt="">
                                                            @else
                                                                <a data-sub-html="No" target="_blank"
                                                                    href="<?= strlen($respuesta->$preguntax) != '' ? "https://fotos.sumapp.cloud/Sumapp/$carpeta2/"
                                                                    . $respuesta->$preguntax : '#' ?>"
                                                                    evidencia="<?= strlen($respuesta->$preguntax) != '' ? 'true' : 'false' ?>">
                                                                    <img style="border-radius:20%;"
                                                                        class="img-responsive thumbnail" width="35px"
                                                                        height="25px"
                                                                        src="<?= strlen($respuesta->$preguntax) != '' ? "https://fotos.sumapp.cloud/Sumapp/$carpeta2/"
                                                                        . $respuesta->$preguntax :
                                                                    asset('assets/images/sinimagen.png') ?>" />
                                                                </a>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td>{{ $respuesta->$preguntax }}</td>
                                                    @endif
                                                @endforeach
                                                <td>
                                                    @if ($respuesta->latitud != '' and $respuesta->longitud != '')
                                                        <a class="btn btn-primary btn-md" target="_blank"
                                                            href="https://maps.google.com/?q={{ $respuesta->latitud }},{{ $respuesta->longitud }}">{{ $respuesta->latitud }}, {{ $respuesta->longitud }}</a>
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

    <script>
        function tutorialreportes()
        {
            introJs().setOptions({
                nextLabel: 'Siguiente',
                prevLabel: 'Anterior',
                doneLabel: 'Fin',
                steps: [{
                    intro: "Tutorial de reportes"
                },
                {
                    element: document.querySelector('#daterange-btn'),
                    intro: "Este filtro se usa para establecer un rango de fechas"
                }
            ]
            }).start();
        }
    </script>
@endsection
