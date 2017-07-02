@extends('layouts.profile')

@section('tabContent')
    <div>
        @foreach ($content as $post)
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <img src="{{$post->user_posts->img_path}}" style="display:block; margin: 0 auto;"/>
                        <br/>
                        {{$post->user_posts->description}}
                        <br>
                        <small>{{$post->user_posts->post_date}}</small>
                    </div>
                </div>
                <footer class="card-footer">
                    <a class="card-footer-item">Liker</a>
                    <a class="card-footer-item">Commenter</a>
                    @if (Session::get('user_id') == $user->id)
                        <a class="card-footer-item">Supprimer</a>
                    @endif
                </footer>
            </div>
            <br/>
        @endforeach
    </div>
@endsection