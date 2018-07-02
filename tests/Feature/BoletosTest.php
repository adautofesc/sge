<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Boleto;
use App\Lancamento;

class BoletosTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVerificaBoletosSemParcelasAtivas()
    {
    	$boletos = Boleto::where('status','emitido')->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();
    	$boletos_indevidos = '';
    	$erros =0;

		foreach($boletos as $boleto){

			$lancamentos =  Lancamento::where('boleto',$boleto->id)->where('status','cancelado')->get();
			if(count($lancamentos)>0){
				$boletos_indevidos = $boletos_indevidos.'Boleto '.$boleto->id.' está ativo com parcela cancelada'."\n";
				$erros ++;
			}

		}
		if($boletos_indevidos == '')			
        	$this->assertTrue(true);
        else
        	$this->assertEquals(0,$erros,$boletos_indevidos);

    }

    






}
