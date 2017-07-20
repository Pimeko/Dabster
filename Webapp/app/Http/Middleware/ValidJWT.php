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
              $message = "Vous devez être connecté pour accéder à cette page.";
              return new Response(view('error', compact('message')));
          }

          $user = JWTAuth::setToken($token)->authenticate();
          if (!$user)
          {
              Session::flush();
              $message = "Jeton invalide : reconnectez-vous.";
              return new Response(view('error', compact('message')));
          }

          return $next($request);

      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          Session::flush();
          $message = "Jeton expiré : reconnectez-vous.";
          return view("error", compact('message'));

      } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          Session::flush();
          $message = "Jeton invalide : reconnectez-vous.";
          return view("error", compact('message'));

      } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          Session::flush();
          $message = "Jeton invalide : reconnectez-vous.";
          return view("error", compact('message'));
      }

    }
}
