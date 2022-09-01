@extends('layouts.app')
@section('content')
    @php
    use App\Http\Controllers\GraficasController;

    $anios = GraficasController::reportespmp();

    $aniosi = GraficasController::getIncidencias();

    $aniosr = GraficasController::getResumen();

    @endphp
    <section class="section">
        <div class="section-header">
            <div class="col-sm-4">
                <h3 class="page__heading" id="titulo">Detalles de graficas</h3>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-warning float-right" onclick="hometutorial();"><i
                        class="fa fa-play-circle" aria-hidden="true"></i><span> Iniciar tutorial</span></button>
            </div>
        </div>
        <!-- Graficas -->
        <div class="section-body" loading="lazy">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <h3 class="text-center">Graficas generales</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card" id="graficapmp">
                                        <div class="card-header bg-warning text-center">
                                            <h4 class="text-white">Inspecciones</h4>
                                            <br />
                                        </div>
                                        <div class="card-body">
                                            <div id="container"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card" id="graficaincidencias">
                                        <div class="card-header bg-danger text-white">
                                            <h4 class="text-white">Incidencias</h4>
                                            <br />
                                        </div>
                                        <div class="card-body">
                                            <div id="container2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h4 class="text-white">Inspecciones por personal</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="container3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="" class="btn btn-primary w-100">Ver mas detalles de las graficas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://bernii.github.io/gauge.js/dist/gauge.min.js"></script>

    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            title: {
                text: "Todos los años"
            },
            yAxis: {
                min: 0,
                title: {
                    enabled: false
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Todos los anios',
                data: [
                    @foreach ($anios as $anio)
                        {
                            name: {{ $anio->year }},
                            y: {{ $anio->inspections }},
                            drilldown: {{ $anio->year }}
                        },
                    @endforeach
                ]
            }],
            drilldown: {
                series: [
                    @foreach ($anios as $anio)
                        {
                            name: {{ $anio->year }},
                            id: {{ $anio->year }},
                            data: [
                                @php
                                    $meses = GraficasController::getMeses($anio->year);
                                @endphp
                                @foreach ($meses as $mes)
                                    {
                                        name: {{ $mes->mes }},
                                        y: {{ $mes->inspeciones }},
                                        drilldown: {{ $mes->mes }}
                                    },
                                @endforeach
                            ]
                        },
                        @php
                            $meses = GraficasController::getMeses($anio->year);
                        @endphp
                        @foreach ($meses as $mes)
                            {
                                name: {{ $mes->mes }},
                                id: {{ $mes->mes }},
                                data: [
                                    @php
                                        $puntossel = GraficasController::getMesEsp($anio->year, $mes->mes);
                                    @endphp
                                    @foreach ($puntossel as $puntosel)
                                        ["{{ $puntosel->cuestionario }}", {{ $puntosel->inspections }}],
                                    @endforeach
                                ]
                            },
                            //Hasta aqui funciona
                        @endforeach
                    @endforeach
                ]
            }
        });

        Highcharts.chart('container2', {
            chart: {
                type: 'column'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            title: {
                text: "Todos los años"
            },
            yAxis: {
                min: 0,
                title: {
                    enabled: false
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Todos los anios',
                data: [
                    @foreach ($aniosi as $anio)
                        {
                            name: {{ $anio->anio }},
                            y: {{ $anio->inspeciones }},
                            drilldown: {{ $anio->anio }}
                        },
                    @endforeach
                ]
            }],
            drilldown: {
                series: [
                    @foreach ($aniosi as $anio)
                        {
                            name: {{ $anio->anio }},
                            id: {{ $anio->anio }},
                            data: [
                                @php
                                    $meses = GraficasController::getIncidenciasMes($anio->anio);
                                @endphp
                                @foreach ($meses as $mes)
                                    {
                                        name: {{ $mes->mes }},
                                        y: {{ $mes->inspeciones }},
                                        drilldown: {{ $mes->mes }}
                                    },
                                @endforeach
                            ]
                        },
                        @php
                            $meses = GraficasController::getIncidenciasMes($anio->anio);
                        @endphp
                        @foreach ($meses as $mes)
                            {
                                name: {{ $mes->mes }},
                                id: {{ $mes->mes }},
                                data: [
                                    @php
                                        $puntossel = GraficasController::getIncidenciasMesEsp($anio->anio, $mes->mes);
                                    @endphp
                                    @foreach ($puntossel as $puntosel)
                                        ["{{ $puntosel->cuestionario }}", {{ $puntosel->inspeciones }}],
                                    @endforeach
                                ]
                            },
                            //Hasta aqui funciona
                        @endforeach
                    @endforeach
                ]
            }
        });

        Highcharts.chart('container3', {
            chart: {
                type: 'column'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            title: {
                text: "Todos los años"
            },
            yAxis: {
                min: 0,
                title: {
                    enabled: false
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Todos los anios',
                data: [
                    @foreach ($aniosr as $anio)
                        {
                            name: {{ $anio->anio }},
                            y: {{ $anio->inspeciones }},
                            drilldown: {{ $anio->anio }}
                        },
                    @endforeach
                ]
            }],
            drilldown: {
                series: [
                    @foreach ($aniosr as $anio)
                        {
                            name: {{ $anio->anio }},
                            id: {{ $anio->anio }},
                            data: [
                                @php
                                    $meses = GraficasController::getMesResumen($anio->anio);
                                @endphp
                                @foreach ($meses as $mes)
                                    {
                                        name: {{ $mes->mes }},
                                        y: {{ $mes->inspeciones }},
                                        drilldown: {{ $mes->mes }}
                                    },
                                @endforeach
                            ]
                        },
                        @php
                            $meses = GraficasController::getMesResumen($anio->anio);
                        @endphp
                        @foreach ($meses as $mes)
                            {
                                name: {{ $mes->mes }},
                                id: {{ $mes->mes }},
                                data: [
                                    @php
                                        $puntossel = GraficasController::getMesEspResumen($anio->anio, $mes->mes);
                                    @endphp
                                    @foreach ($puntossel as $puntosel)
                                        ["{{ $puntosel->Fecha }}", {{ $puntosel->inspeciones }}],
                                    @endforeach
                                ]
                            },
                            //Hasta aqui funciona
                        @endforeach
                    @endforeach
                ]
            }
        });
    </script>
@endsection
