@extends('layouts.profile')

@section('tabContent')
    <div>
        @foreach ($content as $post)
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <a href={{"/posts/" . $post->id}}>
                                <img src="{{$post->img_path}}" style="display:block; margin: 0 auto;"/>
                            </a>
                            <br/>
                            {{$post->description}}
                            <br>

                            <a href="{{'/users/' . $post->user->id}}">
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
                            </a>

                            <span style="float:right">
                                <a href={{"/posts/" . $post->id}}>
                                    {{$post->comments_count}} commentaires
                                </a>
                                <a href={{"/posts/" . $post->id}}>
                                    {{$post->likes_count}} réactions
                                </a>
                                <br/>
                            </span>
                            <small>
                                Le {{ Carbon\Carbon::parse($post->post_date)->format('d-m-Y à h:m:s') }}
                            </small>
                        </div>
                    </div>
                    <a href={{"/posts/" . $post->id}}>
                        <footer class="card-footer">
                            <span class="card-footer-item">Réagir</span>
                        </footer>
                    </a>
                </div>

            <br/>
        @endforeach
    </div>
    {{ $content->links() }}
@endsection