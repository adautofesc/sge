<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
   

    private function getResources(){
        $resources = \App\ControleAcessoRecurso::select('recurso')->where('pessoa', '19511')->get();
        return ["sge_fesc_logged" => "yes",
        "usuario" => 19511,
        "nome_usuario" => "Adauto Jr.",
        "recursos_usuario" => serialize($resources)];
    }
    public function testLogin()
    {
       
        /*
        $response = $this->call('POST', 'authenticate', [
            'username' => 'carparts',
            'email' => 'admin@admin.com',
            'password' => 'password'
        ]);

        $token = 'Bearer ' . json_decode($response->getContent())->token;
        */

        //$response = $this->call('GET','login', [], [], []);
        //$response = $this->followingRedirects()->get('http://sge.localhost/secretaria/pre-atendimento');
        //$response = $this->get('http://sge.localhost/secretaria/pre-atendimento');
        
        /*
        $response = $this->withSession($this->getResources())
                         ->get('http://sge.localhost/secretaria/pre-atendimento');
        //dd($response);
        $response->assertStatus(200);
        */
        //dd($this->get('http://sge.localhost/login'));
        $this->get('http://sge.localhost/login')->assertStatus(200);


        
        //die('Semana:'.$data);
       // $this->assertTrue(True);
    }
    public function testEsqueciSenha(){
        $this->get('http://sge.localhost/esqueciasenha')->assertStatus(200);

    }
}