@extends('layouts.app')
@section('content')
    @php
    use App\Http\Controllers\OpcionesExtrasController;
    use App\Http\Controllers\GraficasController;

    $calificacion = OpcionesExtrasController::getCalMens();

    $anios = GraficasController::reportespmp();

    $aniosi = GraficasController::getIncidencias();
    @endphp
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <h3 class="text-center">Información del mes presente</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h1>Avance PMP</h1>
                                        </div>
                                        <div class="card-body">
                                            <h2 class="text-center"><i class="fa fa-list"></i> <span>
                                                    {{ $calificacion->avance_pmp }}%</span></h2>
                                            <h6><span>Ultima actualizacion:
                                                    {{ substr($calificacion->fecha_calificacion, 0, 10) }}-{{ substr($calificacion->fecha_calificacion, 10) }}
                                                    Hrs</span></h6>
                                            <a href="#" class="btn btn-primary text-white w-100">Ver mas</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h1>Calificacion del mes</h1>
                                        </div>
                                        <div class="card-body">
                                            <h2 class="text-center"><i class="fa fa-chart-line"></i> <span>
                                                    {{ $calificacion->calificacion }}</span></h2>
                                            <h6><span>Ultima actualizacion:
                                                    {{ substr($calificacion->fecha_calificacion, 0, 10) }}-{{ substr($calificacion->fecha_calificacion, 10) }}
                                                    Hrs</span></h6>
                                            <a href="#" class="btn btn-success text-white w-100">Ver mas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card">
                                        <div class="card-header bg-warning text-white">
                                            <h3>PMP</h3>
                                            <br />
                                        </div>
                                        <div class="card-body">
                                            <div id="container"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card">
                                        <div class="card-header bg-danger text-white">
                                            <h3>Incidencias PMP</h3>
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
                                            <h6>Resumen de actividades de personal de mantenimiento</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="container3"></div>
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

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: "Todos los años"
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
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
                name: 'Todos los años',
                data: [
                    @foreach ($anios as $anio)
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
                    @foreach ($anios as $anio)
                        {
                            name: {{ $anio->anio }},
                            id: {{ $anio->anio }},
                            data: [
                                @php
                                    $meses = GraficasController::getMeses($anio->anio);
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
                    @endforeach

                ]
            }
        });


        Highcharts.chart('container2', {
            chart: {
                type: 'column'
            },
            title: {
                text: "Todos los años"
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
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
                name: 'Todos los años',
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
                                    $mesesi = GraficasController::getIncidenciasMes($anio->anio);
                                @endphp
                                @foreach ($mesesi as $mes)
                                    {
                                        name: {{ $mes->mes }},
                                        y: {{ $mes->inspeciones }},
                                        drilldown: {{ $mes->mes }}
                                    },
                                @endforeach
                            ]
                        },
                    @endforeach

                ]
            }
        });
    </script>
@endsection
