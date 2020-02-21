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
	    	
	    	$inscricao->setTurma($id);
	    	$inscricoes->push($inscricao);
	    	return $inscricoes;
	    }

	    //retornar uma inscricao vazia cazo numero de inscrições seja zero.
    }


    public function apiTurmas(){
        $turmas = Turma::whereIn('status',[2,4])->get();
        return $turmas;
	}
	
	public function listaProfessores(){
		$professores=\App\PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
		$sorted = $professores->sortBy('nome_simples');
		$sorted->values()->all();
		
		return response()->json($sorted, 200);
	}

	public function robot(){
		//fazer com que os boletos vencidos coloquem as matriculas em pendencia/cancelamento
		$cobranca_controller = new CobrancaController;
		$cobranca_controller->cobrancaAutomatica();

		//Verificar alunos bolsistas com + de 3 faltas consecutivas
		$bolsa_controller = new BolsaController;
		$bolsa_controller->supervisionarFaltas();

		//Verificar excesso de faltas de aluno
		


	}
}
