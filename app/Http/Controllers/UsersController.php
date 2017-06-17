<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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

    public function postUser(Request $request)
    {
        $newUser = new User;

        $newUser->pseudo = $request->pseudo;
        $newUser->email = $request->email;
        $newUser->password = $request->password;

        $newUser->save();
    }
}
