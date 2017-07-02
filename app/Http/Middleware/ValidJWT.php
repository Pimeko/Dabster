<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;

use Closure;
use JWTAuth;
use Session;

class ValidJWT
{
    public function handle($request, Closure $next)
    {
      try {
          $token = Session::get("token");
          if (!$token)
          {
              Session::flush();
              $message = "You must be connected to access this page.";
              return new Response(view('error', compact('message')));
          }

          $user = JWTAuth::setToken($token)->authenticate();
          if (!$user)
          {
              Session::flush();
              $message = "Invalid token : please connect again.";
              return new Response(view('error', compact('message')));
          }

          return $next($request);

      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          Session::flush();
          $message = "Token expired : please connect again.";
          return view("error", compact('message'));

      } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          Session::flush();
          $message = "Invalid token : please connect again.";
          return view("error", compact('message'));

      } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          Session::flush();
          $message = "Invalid token : please connect again.";
          return view("error", compact('message'));
      }

    }
}
