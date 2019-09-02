<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TurmaController;
use App\Programa;
use App\PessoaDadosAdministrativos;
use App\Local;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
ini_set('max_execution_time', 300);

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
    public function alunosTurmasExport(Request $request){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. 'relatorio' .'.xls"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');

        $tabela =  new Spreadsheet();
        $arquivo = new Xls($tabela);

        $planilha = $tabela->getActiveSheet();
        $planilha->setCellValue('A1', 'Gerado em '.date('d/m/Y'));
        $planilha->setCellValue('A2', 'Nome');
        $planilha->setCellValue('B2', 'Programa');
        $planilha->setCellValue('C2', 'Curso');
        $planilha->setCellValue('D2', 'Professor');
        $planilha->setCellValue('E2', 'Local');
        $planilha->setCellValue('F2', 'Carga Horária');
        $planilha->setCellValue('G2', 'Início');
        $planilha->setCellValue('H2', 'Termino');
        $planilha->setCellValue('I2', 'Telefone(s)');
      
        $linha = 3;

        if(!isset($request->turmas)){
            $concluintes = \App\Inscricao::join('turmas', 'inscricoes.turma','=','turmas.id')
            ->where('inscricoes.status','pendente')
            ->whereIn('turmas.programa',[1,2])
            ->get();

                //->toSql();
                
           // dd($concluintes);
           
           
        }
        else{
        	$turmas = explode(',',$request->turmas);


        	$concluintes = \App\Inscricao::join('turmas', 'inscricoes.turma','=','turmas.id')
            ->whereIn('inscricoes.status',['ativa','pendente','regular','finalizada'])
            ->whereIn('turmas.id', $turmas)
            ->get();
            //return $concluintes;

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
                $planilha->setCellValue('I'.$linha, $concluinte->pessoa->getTelefones()->implode("valor",", "));
               
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
        //return $concluintes;
        
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

	 public function bolsasFuncionariosMunicipais(){
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


    /*
    
Subquery

$employees = DB::table('gb_employee')
                            ->whereNotIn('employee_id', function($query) use ($client_id)
                            {
                                $query->select('gb_emp_client_empid')
                                      ->from('gb_emp_client_lines')
                                      ->where('gb_emp_client_clientid',$client_id);
                            })
                            ->get();

Agrupamento de parâmetro

Event::where('status' , 0)
     ->where(function($q) {
         $q->where('type', 'private')
           ->orWhere('type', 'public');
     })
     ->get();
     */

    public function bolsas(Request $request){
        $filtros =Array();
    	$programas=Programa::all();
    	$descontos = \App\Desconto::orderBy('nome')->get();
        $bolsas =  \App\Bolsa::select('*');

        //dd($request->descontos);
        if(isset($request->descontos)){
           
            $bolsas = $bolsas->whereIn('desconto',$request->descontos);
        }
        if(isset($request->status)){
           
            $bolsas = $bolsas->whereIn('status',$request->status);
        }

        if(isset($request->periodos)){
            if(count($request->periodos)==1){
                $intervalo = \App\classes\Data::periodoSemestre($request->periodos[0]);
                $bolsas = $bolsas->whereBetween('created_at', $intervalo);
            }      
            else{
                //Parameter Grouping
                $bolsas = $bolsas->where(function ($query) use ($request){
                    foreach($request->periodos as $periodo){
                        $intervalo = \App\classes\Data::periodoSemestre($periodo);
                        $query = $query->orWhereBetween('created_at', $intervalo);
                    }

                });
            }
               
        }

    	
    	if(isset($request->tipo)){


    		if($request->tipo=='Registros'){

    			 $bolsas = $bolsas->get();



                 //dd($bolsas);
              

    		}
    		if($request->tipo=='Resultados'){
    			

    		}
    		if($request->tipo=='Comparativo'){
    			

    		}
    	
    	
        	if (count($bolsas)>1){
                foreach($bolsas as $bolsa){
                   $bolsa->nome = $bolsa->getNomePessoa();
                }
                $bolsas = $bolsas->sortBy('nome');
            }
    	
    	}

           return view('relatorios.bolsas')
                    ->with('programas',$programas)
                    ->with('descontos',$descontos)
                    ->with('bolsas', $bolsas)
                    ->with('periodos',\App\classes\Data::semestres());
    	
       

    
    }

    public function tceAlunos($ano = 2018){
        if(!is_numeric($ano))
             die('O ano informado é inválido.');
        $alunos = array();
        $inscricoes = \App\Inscricao::whereBetween('created_at', [($ano-1).'-11-20%',$ano.'-11-20%'])
            ->orderBy('pessoa')
            ->get();

        //dd($inscricoes);
        foreach($inscricoes as $inscricao){
            if(!in_array($inscricao->pessoa, $alunos)){
 
                if($inscricao->pessoa){
                    //dd($inscricao->pessoa->id);
                    $alunos[$inscricao->pessoa->id]['nome'] = $inscricao->pessoa->nome;
                    $alunos[$inscricao->pessoa->id]['dados'] = \App\Pessoa::find($inscricao->pessoa->id);
                    $alunos[$inscricao->pessoa->id]['inscricoes'][] = $inscricao;
                }
            }

        }
        $alunos = array_values(array_sort($alunos, function ($value) {
            return $value['nome'];
        }));

        //dd($alunos);

       
        return view('relatorios.tce-alunos')
            ->with('ano',$ano)
            ->with('alunos',$alunos);


    }



    public function tceTurmasAlunos($ano = 2018){
        if(!is_numeric($ano))
            die('O ano informado é inválido.');
        $turmas = \App\Turma::whereBetween('data_inicio', [($ano-1).'-11-20%',$ano.'-11-20%'])
            ->where('status', '!=','cancelada')
            ->orderBy('data_inicio')
            ->get();

        foreach($turmas as $turma){   
            $inscricoes = \App\Inscricao::select('pessoa')->where('turma',$turma->id)->get();

            $alunos = array();
            foreach($inscricoes as $inscricao){
                if(isset($inscricao->pessoa))
                    $alunos[$inscricao->pessoa->id] = $inscricao->pessoa->nome;
            }
            asort($alunos);
            $turma->alunos = $alunos;
            $turma->nome_curso = $turma->getNomeCurso();
        }

        $turmas = $turmas->sortBy('nome_curso');

        return view('relatorios.tce-turmas-alunos')
            ->with('ano',$ano)
            ->with('turmas',$turmas);

    }
    
    public function tceTurmas($ano = 2018){
        if(!is_numeric($ano))
            die('O ano informado é inválido.');
        $turmas = \App\Turma::whereBetween('data_inicio', [($ano-1).'-11-20%',$ano.'-11-20%'])
            ->where('status', '!=','cancelada')
            ->orderBy('data_inicio')
            ->get();

        foreach($turmas as $turma){   
            $turma->nome_curso = $turma->getNomeCurso();
        }

        $turmas = $turmas->sortBy('nome_curso');

        return view('relatorios.tce-turmas')
            ->with('ano',$ano)
            ->with('turmas',$turmas);

    }


    public function tceEducadores($ano = 2018){
        if(!is_numeric($ano))
            die('O ano informado é inválido.');

        $educadores =  \App\PessoaDadosAdministrativos::getFuncionarios('educador');
        $educadores = $educadores->where('created_at','<=',$ano.'-12-31');
        foreach($educadores as $educador){
            $turmas = \App\Turma::whereBetween('data_inicio', [($ano-1).'-11-20%',$ano.'-11-20%'])
            ->where('status', '!=','cancelada')
            ->where('professor', $educador->id)
            ->orderBy('data_inicio')
            ->get();
            foreach($turmas as $turma){
                $turma->nome_curso = $turma->getNomeCurso();
            }
            $educador->turmas = $turmas->sortBy('nome_curso');

        }
        return view('relatorios.tce-educadores')
            ->with('ano',$ano)
            ->with('educadores',$educadores);
    }




}
