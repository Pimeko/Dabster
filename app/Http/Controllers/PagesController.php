<?php

namespace App\Http\Controllers;

use App\User;

class PagesController extends Controller
{
    public static function home() {
        $users = User::all();
        return view('home', compact('users'));
    }
}