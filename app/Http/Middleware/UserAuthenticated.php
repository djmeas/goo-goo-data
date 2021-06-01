<?php

namespace App\Http\Middleware;

use Auth;

use Closure;

class UserAuthenticated
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
        
        // If this user is not logged in
        if(!Auth::user()) {
            return redirect()->action('HomeController@index')->with('error', 'You do not have access to that content.');
        }
        
        return $next($request);

    }
}
