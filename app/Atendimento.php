<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    
    public function getAtendenteAttribute($value){
		$pessoa=Pessoa::where('id',$value)->get(['id','nome'])->first();
		return $pessoa;
	}

	public function getUsuarioAttribute($value){
		$pessoa=Pessoa::where('id',$value)->get(['id','nome'])->first();
		return $pessoa;
	}
}
