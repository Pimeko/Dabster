@extends('layouts.app')

@section('title', 'S\'inscrire')

@section('content')
<div class="hero is-light">
    <div class="container has-text-centered">
        <h1 class="title">S'inscrire</h1>

        
        {!! Form::open(['style' => 'width:50%;margin:0 auto;']) !!}
            <div class="field">
                {!! Form::label('pseudo', 'Nom d\'utilisateur:', ['class' => 'label']) !!}
                <p class="control">
                    {!! Form::text('pseudo', null, ['class' => 'input']) !!}
                </p>
            </div>
            <div class="field">
                {!! Form::label('email', 'E-mail:', ['class' => 'label']) !!}
                <p class="control">
                    {!! Form::text('email', null, ['class' => 'input']) !!}
                </p>
            </div>
            <div class="field">
                {!! Form::label('password', 'Mot de passe:', ['class' => 'label']) !!}
                <p class="control">
                    {!! Form::text('password', null, ['class' => 'input']) !!}
                </p>
            </div>
            <div class="field">
                <p class="control">
                    {!! Form::submit('S\'inscrire', ['class' => 'button is-primary']) !!}
                </p>
            </div>
        {!! Form::close() !!}
    </div>
@endsection