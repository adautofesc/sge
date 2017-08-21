<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
	public function dadosAcademicos(){
		return $this->hasMany('App\PessoaDadosAcademicos','pessoa');
	}
	public function dadosAdministrativos(){
		return $this->hasMany('App\PessoaDadosAdministrativos','pessoa');
	}
	public function dadosContato(){
		return $this->hasMany('App\PessoaDadosContato','pessoa');
	}
	public function dadosClinicos(){
		return $this->hasMany('App\PessoaDadosClinicos','pessoa');
	}
	public function dadosFinanceiros(){
		return $this->hasMany('App\PessoaDadosFinanceiros','pessoa');
	}
	public function dadosGerais(){
		return $this->hasMany('App\PessoaDadosGerais','pessoa');
	}

}
