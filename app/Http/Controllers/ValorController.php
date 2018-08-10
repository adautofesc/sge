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
                $matricula->status = 'cancelada';
                $matricula->obs = 'Cancelada automaticamente por falta de inscrições.';
                $matricula->save();
                $valor = new Valor;
                $valor->valor = 0;
                $valor->parcelas = 1;
                $valor->referencia = 'Sem inscrição.';
                return $valor;
            }
            $turma = \App\Turma::find($inscricao_t->turma->id);
            $fesc=[84,85,86];
            if(!in_array($turma->local->id,$fesc)){
                $valor = new Valor;
                $valor->valor = 0;
                $valor->parcelas = 1;
                $valor->referencia = 'Parceria.';
                return $valor;

            }

    		if($matricula->curso == 307)
    		{
    			$inscricoes = \App\Inscricao::where('matricula',$matricula->id)->whereIn('status',['regular','pendente'])->get();
    			switch (count($inscricoes)) {
    				case 0:
                        $valor = new Valor;
                        $valor->valor = 0;
                        $valor->parcelas = 1;
                        $valor->referencia = ' Nenhuma disciplina regular.';
                        return $valor;
                        break;
                    case 1:
                    	$valor = Valor::find(5);
                        return $valor;
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $valor = Valor::find(6);
                        return $valor;
                        break;
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                        $valor = Valor::find(7);
                        return $valor;
                        break;
    			}
    			

    		}
    		else
    		{

    			//pega a primeira inscricao da matricula
    			$inscricao = \App\Inscricao::where('matricula',$matricula->id)->first();
                if(!$inscricao){
                    $valor = new Valor;
                        $valor->valor = 0;
                        $valor->parcelas = 1;
                        $valor->referencia = 'Valor não disponível no tabela de valores.';
                        return $valor;
                }




                $valor= Valor::where('programa',$inscricao->turma->programa->id)->where('carga',$inscricao->turma->carga)->where('curso',$inscricao->turma->curso->id)->first();

                if($valor)
                {
                    return $valor;//number_format($valor->valor,2,',','.'); 
                }
                else
                {


                    $valor= Valor::where('programa',$inscricao->turma->programa->id)->where('carga',$inscricao->turma->carga)->first();
                


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
}
