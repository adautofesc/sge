<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurmaDados extends Model
{
    public function turma(){
    	return $this->belongsToOne(Turma::Class);
    }
}
