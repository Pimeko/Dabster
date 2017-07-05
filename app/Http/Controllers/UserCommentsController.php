<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\UserPost;
use App\UserComment;
use JWTAuth;
use Session;
use Validator;

class UserCommentsController extends Controller
{
    public function add(UserPost $post, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|min:2|max:500',
        ]);

        if ($validator->fails()) {
            return redirect('/posts/' . $post->id);
        }

        $authUser = JWTAuth::setToken(Session::get("token"))->authenticate();
        $newComment = new UserComment;

        $newComment->user_id = $authUser->id;
        $newComment->user_post_id = $post->id;
        $newComment->data = $request->data;
        $newComment->comment_date = Carbon::now();

        $newComment->save();
        return redirect('/posts/' . $post->id);
    }

    public function remove($commentId)
    {
        $authUser = JWTAuth::setToken(Session::get("token"))->authenticate();
        $comment = UserComment::where('id', $commentId)->first();
        $postId = $comment->user_post_id;
        if ($comment && $authUser->id == $comment->user_id)
            $comment->delete();

        return redirect('/posts/' . $postId);
    }
}
