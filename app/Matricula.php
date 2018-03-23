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
	 public static function inscricoes($matricula){
		$inscricoes=Inscricao::where('matricula',$matricula)->get();
		return $inscricoes;


	}

}
