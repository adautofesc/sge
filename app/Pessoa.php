<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\classes\Strings;

class Pessoa extends Model
{
	protected $appends=['nome_simples'];

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
	public function getNomeAttribute($value){

		return Strings::converteNomeParaUsuario($value);

	}
	public function getNomeSimplesAttribute($value){

		$nome=$this->nome;
		$nome=explode(' ',$nome);
		$nome_simples = $nome[0].' '.$nome[count($nome)-1];
		return $nome_simples;


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
	public static function getArtigoGenero($a)
	{
		switch ($a) {
			case 'h':
				return "o";
				break;
			case 'm':
				return "a";
				break;
			case 'x':
				return "o";
				break;
			case 'y':
				return "a";
				break;
			case 'z':
				return "o(a)";
				break;
			
			default:
				return "o(a)";
				break;
		}
	}

}
