<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    //Curso -m -c --resource
	protected $appends=['requisitos'];

    public function disciplina(){
		return $this->hasManyThrough(Disciplina::class, Grade::class);
	}
	public function grade(){
		return $this->belongsToMany('App\Grade');

	}
	 public function requisito(){
		return $this->hasManyThrough(Requisito::class, CursoRequisito::class);
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

	public function getRequisitosAttribute($value){
		
		$lista_requisitos=CursoRequisito::where('curso', $this->id)->get();
		
		return $lista_requisitos;

		
	}
}
