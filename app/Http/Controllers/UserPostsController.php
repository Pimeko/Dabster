<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\UserPost;
use App\UserLike;
use JWTAuth;
use JWTFactory;
use Session;
use Tymon\JWTAuthExceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use DB;

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

    public function get($postId)
    {
        $isConnected = Session::has("token");
        $authUser = $isConnected ?
            JWTAuth::setToken(Session::get("token"))->authenticate() : null;

        $user_post = UserPost::where('id', $postId)
            ->withCount('comments')
            ->withCount('likes')
            ->first();
        $auth_like = $isConnected ?
            UserLike::where('user_id', $authUser->id)->where('user_post_id', $postId)->first() : null;
        $auth_like_id = $isConnected ?
            $auth_like ? $auth_like->type : -1 : null;

        $comments = $user_post->comments;
        return view('post', compact('user_post', 'auth_like_id', 'comments'));
    }

    public function remove($postId)
    {
        $authUser = JWTAuth::setToken(Session::get("token"))->authenticate();
        $post = UserPost::where('id', $postId)->first();
        if ($post && $authUser->id == $post->user_id)
        {
            $comments = $post->commentsOnly;
            foreach ($comments as $comment)
                $comment->delete();

            $likes = $post->likes;
            foreach ($likes as $like)
                $like->delete();

            $post->delete();
        }
        return redirect('/');
    }

    private function GetAuthUser()
    {
        return JWTAuth::setToken(Session::get("token"))->authenticate();
    }

    public function trending()
    {
        $user = $this->GetAuthUser();

        $posts = UserLike::select('user_post_id', DB::raw('count(*) as total'))
            ->groupBy('user_post_id')
            ->orderByDesc('total')
            ->with('user_posts')
            ->paginate(4);
        $page = "trending";

        return view('home', compact('posts', 'page', 'user'));
    }

    public function recent()
    {
        $user = $this->GetAuthUser();

        $posts = UserPost::orderByDesc('post_date')
            ->withCount('comments')
            ->withCount('likes')
            ->paginate(4);
        $page = "recent";

        return view('home', compact('posts', 'page', 'user'));
    }

    public function random()
    {
        $user = $this->GetAuthUser();

        $posts = UserPost::inRandomOrder()->paginate(4);

        $page = "random";
        return view('home', compact('posts', 'page', 'user'));
    }
}
