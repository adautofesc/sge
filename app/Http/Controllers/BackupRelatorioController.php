<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TurmaController;
use App\Programa;
use App\PessoaDadosAdministrativos;
use App\Local;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Arr;

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
        header('Content-Disposition: attachment;filename="'. 'relatorio' .'.xls"'); //$filename is  xsl filename 
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
        $planilha->setCellValue('J2', 'Celular');
        $planilha->setCellValue('K2', 'Turma');
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
        	
                if(isset($concluinte->pessoa->getTelefones()->last()->valor))
                    $telefone = $concluinte->pessoa->getTelefones()->last()->valor;
                else
                    $telefone = '-';
                $planilha->setCellValue('A'.$linha, $concluinte->pessoa->nome);
                $planilha->setCellValue('B'.$linha, $concluinte->turma->programa->sigla);
                $planilha->setCellValue('C'.$linha, $concluinte->turma->curso->nome);
                $planilha->setCellValue('D'.$linha, $concluinte->turma->professor->nome);
                $planilha->setCellValue('E'.$linha, $concluinte->turma->local->nome);
                $planilha->setCellValue('F'.$linha, $concluinte->turma->carga);
                $planilha->setCellValue('G'.$linha, $concluinte->turma->data_inicio);
                $planilha->setCellValue('H'.$linha, $concluinte->turma->data_termino);
                $planilha->setCellValue('I'.$linha, $telefone);
                $planilha->setCellValue('J'.$linha, $concluinte->pessoa->getCelular());
                $planilha->setCellValue('K'.$linha, $concluinte->turma->id);
               
                $linha++;
                 
        }
        
        return $arquivo->save('php://output');
        //dd($planilha);
        
    }

    public function alunosTurmasExportSMS(Request $request){
        $pessoas = array();

        $turmas = explode(',',$request->turmas);
        $inscricoes = \App\Inscricao::whereIn('turma',$turmas)->whereIn('status',['regular','pendente','finalizada'])->get();
       // dd($inscricoes);
        foreach($inscricoes as $inscricao){
            
            if(isset($inscricao->pessoa->id) && !in_array($inscricao->pessoa->nome_simples,$pessoas)){
                $pessoas[$inscricao->pessoa->nome_simples] = $inscricao->pessoa->getCelular();
            }         
        }

        //dd($pessoas);
       
        $file = "campanha.txt";
        $txt = fopen($file, "w") or die("Unable to open file!");
        fwrite($txt, "Nome da campanha"."\n");
        fwrite($txt, "Descrição da campanha (até 150 caracteres)"."\n");
        foreach($pessoas as $nome=>$celular){
            if($celular != '-'){
                fwrite($txt, $celular.';'.$nome."\n");
            }
        }
        
        fclose($txt);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: text/plain");
        readfile($file);
    }

	public function turmas(Request $request){
      
		$total_vagas = 0;
		$total_inscricoes = 0;
		$tc =  new \App\Http\Controllers\TurmaController;
		$turmas = $tc->listagemGlobal($request->filtro,$request->valor,$request->removefiltro,$request->remove,500);
        //$atuais = $turmas->pluck('id')->toArray();
        //dd(array_diff($atuais,$outro));



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
		
		return view('relatorios.turmas',compact('turmas'))->with('programas',$programas)
            ->with('professores', $professores)
            ->with('locais',$locais)
            ->with('filtros',$_SESSION['filtro_turmas'])
            ->with('vagas',$total_vagas)
            ->with('periodos',\App\classes\Data::semestres())
            ->with('inscricoes',$total_inscricoes)
            ->with('porcentagem',$inscricoes_porcentagem);

	}

    public function exportarTurmas(Request $request){
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. 'relatorio turmas' .'.xls"'); //$filename is  xsl filename 
        header('Cache-Control: max-age=0');

        $tabela =  new Spreadsheet();
        $arquivo = new Xls($tabela);
        $linha = 3;

        $planilha = $tabela->getActiveSheet();
        $planilha->setCellValue('A1', date('d/m/Y'));
        $planilha->setCellValue('A2', 'ID');
        $planilha->setCellValue('B2', 'Programa');
        $planilha->setCellValue('C2', 'Curso');
        $planilha->setCellValue('D2', 'Professor');
        $planilha->setCellValue('E2', 'Local');
        $planilha->setCellValue('F2', 'Dia(s)');
        $planilha->setCellValue('G2', 'Início');
        $planilha->setCellValue('H2', 'Termino');
        $planilha->setCellValue('I2', 'Entrada');
        $planilha->setCellValue('J2', 'Saída');
        $planilha->setCellValue('K2', 'Vagas');
        $planilha->setCellValue('L2', 'Inscritos');
        $planilha->setCellValue('M2', 'Estado');
        $planilha->setCellValue('N2', 'Matriculas');
        $planilha->setCellValue('O2', 'Sala');
        $planilha->setCellValue('P2', 'CA');
        $planilha->setCellValue('Q2', 'SA');
        $planilha->setCellValue('R2', 'EV');
        $planilha->setCellValue('S2', 'NF');


        $tc =  new \App\Http\Controllers\TurmaController;
		$turmas = $tc->listagemGlobal($request->filtro,$request->valor,$request->removefiltro,$request->remove,500);

        foreach($turmas as $turma){
           
            $planilha->setCellValue('A'.$linha, $turma->id);
            $planilha->setCellValue('B'.$linha, $turma->programa->sigla);
            $planilha->setCellValue('C'.$linha, $turma->getNomeCurso());
            $planilha->setCellValue('D'.$linha, $turma->professor->nome);
            $planilha->setCellValue('E'.$linha, $turma->local->sigla);
            $planilha->setCellValue('F'.$linha, implode(',',$turma->dias_semana));
            $planilha->setCellValue('G'.$linha, $turma->data_inicio);
            $planilha->setCellValue('H'.$linha, $turma->data_termino);
            $planilha->setCellValue('I'.$linha, $turma->hora_inicio);
            $planilha->setCellValue('J'.$linha, $turma->hora_termino);
            $planilha->setCellValue('K'.$linha, $turma->vagas);
            $planilha->setCellValue('L'.$linha, $turma->matriculados);
            $planilha->setCellValue('M'.$linha, $turma->status);
            $planilha->setCellValue('N'.$linha, $turma->status_matriculas);
            
            if(isset($turma->sala->nome))
                $planilha->setCellValue('O'.$linha, $turma->sala->nome);
            else
                $planilha->setCellValue('O'.$linha, 'ND');
            
            $planilha->setCellValue('P'.$linha, $turma->getConceitos('ca'));
            $planilha->setCellValue('Q'.$linha, $turma->getConceitos('sa'));
            $planilha->setCellValue('R'.$linha, $turma->getConceitos('ev'));
            $planilha->setCellValue('S'.$linha, $turma->getConceitos('nf'));


            $linha++;
        }

        return $arquivo->save('php://output');

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
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente','espera'])->where('curso','307')->whereBetween('data',[(date('Y')-1).'-11-20', date('Y').'-11-19'])->get();
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

	public function matriculasPrograma($ano){
        $item = array();
        $total_matriculas = 0;
        $programas = \App\Programa::whereIn('id',[1,2,3,4,12])->get();
        
        if($ano == date('Y')){
            foreach($programas as $programa){
                $turmas = \App\Turma::whereYear('data_inicio',$ano)->where('programa',$programa->id)->whereIn('status',['lancada','iniciada'])->pluck('id')->toArray();
                //dd($turmas);
                $item[$programa->id] = \App\Inscricao::whereIn('turma',$turmas)->whereIn('status',['pendente','regular'])->groupBy('matricula')->pluck('matricula')->toArray();
                //dd($item[$programa->id]);
                $total_matriculas += count($item[$programa->id]);
            }      
        }
        else{
            foreach($programas as $programa){
                $turmas = \App\Turma::whereYear('data_inicio',$ano)->where('programa',$programa->id)->where('status','encerrada')->pluck('id')->toArray();
                $item[$programa->id] = \App\Inscricao::whereIn('turma',$turmas)->where('status','finalizada')->groupBy('matricula')->pluck('matricula')->toArray();
                //dd($item[$programa->id]);
                $total_matriculas += count($item[$programa->id]);
            } 

        }

        return view('relatorios.matriculas-por-programa')->with('programas',$programas)->with('matriculas',$item)->with('total',$total_matriculas)->with('ano',$ano);
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

        return view('relatorios.inscricoes',compact('turmas'))
            ->with('programas',$programas)
            ->with('professores', $professores)
            ->with('locais',$locais)
            ->with('filtros',$_SESSION['filtro_turmas'])
            ->with('vagas',$total_vagas)
            ->with('inscricoes',$total_inscricoes)
            ->with('periodos',\App\classes\Data::semestres());
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
    		}
    		if($request->tipo=='Resultados'){
                $bolsas = $bolsas->select('*',\DB::raw('COUNT(*) as numero'))->groupBy('desconto')->get();   			
    		}
    		/*if($request->tipo=='Comparativo'){
    			

    		}*/   	
        	if (count($bolsas)>1){
                foreach($bolsas as $bolsa){
                    $pessoa =  $bolsa->getPessoa();
                    $bolsa->nome = $pessoa->nome;
                }
                $bolsas = $bolsas->sortBy('nome');
            }
        }
        return view('relatorios.bolsas')
                ->with('r',$request)
                ->with('programas',$programas)
                ->with('descontos',$descontos)
                ->with('bolsas', $bolsas)
                ->with('periodos',\App\classes\Data::semestres());
    }
    

    public function tceAlunos($ano = 2020){
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
                    $alunos[$inscricao->pessoa->id]['dados'] = \App\Pessoa::withTrashed()->find($inscricao->pessoa->id);
                    $alunos[$inscricao->pessoa->id]['inscricoes'][] = $inscricao;
                }
            }

        }
        $alunos = array_values(Arr::sort($alunos, function ($value) {
            return $value['nome'];
        }));
        return view('relatorios.tce-alunos')
            ->with('ano',$ano)
            ->with('alunos',$alunos);


    }



    public function tceTurmasAlunos($ano = 2020){
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
    
    public function tceTurmas($ano = 2020){
        if(!is_numeric($ano))
            die('O ano informado é inválido.');
        $turmas = \App\Turma::whereBetween('data_inicio', [($ano-1).'-11-20%',$ano.'-11-20%'])
            ->where('status', '!=','cancelada')
            ->orderBy('data_inicio')
            
            ->get();

        foreach($turmas as $turma){   
            $turma->nome_curso = $turma->getNomeCurso();
            $turma->ca = $turma->getConceitos('ca');
            $turma->sa = $turma->getConceitos('sa');
            $turma->ev = $turma->getConceitos('ev');
            $turma->nf = $turma->getConceitos('nf');

        }

        $turmas = $turmas->sortBy('nome_curso');

        return view('relatorios.tce-turmas')
            ->with('ano',$ano)
            ->with('turmas',$turmas);

    }


    public function tceEducadores($ano = 2020){
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

    public function tceVagas($ano = null){
        if(!$ano)
            $ano = date('Y');
        
        $vagas = array();
        $ocupacao = array();
        if(!is_numeric($ano))
             die('O ano informado é inválido.');
        $programas = array('1','2','3','4','12');
            foreach($programas as $programa){
                $vagas[$programa] = \App\Turma::whereYear('data_inicio',$ano)->where('programa',$programa)->whereIn('status',['iniciada','encerrada'])->sum('vagas');
                $turmas[$programa] = \App\Turma::whereYear('data_inicio',$ano)->where('programa',$programa)->whereIn('status',['iniciada','encerrada'])->count();


                //dd(\App\Turma::whereYear('data_inicio',$ano)->where('programa',2)->whereIn('status',['iniciada','encerrada'])->get());
                if($ano == 2020){
                    $ocupacao[$programa] = \App\Inscricao::select('inscricoes.id','programa')
                                                        ->join('turmas','turmas.id','=','inscricoes.turma')
                                                        ->wherebetween('turmas.data_inicio',['2020-01-01','2020-12-31'])
                                                        ->where('programa',$programa)
                                                        ->where('inscricoes.status','finalizada')
                                                        ->count();
                    $ocupacao[$programa] += \App\Inscricao::select('inscricoes.id','programa')
                                                        ->join('turmas','turmas.id','=','inscricoes.turma')
                                                        ->wherebetween('turmas.data_inicio',['2020-01-01','2020-12-31'])
                                                        ->where('programa',$programa)
                                                        ->where('inscricoes.status','cancelada')
                                                        ->where('inscricoes.updated_at','>=','2020-03-20')
                                                        ->count();
                }
                else                  
                    $ocupacao[$programa] = \App\Turma::whereYear('data_inicio',$ano)
                                                        ->where('programa',$programa)
                                                        ->sum('matriculados');
        
            }

            switch($ano){
                case '2019' :
                    $vagas[3] = 1507;
                    $vagas[2] = 1159;
                    $vagas[1] = 873;
                    $vagas[4] = 225;
                    $ocupacao[3] = 1301;
                    $ocupacao[2] = 951;
                    $ocupacao[1] = 740;
                    $ocupacao[4] = 177;
                    break;
                case '2018' :
                    $vagas[3] = 2362;
                    $vagas[2] = 1683;
                    $vagas[1] = 623;
                    $vagas[4] = 1385;
                    $ocupacao[3] = 1563;
                    $ocupacao[2] = 1247;
                    $ocupacao[1] = 498;
                    $ocupacao[4] = 1385;
                    break;
                
            }
        //return $turmas[4];
    
    
        return view('relatorios.vagas')->with('ano',$ano)->with('ocupacao',$ocupacao)->with('vagas',$vagas)->with('turmas',$turmas);
        
    }


    /**
     * Uma lista de alunos regulares para assinatura (usado na votação da eleição do conselho)
     */
    public function alunosConselho($ano = 2018){
        if(!is_numeric($ano))
             die('O ano informado é inválido.');
        $alunos = array();
        $inscricoes = \App\Inscricao::whereBetween('created_at', [($ano-1).'-11-20%',$ano.'-11-20%'])
            ->orderBy('pessoa')
            ->get();

        //dd($inscricoes);
        foreach($inscricoes as $inscricao){
            if(!in_array($inscricao->pessoa, $alunos)){
 
                if($inscricao->pessoa && $inscricao->status=='regular' && in_array($inscricao->turma->programa->id,[3,12])){
                    //dd($inscricao->pessoa->id);
                    $alunos[$inscricao->pessoa->id]['nome'] = $inscricao->pessoa->nome;
                    $alunos[$inscricao->pessoa->id]['dados'] = \App\Pessoa::withTrashed()->find($inscricao->pessoa->id);
                    $alunos[$inscricao->pessoa->id]['inscricoes'][] = $inscricao;
                }
            }

        }
        $alunos = array_values(array_sort($alunos, function ($value) {
            return $value['nome'];
        }));
        return view('relatorios.alunos-conselho')
            ->with('ano',$ano)
            ->with('alunos',$alunos);


    }

    /**
     * Listar Bolsistas com mais de 3 faltas seguidas
     */
    public function bolsistasComTresFaltas(){
        $bc = new BolsaController;
        $bolsistas = $bc->fiscalizarBolsa();
        $pessoas = array();
        foreach($bolsistas as $bolsista=>$turma){
            array_push($pessoas, $bolsista);
        }
        $bolsas = \App\Bolsa::whereIn('pessoa',$pessoas)->where('status','ativa')->groupBy('pessoa')->get();
        foreach($bolsas as $bolsa){
            $bolsa->aluno = $bolsa->getPessoa();
            $bolsa->nome_aluno = $bolsa->aluno->nome;
            $bolsa->telefone_aluno = $bolsa->aluno->getCelular();
        }
        $bolsasOrdenadas = $bolsas->sortBy('nome_aluno');
        return view('relatorios.bolsistas')->with('bolsas',$bolsasOrdenadas);
        
    
    }

    public function numeroAlunos(Request $r){
        define("ANO_INICIAL",2018);//se for alterar mexer tbm na view
        

        $locais = \App\Local::orderBy('sigla')->whereNotIn('id',[84,85,86])->get();

        
         
        for($i=ANO_INICIAL;$i<=date("Y");$i++){
            if(isset($r->local)){
                $totais[$i][0] = \DB::table('turmas')->select(['id','programa','local'])->whereIn('status',['encerrada','iniciada'])->whereYear('data_termino',$i)->whereIn('local',$r->local)->get();
                $totais[$i][1] = \DB::table('turmas')->select(['id','programa','local'])->whereIn('status',['encerrada','iniciada'])->whereYear('data_termino',$i)->whereIn('local',$r->local)->whereMonth('data_termino','<=',7)->get();
                $totais[$i][2] = \DB::table('turmas')->select(['id','programa','local'])->whereIn('status',['encerrada','iniciada'])->whereYear('data_termino',$i)->whereIn('local',$r->local)->whereMonth('data_termino','>',7)->get();
            }
            else{
                $totais[$i][0] = \DB::table('turmas')->select(['id','programa','local'])->whereIn('status',['encerrada','iniciada'])->whereYear('data_termino',$i)->get();
                $totais[$i][1] = \DB::table('turmas')->select(['id','programa','local'])->whereIn('status',['encerrada','iniciada'])->whereYear('data_termino',$i)->whereMonth('data_termino','<=',7)->get();
                $totais[$i][2] = \DB::table('turmas')->select(['id','programa','local'])->whereIn('status',['encerrada','iniciada'])->whereYear('data_termino',$i)->whereMonth('data_termino','>',7)->get();

            }


                $alunos[$i][1]['totais'] = Array();
                $turmas[$i][1]['totais'] = $totais[$i][1]->pluck('id');
                $inscricoes[$i][1]['totais'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][1]['totais'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][1]['totais'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][1]['totais']))
                        $alunos[$i][1]['totais'][] = $inscricao->pessoa;
                }
                
                $alunos[$i][1]['ce'] = Array();
                $turmas[$i][1]['ce'] = $totais[$i][1]->where('programa',12)->pluck('id');
                $inscricoes[$i][1]['ce'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][1]['ce'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][1]['ce'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][1]['ce']))
                        $alunos[$i][1]['ce'][] = $inscricao->pessoa;
                }

                $alunos[$i][1]['emg'] = Array();
                $turmas[$i][1]['emg'] = $totais[$i][1]->where('programa',4)->pluck('id');
                $inscricoes[$i][1]['emg'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][1]['emg'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][1]['emg'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][1]['emg']))
                        $alunos[$i][1]['emg'][] = $inscricao->pessoa;
                }

                $alunos[$i][1]['pid'] = Array();
                $turmas[$i][1]['pid'] = $totais[$i][1]->where('programa',2)->pluck('id');
                $inscricoes[$i][1]['pid'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][1]['pid'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][1]['pid'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][1]['pid']))
                        $alunos[$i][1]['pid'][] = $inscricao->pessoa;
                }

                $alunos[$i][1]['uati'] = Array();
                $turmas[$i][1]['uati'] = $totais[$i][1]->where('programa',3)->pluck('id');
                $inscricoes[$i][1]['uati'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][1]['uati'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][1]['uati'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][1]['uati']))
                        $alunos[$i][1]['uati'][] = $inscricao->pessoa;
                }

                $alunos[$i][1]['unit'] = Array();
                $turmas[$i][1]['unit'] = $totais[$i][1]->where('programa',1)->pluck('id');
                $inscricoes[$i][1]['unit'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][1]['unit'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][1]['unit'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][1]['unit']))
                        $alunos[$i][1]['unit'][] = $inscricao->pessoa;
                }


                //**********************************2semestre */

                
                
                $alunos[$i][2]['totais'] = Array();
                $turmas[$i][2]['totais'] = $totais[$i][2]->pluck('id');
                $inscricoes[$i][2]['totais'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][2]['totais'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][2]['totais'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][2]['totais']))
                        $alunos[$i][2]['totais'][] = $inscricao->pessoa;
                }

                $alunos[$i][2]['emg'] = Array();
                $turmas[$i][2]['emg'] = $totais[$i][2]->where('programa',4)->pluck('id');
                $inscricoes[$i][2]['emg'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][2]['emg'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][2]['emg'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][2]['emg']))
                        $alunos[$i][2]['emg'][] = $inscricao->pessoa;
                }

                $alunos[$i][2]['ce'] = Array();
                $turmas[$i][2]['ce'] = $totais[$i][2]->where('programa',12)->pluck('id');
                $inscricoes[$i][2]['ce'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][2]['ce'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][2]['ce'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][2]['ce']))
                        $alunos[$i][2]['ce'][] = $inscricao->pessoa;
                }
                
                $alunos[$i][2]['pid'] = Array();
                $turmas[$i][2]['pid'] = $totais[$i][2]->where('programa',2)->pluck('id');
                $inscricoes[$i][2]['pid'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][2]['pid'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][2]['pid'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][2]['pid']))
                        $alunos[$i][2]['pid'][] = $inscricao->pessoa;
                }
                
                $alunos[$i][2]['uati'] = Array();
                $turmas[$i][2]['uati'] = $totais[$i][2]->where('programa',3)->pluck('id');
                $inscricoes[$i][2]['uati'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][2]['uati'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][2]['uati'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][2]['uati']))
                        $alunos[$i][2]['uati'][] = $inscricao->pessoa;
                }

                $alunos[$i][2]['unit'] = Array();
                $turmas[$i][2]['unit'] = $totais[$i][2]->where('programa',1)->pluck('id');
                $inscricoes[$i][2]['unit'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][2]['unit'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][2]['unit'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][2]['unit']))
                        $alunos[$i][2]['unit'][] = $inscricao->pessoa;
                }

                //************** anual */

                $alunos[$i][0]['totais'] = Array();
                $turmas[$i][0]['totais'] = $totais[$i][0]->pluck('id');
                $inscricoes[$i][0]['totais'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][0]['totais'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][0]['totais'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][0]['totais']))
                        $alunos[$i][0]['totais'][] = $inscricao->pessoa;
                }

                $alunos[$i][0]['emg'] = Array();
                $turmas[$i][0]['emg'] = $totais[$i][0]->where('programa',4)->pluck('id');
                $inscricoes[$i][0]['emg'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][0]['emg'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][0]['emg'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][0]['emg']))
                        $alunos[$i][0]['emg'][] = $inscricao->pessoa;
                }

                $alunos[$i][0]['ce'] = Array();
                $turmas[$i][0]['ce'] = $totais[$i][0]->where('programa',12)->pluck('id');
                $inscricoes[$i][0]['ce'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][0]['ce'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][0]['ce'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][0]['ce']))
                        $alunos[$i][0]['ce'][] = $inscricao->pessoa;
                }

                $alunos[$i][0]['pid'] = Array();
                $turmas[$i][0]['pid'] = $totais[$i][0]->where('programa',2)->pluck('id');
                $inscricoes[$i][0]['pid'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][0]['pid'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][0]['pid'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][0]['pid']))
                        $alunos[$i][0]['pid'][] = $inscricao->pessoa;
                }

                $alunos[$i][0]['unit'] = Array();
                $turmas[$i][0]['unit'] = $totais[$i][0]->where('programa',1)->pluck('id');
                $inscricoes[$i][0]['unit'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][0]['unit'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][0]['unit'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][0]['unit']))
                        $alunos[$i][0]['unit'][] = $inscricao->pessoa;
                }

                $alunos[$i][0]['uati'] = Array();
                $turmas[$i][0]['uati'] = $totais[$i][0]->where('programa',3)->pluck('id');
                $inscricoes[$i][0]['uati'] = \DB::table('inscricoes')->select(['pessoa'])->whereIn('turma',$turmas[$i][0]['uati'])->whereIn('status',['regular','pendente','finalizada'])->get();
                foreach($inscricoes[$i][0]['uati'] as $inscricao){
                    if(!in_array($inscricao->pessoa,$alunos[$i][0]['uati']))
                        $alunos[$i][0]['uati'][] = $inscricao->pessoa;
                }
                
           
        }

        //return $alunos;//select(['id','programa','local','data_termino','status'])->

      
        return view('relatorios.alunos')->with('locais',$locais)->with('r',$r)->with('alunos',$alunos);
    }



}
