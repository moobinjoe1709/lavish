<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAuth
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
		if(empty(Auth::user()->name)){
			return redirect('/');
		}else{
			return $next($request);
		}
    }
}
