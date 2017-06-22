@extends('layouts.app')

@section('title', 'Profil')

@section('includes')
        <link href="/css/profile.css" rel="stylesheet">
@endsection

@section('content')

  <div class="container profile">
    <div class="section profile-heading">
      <div class="columns">
        <div class="column is-2">
          <div class="image is-128x128 avatar">
            <img src="https://placehold.it/256x256">
          </div>
        </div>
        <div class="column is-4 name">
          <p>
            <span class="title is-bold">{{ $user->pseudo }}</span>
            @if ($alreadyFollows)
              <span class="button is-primary is-outlined follow">Unfollow</span>
            @else
              <span class="button is-primary is-outlined follow">Follow</span>
            @endif
          </p>
          <p class="tagline">The users profile bio would go here, of course. It could be two lines</p>
        </div>
        <div class="column is-2 followers has-text-centered">
          <p class="stat-val">{{ $followersCount }}</p>
          <p class="stat-key">suiveurs</p>
        </div>
        <div class="column is-2 following has-text-centered">
          <p class="stat-val">{{ $followingsCount }}</p>
          <p class="stat-key">suivis</p>
        </div>
        <div class="column is-2 likes has-text-centered">
          @if ($likesCount > 1)
            <p class="stat-val">{{ $likesCount }}</p>
            <p class="stat-key">réactions</p>
          @else
            <p class="stat-val">{{ $likesCount }}</p>
            <p class="stat-key">réaction</p>
          @endif
        </div>
      </div>
    </div>
    <div class="profile-options">
      <div class="tabs is-fullwidth">
        <ul>
          <li class="link is-active"><a><span class="icon"><i class="fa fa-th"></i></span> <span>Mes dabs</span></a></li>
          <li class="link"><a><span class="icon"><i class="fa fa-list"></i></span> <span>Dabbeurs suivis</span></a></li>
          <li class="link"><a><span class="icon"><i class="fa fa-heart"></i></span> <span>J'ai réagi</span></a></li>
        </ul>
      </div>
    </div>
  </div>

@endsection