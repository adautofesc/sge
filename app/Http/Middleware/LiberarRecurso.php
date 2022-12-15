<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class LiberarRecurso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $recurso)
    {
        $user = Auth::user();
        //dd($user->recursos);
        if(in_array($recurso,$user->recursos))
            return $next($request);
        else
            return view('errors.403')->with('recurso', $recurso);

        
            
    }
}
