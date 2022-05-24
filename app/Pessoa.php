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
		$query=Pessoa::withTrashed()->find($id);
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
	public function getCelular(){
		$telefones = $this->getTelefones();
		//dd($telefones);
		foreach($telefones as $telefone){
			//dd($telefone->valor);
			$telefone->valor = preg_replace( '/[^0-9]/is', '', $telefone->valor);
			if(substr($telefone->valor, 0,1)=='9' || substr($telefone->valor, 2,1)=='9' || substr($telefone->valor, 0,1)=='8' || substr($telefone->valor, 2,1)=='8' ){
				switch(strlen($telefone->valor)){
					case 8:
						return '169'.$telefone->valor;
						break;
					case 9:
						return '16'.$telefone->valor;
						break;
					case 10:
						return substr($telefone->valor, 0,2).'9'.substr($telefone->valor,2);
						break;
					case 11:
						return $telefone->valor;
						break;
				}
			}
				
				




		}
		return '-';
			
	}
	public function getTelefones(){
		$telefones = PessoaDadosContato::whereIn('dado',[2,9])->where('pessoa',$this->id)->orderByDesc('id')->get();
		return $telefones;
	}

	public static function cabecalho($id)
	{
		$pessoa= Pessoa::withTrashed()->find($id);
		$pessoa=\App\Http\Controllers\PessoaController::formataParaMostrar($pessoa);
		if(isset($pessoa->telefone))
			$pessoa->telefone=\App\classes\Strings::formataTelefone($pessoa->telefone);
		if(isset($pessoa->telefone_alternativo))
			$pessoa->telefone_alternativo=\App\classes\Strings::formataTelefone($pessoa->telefone_alternativo);
		if(isset($pessoa->telefone_contato))
			$pessoa->telefone_contato=\App\classes\Strings::formataTelefone($pessoa->telefone_contato);

		return $pessoa;
	}
	public function getIdade(){
		return \App\classes\Data::calculaIdade($this->nascimento);
	}

	public function getProgramas(){
		$programas =   PessoaDadosAdministrativos::where('pessoa',$this->id)->where('dado','programa')->pluck('valor')->toArray();
		return $programas;
	}

	public function getEmail(){
		$email =   PessoaDadosContato::where('pessoa',$this->id)->where('dado','1')->OrderByDesc('id')->first();
		if($email)
			return $email->valor;
		else
			return 'ND';
	}

}
