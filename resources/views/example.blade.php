<<<<<<< HEAD
@extends('layouts.app')

@section('title', 'Example')

@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            Example
        </div>

        <div class="hero is-light">
            @forelse ($users as $user)
                <p>This is user {{ $user->pseudo }}</p>
            @empty
                <p> No users :(</p>
            @endforelse
        </div>

    </div>
@endsection
=======
<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Example</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    {{ $users }}
    <form action="{{ route('login') }}">
        pseudo:<br>
        <input type="text" name="pseudo" value="pimeko">
        <br>
        password:<br>
        <input type="text" name="lastname" value="abc">
        <br><br>
        <input type="submit" value="Submit">
    </form>
    </body>
</html>
>>>>>>> 68097ce3e0311797cf8bfc5df9036ba399ec3bce
