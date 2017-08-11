<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaDadosAdministrativos extends Model
{
    //
    public function pessoa(){
		return $this->belongsTo('App\Pessoa');
	}
	public function dado(){
		return $this->hasOne('App\TipoDado');
	}
}
