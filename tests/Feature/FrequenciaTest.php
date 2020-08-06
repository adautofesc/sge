<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Frequencia;

class FrequenciaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
       $saldo =  Frequencia::getSaldo(959,1234);
        $this->assertObjectHasAttribute('presencass', $saldo);
        
    }
}
