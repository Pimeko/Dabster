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
                    </div>
                    <footer class="card-footer">
                        <span class="card-footer-item">Réagir</span>
                    </footer>
                </div>

            </a>
            <br/>
        @endforeach
    </div>
    {{ $content->links() }}
@endsection