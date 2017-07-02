<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\UserUser;
use Session;
use JWTAuth;

class UserUserController extends Controller
{
  public function showFollowings(User $user)
  {
    return $user->usersFollowings;
  }

  public function showFollowers(User $user)
  {
    $req = $user->usersFollowers;

    $data = json_decode($req, TRUE);
    $res = array();

    foreach ($data as $user)
    {
      $tmp = User::where('id', $user['id'])->first()->usersFollowers;
      $user['followers'] = $tmp;

      array_push($res, $user);
    }

    return json_encode($res);
  }

  public function follow($userId, Request $request)
  {
      $authUser = JWTAuth::setToken(Session::get("token"))->authenticate();
      $user = User::where('id', $userId)->first();
      if ($user)
      {
          // Unfollow
          if ($user->usersFollowers()->where('follower_id', $authUser->id)->get()->count() > 0)
              $user->usersFollowers()->detach($authUser->id);
          else // Follow
              $user->usersFollowers()->attach($authUser->id);
      }

      return redirect('/users/' . $userId);
  }
}
