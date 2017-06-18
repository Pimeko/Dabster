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