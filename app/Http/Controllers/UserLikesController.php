<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserPost;
use App\UserLike;
use JWTAuth;
use Session;

class UserLikesController extends Controller
{
    public function changeLike(UserPost $post, Request $request)
    {
        $authUser = JWTAuth::setToken(Session::get("token"))->authenticate();
        $currLike = UserLike::where('user_id', $authUser->id)->where('user_post_id', $post->id)->first();
        if ($currLike)
        {
            if ($currLike->type == $request->like_id)
                $currLike->delete();
            else
            {
                $currLike->type = $request->like_id;
                $currLike->save();
            }
        }
        else
            $this->postLike($post, $request, $authUser);

        return redirect('/posts/' . $post->id);
    }

    public function postLike(UserPost $post, Request $request, $authUser)
    {
        $newLike = new UserLike;

        $newLike->user_id = $authUser->id;
        $newLike->user_post_id = $post->id;
        $newLike->type = $request->like_id;

        $newLike->save();
    }
}
