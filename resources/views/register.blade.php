@extends('layouts.app')

@section('title', 'S\'inscrire')

@section('content')
<div class="hero is-light">
    <div class="container has-text-centered">
        <h1 class="title">S'inscrire</h1>

        @if($error)
            <div style="color: #D9534F">Erreur : {{ $error }}</div>
        @endif

        <form action="" method="post" style="width:50%;margin:0 auto;">
            {{ csrf_field() }}
            <div class="field">
                <label class="label">Adresse e-mail :</label><br>
                <p class="control">
                    <input type="text" name="email" placeholder="Adresse e-mail" class="input">
                </p>
            </div>
            <div class="field">
                <label class="label">Pseudo :</label><br>
                <p class="control">
                    <input type="text" name="pseudo" placeholder="Nom d'utilisateur:" class="input">
                </p>
            </div>
            <div class="field">
                <label class="label">Mot de passe :</label><br>
                <p class="control">
                    <input type="password" name="password" class="input">
                </p>
            </div>
            <div class="field">
                <p class="control">
                    <input type="submit" value="S'inscrire" class="button is-primary">
                </p>
            </div>
        </form>
    </div>
@endsection