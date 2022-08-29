@php
use App\Http\Controllers\SabanasController;
@endphp
<style>
    .center-item {
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .text-orange {
        color: #ffa533 !important;
    }

    #tablaSabana {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #tablaSabana td,
    #tablaSabana th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #tablaSabana tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #tablaSabana th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #108dcc;
        color: white;
    }
</style>
<div id="sabanaHeader" class="row">
    <div class="col-12 col-md-6">
        <div style="margin: 120px 0px 120px 0px !important;">
            <div class="center-item">
                <h2 style="margin-bottom: -3px;">Limpieza</h2>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <ol>
            <li>Menor a 1 mes: <span class="text-primary"><b>FECHA</b></span></li>
            <li>Entre 1 y 2 Meses: <span class="text-success"><b>FECHA</b></span></li>
            <li>Mayor a 2 Meses: <span class="text-warning"><b>FECHA</b></span></li>
            <li>No hay registros: <span class="text-danger"><b>SIN REVISAR</b></span></li>
        </ol>
    </div>
</div>
<hr>
<div id="sabanaBody" class="table-responsive mt-3">
    <table id="tablaSabana">
        <thead>
            <tr>
                @foreach ($pisos_reales as $piso)
                    <th>{{ SabanasController::nombrePiso($piso) }}</th>
                    <th>Fecha</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($habitaciones as $habitacion)
                <tr>
                    @foreach ($pisos_reales as $piso)
                        <td>{{ $habitacion->$piso }}</td>
                        @if ($habitacion->$piso != null and $habitacion->$piso != '')
                            @php
                                $fecha = SabanasController::obtenerUltimaFechat($habitacion->$piso, $tickets);
                            @endphp
                            <td class="{{ SabanasController::colorFechat($fecha) }}">{{ $fecha }}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
