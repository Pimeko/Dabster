@extends('layouts.app')

@section('content')
<div class="hero is-light">
    <div class="container has-text-centered">

        @if($errors)
            @foreach ($errors as $error)
                <div style="color: #D9534F">{{ $error }}</div>
            @endforeach
        @endif

        <h1 class="title">Edition de profil</h1>
        
        {!! Form::open(['style' => 'width:50%;margin:0 auto;']) !!}
            <div class="field">
                {!! Form::label('description', 'Description:', ['class' => 'label']) !!}
                <p class="control">
                    {!! Form::textarea('description', $user->description, ['class' => 'input']) !!}
                </p>
            </div>
            <div class="field">
                <p class="control">
                    {!! Form::submit('Sauvegarder', ['class' => 'button is-primary']) !!}
                </p>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection