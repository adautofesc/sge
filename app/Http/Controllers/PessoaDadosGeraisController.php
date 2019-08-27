<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\GerenciadorAcesso;
use App\Pessoa;
use App\PessoaDadosGerais;

class PessoaDadosGeraisController extends Controller
{
    
    public function editarObservacoes_view($id){
		if(!GerenciadorAcesso::pedirPermissao(3) && $id != Session::get('usuario') )
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));


		$pessoa =Pessoa::find($id);
		$obs = PessoaDadosGerais::where('pessoa',$id)->where('dado',5)->first();


		return view('pessoa.editar-observacao', compact('pessoa'))->with('obs',$obs->valor);

	}


	public function editarObservacoes_exec(Request $request){
		if(!GerenciadorAcesso::pedirPermissao(3) && $request->pessoa != Session::get('usuario') )
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($request->pessoa) && $request->pessoa != Session::get('usuario') )
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


}
