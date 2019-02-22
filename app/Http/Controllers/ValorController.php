<?php

/*
update turmas set carga=100 where valor = 550 and programa in('1','2') and carga is null;
update turmas set carga=80 where valor = 440 and programa in('1','2') and  carga is null;
update turmas set carga=60 where valor = 330 and programa in('1','2') and  carga is null;
update turmas set carga=40 where valor = 220 and programa in('1','2') and  carga is null;
update turmas set carga=60 where valor = 660 and programa in('12') and  carga is null;
update turmas set carga=40 where valor = 440 and programa in('12') and  carga is null;
update turmas set carga=30 where valor = 330 and programa in('12') and  carga is null;
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valor;
use App\Matricula;
ini_set('max_execution_time', 180);
class ValorController extends Controller
{
    //
    public static function valorMatricula($id_matricula)
    {

    	$matricula = Matricula::find($id_matricula);


    	if($matricula)
    	{
            if($matricula->curso == null){
                \App\Http\Controllers\MatriculaController::matriculaSemCurso($matricula);

            }
            $inscricao_t = \App\Inscricao::where('matricula',$matricula->id)->first();

            if($inscricao_t == null){
                return ValorController::retornarZero('Não há inscrições ativas');
            }
            $turma = \App\Turma::find($inscricao_t->turma->id);

            //dd($turma->parceria->id);
            $fesc=[84,85,86];
            if(!in_array($turma->local->id,$fesc)){
                 return ValorController::retornarZero('Turma fora da fesc');

            }
            if(isset($turma->parceria))
                return ValorController::retornarZero('Parcerias/Ação Social');

            if($turma->programa->id == 4)
                return ValorController::retornarZero('Escola Municipal de Governo');




    		if($matricula->curso == 307)
    		{
    			$inscricoes = \App\Inscricao::where('matricula',$matricula->id)->whereIn('status',['regular','pendente'])->get();
    			switch (count($inscricoes)) {
    				case 0:
                         return ValorController::retornarZero('Não há inscrições ativas');
                        break;
                    case 1:
                    	$valor = Valor::where('curso','307')->where('carga','1')->where('ano',substr($inscricoes->first()->turma->data_inicio,-4))->first();
                        return $valor; 
                        //return $this->gerar($valor->valor/$valor->parcelas, qnde de parcelas,
                        break;
                    case 2:
                    case 3:
                    
                        $valor = Valor::where('curso','307')->where('carga','2')->where('ano',substr($inscricoes->first()->turma->data_inicio,-4))->first();
                        return $valor;
                        break;
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                        $valor = Valor::where('curso','307')->where('carga','3')->where('ano',substr($inscricoes->first()->turma->data_inicio,-4))->first();
                        return $valor;
                        break;
    			}
    			

    		}
    		else
    		{

    			//pega a primeira inscricao da matricula
    			$inscricao = \App\Inscricao::where('matricula',$matricula->id)->first();
                if(!$inscricao){
                    return ValorController::retornarZero('Não há inscrições ativas');
                }
                else

                    $turma= \App\Turma::find($inscricao->turma->id);
                    if($turma->valor>0){
                        $valor = new Valor;
                        $valor->valor = $turma->valor;
                        switch($turma->periodicidade){
                            case 'mensal' :
                                $valor->parcelas = 1;
                                break;
                            case 'bimestral' :
                                $valor->parcelas = 2;
                                break;
                            case 'trimestral' :
                                $valor->parcelas = 3;
                                break;
                            case 'semestral' :
                                $valor->parcelas = 5;
                                break;
                            case 'anual' :
                                $valor->parcelas = 11;
                                break;
                            case 'eventual' :
                                $valor->parcelas = 1;
                                break;
                            default :
                                $valor->parcelas = 5;
                                break;
                        }
                        
                        $valor->referencia = 'parcelas temporaria';
                        return $valor;
                    }
                

               


                
                if(isset($valor))
                    return $valor;//number_format($valor->valor,2,',','.');
                else

                    throw new \Exception("Erro ao acessar valor da turma:".$inscricao->turma->id.' Matrricula:'.$matricula->id, 1);
                    
                    /*$valor = new Valor;
                        $valor->valor = 0;
                        $valor->parcelas = 1;
                        $valor->referencia = 'Valor não disponível no tabela de valores.';
                        return $valor;*/
                     
                    
                    
                

    			//pegar programa e  carga horária
    			//listar se existe algum valor com programa e curso
    				//se sim retornar o valor
    				//se não verificar programa e carga horária
    		}
    	}

    }
    public static function retornarZero($msg='Valor não disponível no tabela de valores.'){
        $valor = new Valor;
        $valor->valor = 0;
        $valor->parcelas = 1;
        $valor->referencia = $msg;
        return $valor;

    }

    public function gerar($valor,$parcelas,$referencia='gerado por alguma função'){
        $valor = new Valor;
        $valor->valor = $valor;
        $valor->parcelas = $parcelas;
        $valor->referencia = $referencia;
        return $valor;

    }
}
