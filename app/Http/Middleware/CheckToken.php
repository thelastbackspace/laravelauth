<?php

namespace App\Http\Middleware;
use Closure;

class CheckToken
{
    public function handle($request, Closure $next)
    {
        if (session()->has('token')) {
            // Check if token is valid here
            return $next($request);
        } else {
            return response("not logged in");
            return redirect()->route('login');
        }
    }
}
