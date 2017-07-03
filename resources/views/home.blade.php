@extends('layouts.app')

@section('title', 'Accueil')

@section('includes')
    <link href="/css/profile.css" rel="stylesheet">
@endsection

@section('content')
    @if (Session::has('token'))
    <div class="container profile">
        <div class="profile-options">
            <div class="tabs is-fullwidth">
                <ul id="myTabs">
                    <li class="{{ $page === 'feed' ? 'link is-active' : 'link' }}">
                        <a href={{ '/users/' . $user->id . '/feed'}}>
                            <span class="icon"><i class="fa fa-home"></i></span>
                            <span>Fil d'actualité</span>
                        </a>
                    </li>
                    <li class="{{ $page === 'trending' ? 'link is-active' : 'link' }}">
                        <a href={{ '/users/' . $user->id . '/trending'}}>
                            <span class="icon"><i class="fa fa-heartbeat"></i></span>
                            <span>Dabs Tendances</span>
                        </a>
                    </li>
                    <li class="{{ $page === 'recent' ? 'link is-active' : 'link' }}">
                        <a href={{ '/users/' . $user->id . '/recent'}}>
                            <span class="icon"><i class="fa fa-clock-o"></i></span>
                            <span>Les plus récents</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endif
    <br/>
    <div class="content">
            @foreach ($posts as $post)
                <a href={{"/posts/" . $post->id}}>
                    <div class="card">
                        <div class="card-content">
                            <div class="content">
                                <img src="{{$post->img_path}}" style="display:block; margin: 0 auto;"/>
                                <br/>
                                {{$post->description}}
                                <br>
                            </div>

                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="{{$post->user->pp}}" alt="Image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <p class="title is-4">{{$post->user->pseudo}}</p>
                                </div>
                            </div>
                            <small>
                                Le {{ Carbon\Carbon::parse($post->post_date)->format('d-m-Y à h:m:s') }}
                            </small>
                        </div>

                        <footer class="card-footer">
                            <span class="card-footer-item">Réagir</span>
                        </footer>
                    </div>

                </a>
                <br/>
            @endforeach

    </div>
    {{ $posts->links() }}
@endsection
