<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\classes\Strings;

class Pessoa extends Model
{
	public function dadosAcesso(){
		return $this->hasOne('App\PessoaDadosAcesso','pessoa');
	}
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
	public static function getNome($id)
	{		
		$query=Pessoa::find($id);
		if($query)
			$nome=Strings::converteNomeParaUsuario($query->nome);
		else
			$nome="Impossível encontrar o nome dessa pessoa";

		return $nome;
	}
}
