<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Inscricao;

class Matricula extends Model
{
    //
    //protected $appends=['inscricoes'];

    public function getInscricoesAttribute($value){

		$inscricoes=Inscricao::where('matricula',$this->id)->get();
		return $inscricoes;


	}
	 public function getInscricoes(){
		$inscricoes=Inscricao::where('matricula',$this->id)->get();
		$this->inscricoes = $inscricoes;
		return $inscricoes;
	}

}
