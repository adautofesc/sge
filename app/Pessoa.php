<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\classes\Strings;

class Pessoa extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
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
			case 'M':
				return "o";
				break;
			case 'F':
				return "a";
				break;
			case 'X':
				return "o";
				break;
			case 'Y':
				return "a";
				break;
			case 'Z':
				return "o(a)";
				break;
			
			default:
				return "o(a)";
				break;
		}
	}

	public static function cabecalho($id)
	{
		$pessoa= Pessoa::find($id);
		$pessoa=\App\Http\Controllers\PessoaController::formataParaMostrar($pessoa);
		if(isset($pessoa->telefone))
			$pessoa->telefone=\App\classes\Strings::formataTelefone($pessoa->telefone);
		if(isset($pessoa->telefone_alternativo))
			$pessoa->telefone_alternativo=\App\classes\Strings::formataTelefone($pessoa->telefone_alternativo);
		if(isset($pessoa->telefone_contato))
			$pessoa->telefone_contato=\App\classes\Strings::formataTelefone($pessoa->telefone_contato);

		return $pessoa;
	}

}
