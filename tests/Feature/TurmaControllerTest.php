<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Turma;

class TurmaControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVerificarQuantidadeDeMatriculados(){
    	$erros =0;
    	$divergentes = ' ';
    	$turmas = Turma::all();
    	foreach($turmas as $turma){
    		$inscritos = \App\Inscricao::where('turma',$turma->id)->whereIn('status',['regular','pendente'])->get();
    		if(count($inscritos)!=$turma->matriculados){
    			$erros++;
    			$divergentes = $divergentes .'Turma  '.$turma->id.' tem '.count($inscritos).' consta '.$turma->matriculados."\n";
    		}

    	}
    	$this->assertEquals(0,$erros,$divergentes);	
    }

    public function testVerificaSeTodasTurmasTemCargaHoraria(){
    	$resultado = '';
    	$turmas = Turma::whereIn('carga',[null,'0',''])->get();
    	//dd(count($turmas));
    	foreach($turmas as $turma){
    		$resultado = $resultado.'Turma '.$turma->id.' não possui carga definida.'."\n";
    	}
    	$this->assertCount(0,$turmas,$resultado);	
    }
}
