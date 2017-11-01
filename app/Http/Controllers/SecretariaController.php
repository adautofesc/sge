<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;
use App\Atendimento;
use Session;

class SecretariaController extends Controller
{
    //
    public function iniciarAtendimento()
	{
		return view('secretaria.inicio-atendimento');
	}
	public function atender($id=0){

		if($id>0){
			session('pessoa_atendimento',$id);
		}
		else{
			$id=session('pessoa_atendimento');
		}
		
		$pessoa=Pessoa::find($id);
		// Verifica se a pessoa existe
		if(!$pessoa)
			return redirect(asset('/secretaria/pre-atendimento'));
		else
			Session::put('pessoa_atendimento',$id);
		
		$pessoa=PessoaController::formataParaMostrar($pessoa);
		if(!Session::get('atendimento')){
			$atendimento=new Atendimento();
			$atendimento->atendente=Session::get('usuario');
			$atendimento->usuario=$pessoa->id;
			$atendimento->save();
			Session::put('atendimento', $atendimento->id);
			
			
		}
		
		return view('secretaria.atendimento', compact('pessoa'));
	}
}
