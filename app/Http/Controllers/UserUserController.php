<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\UserUser;
use App\Services\PushService;

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

  public function follow(User $user, Request $request)
  {
    // Unfollow
    if ($user->usersFollowers()->where('follower_id', $request->user_id)->get()->count() > 0)
      $user->usersFollowers()->detach($request->user_id);
    else // Follow
      $user->usersFollowers()->attach($request->user_id);
  }
}
