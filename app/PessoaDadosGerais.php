<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaDadosGerais extends Model
{
    //
    protected $table  = 'pessoas_dados_gerais';

    public function pessoa(){
		return $this->belongsTo('App\Pessoa');
	}
	public function dado(){
		return $this->hasOne('App\TipoDado');
	}
}
