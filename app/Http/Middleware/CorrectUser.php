<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Session;

class CorrectUser
{
    public function handle($request, Closure $next)
    {
      try {
          $user = JWTAuth::setToken(Session::get("token"))->authenticate();

          if ($user->id != $request->route('userId')) {
              return response()->json(['wrong_user'], 403);
          }

      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          return response()->json(['token_expired'], $e->getStatusCode());

      } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          return response()->json(['token_invalid'], $e->getStatusCode());

      } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          return response()->json(['token_absent'], $e->getStatusCode());

      }

      return $next($request);
    }
}
