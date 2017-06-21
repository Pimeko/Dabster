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
              return new Response(view('error'));

          $user = JWTAuth::setToken($token)->authenticate();
          if (!$user)
              return new Response(view('error'));

          return $next($request);

      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          return view("error");
          //return response()->json(['token_expired'], $e->getStatusCode());

      } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          return view("error");
          //return response()->json(['token_invalid'], $e->getStatusCode());

      } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          return view("error");
          //return response()->json(['token_absent'], $e->getStatusCode());

      }

    }
}
