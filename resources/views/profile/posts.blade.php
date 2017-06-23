@extends('layouts.profile')

@section('tabContent')
    <div>
        Posts <br/>
        @foreach ($content as $post)
            <img src="{{ $post->img_path }}"/> <br/>
        @endforeach
    </div>
    {{ $content->links() }}
@endsection