<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaDadosClinicos extends Model
{
    //
    protected $table  = 'pessoas_dados_clinicos';
    public function pessoa(){
		return $this->belongsTo('App\Pessoa');
	}
	public function dado(){
		return $this->hasOne('App\TipoDado');
	}
}
