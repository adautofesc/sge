<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TurmaController;
use App\Programa;
use App\PessoaDadosAdministrativos;
use App\Local;

class RelatorioController extends Controller
{
    
	public function alunosTurmas(){
		return view('admin.relatorio-turmas-alunos');
	}

	public function inscricoesAtivas(Request $request){
		$total_vagas = 0;
		$total_inscricoes = 0;
		$tc =  new \App\Http\Controllers\TurmaController;
		$turmas = $tc->listagemGlobal($request->filtro,$request->valor,$request->removefiltro,$request->remove,500);

		foreach($turmas as $turma){
			$total_vagas = $total_vagas+$turma->vagas;
			$total_inscricoes = $total_inscricoes+$turma->matriculados;
		}
		if($total_vagas>0)
			$inscricoes_porcentagem = number_format($total_inscricoes*100/$total_vagas,2,',',' ');
		else
			$inscricoes_porcentagem = 0 ;

		

		$programas=Programa::all();
        $professores = PessoaDadosAdministrativos::getFuncionarios('Educador');
        $professores = $professores->sortBy('nome_simples');
        $locais = Local::select(['id','sigla','nome'])->orderBy('sigla')->get();


		//return $turmas;
		
		return view('secretaria.relatorios.turmas',compact('turmas'))->with('programas',$programas)->with('professores', $professores)->with('locais',$locais)->with('filtros',$_SESSION['filtro_turmas'])->with('vagas',$total_vagas)->with('inscricoes',$total_inscricoes)->with('porcentagem',$inscricoes_porcentagem);

	}
	public function matriculasUati(){

		$matriculas_faixa['matriculas com uma disciplina']= 0;
		$matriculas_faixa['com 2 a 4 disciplinas']= 0;
		$matriculas_faixa['acima de 4']= 0;
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente'])->where('curso','307')->get();
		$matriculas_faixa['Matriculas totais'] = count($matriculas);
		foreach($matriculas as $matricula){
			$inscricoes = $matricula->getInscricoes();
			switch(count($inscricoes)){
				case 1:
					$matriculas_faixa['matriculas com uma disciplina']++;
				 break;
				case 2:
				case 3:
				case 4:
					$matriculas_faixa['com 2 a 4 disciplinas']++;
				break;
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				case 10:
					$matriculas_faixa['acima de 4']++;
				break;
			}

		}
		return $matriculas_faixa;
	}
	public function alunosPorUnidade(){
		$alunos_fesc['campus 1'] = array();
		$alunos_fesc['campus 2'] = array();
		$alunos_fesc['campus 3'] = array();
		$alunos_fesc['todos'] = array();

		$inscricoes = \App\Inscricao::join('turmas', 'inscricoes.turma','=','turmas.id')
								->whereIn('turmas.local',[84,85,86])
								->whereIn('inscricoes.status',['regular','pendente'])
								->get();

		foreach($inscricoes as $inscricao){

			
			if(!in_array($inscricao->pessoa->id, $alunos_fesc['campus 1']) && $inscricao->local == 84){
				array_push($alunos_fesc['campus 1'] , $inscricao->pessoa->id);
			}
			if(!in_array($inscricao->pessoa->id, $alunos_fesc['campus 2']) && $inscricao->local == 85){
				array_push($alunos_fesc['campus 2'] , $inscricao->pessoa->id);
			}
			if(!in_array($inscricao->pessoa->id, $alunos_fesc['campus 3']) && $inscricao->local == 86){
				array_push($alunos_fesc['campus 3'] , $inscricao->pessoa->id);
			}
			if(!in_array($inscricao->pessoa->id, $alunos_fesc['todos'])){
				array_push($alunos_fesc['todos'] , $inscricao->pessoa->id);
			}


		}
		dd($alunos_fesc);

		
	}

	public function matriculasPrograma($programa){

		$qnde_matriculas = 0;
		$pessoas= Array();
		
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente'])->get();
		$matriculas_faixa['Matriculas totais'] = count($matriculas);
		foreach($matriculas as $matricula){
			$inscricoes = $matricula->getInscricoes();
			if($inscricoes->first()->turma->programa->id == $programa){
				if(!in_array($matricula->pessoa,$pessoas))
					array_push($pessoas,$matricula->pessoa);
				$qnde_matriculas++;
			}
			

		}
		return count($pessoas). ' pessoas com '.$qnde_matriculas .' matrículas.' ;
	}



}
