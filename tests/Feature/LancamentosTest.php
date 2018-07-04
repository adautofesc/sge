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

        //Amostra 1: matrícula ativa UATI 1 disciplina
        $matricula1 = \App\Matricula::leftjoin('inscricoes','matriculas.id', '=','inscricoes.matricula' )
                        ->selectRaw('matriculas.*, count(inscricoes.id) as numero_inscricoes')
                        ->where('matriculas.curso',307)
                        ->where('matriculas.status','ativa')
                        ->where('inscricoes.status','regular')
                        ->groupBy('matriculas.id')
                        ->havingRaw('count(inscricoes.id) = ?',[1])
                        ->inRandomOrder()
                        ->first();
        $amostra1 = \App\Lancamento::where('matricula', $matricula1->id)->orderbyDesc('parcela')->first();
        if($amostra1->parcela >5 || abs($amostra1->valor - 20.00) != 00){
            $erros++;
            $erro_str = $erro_str . 'Lançamento '.$amostra1->id.' da pessoa '.$amostra1->pessoa. ': Parcelas: '.$amostra1->parcela.'/5 Valor:'.$amostra1->valor.'/20'."\n";
        }

        //Amostra 2: matrícula ativa UATI 2 disciplina
        $matricula2 = \App\Matricula::leftjoin('inscricoes','matriculas.id', '=','inscricoes.matricula' )
                        ->selectRaw('matriculas.*, count(inscricoes.id) as numero_inscricoes')
                        ->where('matriculas.curso',307)
                        ->where('matriculas.status','ativa')
                        ->where('inscricoes.status','regular')
                        ->groupBy('matriculas.id')
                        ->havingRaw('count(inscricoes.id) = ?',[2])
                        ->inRandomOrder()
                        ->first();
        $amostra2 = \App\Lancamento::where('matricula', $matricula2->id)->orderbyDesc('parcela')->first();
        if($amostra2->parcela >5 || abs($amostra2->valor - 50.00) != 00){
            $erros++;
            $erro_str = $erro_str . 'Lançamento '.$amostra2->id.' da pessoa '.$amostra2->pessoa. ': Parcelas: '.$amostra2->parcela.'/5 Valor:'.$amostra2->valor.'/50'."\n";
        }


        

        //Amostra 3: matrícula ativa UATI 3 disciplinas
        $matricula3 = \App\Matricula::leftjoin('inscricoes','matriculas.id', '=','inscricoes.matricula' )
                        ->selectRaw('matriculas.*, count(inscricoes.id) as numero_inscricoes')
                        ->where('matriculas.curso',307)
                        ->where('matriculas.status','ativa')
                        ->where('inscricoes.status','regular')
                        ->groupBy('matriculas.id')
                        ->havingRaw('count(inscricoes.id) = ?',[3])
                        ->inRandomOrder()
                        ->first();
        $amostra3 = \App\Lancamento::where('matricula', $matricula3->id)->orderbyDesc('parcela')->first();
        if($amostra3->parcela >5 || abs($amostra3->valor - 50.00) != 00){
            $erros++;
            $erro_str = $erro_str . 'Lançamento '.$amostra3->id.' da pessoa '.$amostra3->pessoa. ': Parcelas: '.$amostra3->parcela.'/5 Valor:'.$amostra3->valor.'/50'."\n";
        }


        //Amostra 4: matrícula ativa UATI 5 disciplinas
        $matricula4 = \App\Matricula::leftjoin('inscricoes','matriculas.id', '=','inscricoes.matricula' )
                        ->selectRaw('matriculas.*, count(inscricoes.id) as numero_inscricoes')
                        ->where('matriculas.curso',307)
                        ->where('matriculas.status','ativa')
                        ->where('inscricoes.status','regular')
                        ->groupBy('matriculas.id')
                        ->havingRaw('count(inscricoes.id) = ?',[5])
                        ->inRandomOrder()
                        ->first();
        $amostra4 = \App\Lancamento::where('matricula', $matricula4->id)->orderbyDesc('parcela')->first();
        if($amostra4->parcela >5 || abs($amostra4->valor - 80.00) != 00){
            $erros++;
            $erro_str = $erro_str . 'Lançamento '.$amostra4->id.' da pessoa '.$amostra4->pessoa. ': Parcelas: '.$amostra4->parcela.'/5 Valor:'.$amostra2->valor.'/80'."\n";
        }

        //Amostra 5: matrícula pendente UATI 1 disciplina
        $matricula5 = \App\Matricula::leftjoin('inscricoes','matriculas.id', '=','inscricoes.matricula' )
                        ->selectRaw('matriculas.*, count(inscricoes.id) as numero_inscricoes')
                        ->where('matriculas.curso',307)
                        ->where('matriculas.status','pendente')
                        ->where('inscricoes.status','regular')
                        ->groupBy('matriculas.id')
                        ->havingRaw('count(inscricoes.id) = ?',[1])
                        ->inRandomOrder()
                        ->first();
        $amostra5 = \App\Lancamento::where('matricula', $matricula5->id)->orderbyDesc('parcela')->first();
        if($amostra5->parcela >5 || abs($amostra5->valor - 20.00) != 00){
            $erros++;
            $erro_str = $erro_str . 'Lançamento '.$amostra5->id.' da pessoa '.$amostra5->pessoa. ': Parcelas: '.$amostra5->parcela.'/5 Valor:'.$amostra5->valor.'/20'."\n";
        }
       
        //Amostra 6: matrícula ativa UATI BOLSISTA
        
      
        //Amostra 7: matrícula espera UATI 1 disciplina
    
        //Amostra 8: matrícula ativa PID
        
        //Amostra 9: matrícula ativa PID Com Bolsa
        
        //Amostra 10: matrícula PID em espera
        
        //Amostra 11: matrícula PID em espera Com bolsa
        
        //Amostra 12: matrícula ativa CE
        
        //Amostra 13: matrícula ativa CE Com Bolsa
        
        //Amostra 14: matrícula CE em espera
        
        //Amostra 15: matrícula CE em espera Com bolsa
       
        $this->assertEquals(0,$erros,$erro_str);

    }

    
}
