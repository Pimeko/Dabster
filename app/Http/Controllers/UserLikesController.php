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
    {/*
        if ($request->has('_method'))
        {
            if ($request->_method == 'PUT')
                $this->putLike($post, $request);
            else if ($request->_method == 'DELETE')
                $this->deleteLike($post, $request);
        }
        else*/
        return    $this->postLike($post, $request);
    }

    public function putLike(UserPost $post, Request $request)
    {
        $currLike = UserLike::where('user_id', $request->user_id)->where('post_id', $post->id)->first();
        $currLike->type = $request->type;
        $currLike->save();
    }

    public function deleteLike(UserPost $post, Request $request)
    {
        $currLike = UserLike::where('user_id', $request->user_id)->where('post_id', $post->id)->first();
        $currLike->delete();
    }

    public function postLike(UserPost $post, Request $request)
    {
        $authUser = JWTAuth::setToken(Session::get("token"))->authenticate();
        $newLike = new UserLike;

        $newLike->user_id = $authUser->id;
        $newLike->user_post_id = $post->id;
        $newLike->type = $request->like_id;

        $newLike->save();

        return redirect('/users/' . $post->user_id . '/likes');
    }
}
