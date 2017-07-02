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
                        <small>{{$like->user_posts->post_date}}</small>
                    </div>
                </div>
            </div>
            </a>
            <br/>
        @endforeach
    </div>
@endsection