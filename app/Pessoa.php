<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
	public function dadosAcademicos(){
		return $this->hasMany('App\PessoaDadosAcademicos');
	}
	public function dadosAdministrativos(){
		return $this->hasMany('App\PessoaDadosAdministrativos');
	}
	public function dadosContato(){
		return $this->hasMany('App\PessoaDadosContato');
	}
	public function dadosClinicos(){
		return $this->hasMany('App\PessoaDadosClinicos');
	}
	public function dadosFinanceiros(){
		return $this->hasMany('App\PessoaDadosFinanceiros');
	}
	public function dadosGerais(){
		return $this->hasMany('App\PessoaDadosGerais');
	}

}
