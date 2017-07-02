<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\UserPost;
use App\UserComment;
use JWTAuth;
use Session;

class UserCommentsController extends Controller
{
    public function addComment(UserPost $post, Request $request)
    {
        $authUser = JWTAuth::setToken(Session::get("token"))->authenticate();
        $newComment = new UserComment;

        $newComment->user_id = $authUser->id;
        $newComment->user_post_id = $post->id;
        $newComment->data = $request->data;
        $newComment->comment_date = Carbon::now();

        $newComment->save();
        return redirect('/posts/' . $post->id);
    }
}
