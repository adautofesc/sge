<?php

use Illuminate\Database\Seeder;

class Start extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $pessoa=[
        	'nome'=>'ADAUTO INOCÊNCIO DE OLIVEIRA JUNIOR',
        	'genero'=>'h',
        	'nascimento'=>'1984-11-10',
        	'por'=>1
        ];

        $acesso=[
        	'pessoa'=>1 ,
        	'usuario'=>'adauto',
        	'senha'=>'$10$alGr/nmcPEXYx53/tWSMy.W/ISr4Aw8eRlsUUjxO3OQwFnelQ07O.',
        	'validade'=>'2019-12-31',
        	'status'=>'1'
        ];

        $recurso=array ([
        	'pessoa'=>1,
        	'recurso'=>1
        ]);

        $tipos_dados=array([
        	'id'=>1
        ];
        $bairros=[
        ];

    }
}
