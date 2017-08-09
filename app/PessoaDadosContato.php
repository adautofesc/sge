<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaDadosContato extends Model
{
    //
    protected $table  = 'pessoas_dados_contato';

    public function pessoa(){
    	return $this->hasOne('App\Pessoa','pessoa'); // (Pessoa::class)
    }
    public function dado(){
    	return $this->hasOne('App\TipoDado','dado'); // (Pessoa::class)
    }
}