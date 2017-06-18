<?php

namespace App\Http\Controllers;

use App\User;
use Request;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuthExceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{

    public function example() {
        $users = User::all();
        return view('example', compact('users'));
    }

    public function login() {

        return view('login');
    }

    public function auth() {
        $request = Request::all();
        
        $user = User::where('pseudo', $request['pseudo'])->first();

        try
        {
            if (empty($user) || $request['password'] !== $user->password)
                return response()->json(['error' => 'invalid_credentials', 'request' => $request['password'], 'user' => $user->password], 401);
            $token = JWTAuth::fromUser($user);
            return response()->json(compact('token'));
        }
        catch (JWTException $e)
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return $input;
    }
}