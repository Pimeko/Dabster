<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dabster - @yield('title')</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <link href="/css/bulma.css" rel="stylesheet">
        @yield('includes')
    </head>
    <body>
        <nav class="nav has-shadow">
            <div class="container">
                <div class="nav-left">
                    <a class="nav-item" href="/">
                        <img src="/img/logo.png" alt="Logo">
                    </a>
                </div>
                <div class="nav-right">
                    @if (Session::has('token'))
                        <a class="nav-item" href="/">
                            Accueil
                        </a>
                        <a class="nav-item" href="/upload">
                            Poster un dab
                        </a>
                        <a class="nav-item" href="{{ URL::to('/users/' . Session::get('user_id')) .'/posts' }}">
                            Profil
                        </a>
                        <a class="nav-item" href="/logout">
                            Se déconnecter
                        </a>
                    @else
                        <a class="nav-item" href="/">
                            Accueil
                        </a>
                        <a class="nav-item" href="/login">
                            Se connecter
                        </a>
                        <a class="nav-item" href="/register">
                            S'inscrire
                        </a>
                    @endif
                </div>
            </div>
        </nav>

        <div class="container">
            @yield('content')
        </div>
        <br/>

        <footer class="footer">
            <div class="content has-text-centered">
                <p>
                    <strong>Dabster inc. & associates</strong>
                    <br/>
                    Benjamin Widawski - Yassine Ammar - Thibault Virsolvy - Maximilien Gomes
                    <br/>
                    EPITA 2018 - All rights reserved ©
                </p>
            </div>
        </footer>
        @yield('footer')
    </body>
</html>