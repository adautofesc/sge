<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    public $timestamps = false;
	protected $dates = ['inicio','termino'];

    public function setDiasSemanaAttribute($value){
		$this->attributes['dias_semana']= implode(',',$value);
	}
	public function getDiasSemanaAttribute($value){
		return explode(',',$value);
	}

	public function getLocal()
	{
		$sala = \App\Sala::find($this->sala);
		$local = \App\Local::find($sala->local);

		return $local;

	}
	public function getPessoa(){

		$pessoa = \App\Pessoa::withTrashed()->find($this->pessoa);
		return $pessoa;
	}

	public function getHoraInicioAttribute($value){	
		return substr($value,0,5);
	}
	public function getHoraTerminoAttribute($value){	
		return substr($value,0,5);
	}
}
