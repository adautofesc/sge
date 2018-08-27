<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class ChecarLogin
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

        if(Session::has('sge_fesc_logged') && Session::get('usuario')>0)
            return $next($request);
        else 
            return redirect()->route('login');
    }
}
