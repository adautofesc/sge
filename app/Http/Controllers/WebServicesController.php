<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscricao;
use App\Turma;

class WebServicesController extends Controller
{


    public function apiChamada($id){
	    $inscritos=\App\Inscricao::where('turma',$id)->get();
	    $inscritos= $inscritos->sortBy('pessoa.nome');
	    if(count($inscritos)>0)
	    	return $inscritos;
	    else{
	    	$inscricoes = collect();
	    	$inscricao = new \App\Inscricao;
	    	$inscricao->id = 0;
	    	$pessoa = new \App\Pessoa;
	    	$pessoa->nome = '';
	    	$pessoa->id = 0;
	    	$inscricao->pessoax = new \App\Pessoa;
	    	$inscricao->turma = \App\Turma::find($id);
	    	$inscricoes->push($inscricao);
	    	return $inscricoes;
	    }

	    //retornar uma inscricao vazia cazo numero de inscrições seja zero.
    }


    public function apiTurmas(){
        $turmas = Turma::whereIn('status',[2,4])->get();
        return $turmas;
    }
}
