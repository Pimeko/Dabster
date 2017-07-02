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

                @if (Session::has('token'))
                    <footer class="card-footer">
                        @for ($i = 0; $i < 4; $i++)
                        <a class="card-footer-item" style="{{$auth_like_id == $i ? "border-bottom:#AFEFF1 2px solid;" : "none"}}">
                            {!! Form::open([
                                'url' => '/posts/' . $user_post->id . '/likes',
                                'method' => 'post'
                            ]) !!}
                            {{ Form::hidden('like_id', $i) }}

                            {{ Form::button('<img src="/img/reactions/' . $i . '.png" width="150" height="150"/>',
                            ['type' => 'submit'] )  }}

                            {!! Form::close() !!}
                        </a>
                        @endfor
                    </footer>
                    <footer class="card-footer">
                        <a class="card-footer-item">Commenter</a>
                        @if (Session::get('user_id') == $user_post->user_id)
                            <a class="card-footer-item">Supprimer</a>
                        @endif
                    </footer>
                @endif
            </div>

        <br/>
    </div>

@endsection
