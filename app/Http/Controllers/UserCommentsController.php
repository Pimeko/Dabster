<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\UserPost;
use App\UserComment;

class UserCommentsController extends Controller
{
    public function addComment(UserPost $post, Request $request)
    {
        $newComment = new UserComment;

        $newComment->user_id = $request->user_id;
        $newComment->post_id = $post->id;
        $newComment->data = $request->data;
        $newComment->comment_date = Carbon::now();

        $newComment->save();
    }
}
