@extends('layouts.app')
@section('content')
    @php
    use App\Http\Controllers\OpcionesExtrasController;
    use App\Http\Controllers\GraficasController;

    $calificacion = OpcionesExtrasController::getCalMens();

    $anios = GraficasController::reportespmp();

    $aniosi = GraficasController::getIncidencias();

    $aniosr = GraficasController::getResumen();

    //$habitaciones15 = OpcionesExtrasController::habitacion15();

    //$habitaciones19 = OpcionesExtrasController::habitacion19();

    //$habitaciones21 = OpcionesExtrasController::habitacion21();

    @endphp
    <section class="section">
        <div class="section-header">
            <div class="col-sm-4">
                <h3 class="page__heading" id="titulo">Dashboard</h3>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-warning float-right" onclick="hometutorial();"><i
                        class="fa fa-play-circle" aria-hidden="true"></i><span> Iniciar tutorial</span></button>
            </div>
        </div>

        <!-- Tarjetas principales -->
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
                                    <div class="card" id="avancepmp">
                                        <div class="card-header bg-primary text-white">
                                            <h1>Avance PMP</h1>
                                        </div>
                                        <div class="card-body">
                                            <h2 class="text-center"><i class="fa fa-list"></i> <span>
                                                    {{ $calificacion->avance_pmp }}%</span></h2>
                                            <h6><span>Ultima actualizacion:
                                                    {{ substr($calificacion->fecha_calificacion, 0, 10) }}-{{ substr($calificacion->fecha_calificacion, 10) }}
                                                    Hrs</span></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="card" id="calificacionmes">
                                        <div class="card-header bg-success text-white">
                                            <h1>Calificacion del mes</h1>
                                        </div>
                                        <div class="card-body">
                                            <h2 class="text-center"><i class="fa fa-chart-line"></i> <span>
                                                    {{ $calificacion->calificacion }}</span></h2>
                                            <h6><span>Ultima actualizacion:
                                                    {{ substr($calificacion->fecha_calificacion, 0, 10) }}-{{ substr($calificacion->fecha_calificacion, 10) }}
                                                    Hrs</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="card" id="avancepmp">
                                        <div class="card-header bg-secondary text-white">
                                            <h2 class="text-white">Avance de habitaciones punto 19</h2>
                                        </div>
                                        <div class="card-body">
                                            <h2 class="text-center"><i class="fa fa-bed"></i> <span>
                                                    {{ $calificacion->avance_pmp }}%</span></h2>
                                            <h6><span>Ultima actualizacion:
                                                    {{ substr($calificacion->fecha_calificacion, 0, 10) }}-{{ substr($calificacion->fecha_calificacion, 10) }}
                                                    Hrs</span></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="card" id="calificacionmes">
                                        <div class="card-header bg-info text-white">
                                            <h2 class="text-white">Avance de habitaciones punto 21</h2>
                                        </div>
                                        <div class="card-body">
                                            <h2 class="text-center"><i class="fa fa-bed"></i></i> <span>
                                                    {{ $calificacion->calificacion }}</span></h2>
                                            <h6><span>Ultima actualizacion:
                                                    {{ substr($calificacion->fecha_calificacion, 0, 10) }}-{{ substr($calificacion->fecha_calificacion, 10) }}
                                                    Hrs</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Graficas -->
        <div class="section-body">
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
                                    <div class="card" id="graficaincidencias">
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

        <!-- Tacometros de progreso -->
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <h3 class="text-center">progresos de reportes</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card" id="graficapmp">
                                        <div class="card-header bg-primary text-white">
                                            <h3>Diario</h3>
                                            <br />
                                        </div>
                                        <div class="card-body">
                                            <canvas id="taco1"></canvas>
                                        </div>
                                        <div class="card-footer bg-secondary">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-6"><h5 class="text-white">0.0</h5></div>
                                                    <div class="col-sm-6"><h5 class="text-white">70%</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card" id="graficaincidencias">
                                        <div class="card-header bg-secondary text-white">
                                            <h3>Mensual</h3>
                                            <br />
                                        </div>
                                        <div class="card-body">
                                            <canvas id="taco2"></canvas>
                                        </div>
                                        <div class="card-footer bg-secondary">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-6"><h5 class="text-white">0.0</h5></div>
                                                    <div class="col-sm-6"><h5 class="text-white">70%</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card">
                                        <div class="card-header bg-warning text-white">
                                            <h3>Bimestral</h3>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="taco3"></canvas>
                                        </div>
                                        <div class="card-footer bg-secondary">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-6"><h5 class="text-white">0.0</h5></div>
                                                    <div class="col-sm-6"><h5 class="text-white">70%</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4"></div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h5>Anual/semestral</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="taco4"></canvas>
                                        </div>
                                        <div class="card-footer bg-secondary">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-6"><h5 class="text-white">0.0</h5></div>
                                                    <div class="col-sm-6"><h5 class="text-white">70%</h5></div>
                                                </div>
                                            </div>
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
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://bernii.github.io/gauge.js/dist/gauge.min.js"></script>
    <script>
        //--------------------
        //--------------------
        //Graficas
        //--------------------
        //--------------------
        //--------------------
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

        //--------------------
        //--------------------
        // Tacometros
        //--------------------
        //--------------------
        var opts = {
            angle: 0.15, // The span of the gauge arc
            lineWidth: 0.44, // The line thickness
            radiusScale: 1, // Relative radius
            pointer: {
                length: 0.6, // // Relative to gauge radius
                strokeWidth: 0.035, // The thickness
                color: '#000000' // Fill color
            },
            limitMax: false, // If false, max value increases automatically if value > maxValue
            limitMin: false, // If true, the min value of the gauge will be fixed
            colorStart: '#BDEA74', // Colors
            colorStop: '#BDEA74', // just experiment with them
            strokeColor: '#E0E0E0', // to see which ones work best for you
            generateGradient: true,
            highDpiSupport: true, // High resolution support

        };
        var target = document.getElementById('taco1'); // your canvas element
        var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
        gauge.maxValue = 100; // set max gauge value
        gauge.setMinValue(0); // Prefer setter over gauge.minValue = 0
        gauge.animationSpeed = 32; // set animation speed (32 is default value)
        gauge.set(90); // set actual value

        var target2 = document.getElementById('taco2'); // your canvas element
        var gauge2 = new Gauge(target2).setOptions(opts); // create sexy gauge!
        gauge2.maxValue = 100; // set max gauge value
        gauge2.setMinValue(0); // Prefer setter over gauge.minValue = 0
        gauge2.animationSpeed = 32; // set animation speed (32 is default value)
        gauge2.set(10); // set actual value

        var target3 = document.getElementById('taco3'); // your canvas element
        var gauge3 = new Gauge(target3).setOptions(opts); // create sexy gauge!
        gauge3.maxValue = 100; // set max gauge value
        gauge3.setMinValue(0); // Prefer setter over gauge.minValue = 0
        gauge3.animationSpeed = 32; // set animation speed (32 is default value)
        gauge3.set(70); // set actual value

        var target4 = document.getElementById('taco4'); // your canvas element
        var gauge4 = new Gauge(target4).setOptions(opts); // create sexy gauge!
        gauge4.maxValue = 100; // set max gauge value
        gauge4.setMinValue(0); // Prefer setter over gauge.minValue = 0
        gauge4.animationSpeed = 32; // set animation speed (32 is default value)
        gauge4.set(50); // set actual value
    </script>



    <script>
        function hometutorial() {
            introJs().setOptions({
                nextLabel: 'Siguiente',
                prevLabel: 'Anterior',
                doneLabel: 'Fin',
                steps: [{
                        intro: "Tutorial de vista Home"
                    },
                    {
                        element: document.querySelector('#avancepmp'),
                        intro: "Aqui se mostrara el avance PMP"
                    },
                    {
                        element: document.querySelector('#calificacionmes'),
                        intro: "Aqui se mostrara la calificacion del mes actual"
                    },
                    {
                        element: document.querySelector('#graficapmp'),
                        intro: "Este es la grafica PMP, si se selecciona una barra se despliega mas informacion"
                    },
                    {
                        element: document.querySelector('#graficaincidencias'),
                        intro: "Este es la grafica de incidencias (calificaiones bajas, respuestas negativas, etc.), si se selecciona una barra se despliega mas informacion"
                    }
                ]
            }).start();
        }
    </script>
@endsection
