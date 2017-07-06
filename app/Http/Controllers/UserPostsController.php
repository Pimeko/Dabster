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
use App\UserHelper;
use Tymon\JWTAuthExceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;

class UserPostsController extends Controller
{
    public function get($postId)
    {
        $auth_like_id = -1;
        if (Session::has("token"))
        {
            $auth_like = UserLike::where('user_id', UserHelper::GetAuthUser()->id)
                ->where('user_post_id', $postId)->first();
            $auth_like_id = $auth_like ? $auth_like->type : -1;
        }

        $user_post = UserPost::where('id', $postId)
            ->withCount('comments')
            ->withCount('likes')
            ->first();

        $comments = $user_post->comments;
        $error = null;
        return view('post', compact('user_post', 'auth_like_id', 'comments', 'error'));
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

    public function trending()
    {
        $user = UserHelper::GetAuthUser();

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
        $user = UserHelper::GetAuthUser();

        $posts = UserPost::orderByDesc('post_date')
            ->withCount('comments')
            ->withCount('likes')
            ->paginate(4);
        $page = "recent";

        return view('home', compact('posts', 'page', 'user'));
    }

    public function random()
    {
        $user = UserHelper::GetAuthUser();

        $posts = UserPost::inRandomOrder()
            ->withCount('comments')
            ->withCount('likes')
            ->paginate(4);

        $page = "random";
        return view('home', compact('posts', 'page', 'user'));
    }

    public function uploadPage()
    {
        $error = null;
        return view('upload', compact('error'));
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,bmp,png,jpg,gif|max:10240',
            'description' => 'nullable|max:500',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return view('upload', compact('error'));
        }

        $user = UserHelper::GetAuthUser();

        $newUserPost = new UserPost;
        $newUserPost->user_id = $user->id;

        // Save image on server
        $file = $request->file('image');
        $file->storeAs($user->id, $file->getClientOriginalName());
        $fullPath = '/img/' . $user->id . '/' . $file->getClientOriginalName();
        $user->save();

        $newUserPost->img_path = $fullPath;
        $newUserPost->post_date = Carbon::now();

        if ($request->has('description'))
            $newUserPost->description = $request->description;

        $newUserPost->save();

        return redirect('/');
    }
}
