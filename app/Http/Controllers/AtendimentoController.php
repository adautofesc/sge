<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimento;
use App\Pessoa;
use Session;

class AtendimentoController extends Controller
{
    //
    public static function novoAtendimento($acao,$pessoa){
    	if($pessoa=='' || $pessoa==0){
			$pessoa=Session::get('pessoa_atendimento');
		}
    	$atendimento=new Atendimento;
		$atendimento->atendente=Session::get('usuario');
		$atendimento->usuario=$pessoa;
		$atendimento->descricao=$acao;
		$atendimento->save();
		return $atendimento;
	}
	public static function abrirAtendimento($pessoa){
		if($pessoa=='' || $pessoa==0){
			$pessoa=Session::get('pessoa_atendimento');
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
			$atendimento->atendente=Session::get('usuario');
			$atendimento->usuario=$pessoa;
			$atendimento->save();
			Session::put('atendimento', $atendimento->id);
			return true;
			
			
		}
	}
	public function atender($id=0){
		

	}
}
