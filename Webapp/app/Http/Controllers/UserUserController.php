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
