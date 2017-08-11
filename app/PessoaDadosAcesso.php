<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaDadosAcesso extends Model
{
    // Classe de controle de Login
    protected $table  = 'pessoas_dados_acesso';

    public function pessoa(){
    	return $this->belongsTo('App\Pessoa','pessoa'); // (Pessoa::class)
    }
}
