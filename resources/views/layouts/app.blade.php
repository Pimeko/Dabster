<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dabster - @yield('title')</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="css/bulma.css" rel="stylesheet">
    </head>
    <body>

        <div class="hero-head">
            <header class="nav">
                <div class="container">
                    <div class="nav-left">
                        <a class="nav-item" href="/">
                            <img src="img/420px-logo.png" alt="Logo">
                        </a>
                    </div>
                    <div class="nav-right">
                        @if (Session::has('token'))
                            <a class="nav-item" href="/">
                                Accueil
                            </a>
                            <a class="nav-item" href="logout">
                                Se déconnecter
                            </a>
                        @else
                            <a class="nav-item" href="/">
                                Accueil
                            </a>
                            <a class="nav-item" href="login">
                                Se connecter
                            </a>
                            <a class="nav-item" href="register">
                                S'inscrire
                            </a>
                        @endif
                    </div>
                </div>
            </header>
        </div>

        <div class="hero body">
            <div class="container">
                @yield('content')
            </div>
        </div>

        @yield('footer')
    </body>
</html>