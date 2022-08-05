<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/footers/">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #000000;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgb(113, 107, 119), rgba(39, 42, 44, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(113, 107, 119), rgba(39, 42, 44, 1))
        }
    </style>
</head>

<body class="antialiased">

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Reportes Accor</h2>
                                <img src="https://1000marcas.net/wp-content/uploads/2021/06/Accor-logo.png"
                                    width="100px" alt="">
                                <br />
                                <br />
                                @if (Route::has('login'))
                                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                                        <br />
                                        @auth
                                            <a href="{{ url('/home') }}" class="btn btn-dark w-100">Home</a>
                                            <br />
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-dark w-100">Login</a>
                                            <br />
                                            <br />
                                            @if (Route::has('register'))
                                                <a href="{{ route('register') }}" class="btn btn-dark w-100">Register</a>
                                            @endif
                                    @endif
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="container">
                </div>
            </div>
        </div>
    </section>


        <div
            class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">

        </div>
    </body>

    </html>
