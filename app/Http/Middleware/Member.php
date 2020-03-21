<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Member
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
        if(Session::get('Mname') == ""){
			Session::flash('alert-mlogin','login');
			return redirect('/');
		}else{
			return $next($request);
		}
    }
}
