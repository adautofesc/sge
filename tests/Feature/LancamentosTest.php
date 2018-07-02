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
     */
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


    }

    
}
