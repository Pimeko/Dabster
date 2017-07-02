@extends('layouts.profile')

@section('tabContent')
    <div>
        @foreach ($content as $following)
            <a href={{"/users/" . $following->id}}>
                <div class="card">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-left">
                                <figure class="image is-48x48">
                                    <img src="{{$following->pp}}" alt="Image">
                                </figure>
                            </div>
                            <div class="media-content">
                                <p class="title is-4">{{$following->pseudo}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <br/>
        @endforeach
    </div>
@endsection