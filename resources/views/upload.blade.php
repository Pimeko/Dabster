@extends('layouts.app')

@section('title', 'Upload')

@section('includes')
    <link href="/css/edit.css" rel="stylesheet">
@endsection

@section('content')
<div class="hero is-light">
    <div class="container has-text-centered">

        @if($errors)
            @foreach ($errors as $error)
                <div style="color: #D9534F">{{ $error }}</div>
            @endforeach
        @endif

        <h1 class="title">Poster un dab</h1>
        
        {!! Form::open(['style' => 'width:50%;margin:0 auto;',
        'files' => 'true',
        'enctype' => "multipart/form-data",
        'method' => 'post']) !!}
            <div class="field">
                <p class="control">
                    {!! Form::file('image', ['class' => 'inputfile', 'id' => 'fileToUpload']) !!}
                    <label for="fileToUpload">
                        <i class="fa fa-upload"></i>
                        <span>Photo du dab</span>
                  </label>
                </p>
            </div>
            <div class="field">
                {!! Form::label('description', 'Description:', ['class' => 'label']) !!}
                <p class="control">
                    {!! Form::textarea('description', null,
                    ['class' => 'input',
                    'placeholder' => 'Description optionnelle du dab']) !!}
                </p>
            </div>
            <div class="field">
                <p class="control">
                    {!! Form::submit('Uploader', ['class' => 'button is-primary']) !!}
                </p>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('footer')
    <script src="/js/custom-file-input.js"></script>
@endsection