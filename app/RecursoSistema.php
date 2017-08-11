<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecursoSistema extends Model
{
    //
    protected $table  = 'recursos_sistema';

	public function pessoa(){
		return $this->hasManyThrough('App\Pessoa','App\ControleAcessoRecurso');
	}    
}
