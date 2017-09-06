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
}
