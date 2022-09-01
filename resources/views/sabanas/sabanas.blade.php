@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="col-sm-4">
                <h3 class="page__heading">Sabanas</h3>
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
                                <div class="col-sm-12">
                                    <div class="mx-auto" style="max-width: 600px !important;">
                                        <form onsubmit="enviarForm(this)">
                                            <div class="card">
                                                <div class="card-header">Listado de sabanas</div>
                                                <div class="card-body">
                                                    <h6 class="card-title">Selecciona la sabana a generar: <span
                                                            class="text-danger">*</span></h6>
                                                    <div class="card-text text-center">
                                                        <select id="sabana" name="sabana" class="custom-select mb-3"
                                                            style="max-width: 500px;" required>
                                                            <option value="">--- Selecciona ---</option>
                                                            @foreach ($listasabanas as $sabana)
                                                                <option value="{{ $sabana['url'] }}">{{ $sabana['titulo'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-info">
                                                            <i class="fas fa-check"></i> Generar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="divSabanaGenerada" class="col-12 hide">
                                    <div class="mx-auto" style="max-width: 1000px !important;">
                                        <div class="card">
                                            <div class="card-header">
                                                <h2>Sabana generada</h2>
                                            </div>
                                            <div id="divGeneracion" class="card-body"></div>
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

    <script>
        let divGeneracion = document.querySelector('#divGeneracion');

        async function enviarForm(e) {
            event.preventDefault();
            let form = new FormData(e);
            let urlSabana = form.get('sabana');
            await generarSabana(urlSabana);
        }

        async function generarSabana(urlSabana) {
            await $.ajax({
                url: urlSabana,
                type: 'post',
                beforeSend: () => {
                    mostrarLoader();
                    $('#divSabanaGenerada').addClass('hide');
                    divGeneracion.innerHTML = '';
                },
                error: (response) => {
                    quitarLoader();
                    console.log(response);
                },
                success: (response) => {
                    quitarLoader();
                    console.log("Si entra");
                    $('#divSabanaGenerada').removeClass('hide');
                    divGeneracion.innerHTML = response.html;
                }
            });
        }

        async function filtrarPregunta(respuestasHabitaciones, idSucursal, idEncuesta, idBloque) {
            event.preventDefault();
            let form = new FormData(document.querySelector('#preguntasSabanaForm'));
            let idPregunta = form.get('pregunta');
            await generarSabanaPregunta(respuestasHabitaciones, idSucursal, idEncuesta, idBloque,
                idPregunta);
        }

        async function generarSabanaPregunta(respuestasHabitaciones, idSucursal, idEncuesta, idBloque,
            idPregunta) {
            let divSabanaBody = document.querySelector('#sabanaBody');
            await $.ajax({
                data: {
                    'respuestasHabitaciones': respuestasHabitaciones,
                    'idSucursal': idSucursal,
                    'idEncuesta': idEncuesta,
                    'idBloque': idBloque,
                    'idPregunta': idPregunta
                },
                url: 'getPreguntaEsp',
                type: 'post',
                beforeSend: () => {
                    mostrarLoader();
                    $('#sabanaBody').addClass('hide');
                    divSabanaBody.innerHTML = '';
                },
                error: (response) => {
                    quitarLoader();
                    console.log(response);
                },
                success: (response) => {
                    quitarLoader();
                    $('#sabanaBody').removeClass('hide');
                    console.log(respuestasHabitaciones);
                    divSabanaBody.innerHTML = response.html;
                }
            });
        }

        function mostrarLoader() {
            Swal.fire({
                title: 'Cargando',
                text: 'Espera un momento porfavor',
                didOpen: () => {
                    Swal.showLoading();
                },
                allowOutsideClick: false,
            });
        }

        function quitarLoader() {
            Swal.close();
        }
    </script>
@endsection
