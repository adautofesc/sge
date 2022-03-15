<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    public $timestamps = false;

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
}
