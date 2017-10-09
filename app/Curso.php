<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    //Curso -m -c --resource
    public function disciplina(){
		return $this->hasManyThrough(Disciplinas::class, Grade::class);
	}
	public function grade(){
		return $this->belongsToMany('App\Grade');

	}
	public function getProgramaAttribute($value){
		return Programa::find($value);
	}
	public function setValorAttribute($value){
		$this->attributes['valor'] = str_replace(',', '.', $value);
	}
	public function getValorAttribute($value){
		return number_format($value,2,',','.');
	}
}
