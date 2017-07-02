@extends('layouts.app')

@section('title', 'Post')

@section('includes')
    <link href="/css/reaction.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content">
        <br/>
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <img src="{{$user_post->img_path}}" style="display:block; margin: 0 auto;"/>
                    <br/>
                    {{$user_post->description}}
                    <br>
                    <small>{{$user_post->post_date}}</small>
                </div>
            </div>
            <footer class="card-footer">
                <a class="card-footer-item" >
                    {!! Form::open([
                    'url' => '/posts/' . $user_post->id . '/likes',
                    'method' => 'post'
                    ]) !!}
                    {{ Form::hidden('like_id', '0') }}

                    {{ Form::button('<img src="/img/reactions/0.png" width="150" height="150"/>',
                    ['type' => 'submit'] )  }}

                    {!! Form::close() !!}
                </a>
                <a class="card-footer-item">
                    <img src="/img/reactions/1.png" width="150" height="150"/>
                </a>
                <a class="card-footer-item">
                    <img src="/img/reactions/2.png" width="150" height="150"/>
                </a>
                <a class="card-footer-item">
                    <img src="/img/reactions/3.png" width="150" height="150"/>
                </a>
            </footer>
            <footer class="card-footer">
                <a class="card-footer-item">Commenter</a>
                @if (Session::get('user_id') == $user_post->user_id)
                    <a class="card-footer-item">Supprimer</a>
                @endif
            </footer>
        </div>
        <br/>
    </div>

@endsection
