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
		if($id==0 && isset($_COOKIE['pessoa_atendimento'])){
			$id=$_COOKIE['pessoa_atendimento'];
		}
		$pessoa=Pessoa::find($id);
		// Verifica se a pessoa existe
		if(!$pessoa)
			return redirect(asset('/secretaria/pre-atendimento'));
		setcookie('pessoa_atendimento',$pessoa->id,time()+3600,'/');
		
		if($_COOKIE['pessoa_atendimento']!=$id || !isset($_COOKIE['atendimento'])){
			$atendimento=new Atendimento();
			$atendimento->atendente=Session::GET('usuario');
			$atendimento->usuario=$pessoa->id;
			$atendimento->save();
			setcookie('atendimento',$atendimento->id,time()+3600,"/atendimento");
			
		}
		$pessoa=PessoaController::formataParaMostrar($pessoa);
		return view('secretaria.atendimento', compact('pessoa'));
	}
}
