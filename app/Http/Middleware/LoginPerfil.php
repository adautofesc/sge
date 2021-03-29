<?php

namespace App\Http\Middleware;

use Closure;
use App\Pessoa;
use App\PessoaDadosContato;

class LoginPerfil
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
        if(session('pessoa_perfil') == null)
            return redirect('/perfil/cpf');
        else{
            
            $request->pessoa = Pessoa::find(session('pessoa_perfil'));
            $request->pessoa->email = (PessoaDadosContato::where('pessoa',$request->pessoa->id)->where('dado',1)->orderbyDesc('id')->first()->valor);
            $request->pessoa->celular = $request->pessoa->getCelular();        

            return $next($request);

        }

    }
}
