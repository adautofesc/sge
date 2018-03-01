<?php

namespace App\Http\Middleware;

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
        foreach(unserialize(Session('recursos_usuario')) as $controle){
            if($controle->recurso == $recurso)
                return $next($request);
        }
        return redirect()->route('403');
        
            
    }
}
