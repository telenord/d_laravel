<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateAndVerify
{
    /**
     * Handle an incoming request.
	 * if not logged - redirects to login
	 * if not verified - redirect to verification page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
		
		//email isn't verified, redirect to verification page
		if (!Auth::guard($guard)->user()->verified) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Email is not verified.', 401);
            } else {
                return redirect()->route('verification.email_not_verified');
            }
		}

        return $next($request);
    }
}
