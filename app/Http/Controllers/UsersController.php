<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use JWTFactory;
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
            return response()->json(compact('token'));
        }
        catch (JWTException $e)
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
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
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            $token = JWTAuth::fromUser($user);
            return response()->json(compact('token'));
        }
        catch (JWTException $e)
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
    }
}
