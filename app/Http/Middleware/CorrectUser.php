<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class CorrectUser
{
    public function handle($request, Closure $next)
    {
      try {
          $user = JWTAuth::parseToken()->authenticate();

          if (!$user) {
              return response()->json(['user_not_found'], 404);
          }
          if ($user->id != $request->user_id) {
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
