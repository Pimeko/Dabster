@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            Feed
        </div>

            @foreach ($posts as $post)
                <a href={{"/posts/" . $post->id}}>
                    <div class="card">
                        <div class="card-content">
                            <div class="content">
                                <img src="{{$post->img_path}}" style="display:block; margin: 0 auto;"/>
                                <br/>
                                {{$post->description}}
                                <br>
                                <small>
                                    Le {{ Carbon\Carbon::parse($post->post_date)->format('d-m-Y à h:m:s') }}
                                </small>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <span class="card-footer-item">Réagir</span>
                        </footer>
                    </div>

                </a>
                <br/>
            @endforeach

    </div>
</div>
@endsection
