<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthentication
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
        $user = \App\User::where(['email' => $request->get('user')])->first();

        if (!$user || !Hash::check($request->get('token'), $user->api_token)) {
            return response()->json([
                'result' => false,
                'data' => ['errors' => 'unauthorised'],
                'status' => Response::HTTP_FORBIDDEN
            ], 403);
        }
        
        Auth::onceUsingId($user->id);

        return $next($request);
    }
}
