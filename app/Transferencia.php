<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Transferencia extends Model
{
    //use SoftDeletes;
    public $timestamps = false;

    public function matricula(){
    	return $this->hasOne('App\Matricula');
    }

    public function anterior(){
    	return $this->hasOne('App\Inscricao');
    }

    public function nova(){
    	return $this->hasOne('App\Inscricao');
    }

    public function responsavel(){
    	return $this->hasOne('App\Pessoa');
    }
     public function getAnterior(){
        $this->anterior = \App\Inscricao::find($this->anterior);
        
     }
     public function getNova(){
        $this->nova = \App\Inscricao::find($this->nova);
        
     }
     public function getMatricula(){
        $this->matricula = \App\Matricula::find($this->matricula);
     }
     public function getPessoa(){
        $this->getMatricula();
        $matricula = $this->matricula;
        $pessoa = $matricula->pessoa;
        return \App\Pessoa::find($pessoa);
     }

}
