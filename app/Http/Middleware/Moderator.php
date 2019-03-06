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
            dump("not logged in");
            redirect(route('login'));
        }

        if (!auth()->user()->canModerate()) {
            dump("Redirecting to ".auth()->user()->home());
            redirect(auth()->user()->home());
        }

        //dd("Continue!");
        return $next($request);
    }
}
