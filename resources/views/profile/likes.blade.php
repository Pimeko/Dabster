@extends('layouts.profile')

@section('tabContent')
    <div>
        @foreach ($content as $like)
            <a href={{"/posts/" . $like->user_posts->id}}>
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <img src="{{$like->user_posts->img_path}}" style="display:block; margin: 0 auto;"/>
                            <br/>
                            {{$like->user_posts->description}}
                            <br>
                        </div>

                        <div class="media">
                            <div class="media-left">
                                <figure class="image is-48x48">
                                    <img src="{{$like->user_posts->user->pp}}" alt="Image">
                                </figure>
                            </div>
                            <div class="media-content">
                                <p class="title is-4">{{$like->user_posts->user->pseudo}}</p>
                            </div>
                        </div>
                        <small>{{$like->user_posts->post_date}}</small>
                    </div>
                    <footer class="card-footer">
                        <span class="card-footer-item">Réagir</span>
                    </footer>
                </div>
            </a>
            <br/>
        @endforeach
    </div>
@endsection