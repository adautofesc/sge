<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
	public function grade(){
    	return $this->belongsToMany('App\Grade');
    }

    public function getProgramaAttribute($value){
    	return Programa::find($value);
    }

}
