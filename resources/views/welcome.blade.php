<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon"/>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>NATIONAL TRANSMISSION & DESPATCH COMPANY LIMITED (NTDC) PAKISTAN</title>


    <!-- Fonts -->
    <link href="../fonts/fonts.css" rel="stylesheet">
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-light justify-content-end">
    <a class="navbar-brand" href="#">Technical Services Group</a>
{{--    <button class="btn btn-success">Always Show</button>--}}
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-grow-0 ml-auto" id="navbarSupportedContent">
        <ul class="navbar-nav text-right">
            @if (Route::has('login'))
                <li class="nav-item active">
                    @auth
                        <a href="{{ url('/home') }}" class="nav-link text-dark">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link text-dark">Login</a>

                </li>
                {{-- <li>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link text-dark disabled">Register</a>
                    @endif
                </li> --}}
            @endauth
            @endif
        </ul>
    </div>
</nav>
<div class="flex-center position-ref full-height">

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ffffff;">
        <a class="navbar-brand" href="#">
            <img src="img/logo.png">
        </a>
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown2"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown2">
                <ul class="navbar-nav mr-auto">
                </ul>

                <ul class="nav justify-content-center">

                    <li class="nav-item">
                        <a class="nav-link" href="#"><b>HOME</b><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><b>ABOUT</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><b>PROJECTS</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><b>ENERGY RESOURCES</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><b>TRANSMISSION NETWORKS</b></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"><b>SERVICES</b></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"><b>TENDERS</b></a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</div>

<!-- banner -->

<div class="cn-bnr">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/first.jpg" class="d-block w-100" alt="First slide">


            </div>
            <div class="carousel-item">
                <img src="img/second.jpg" class="d-block w-100" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img src="img/third.jpg" class="d-block w-100" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <div class="bnr-icons">
                <i class="fa fa-angle-left"></i>
            </div>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <div class="bnr-icons">
                <i class="fa fa-angle-right"></i>
            </div>
        </a>
    </div>
</div>
<!--/.banner -->
<br>
<div class="card text-center">
    <div class="card-header">
        <h1>WELCOME TO TSG TRAINING PORTAL</h1>
    </div>
    <div class="card-body">


        <p class="card-text">National Transmission & Despatch Company (NTDC) was incorporated on 6th November, 1998 and
            commenced commercial operation on 24th December, 1998. It was organized to take over all the properties,
            rights and assets obligations and liabilities of 220 KV and 500KV Grid Stations and Transmission
            Lines/Network owned by Pakistan Water and Power Development Authority (WAPDA).</p>

        <a href="#" class="btn btn-danger">READ MORE</a>
    </div>

</div>


<main>
    <!-- cards -->
    <section class="cn-prod">

        <div class="card-header">
            <center><h1>INTRODUCTION</h1></center>
        </div>
        <br>
        <div class="container">
            <div class="card-deck">

                <div class="card">
                    <img class="card-img-top" src="img/services.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><b>OUR SERVICES</b></h5>
                        <hr>
                        <p class="card-text">Dusk occurs at the darkest stage of twilight, or at the very end of
                            astronomical twilight after sunset and just before night.Pre-dusk, during early to
                            intermediate stages of twilight,there may be enough light in the sky under clear conditions
                            to read outdoors without artificial illumination, but at the end of civil twilight, when
                            Earth rotates to a point at which the center of the Sun is 6° below the local horizon,
                            artificial illumination is required to read outside.</p>

                        <div class="card-footer">
                            <center>
                                <button type="button" class="btn btn-danger">READ MORE</button>
                            </center>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <img class="card-img-top" src="img/energyresources.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><b>ENERGY RESOURCES</b></h5>
                        <hr>
                        <p class="card-text">Dusk occurs at the darkest stage of twilight, or at the very end of
                            astronomical twilight after sunset and just before night.Pre-dusk, during early to
                            intermediate stages of twilight,there may be enough light in the sky under clear conditions
                            to read outdoors without artificial illumination, but at the end of civil twilight, when
                            Earth rotates to a point at which the center of the Sun is 6° below the local horizon,
                            artificial illumination is required to read outside.</p>

                        <div class="card-footer">
                            <center>
                                <button type="button" class="btn btn-danger">READ MORE</button>
                            </center>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <img class="card-img-top" src="img/transmissionnetworks.png" alt="Card image cap">

                    <div class="card-body">
                        <h5 class="card-title"><b>TRANSMISSION NETWORKS</b></h5>
                        <hr>
                        <p class="card-text">Dusk occurs at the darkest stage of twilight, or at the very end of
                            astronomical twilight after sunset and just before night.Pre-dusk, during early to
                            intermediate stages of twilight,there may be enough light in the sky under clear conditions
                            to read outdoors without artificial illumination, but at the end of civil twilight, when
                            Earth rotates to a point at which the center of the Sun is 6° below the local horizon,
                            artificial illumination is required to read outside.</p>
                        <div class="card-footer">
                            <center>
                                <button type="button" class="btn btn-danger">READ MORE</button>
                            </center>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!--/.cards -->


    <script type="text/javascript" src="{{ asset('js/app.js')}}">

    </script>
</main>
</body>
</html>
