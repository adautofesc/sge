<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PessoaDadosGerais;
use App\PessoaDadosAcesso;

class PerfilAuthController extends Controller
{
    public function validaCPF($cpf) { 
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function viewCPF(){
        return view('perfil.cpf');
        
    }

    public function verificarCPF($cpf){
        if(!is_numeric($cpf))
            return redirect()->back()->withErrors(['CPF inválido']);
        elseif(!$this->validaCPF($cpf))
            return redirect()->back()->withErrors(['CPF inválido']);
        else{
            $pessoa = PessoaDadosGerais::where('dado',3)->where('valor',$cpf)->first();
            if($pessoa->pessoa == null)
                return "view de cadastro";
            else{
                $senha = PessoaDadosGerais::where('dado',26)->where('pessoa',$pessoa->pessoa)->first();
                if($senha == null)
                    return "view de cadastro de senha";
                else
                    return "view de digitar a senha";


            }
        }



    }

    
}
