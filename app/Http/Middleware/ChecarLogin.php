<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

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
    if(Auth::user() && Auth::user()->status==1 && strtotime(Auth::user()->validade) > strtotime(date('Y-m-d')) )
        return $next($request);
            
    else{
        Auth::logout();
        return redirect()->route('login')->withErrors(['Login bloqueado ou expirado']);

    }
        
    }
}
