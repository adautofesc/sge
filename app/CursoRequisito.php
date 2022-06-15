<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursoRequisito extends Model
{
    //
    public $timestamps = false;
    protected $table  = 'cursos_requisitos';

    public function curso(){
    	return $this->belongsTo('App\Curso','curso');
    }
    public function requisito(){
    	return $this->hasMany('App\Requisitos','requisito');
    }
	public function getRequisitoAttribute($value){
		$requisito=Requisito::find($value);
		return $requisito;
	}
}
