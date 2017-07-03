@extends('layouts.app')

@section('title', 'Error')

@section('content')
<div class="hero is-light">
    <div class="container has-text-centered">
        <h1 class="title">Erreur</h1>
        {{$message}}
    </div>
</div>
@endsection
