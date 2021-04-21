<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimento;
use App\Pessoa;
use Session;
use Auth;

class AtendimentoController extends Controller
{
    //
    public static function novoAtendimento($acao,$pessoa,$atendente=0){
    	if($atendente=='' || $atendente==0){
			$atendente=Auth::user()->pessoa;
		}
    	$atendimento=new Atendimento;
		$atendimento->atendente=$atendente;
		$atendimento->usuario=$pessoa;
		$atendimento->descricao=$acao;
		$atendimento->save();
		return $atendimento;
	}
	public static function abrirAtendimento($pessoa){
		if($pessoa=='' || $pessoa==0){
			$pessoa=Auth::user()->pessoa;
		}
		
		$pessoa_obj=Pessoa::find($pessoa);
		// Verifica se a pessoa existe
		if(!$pessoa_obj)
			return redirect(asset('/secretaria/pre-atendimento'));
		else{
			$pessoa=$pessoa_obj->id;
			Session::put('pessoa_atendimento',$pessoa);
		}

		if(!Session::get('atendimento')){
			$atendimento=new Atendimento;
			$atendimento->atendente=Auth::user()->pessoa;
			$atendimento->usuario=$pessoa;
			$atendimento->save();
			Session::put('atendimento', $atendimento->id);
			return true;
			
			
		}
	}
	public function atender($id=0){
		

	}
}
