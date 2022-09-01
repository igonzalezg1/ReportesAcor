@extends('layouts.app')
@section('content')
    @php
    use App\Http\Controllers\OpcionesExtrasController;
    use App\Http\Controllers\GraficasController;
    use Carbon\Carbon;
    use koolreport\drilldown\DrillDown;
    use koolreport\widgets\google\ColumnChart;

    $calificacion = OpcionesExtrasController::getCalMens();

    $anios = GraficasController::reportespmp();

    $aniosi = GraficasController::getIncidencias();

    $aniosr = GraficasController::getResumen();

    $habitaciones = OpcionesExtrasController::habitaciones15();

    $habitaciones15 = round((15 / 100) * $habitaciones, 0);

    $habitaciones19 = OpcionesExtrasController::habitacion19();

    $habitaciones21 = OpcionesExtrasController::habitacion21();

    $fechahoy = Carbon::now('America/Mexico_City');

    $dayProgress = GraficasController::getprogessday();

    $porcentajeday = ($dayProgress * 100) / 10;

    $monthProgress = GraficasController::getprogressmonth();

    $porcentajeMonth = ($monthProgress * 100) / 11;

    if ($porcentajeMonth > 100) {
        $porcentajeMonth = 100;
    }

    $bimonthProgress = GraficasController::getprogressbimonth();

    $porcentajebimonth = ($bimonthProgress * 100) / 42;

    $semestral = GraficasController::getprogresssemestral();

    $porcentajesemestral = ($semestral * 100) / 91;

    $bloques_resultado = GraficasController::gettablasemestral();

    $bloques_resultado2 = GraficasController::gettablasdiario();

    $bloques_resultado3 = GraficasController::gettablamensual();

    $bloques_resultado4 = GraficasController::gettablabimestral();

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
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-xs-12">
                                        <h3 class="text-center">Información del mes presente</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <a href="{{ route('getcalmensual', ['mes' => $fechahoy->month]) }}">
                                            <div class="card" id="avancepmp">
                                                <div class="card-header bg-primary text-white text-center">
                                                    <h4 class="text-white">Avance PMP</h4>
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="text-center"><i class="fa fa-list"></i> <span>
                                                            {{ $calificacion->avance_pmp }}%</span></h6>
                                                    <p><span>Ultima actualizacion:
                                                            {{ substr($calificacion->fecha_calificacion, 0, 10) }}-{{ substr($calificacion->fecha_calificacion, 10, 6) }}
                                                            Hrs</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="card" id="calificacionmes">
                                            <div class="card-header bg-success text-white text-center">
                                                <h4 class="text-white">Calificacion final</h4>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center"><i class="fa fa-chart-line"></i> <span>
                                                        {{ $calificacion->calificacion }}</span></h6>
                                                <p><span>Ultima actualizacion:
                                                        {{ substr($calificacion->fecha_calificacion, 0, 10) }}-{{ substr($calificacion->fecha_calificacion, 10, 6) }}
                                                        Hrs</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="card" id="avancepmp">
                                            <div class="card-header bg-secondary text-white">
                                                <h4 class="text-white">Avance punto 19</h4>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center"><i class="fa fa-bed"></i> {{ $habitaciones19 }} de
                                                    {{ $habitaciones15 }}</span></h6>
                                                <p><span>(15% de {{ $habitaciones }}) última actualización: <br />
                                                        {{ substr($fechahoy, 0, 10) }}-{{ substr($fechahoy, 10, 6) }}
                                                        Hrs</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="card" id="calificacionmes">
                                            <div class="card-header bg-info text-white">
                                                <h4 class="text-white">Avance punto 21</h4>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center"><i class="fa fa-bed"></i> {{ $habitaciones21 }} de
                                                    {{ $habitaciones15 }}</span></h6>
                                                <p><span>(15% de {{ $habitaciones }}) última actualización: <br />
                                                        {{ substr($fechahoy, 0, 10) }}-{{ substr($fechahoy, 10, 6) }}
                                                        Hrs</span>
                                                </p>
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
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <a data-toggle="modal" href="#diariorevision">
                                        <div class="card">
                                            <div class="card-header bg-primary text-white">
                                                <h6>Diario</h6>
                                                <br />
                                            </div>
                                            <div class="card-body">
                                                <div class="gauge">
                                                    <canvas width="170" height="100" id="taco1"></canvas>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-secondary">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="text-dark">{{ $dayProgress }}</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="text-dark">{{ $porcentajeday }}%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <a data-toggle="modal" href="#mensualrevision">
                                        <div class="card" id="graficaincidencias">
                                            <div class="card-header bg-danger text-white">
                                                <h6>Mensual</h6>
                                                <br />
                                            </div>
                                            <div class="card-body">
                                                <div class="gauge">
                                                    <canvas width="170" height="100" id="taco2"></canvas>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-secondary">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="text-dark">{{ $monthProgress }}</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="text-dark">{{ $porcentajeMonth }}%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <a data-toggle="modal" href="#bimensualrevision">
                                        <div class="card">
                                            <div class="card-header bg-warning text-white">
                                                <h6>Bimestral</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="gauge">
                                                    <canvas width="170" height="100" id="taco3"></canvas>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-secondary">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="text-dark">{{ $bimonthProgress }}</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="text-dark">{{ $porcentajebimonth }}%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <a data-toggle="modal" href="#semestralrevision">
                                        <div class="card">
                                            <div class="card-header bg-info text-white">
                                                <h6>Anual/semestral</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="gauge">
                                                    <canvas width="170" height="100" id="taco4"></canvas>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-secondary">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="text-dark">{{ $semestral }}</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="text-dark">{{ $porcentajesemestral }}%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <div class="modal fade" id="diariorevision" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Diario</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding:15px">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Punto</th>
                                    <th>Realizado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bloques_resultado2 as $bloque) : ?>
                                        <tr>
                                            <td><?= $bloque['titulo'] ?></td>
                                            <td><?= $bloque['contesto'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mensualrevision" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Mensual</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding:15px">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Punto</th>
                                    <th>Realizado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bloques_resultado3 as $bloque) : ?>
                                        <tr>
                                            <td><?= $bloque['titulo'] ?></td>
                                            <td><?= $bloque['contesto'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bimensualrevision" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Bimestral/Trimestral</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding:15px">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Punto</th>
                                    <th>Realizado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bloques_resultado4 as $bloque) : ?>
                                        <tr>
                                            <td><?= $bloque['titulo'] ?></td>
                                            <td><?= $bloque['contesto'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="semestralrevision" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Semestrales</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding:15px">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Punto</th>
                                    <th>Realizado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bloques_resultado as $bloque) : ?>
                                        <tr>
                                            <td><?= $bloque['titulo'] ?></td>
                                            <td><?= $bloque['contesto'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


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
                data: [
                    @foreach ($anios as $anio)
                        {
                            name: {{ $anio->year }},
                            y: {{ $anio->inspections }}
                        },
                    @endforeach
                ]
            }]
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
                data: [
                    @foreach ($aniosi as $anio)
                        {
                            name: {{ $anio->anio }},
                            y: {{ $anio->inspeciones }}
                        },
                    @endforeach
                ]
            }]
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
                data: [
                    @foreach ($aniosr as $anio)
                        {
                            name: {{ $anio->anio }},
                            y: {{ $anio->inspeciones }}
                        },
                    @endforeach
                ]
            }]
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
        gauge.maxValue = 10; // set max gauge value
        gauge.setMinValue(0); // Prefer setter over gauge.minValue = 0
        gauge.animationSpeed = 32; // set animation speed (32 is default value)
        gauge.set({{ $dayProgress }}); // set actual value

        var target2 = document.getElementById('taco2'); // your canvas element
        var gauge2 = new Gauge(target2).setOptions(opts); // create sexy gauge!
        gauge2.maxValue = 11; // set max gauge value
        gauge2.setMinValue(0); // Prefer setter over gauge.minValue = 0
        gauge2.animationSpeed = 32; // set animation speed (32 is default value)
        gauge2.set({{ $monthProgress }}); // set actual value

        var target3 = document.getElementById('taco3'); // your canvas element
        var gauge3 = new Gauge(target3).setOptions(opts); // create sexy gauge!
        gauge3.maxValue = 42; // set max gauge value
        gauge3.setMinValue(0); // Prefer setter over gauge.minValue = 0
        gauge3.animationSpeed = 32; // set animation speed (32 is default value)
        gauge3.set({{ $bimonthProgress }}); // set actual value

        var target4 = document.getElementById('taco4'); // your canvas element
        var gauge4 = new Gauge(target4).setOptions(opts); // create sexy gauge!
        gauge4.maxValue = 91; // set max gauge value
        gauge4.setMinValue(0); // Prefer setter over gauge.minValue = 0
        gauge4.animationSpeed = 32; // set animation speed (32 is default value)
        gauge4.set({{ $semestral }}); // set actual value
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
