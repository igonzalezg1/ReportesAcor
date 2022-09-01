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
<hr>
<div id="sabanaBody" class="table-responsive mt-3">
    <table id="tablaSabana">
        <thead>
            <tr>
                @foreach ($pisos_reales as $piso)
                    <th>{{ SabanasController::nombrePiso($piso) }}</th>
                    <th>Respuesta</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($habitaciones as $habitacion)
                <tr>
                    @foreach ($pisos_reales as $piso)
                        @php
                            $pisoq = intval($habitacion->$piso);
                        @endphp
                        <td><a
                                href="{{ route('getRespuestas19', ['id_encuesta' => 84, 'id_bloque' => 424, 'punto' => 19, 'piso' => $pisoq]) }}">{{ $habitacion->$piso }}</a>
                        </td>
                        @if ($habitacion->$piso != null and $habitacion->$piso != '')
                            @php
                                $fecha = SabanasController::obtenerUltimaRespuesta($habitacion->$piso, $newRespuestasPreguntas);
                            @endphp
                            @if ($pregunta->tipo == 'Evidencia' and $fecha['respuesta'] != 'SIN REVISAR')
                                <td>
                                    <a target="_blank"
                                        href="{{ "https://fotos.sumapp.cloud/Sumapp/$carpeta->carpeta/" . $fecha['respuesta'] }}">
                                        <img style="border-radius:20%;" class="img-responsive thumbnail" width="35px"
                                            height="25px"
                                            src="<?= "https://fotos.sumapp.cloud/Sumapp/$carpeta->carpeta/" .
                                        $fecha['respuesta'] ?>" />
                                        <br>
                                        <b class="<?= SabanasController::colorFechaesp($fecha['fecha']) ?>"
                                            style="font-size: 12px;"><?= $fecha['fecha'] ?></b>
                                    </a>
                                </td>
                            @else
                                <td class="{{ SabanasController::colorFechaesp($fecha['fecha']) }}">
                                    {{ $fecha['respuesta'] }}</td>
                            @endif
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
