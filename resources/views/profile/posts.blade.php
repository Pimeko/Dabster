@extends('layouts.profile')

@section('tabContent')
    <div>

        @foreach ($content as $post)
            <a href={{"/posts/" . $post->id}}>
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <img src="{{$post->img_path}}" style="display:block; margin: 0 auto;"/>
                            <br/>
                            {{$post->description}}
                            <br>
                            <small>{{$post->post_date}}</small>
                        </div>
                    </div>
                </div>
            </a>
            <br/>
        @endforeach
    </div>
    {{ $content->links() }}
@endsection