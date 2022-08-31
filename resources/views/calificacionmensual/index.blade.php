@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="col-sm-4">
                <h3 class="page__heading">Calificacion mensual</h3>
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-warning float-right" onclick="tutorialreportes();"><i
                        class="fa fa-play-circle" aria-hidden="true"></i><span> Iniciar tutorial</span></button>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <h4>Informacion de {{ $inihotel }} del mes de {{ $meses[$mes] }}</h4>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="card" id="avancepmp">
                                            <div class="card-header bg-primary text-white text-center">
                                                <h4 class="text-white">PMP sin p19 y p21:</h4>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="text-center"><span>
                                                        {{ $datos->avance_pmp }}</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="card" id="calificacionmes">
                                            <div class="card-header bg-success text-white text-center">
                                                <h4 class="text-white">Calificación final:</h4>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="text-center"><span>
                                                        {{ $datos->calificacion }}</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="card" id="avancepmp">
                                            <div class="card-header bg-warning text-white">
                                                <h4 class="text-white">Inspecciones P.19:</h4>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="text-center">{{ $habitacion19 }} de
                                                    {{ $habitaciones15 }}</span></h4>
                                                <h5 class="text-center">(15% de {{ $habitaciones }})</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="card" id="calificacionmes">
                                            <div class="card-header bg-danger text-white">
                                                <h4 class="text-white">Inspecciones P.21:</h4>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="text-center">{{ $habitacion21 }} de
                                                    {{ $habitaciones15 }}</span></h4>
                                                <h5 class="text-center">(15% de {{ $habitaciones }})</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="TablaReporte" class="table display" style="width: 100% !important;">
                                            <thead>
                                                <tr>
                                                    <th>Servicio</th>
                                                    <th>Peso</th>
                                                    <th>Si / No</th>
                                                    <th>Resultado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($bloquesrealizados as $bloque) : ?>
                                                <tr>
                                                    <td>
                                                        <a
                                                            href="{{ route('getRespuestas', ['id_encuesta' => $bloque['id_encuesta'], 'id_bloque' => $bloque['id_bloque'], 'punto' => $bloque['nombre']]) }}">
                                                            <?= $bloque['nombre'] ?>
                                                        </a>
                                                    </td>
                                                    <td><?= $bloque['peso'] ?></td>
                                                    <td><?= $bloque['resultado'] > 0 ? 'Si' : 'No' ?></td>
                                                    <td><?= $bloque['resultado'] ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(window).ready(() => {
            let idiomaTablaReporte = {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningun dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar dato especifico:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "ÃƒÅ¡ltimo",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                    "copy": 'Copiar',
                    "colvis": 'Visibilidad de columnas',
                    "copyTitle": 'Informacion copiada',
                    "copyKeys": 'Use your keyboard or menu to select the copy command',
                    "copySuccess": {
                        "_": '%d filas copiadas al portapapeles',
                        "1": '1 fila copiada al portapapeles'
                    },
                    "pageLength": {
                        "_": "Mostrar %d filas",
                        "-1": "Todo"
                    }
                }
            };

            let TablaReporte = $('#TablaReporte').DataTable({
                "language": idiomaTablaReporte,
                "order": [],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "scrollX": true,
                "info": true,
                "autoWidth": true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                "lengthMenu": [
                    [7, 10, 30, 31, -1],
                    [7, 10, 30, 31, "Mostrar Todo"]
                ]
            });
        });
    </script>
@endsection
