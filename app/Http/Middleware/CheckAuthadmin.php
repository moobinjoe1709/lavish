<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAuthadmin
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
		if(Auth::user()->status != 1){
			return redirect('/');
		}else{
			return $next($request);
		}
    }
}
