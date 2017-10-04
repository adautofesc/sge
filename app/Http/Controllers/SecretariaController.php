<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;

class SecretariaController extends Controller
{
    //
    public function iniciarAtendimento()
	{
		return view('secretaria.inicio-atendimento');
	}
	public function atender($id){

		

		$pessoa=Pessoa::find($id);
		// Verifica se a pessoa existe
		if(!$pessoa)
			return $this->listarTodos();

		$pessoa=Pessoa::find($id);
		$pessoa=PessoaController::formataParaMostrar($pessoa);


		return view('secretaria.atendimento', compact('pessoa'));
	}
}
