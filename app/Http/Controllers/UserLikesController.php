<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserPost;
use App\UserLike;

class UserLikesController extends Controller
{
    public function changeLike(UserPost $post, Request $request)
    {
        if ($request->has('_method'))
        {
            if ($request->_method == 'PUT')
                $this->putLike($post, $request);
            else if ($request->_method == 'DELETE')
                $this->deleteLike($post, $request);
        }
        else
            $this->postLike($post, $request);
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
        $newLike = new UserLike;

        $newLike->user_id = $request->user_id;
        $newLike->post_id = $post->id;
        $newLike->type =    $request->type;

        $newLike->save();
    }
}
