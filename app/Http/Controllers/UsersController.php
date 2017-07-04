<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\User;
use App\UserLike;
use App\UserPost;
use JWTAuth;
use JWTFactory;
use Session;
use Redirect;
use Image;
use Storage;
use Tymon\JWTAuthExceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use App\UserHelper;

class UsersController extends Controller
{
    public function createUser(Request $request)
    {
        $newUser = new User;

        $newUser->pseudo = $request->pseudo;
        $newUser->email = $request->email;
        $newUser->password = bcrypt($request->password);
        $newUser->pp = '/img/default.png';
        $newUser->description = "";

        $newUser->save();

        return $newUser;
    }

    public function createAndStoreTokenFromUser($user)
    {
        try
        {
            $token = JWTAuth::fromUser($user);
            Session::put('user_id', $user->id);
            Session::put('token', $token);
            return true;
        }
        catch (JWTException $e)
        {
            return false;
        }
    }

    // Creates a user and generates a token
    public function register(Request $request)
    {
        $newUser = $this->createUser($request);

        return redirect($this->createAndStoreTokenFromUser($newUser) ? '/' : 'register');
    }

    public function checkUserCredentials($user, $request)
    {
        return !empty($user) && Hash::check($request->password, $user->password);
    }

    // Check user's credentials and generates a token
    public function authenticate(Request $request)
    {
        $user = UserHelper::getUserByPseudo($request->pseudo);

        if (!$this->checkUserCredentials($user, $request))
        {
            $error =  "Mauvais pseudo / mot de passe, veuillez réessayer";
            return view('login', compact("error"));
        }

        return redirect($this->createAndStoreTokenFromUser($user) ? '/' : 'register');
    }

    public function logout() {
        Session::flush();
        return redirect('/');
    }

    // Does A follow B ?
    private function doesUserFollows($userA, $userB)
    {
        $res = false;

        $followers = $userB->usersFollowers;
        foreach ($followers as &$follower) {
            if ($follower->id == $userA->id) {
                $res = true;
            }
        }

        return $res;
    }

    private function getProfileGeneralData($user)
    {
        $data = array();

        $data["followingsCount"] =$user->usersFollowings->count();
        $data["followersCount"] = $user->usersFollowers->count();
        $data["likesCount"] = $user->likes->count();
        $data["alreadyFollows"] = $this->doesUserFollows(UserHelper::GetAuthUser(), $user);

        return $data;
    }

    public function profilePosts($userId) {
        $user = UserHelper::GetUserById($userId);

        $generalData = $this->getProfileGeneralData($user);
        $page = 'posts';

        $content = $user->posts()
            ->with('user')
            ->withCount('comments')
            ->withCount('likes')
            ->orderByDesc('post_date')
            ->paginate(4);

        return view('profile.posts', compact('user', 'generalData', 'page', 'content'));
    }

    public function profileLikes($userId) {
        $user = UserHelper::GetUserById($userId);

        $generalData = $this->getProfileGeneralData($user);
        $page = 'likes';

        $content = UserLike::where('user_id', $user->id)
            ->with('user_posts')
            ->paginate(4);

        return view('profile.likes', compact('user', 'generalData', 'page', 'content'));
    }

    public function profileFollowings($userId) {
        $user = UserHelper::GetUserById($userId);

        $generalData = $this->getProfileGeneralData($user);
        $page = 'followings';

        $content = $user->usersFollowings()
            ->paginate(4);

        return view('profile.followings', compact('user', 'generalData', 'page', 'content'));
    }

    public function profileEdit($userId) {
        $user = UserHelper::GetUserById($userId);
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request, $userId) {
        $user = UserHelper::GetAuthUser();
        $user->description = $request->description;

        if ($request->pp)
        {
            $file = $request->pp;
            $path = $file->storeAs('pp', $userId.'.jpg');
            print_r($path);
            $image = Image::make(Storage::disk('local')->get($path))->resize(256, 256)->stream();
            Storage::disk('local')->put($path, $image);
            $user->pp = '/img/pp/'.$userId.'.jpg';
        }
        $user->save();

        return redirect('/users/' . $userId);
    }

    public function feed($userId)
    {
        $user = UserHelper::GetUserById($userId);
        $followings = array();
        $usersFollowings = $user->usersFollowings;
        foreach ($usersFollowings as $following)
            array_push($followings, $following->id);

        $posts = UserPost::whereIn('user_id', $followings)
            ->with('user')
            ->withCount('comments')
            ->withCount('likes')
            ->orderByDesc('post_date')
            ->paginate(4);
        $page = "feed";

        return view('home', compact('posts', 'page', 'user'));
    }
}
