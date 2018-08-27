<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
     public function curso(){
    	return $this->belongsToMany(Curso::Class);
    }
}
