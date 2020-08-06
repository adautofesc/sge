<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route; 
use App\User;


class ViewsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $admin;
    
   

    /**
     * test all route
     *
     * @group route
     */

    public function testAllRoute()
    {
        $user = User::find(2);

        $routeCollection = Route::getRoutes();
        $this->withoutEvents();
        $blacklist = [
            'url/that/not/tested',
        ];
        $dynamicReg = "/{\\S*}/"; //used for omitting dynamic urls that have {} in uri (http://laravel-tricks.com/tricks/adding-a-sitemap-to-your-laravel-application#comment-1830836789)
        $this->be($user);
        foreach ($routeCollection as $route) {
            if (!preg_match($dynamicReg, $route->uri()) &&
                in_array('GET', $route->methods()) && 
                !in_array($route->uri(), $blacklist)
            ) {
                $start = $this->microtimeFloat();
                fwrite(STDERR, print_r('test ' . $route->uri() . "\n", true));
                $response = $this->call('GET', $route->uri());
                $end   = $this->microtimeFloat();
                $temps = round($end - $start, 3);
                fwrite(STDERR, print_r('time: ' . $temps . "\n", true));
                $this->assertLessThan(15, $temps, "too long time for " . $route->uri());
                $this->assertEquals(200, $response->getStatusCode(), $route->uri() . "failed to load");

            }

        }
    }

    public function microtimeFloat()
    {
        list($usec, $asec) = explode(" ", microtime());

        return ((float) $usec + (float) $asec);

    }

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
 
}