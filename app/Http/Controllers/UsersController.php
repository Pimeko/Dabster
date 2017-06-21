<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function getUser(User $user)
    {
        return $user;
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

        try
        {
            if (empty($user) || !Hash::check($request->password, $user->password))
            {
                //return response()->json(['error' => 'invalid_credentials'], 401);
                return view('login');
            }

            $token = JWTAuth::fromUser($user);
            Session::put('user_id', $user->id);
            Session::put('token', $token);
            return PagesController::home();
            //return response()->json(compact('token'));
        }
        catch (JWTException $e)
        {
            //return response()->json(['error' => 'could_not_create_token'], 500);
            return view('login');

        }
    }

    public function logout() {
        Session::remove('token');
        Session::remove('user_id');
        return PagesController::home();
    }

    public function profile(Request $request) {
        $id = $request->id ? $request->id : Session::get('user_id'); 
        $user = User::where('id', $id)->first();
        $likes = UserLike::where('user_id', $id)->get()->count();
        return view('profile', compact('user', 'likes'));
    }
}
