<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\GerenciadorAcesso;
use App\Http\Controllers\loginController;
use App\PessoaDadosClinicos;

class PessoaDadosClinicosController extends Controller
{
	public function store(Request $req){
		//dd($req->valor);
		if(isset($req->pessoa) && isset($req->tipo) && isset($req->valor)){
			$reg = new PessoaDadosClinicos;
			$reg->pessoa = $req->pessoa;
			$reg->dado = $req->tipo;
			$reg->valor = $req->valor;
			$reg->save();
			return response($reg,200);

		}
		else
			return response('Dados insuficientes para inserir essa informação',412);

	}

    public function editarDadosClinicos_view($id){
		
		if(!GerenciadorAcesso::pedirPermissao(3) && $id != Session::get('usuario') )
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));
		
		$dados=PessoaDadosClinicos::where('pessoa',$id)->get();

		//return $dados;



		return view('pessoa.dados-clinicos.editar', compact('dados'))->with('pessoa',$id);


	}
	public function editarDadosClinicos_exec(Request $request){
		if(!GerenciadorAcesso::pedirPermissao(3) && $request->pessoa != Session::get('usuario') )
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($request->pessoa) && $request->pessoa != Session::get('usuario') )
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));

		$pessoa=Pessoa::find($request->pessoa);
		if(!$pessoa)
			return redirect(asset("/pessoa/listar/"));

		$dadosClinicosAtuais=PessoaDadosClinicos::where('pessoa',$request->pessoa)->get();


		if($request->necessidade_especial != '' || $dadosAtuais->necessidade_especial!=$request->necessidade_especial)
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado='necessidade_especial'; 
				$info->valor=mb_convert_case($request->necessidade_especial, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}					
		if($request->medicamentos != '' || $request->medicamentos!= $dadosAtuais->medicamentos)
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado='medicamento'; 
				$info->valor=mb_convert_case($request->medicamentos, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}
		if($request->alergias != '' || $request->alergias !=  $dadosAtuais->alergias)
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado='alergia'; 
				$info->valor=mb_convert_case($request->alergias, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}
		if($request->doenca_cronica != '' || $request->doenca_cronica !=  $dadosAtuais->doenca_cronica )
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado='doenca'; 
				$info->valor=mb_convert_case($request->doenca_cronica, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}



		
		return redirect()->back()->withErrors(['Alterções salvas com sucesso.']);
	}
	public function delete($id){
		PessoaDadosClinicos::destroy($id);
		return response('Excluido',200);
	}
}
