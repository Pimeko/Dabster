@extends('layouts.app')

@section('title', 'Upload')

@section('includes')
    <link href="/css/edit.css" rel="stylesheet">
@endsection

@section('content')
<div class="hero is-light">
    <div class="container has-text-centered">
        <h1 class="title">Poster un dab</h1>
            @if($error)
                <div style="color: #D9534F">{{ $error }}</div>
            @endif

            <form action="" method="post" style="width:50%;margin:0 auto;" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="field">
                    <p class="control">
                        <input type="file" name="image">
                    </p>
                </div>
                <div class="field">
                    <label class="label">Description :</label><br>
                    <p class="control">
                        <textarea class="input" name="description" placeholder="Description optionnelle du dab"></textarea>
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <input type="submit" value="Uploader" class="button is-primary">
                    </p>
                </div>
            </form>
    </div>
</div>
@endsection