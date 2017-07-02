@extends('layouts.profile')

@section('tabContent')
    <div>
        @foreach ($content as $like)
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <img src="{{$like->user_posts->img_path}}" style="display:block; margin: 0 auto;"/>
                        <br/>
                        {{$like->user_posts->description}}
                        <br>
                        <small>{{$like->user_posts->post_date}}</small>
                    </div>
                </div>
                <footer class="card-footer">
                    <a class="card-footer-item">
                        <img src="/img/reactions/0.png" width="150" height="150"/>
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
                    @if (Session::get('user_id') == $like->user_posts->user_id)
                        <a class="card-footer-item">Supprimer</a>
                    @endif
                </footer>
            </div>
            <br/>
        @endforeach
    </div>
@endsection