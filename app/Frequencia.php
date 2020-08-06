<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

class Frequencia extends Model
{
    use SoftDeletes;

    /**
     * Função que retorna o saldo de frequencia do aluno em determinada turma
     */
    public static function getSaldo(int $turma, int $aluno){
        $aulas = Aula::where('turma',$turma)->where('status','executada')->orderBy('data')->get();
        $presencas = Frequencia::join('aulas','frequencias.aula','aulas.id')->where('turma',$turma)->get();
        $justificativas = JustificativaAusencia::where('pessoa',$aluno)->where('inicio','>=',$aulas->first()->data)->get();
        
        $saldo = new stdClass;
        $saldo->aulas = $aulas->count();
        $saldo->presencas = array();
        $saldo->faltas = array();
        $saldo->evadido = '';
        $saldo->faltas_justificadas = array();
        
        foreach($aulas as $aula){
            $justificativa = $justificativas->filter(function($item) use($aula){
                //dd(data_get($item, 'inicio'));
                $data_inicio = new \DateTime(data_get($item, 'inicio').' 00:00:01');
                $data_termino = new \DateTime(data_get($item, 'termino').' 23:59:59');
                return ($data_inicio <= $aula->data && $data_termino >= $aula->data);
                
            });
            
            $presenca = $presencas->where('aluno',$aluno)
                                  ->where('aula',$aula->id)
                                  ->first();                   
            if(is_null($presenca)){                     
                $saldo->faltas[] = $aula->data;
                if($justificativa->count()==0)
                    $faltas_seguidas[] = $aula->data;
                else
                    $saldo->faltas_justificadas[] = $aula->data;
                if(count($faltas_seguidas) == 4) 
                    $saldo->evadido = 'teste';
           
            } else {
                $faltas_seguidas[] = array();
                $saldo->presencas[] = $aula->data;

            }
        }
        $saldo->percentual = ceil(count($saldo->presencas)*100/$aulas->count());
        //dd($saldo);
        return $saldo;

    }

    /**
     * Controle de Frequencia retorna os alunos possivelmente evadidos com mais de 4 faltas seguidas
     */
    public static function controleFrequencia(){
        $turmas = Turma::select('id')->whereIn('status',['iniciada','andamento'])->get();
        foreach($turmas as $turmas){
            $inscricoes = $turma->getInscricoes();
            foreach($inscricoes as $inscricao){
               $saldo = getSaldo($turma->id,$inscricao->aluno) ;
               if($saldo->aulas >5 && $saldo->percentual < 75){
                   //notificar aluno que ele já obteve menos de 75% de presença massss registrar contato pra ele não mandar mais de uma vez essa mensagem
               }
                   
                

            }
                
            
        }
    }

    public static function novaFrequencia(int $aula, int $aluno){
        $frequencia =  new Frequencia;
        $frequencia->aula = $aula;
        $frequencia->aluno = $aluno;
        $frequencia->save();
        return $frequencia;
    }

    public static function removeFrequencia(int $aula, int $aluno){
        $frequencia = Frequencia::where('aula',$aula)->where('aluno',$aluno)->first();
        if(isset($frequencia->id)){
            $frequencia->delete();
        }     
    }
}
