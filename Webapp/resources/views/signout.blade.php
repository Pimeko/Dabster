@extends('layouts.app')

@section('title', 'Upload')

@section('includes')
    <link href="/css/edit.css" rel="stylesheet">
@endsection

@section('content')
<div class="hero is-light">
    <div class="container has-text-centered">
        <h1 class="title">Supprimer son compte</h1>

            @if($error)
                <div style="color: #D9534F">{{ $error }}</div>
            @endif

            <form action="" method="post" style="width:50%;margin:0 auto;">
                {{ csrf_field() }}
                <div class="field">
                    <label class="label">Pour supprimer votre compte, tapez votre pseudo :</label><br>
                    <p class="control">
                        <input type="text" class="input" name="pseudo" placeholder="Votre pseudo">
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <input type="submit" value="Supprimer mon compte" class="button is-primary">
                    </p>
                </div>
            </form>

            <a href="/">Ou bien retournez sur la plus grosse communauté du dab.</a>
    </div>
</div>
@endsection