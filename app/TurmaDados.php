<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurmaDados extends Model
{
    public $timestamps = false;
    protected $fillable =['turma','dado','valor'];
    
    public function turma(){
    	return $this->belongsToOne(Turma::Class);
    }
}
