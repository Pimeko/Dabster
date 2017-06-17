<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\UserPost;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuthExceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class UserPostsController extends Controller
{
    public function getPosts(User $user)
    {
        return $user->posts;
    }

    public function addPost(User $user, Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user;
        /*
        $newUserPost = new UserPost;

        $newUserPost->user_id = $user->id;
        $newUserPost->img_path = $request->img_path;
        $newUserPost->post_date = Carbon::now();

        $newUserPost->save();*/
    }
}
