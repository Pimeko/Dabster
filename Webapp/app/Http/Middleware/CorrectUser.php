<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Session;
use Illuminate\Http\Response;

class CorrectUser
{
    public function handle($request, Closure $next)
    {
      $user = JWTAuth::setToken(Session::get("token"))->authenticate();

      if ($user->id != $request->route('userId')) {
          $message = "You do not have access to this page.";
          return new Response(view('error', compact('message')));
      }

      return $next($request);
    }
}
