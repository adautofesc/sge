<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LancamentosTest extends TestCase
{
    /**
     * Teste para verificar se existe algum lançamento duplicado
     * @return [type] [description]
     
    public function testLancamentoDuplicados(){
    	$erros = 0;
    	$erro_str='';
    	$lancamentos = Lancamento::where('status',null)->get();
    	foreach($lancamentos as $lancamento){
    		$duplicado = Lancamento::where('matricula',$lancamento->matricula)->where('parcela',$lancamento->parcela)->where('status', null)->get();
    		if(count($duplicado)>1){
    			$erros++;
    			$erro_str=$erro_str.'Matricula '.$lancamento->matricula.' possui '.count($duplicado).' duplicidades na parcela '.$lancamento->parcela."\n"; 

    		}

    	}
    	$this->assertEquals(0,$erros,$erro_str);


    }*/

    /**
     * Pega alguns números de matriculas e verifica como foram lançamentos
     * @return [type] [description]
     */
    public function testValorLancamentosPorAmostra(){
        
        $erros = 0;
        $erro_str='';

        //lista de cursos e status que serão testados
        $cursos = array('307','898','1151','1432','1042'); //uati, hidro, natação, tecnologias, smartphone, corte/costura
        $status = array('ativa','pendente','espera');
        // nº de disciplinas realizado com for.
        // 
        foreach($cursos as $curso){
            foreach($status as $estado){
                for($i=1;$i<6;$i++){
                    $valor=0;

                    //*******************************
                    //sem bolsa
                    //*******************************
                    $matricula = \App\Matricula::leftjoin('inscricoes','matriculas.id', '=','inscricoes.matricula' )
                        ->selectRaw('matriculas.*, count(inscricoes.id) as numero_inscricoes')
                        ->where('matriculas.curso',$curso)
                        ->where('matriculas.status','ativa')
                        ->where('inscricoes.status','regular')
                        ->groupBy('matriculas.id')
                        ->havingRaw('count(inscricoes.id) = ?',[$i])
                        ->inRandomOrder()
                        ->first();
                    if($matricula){
                        $amostra = \App\Lancamento::where('matricula', $matricula->id)->orderbyDesc('parcela')->first();
                        $inscricao = \App\Inscricao::where('matricula',$matricula->id)->first();
                    }
                    if($inscricao)
                        $turma = \App\Turma::find($inscricao->turma->id);

                   

                    if($curso == 307){   
                        if($i==1)
                            $valor = 100;
                        if($i>1 && $i<5)
                            $valor = 250;
                        if($i>5)
                            $valor = 400;
                    }
                    else{
                        $valor = str_replace(',', '.',$turma->valor ); 
                    }

                    if($curso == 898 || $curso == 1151)
                        $parcelas = 11;
                    else
                        $parcelas = 5;


                    if($amostra){
                        if($amostra->parcela > $parcelas || abs($amostra->valor - $valor/$parcelas) != 00){
                        $erros++;
                        $erro_str = $erro_str . 'Lançamento '.$amostra->id.' da pessoa '.$amostra->pessoa. ': Parcelas: '.$amostra->parcela.'/'.$parcelas .' Valor:'.$amostra->valor.'/'.$valor/$parcelas.'-'.$curso."\n";
                        }
                    }
                    
                    
                    //******************************
                    //com bolsa
                    //******************************
                    
                    $matricula = \App\Matricula::leftjoin('inscricoes','matriculas.id', '=','inscricoes.matricula' )
                        ->selectRaw('matriculas.*, count(inscricoes.id) as numero_inscricoes')
                        ->where('matriculas.curso',$curso)
                        ->where('matriculas.status','ativa')
                        ->where('inscricoes.status','regular')
                        ->where('matriculas.desconto','>',0)
                        ->groupBy('matriculas.id')
                        ->havingRaw('count(inscricoes.id) = ?',[$i])
                        ->inRandomOrder()
                        ->first();
                    if($matricula){
                        $amostra = \App\Lancamento::where('matricula', $matricula->id)->orderbyDesc('parcela')->first();
                        $inscricao = \App\Inscricao::where('matricula', $matricula->id)->first();
                    }
                    if($inscricao)
                        $turma = \App\Turma::find($inscricao->turma->id);

                    

                    if($curso == 307){   
                        if($i==1)
                            $valor = 100  - $matricula->valor_desconto;
                        if($i>1 && $i<5)
                            $valor = 250 - $matricula->valor_desconto;
                        if($i>5)
                            $valor = 400 - $matricula->valor_desconto;
                    }
                    else{
                        $valor = str_replace(',', '.',$turma->valor );
                    }

                    if($curso == 898 || $curso == 1151)
                        $parcelas = 11;
                    else
                        $parcelas = 5;

                    if($amostra){
                        if($amostra->parcela > $parcelas || abs($amostra->valor - ($valor/$parcelas)) != 00){
                        $erros++;
                        $erro_str = $erro_str . 'Lançamento '.$amostra->id.' da pessoa '.$amostra->pessoa. ': Parcelas: '.$amostra->parcela.'/'.$parcelas .' Valor:'.$amostra->valor.'/'.$valor.'-'.$turma->valor_desconto.'-'.$parcelas."\n";
                        }
                    }
                }// end for
            }// end foreach status
        }// end foreach cursos

       
        $this->assertEquals(0,$erros,$erro_str);

    }

    
}
