<?php

namespace App\Http\Controllers;

use App\UserPost;
use Session;
use JWTAuth;

class PagesController extends Controller
{
    public static function home() {
        try {
            $token = Session::get("token");
            if (!$token)
            {
                $posts = UserPost::orderByDesc('post_date')->with('user')->paginate(5);
                return view('home', compact('posts'));
            }

            $user = JWTAuth::setToken($token)->authenticate();
            if (!$user)
            {
                Session::flush();
                return redirect('/');
            }

            // feed for connected user
            return redirect('/users/' . $user->id . '/feed');

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            Session::flush();
            return redirect('/');

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            Session::flush();
            return redirect('/');

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            Session::flush();
            return redirect('/');
        }

    }
}