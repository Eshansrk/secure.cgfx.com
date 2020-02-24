<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

// use App;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (Auth::guard($guard)->guest()) {

            if ($request->ajax() || $request->wantsJson()) {

                return response('Unauthorized.', 401);

            } else {

                return redirect()->guest('/login');
            }
        }
        // elseif (!is_null($role) && Auth::guard($guard)->user()->role != $role) {

        //     App::abort('403');
        // }
        
        return $next($request);
    }
}
