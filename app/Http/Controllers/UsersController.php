<?php

namespace App\Http\Controllers;

use App\UserComment;
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
use Validator;

class UsersController extends Controller
{
    public function createUser(Request $request)
    {
        if (User::where('pseudo', $request->pseudo)->first()
            || User::where('email', $request->email)->first())
            return null;
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'pseudo' => 'required|min:3|max:80',
            'password' => 'min:3|max:80',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return view('register', compact('error'));
        }

        $newUser = $this->createUser($request);
        if (!$newUser || !$this->createAndStoreTokenFromUser($newUser))
        {
            $error = "Il y a déjà un utilisateur avec ce pseudo ou cette adresse mail.";
            return view('register', compact("error"));
        }

        return redirect('/');
    }

    // Check user's credentials and generates a token
    public function authenticate(Request $request)
    {
        $user = UserHelper::getUserByPseudo($request->pseudo);

        if (empty($user) || !Hash::check($request->password, $user->password))
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

    public function signout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pseudo' => 'required|min:3|max:80',
        ]);
        $auth = UserHelper::GetAuthUser();
        $error = null;
        if ($request->pseudo != $auth->pseudo)
            $error = "Le pseudo n'est pas correct.";
        if ($validator->fails())
            $error = $validator->errors()->first();

        if ($error)
            return view('signout', compact('error'));

        UserLike::where('user_id', $auth->id)->delete();
        $posts = UserPost::where('user_id', $auth->id)->get();
        foreach ($posts as $post)
        {
            unlink(public_path() . $post->img_path);
            UserComment::where('user_post_id', $post->id)->delete();
            $post->delete();
        }
        rmdir(public_path() . '/img/' . $auth->id);
        UserComment::where('user_id', $auth->id)->delete();
        $auth->usersFollowings()->detach();
        $auth->usersFollowers()->detach();

        User::where('id', $auth->id)->delete();

        return $this->logout();
    }

    private function getProfileGeneralData($user)
    {
        $data = array();

        $data["followingsCount"] =$user->usersFollowings->count();
        $data["followersCount"] = $user->usersFollowers->count();
        $data["likesCount"] = $user->likes->count();
        $data["alreadyFollows"] = UserHelper::doesUserFollows(UserHelper::GetAuthUser(), $user);

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
