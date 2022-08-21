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
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" id="daterange_textbox" class="form-control" readonly />
                                </div>
                            </div>
                            <br />
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
                                    <tbody id="cuerpotabla">
                                    @foreach($respuestas as $respuesta)
                                        <tr>
                                            <td>{{\Carbon\Carbon::parse($respuesta->fecha_registro)->format('Y/m/d')}}</td>
                                            @foreach($preguntas as $pregunta)
                                                <?php
                                                    $preguntax = $pregunta->id
                                                ?>
                                                @if($pregunta->tipo == 'Evidencia')
                                                    <td>
                                                        @if($carpeta2 == '')
                                                            <img style="border-radius:20%;" class="img-responsive thumbnail" width="35px" height="25px" src="{{ asset('assets/images/sinimagen.png') }}" alt="">
                                                        @else
                                                            <a data-sub-html="No" target="_blank" href="<?= (strlen($respuesta->$preguntax) != '') ? "https://fotos.sumapp.cloud/Sumapp/$carpeta2/" . $respuesta->$preguntax : '#' ?>" evidencia="<?= (strlen($respuesta->$preguntax) != '') ? 'true' :  'false' ?>">
                                                                <img style="border-radius:20%;" class="img-responsive thumbnail" width="35px" height="25px" src="<?= (strlen($respuesta->$preguntax) != '') ? "https://fotos.sumapp.cloud/Sumapp/$carpeta2/" . $respuesta->$preguntax : asset('assets/images/sinimagen.png') ?>" />
                                                            </a>
                                                        @endif
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


    <script type="text/javascript">
        function fetch_data(start_date = '', end_date = '')
        {
            var asset = '{!! asset('') !!}';
            var variab = '{{ '/'.$id_encuesta.'/'.$id_bloque.'/'.$punto }}'
            var ruta = asset + 'filtrar_fechas/'+start_date+'/'+end_date+variab;

            var datatable = $('#reportes').DataTable({
                "processiong": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: ruta,
                    type: "GET"
                },
                columns: [
                    {'fecha': 'fecha'}
                ]
            });
        }
        $('#daterange_textbox').daterangepicker({
                ranges: {
                    'Hoy': [moment(), moment()],
                    'YTD': [moment().subtract(1, 'days'), moment()],
                    'Ultimos 30 dias' : [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                },
                format: 'YYYY-MM-DD'
            },
            function(start, end){
                $('#reportes').dataTable().fnDestroy();
                fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            });
    </script>
@endsection
