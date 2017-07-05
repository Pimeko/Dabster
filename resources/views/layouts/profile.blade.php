@extends('layouts.app')

@section('title', 'Profil')

@section('includes')
        <link href="/css/profile.css" rel="stylesheet">
        <link href="/css/reaction.css" rel="stylesheet">
@endsection

@section('content')

  <div class="container profile">
    <div class="section profile-heading">
      <div class="columns">
        <div class="column is-2">
          <div class="image is-128x128 avatar">
            <img src="{{ $user->pp }}">
          </div>
        </div>
        <div class="column is-4 name">
          <p>
            <span class="title is-bold">{{ $user->pseudo }}</span>
            @if (Session::get('user_id') !== $user->id)

              <form action="{{'/users/' . $user->id . '/followings'}}" method="post" style="width:50%;margin:0 auto;">
                {{ csrf_field() }}

                @if ($generalData['alreadyFollows'])
                  <input type="submit" value="Ne plus suivre" class="button is-primary">
                @else
                  <input type="submit" value="Suivre" class="button is-primary">
                @endif
              </form>
            @endif
          </p>
          <p class="tagline">
            @if (Session::get('user_id') === $user->id && $user->description === "")
              Editez votre profil pour ajouter une description.
            @else
              {{ $user->description  }}
            @endif
          </p>
          <p>
            @if (Session::get('user_id') === $user->id)
              <a href={{ '/users/' . $user->id . '/edit'}} class="button is-primary is-outlined follow">Editer profil</a>
            @endif
          </p>
        </div>

        <div class="column is-2 followers has-text-centered">
          <p class="stat-val">{{ $generalData['followersCount']}}</p>
          <p class="stat-key">suiveurs</p>
        </div>
        <div class="column is-2 following has-text-centered">
          <p class="stat-val">{{ $generalData['followingsCount'] }}</p>
          <p class="stat-key">suivis</p>
        </div>
        <div class="column is-2 likes has-text-centered">
          <p class="stat-val">{{ $generalData['likesCount'] }}</p>
          @if ($generalData['likesCount'] > 1)
            <p class="stat-key">réactions</p>
          @else
            <p class="stat-key">réaction</p>
          @endif
        </div>

      </div>
    </div>
    <br/>
    <div class="profile-options">
      <div class="tabs is-fullwidth">
        <ul id="myTabs">
          <li class="{{ $page === 'posts' ? 'link is-active' : 'link' }}">
            <a href={{ '/users/' . $user->id . '/posts'}}><span class="icon"><i class="fa fa-th"></i></span>
              <span>Dabs postés</span>
            </a>
          </li>
          <li class="{{ $page === 'followings' ? 'link is-active' : 'link' }}">
            <a href={{ '/users/' . $user->id . '/followings'}}><span class="icon"><i class="fa fa-list"></i></span>
              <span>Dabbeurs suivis</span>
            </a>
          </li>
          <li class="{{ $page === 'likes' ? 'link is-active' : 'link' }}">
            <a href={{ '/users/' . $user->id . '/likes'}}><span class="icon"><i class="fa fa-heart"></i></span>
              <span>Les réactions</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    @yield('tabContent')
  </div>

@endsection

@section('footer')
  <script>
    $('#myTabs a').click(function (e) {
      alert(e)
      //e.preventDefault()
      $(this).tab('show')
    })
  </script>
@endsection