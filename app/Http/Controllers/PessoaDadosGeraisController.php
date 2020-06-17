<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\GerenciadorAcesso;
use App\Pessoa;
use App\PessoaDadosGerais;
use Auth;

class PessoaDadosGeraisController extends Controller
{
    
    public function editarObservacoes_view($id){
		if(!GerenciadorAcesso::pedirPermissao(3) && $id != Auth::user()->pessoa )
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));


		$pessoa =Pessoa::find($id);
		$obs = PessoaDadosGerais::where('pessoa',$id)->where('dado',5)->first();


		return view('pessoa.editar-observacao', compact('pessoa'))->with('obs',$obs->valor);

	}


	public function editarObservacoes_exec(Request $request){
		if(!GerenciadorAcesso::pedirPermissao(3) && $request->pessoa != Auth::user()->pessoa )
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($request->pessoa) && $request->pessoa != Auth::user()->pessoa )
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));

		$dado = PessoaDadosGerais::where('pessoa',$request->pessoa)->where('dado',5)->first();
		if(isset($dado))
			$dado->valor = $request->obs;
		else{
			$dado = new PessoaDadosGerais;
			$dado->pessoa = $request->pessoa;
			$dado->dado = 5; //dado 5 = obs
			$dado->valor = $request->obs;
		}
		$dado->save();

		return redirect()->back()->withErrors(['Alterções salvas com sucesso.']);
	}

	public static function gravarDocumento(int $pessoa, $documento, $numero=0){
		
		switch($documento){
			case "rg": 
				$tipo = 3;
			break;
				
			case "cpf" : 
				$tipo = 4;
			break;	
			default : 
			 die('Tipo de dado não especificado. PessoaDadosController 60');
			break;			
		}
		$existente = PessoaDadosGerais::where('dado',$tipo)->where('pessoa',$pessoa)->get();
		if(is_null($existente) && $numero !=0 && $numero!=' '){
			$doc = new PessoaDadosGerais;
			$doc->dado = $tipo;
			$doc->valor = preg_replace( '/[^0-9]/is', '', $numero);
			$doc->save();
		}
		else {
			$doc = null;
		}
		return $doc;

	}


}
