<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;

use Closure;
use JWTAuth;
use Session;

class NotConnected
{
    public function handle($request, Closure $next)
    {
        if (Session::has("token"))
            return redirect('/');

        return $next($request);
    }
}
