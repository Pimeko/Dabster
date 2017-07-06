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
                        <br/>
                        <a href="{{'/users/' . $user_post->user->id}}">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="{{$user_post->user->pp}}" alt="Image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <p class="title is-4">{{$user_post->user->pseudo}}</p>
                                </div>
                            </div>
                        </a>
                        <span style="float:right">
                                <a href="#">
                                    {{$user_post->comments_count}} commentaires
                                </a>
                                <a href="#">
                                    {{$user_post->likes_count}} réactions
                                </a>
                                <br/>
                            </span>
                        <small>
                            Le {{ Carbon\Carbon::parse($user_post->post_date)->format('d-m-Y à h:m:s') }}
                        </small>
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
                        @if (Session::get('user_id') == $user_post->user_id)

                            {!! Form::open([
                                'url' => '/posts/' . $user_post->id,
                                'method' => 'delete'
                            ]) !!}


                            {{ Form::button('Supprimer la publication',
                            ['type' => 'submit', 'class' => 'card-footer-item'] )  }}

                            {!! Form::close() !!}
                        @endif
                    </footer>
                @endif
            </div>
        <br/>

        <div class="field">
            <form action="{{'/posts/' . $user_post->id . '/comments'}}" method="post" style="width:50%;margin:0 auto;">
                {{ csrf_field() }}
                <label class="label">COMMENTAIRES</label>

                @if($error)
                    <div style="color: #D9534F">{{ $error }}</div>
                @endif

                @if (Session::has('token'))
                    <div class="field">
                        <p class="control">
                            <textarea class="textarea" name="data" placeholder="Votre commentaire sur ce dab"></textarea>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control">
                            <input type="submit" value="Poster" class="button is-primary">
                        </p>
                    </div>
                @else
                    Il faut être connecté pour pouvoir commenter et réagir aux dabs. <a href="/login">Connectez-vous !</a>
                @endif
            </form>
        </div>

        @foreach ($comments as $comment)
            <div class="card">
                <div class="card-content">
                    <p class="title">
                        {{$comment->data}}
                    </p>
                    <p class="subtitle">
                        de <a href="{{"/users/" . $comment->user->id}}">{{$comment->user->pseudo }}</a>
                        <br/>
                        <small>
                            Le {{ Carbon\Carbon::parse($comment->comment_date)->format('d-m-Y à h:m:s') }}</small>
                    </p>
                </div>

                <footer class="card-footer">
                    @if (Session::get('user_id') == $comment->user->id)

                        {!! Form::open([
                            'url' => '/comments/' . $comment->id,
                            'method' => 'delete'
                        ]) !!}

                        {{ Form::button('Supprimer',
                        ['type' => 'submit', 'class' => 'card-footer-item'] )  }}

                        {!! Form::close() !!}

                    @endif
                </footer>
            </div>
            <br/>
        @endforeach
    </div>

@endsection
