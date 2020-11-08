<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AllowAdminsOnly
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
        if(Auth::check()){
            if(Auth::user()->is_admin)
                return $next($request);
            return redirect()->route('home')->with('error', 'Access allowed to admins only');
        }
        else
            return redirect()->route('home');
        
    }
}
