<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class Moderator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect(route('login'));
        }

        if (!auth()->user()->canModerate()) {
            return redirect(auth()->user()->home());
        }

        return $next($request);
    }
}
