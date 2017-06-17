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
        $newUserPost = new UserPost;

        $newUserPost->user_id = $user->id;

        // Save image on server
        $imageName = $request->file('image')->getClientOriginalName();
        $path = '/img/' . $user->id . '/';
        $request->file('image')->move(
            base_path() . $path, $imageName
        );
        $fullPath = $path . $imageName;

        $newUserPost->img_path = $fullPath;
        $newUserPost->post_date = Carbon::now();

        if ($request->has('description'))
            $newUserPost->description = $request->description;

        $newUserPost->save();
    }
}
