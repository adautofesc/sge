<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TurmaController;
use App\Programa;
use App\PessoaDadosAdministrativos;
use App\Local;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class RelatorioController extends Controller
{
    
	public function alunosTurmas(){
		return view('admin.relatorio-turmas-alunos');
	}

    /**
     * [relatorioConcluintes description]
     * @param  integer $turma [description]
     * @return [type]         [description]
     */
    public function alunosConcluintes($turma=0){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. 'relatorio' .'.xls"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');

        $tabela =  new Spreadsheet();
        $arquivo = new Xls($tabela);

        $planilha = $tabela->getActiveSheet();
        $planilha->setCellValue('A1', 'ALUNOS PENDENTES - Gerado em '.date('d/m/Y'));
        $planilha->setCellValue('A2', 'Nome');
        $planilha->setCellValue('B2', 'Programa');
        $planilha->setCellValue('C2', 'Curso');
        $planilha->setCellValue('D2', 'Professor');
        $planilha->setCellValue('E2', 'Local');
        $planilha->setCellValue('F2', 'Carga Horária');
        $planilha->setCellValue('G2', 'Início');
        $planilha->setCellValue('H2', 'Termino');
        $linha = 3;

        if($turma ==0){
            $concluintes = Inscricao::join('turmas', 'inscricoes.turma','=','turmas.id')
            ->where('inscricoes.status','pendente')
            ->whereIn('turmas.programa',[1,2])
            ->get();

                //->toSql();
                
           // dd($concluintes);
           
           
        }
            
        foreach($concluintes as $concluinte){ 

                $planilha->setCellValue('A'.$linha, $concluinte->pessoa->nome);
                $planilha->setCellValue('B'.$linha, $concluinte->turma->programa->sigla);
                $planilha->setCellValue('C'.$linha, $concluinte->turma->curso->nome);
                $planilha->setCellValue('D'.$linha, $concluinte->turma->professor->nome);
                $planilha->setCellValue('E'.$linha, $concluinte->turma->local->nome);
                $planilha->setCellValue('F'.$linha, $concluinte->turma->carga);
                $planilha->setCellValue('G'.$linha, $concluinte->turma->data_inicio);
                $planilha->setCellValue('H'.$linha, $concluinte->turma->data_termino);

                $linha++;
                /*
                $aluno->turma = $concluinte->turma->id;
                $aluno->nome = $concluinte->pessoa->nome;
                $aluno->programa = $concluinte->turma->programa->sigla;
                $aluno->curso = $concluinte->turma->curso->nome;
                $aluno->professor = $concluinte->turma->professor->nome;
                $aluno->unidade = $concluinte->turma->local->nome;
                $aluno->carga= $concluinte->turma->carga;
                $aluno->inicio =  $concluinte->turma->data_inicio;
                $aluno->termino =  $concluinte->turma->data_termino;*/   
        }
        
        return $arquivo->save('php://output', 'xls');
        //return $formandos;
    }

	public function turmas(Request $request){
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
		
		return view('relatorios.turmas',compact('turmas'))->with('programas',$programas)->with('professores', $professores)->with('locais',$locais)->with('filtros',$_SESSION['filtro_turmas'])->with('vagas',$total_vagas)->with('inscricoes',$total_inscricoes)->with('porcentagem',$inscricoes_porcentagem);

	}

	public function dadosTurmas($string){

		$turmas_arr = explode(',',$string);
		$turmas = \App\Turma::whereIn('id',$turmas_arr)->get();
		foreach($turmas as $turma){
			$turma->inscricoes = \App\Inscricao::where('turma','=', $turma->id)->whereIn('status',['regular','pendente','finalizada'])->get();
			$turma->inscricoes = $turma->inscricoes->sortBy('pessoa.nome');
			foreach($turma->inscricoes as $inscricao){
			
				$inscricao->telefone = \App\PessoaDadosContato::getTelefone($inscricao->pessoa->id);
	            $inscricao->atestado = $inscricao->getAtestado();
	            if($inscricao->atestado){
	                $inscricao->atestado->validade =  $inscricao->atestado->calcularVencimento($turma->programa->id);
	                //dd($inscricao->atestado);
	            }
			}
		}
		return view('relatorios.dados-turmas',compact('turmas'));
	}



	public function matriculasUati(){

		$matriculas_faixa['Matriculas com uma disciplina']= 0;
		$matriculas_faixa['Com 2 a 3 disciplinas']= 0;
		$matriculas_faixa['Acima de 3']= 0;
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente'])->where('curso','307')->get();
		$matriculas_faixa['Matriculas totais'] = count($matriculas);
		foreach($matriculas as $matricula){
			$inscricoes = $matricula->getInscricoes();
			switch(count($inscricoes)){
				case 1:
					$matriculas_faixa['Matriculas com uma disciplina']++;
				 break;
				case 2:
				case 3:
					$matriculas_faixa['Com 2 a 3 disciplinas']++;
				break;
				case 4:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				case 10:
					$matriculas_faixa['Acima de 3']++;
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
		return $alunos_fesc;

		
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

	 public function bolsas(){
        $bolsas = \App\Bolsa::where('desconto','3')->get();
        return view('relatorios.bolsistas')->with('bolsas',$bolsas);
    }

    public function inscricoes(Request $request){
    	$total_vagas = 0;
		$total_inscricoes = 0;
		$tc =  new \App\Http\Controllers\TurmaController;
		$turmas = $tc->listagemGlobal($request->filtro,$request->valor,$request->removefiltro,$request->remove,500);

    	$programas=Programa::all();
        $professores = PessoaDadosAdministrativos::getFuncionarios('Educador');
        $professores = $professores->sortBy('nome_simples');
        $locais = Local::select(['id','sigla','nome'])->orderBy('sigla')->get();

        return view('relatorios.inscricoes',compact('turmas'))->with('programas',$programas)->with('professores', $professores)->with('locais',$locais)->with('filtros',$_SESSION['filtro_turmas'])->with('vagas',$total_vagas)->with('inscricoes',$total_inscricoes)->with('periodos',\App\classes\Data::semestres());
    }

    /**
     * Relatório com a lista de turmas e nomes com dados dos atestados.
     * @return [file] [lista de turmas com nomes e datas de vencimento dos atestados.]
     */
    public function turmasAtestados(){
    	
    	return $lista;

    }




}
