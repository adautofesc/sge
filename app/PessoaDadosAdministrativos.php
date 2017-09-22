<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaDadosAdministrativos extends Model
{
    //
	protected $table  = 'pessoas_dados_administrativos';

    public function pessoa(){
		return $this->belongsTo('App\Pessoa');
	}
	public function dado(){
		return $this->hasOne('App\TipoDado');
	}

	public static function getFuncionarios($categoria=''){
		if($categoria=='')
			$funcionarios_ri=PessoaDadosAdministrativos::where('dado',16)->get();
		else
			$funcionarios_ri=PessoaDadosAdministrativos::where('dado',16)->where('valor', $categoria)->get();

		$funcionarios=collect();
		foreach($funcionarios_ri as $dado){
			$pessoa = Pessoa::find($dado->pessoa);
			$funcionarios->push($pessoa);
		}

		return $funcionarios;
	}

}
