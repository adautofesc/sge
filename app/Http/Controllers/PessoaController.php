<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;
use Session;

class PessoaController extends Controller
{
    //
    public function adicionaPrimeiro(){
    	$admin= new Pessoa;
    	$admin->nome = "Adauto";
    	$admin->genero="h";
    	$admin->nascimento='1984-11-10';
    	$admin->save();

    	return "Pessoa registrada";
		

	}
	public function listaTodos(){

	}
	public function adiciona(Request $request){
		

	}
	public function mostra($id){

	}
	public function edita($id){

	}
	public function apaga($id){

	}
	
}
