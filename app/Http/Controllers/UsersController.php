<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\User;
use App\UserLike;
use JWTAuth;
use JWTFactory;
use Session;
use Tymon\JWTAuthExceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getUsers()
    {
        return User::all();
    }

    public function getUser($userId)
    {
        $user = User::where('id', $userId)
            ->with('usersFollowings')
            ->with('usersFollowers')
            ->with('likes')
            ->first();

        if (!$user)
            return view('error');


        $usersFollowingsCount = $user->usersFollowings->count();
        $usersFollowersCount = $user->usersFollowers->count();
        $nbLikes = $user->likes->count();

        return view('profile', compact('user', 'nbLikes'));
    }

    // Creates a user and generates a token
    public function register(Request $request)
    {
        $newUser = new User;

        $newUser->pseudo = $request->pseudo;
        $newUser->email = $request->email;
        $newUser->password = bcrypt($request->password);

        $newUser->save();

        try
        {
            $token = JWTAuth::fromUser($newUser);
            Session::put('user_id', $newUser->id);
            Session::put('token', $token);
            return PagesController::home();
            //return response()->json(compact('token'));
        }
        catch (JWTException $e)
        {
            return view('register'); 
            //response()->json(['error' => 'could_not_create_token'], 500);
        }
    }

    // Check user's credentials and generates a token
    public function authenticate(Request $request)
    {
        $user = User::where('pseudo', $request->pseudo)->first();
        $errors = [];
        try
        {
            if (empty($user) || !Hash::check($request->password, $user->password))
            {
                array_push($errors, "Mauvais pseudo/mot de passe, veuillez réessayer");
                return view('login', compact("errors"));
            }
            $token = JWTAuth::fromUser($user);
            Session::put('user_id', $user->id);
            Session::put('token', $token);
            return redirect('/');
        }
        catch (JWTException $e)
        {   
            array_push($errors, "Erreur de token");
            return view('login', compact("errors"));
        }
    }

    public function logout() {
        Session::remove('token');
        Session::remove('user_id');
        return redirect('/');
    }

    public function profile(Request $request, $userId) {
        $user = User::where('id', $userId)
            ->with('usersFollowings')
            ->with('usersFollowers')
            ->with('likes')
            ->first();


        $token = Session::get("token");
        if (!$token)
            return new Response(view('error'));

        $authUser = JWTAuth::setToken($token)->authenticate();

        if (!$user || !$authUser)
            return view('error');

        $followers = $user->usersFollowers;
        $alreadyFollows = false;
        foreach ($followers as &$follower) {
            if ($follower->id == $authUser->id) {
                $alreadyFollows = true;
            }
        }
        $followingsCount = $user->usersFollowings->count();
        $followersCount = $user->usersFollowers->count();
        $likesCount = $user->likes->count();

        return view('profile', compact('user', 'alreadyFollows', 'followingsCount', 'followersCount', 'likesCount'));
    }
}
