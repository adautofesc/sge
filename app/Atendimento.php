<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atendimento extends Model
{
    use SoftDeletes;
    public function getAtendenteAttribute($value){
		$pessoa=Pessoa::where('id',$value)->get(['id','nome'])->first();
		return $pessoa;
	}

	public function getUsuarioAttribute($value){
		$pessoa=Pessoa::where('id',$value)->get(['id','nome'])->first();
		return $pessoa;
	}
}
