<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pessoa;
use App\PessoaDadosGerais;
use App\PessoaDadosContato;
use App\classes\GerenciadorAcesso;
use App\classes\Data;
use Session;



class PessoaController extends Controller
{
    //
    


    public function adicionaPrimeiro(){
    	$admin= new Pessoa;
    	$admin->nome = "Adauto";
    	$admin->genero="h";
    	$admin->nascimento='1984-11-10';
    	$admin->save();

    	return "Pessoa registrada";
		

	}
	public function listaTodos(){


	}
	public function mostraFormularioAdicionar($erros='',$sucessos='',$responsavel=''){
		//posso cadastrar
		$hoje=new Data();
		$data=$hoje->getData();
		$user=Session::get('usuario');
		$usuario= Pessoa::where('id',$user)->first();
		$array_nome=explode(' ',$usuario->nome);
		$nome=$array_nome[0].' '.end($array_nome); 
		$bairros=DB::table('bairros_sanca')->get();          
		$dados=['data'=>$data,'usuario'=>$nome, 'bairros'=>$bairros,'alert_danger'=>$erros,'alert_sucess'=>$sucessos,'responsavel_por'=>$responsavel];
		

		if(GerenciadorAcesso::pedirPermissao(1)){ // pede permissao para acessar o formulário
			
			return view('pessoa.cadastrar', compact('dados'));
			//return $erros;
			//return $dados;

		}
			


			//
		else
			return redirect(asset('/403'));


	}
	public function gravarPessoa(Request $request){

		//================================================
		//      Gravar pessoas no Banco
		//==============================================

		// Verificação de permissao
		if(GerenciadorAcesso::pedirPermissao(1)){ 


			//****************************Validação***********************
			$this->validate($request, [
				'nome'=>'required',
				'nascimento'=>'required',
				'genero'=>'required',
				'telefone'=>'required|numeric'		

			]);
			//******************************************************
			if(isset($request->cpf)) // se preencheu o CPF
			{
				$cpf_no_sistema=PessoaDadosGerais::where('dado','3')->where('valor',$request->cpf)->get();
				if (count($cpf_no_sistema)) // Já existe no sistema?
				{
					$erros_bd=["Desculpe, CPF já cadastrado no sistema."];
					//return $cpf_no_sistema;
					return $this->mostraFormularioAdicionar($erros_bd);
				}
				else // CPF não está cadastrado. Pode cadastrar NORMALMENTE
				{
					
					$pessoa = new Pessoa;
					$pessoa->nome=mb_convert_case($request->nome, MB_CASE_UPPER, 'UTF-8');
					$pessoa->nascimento=$request->nascimento;
					$pessoa->genero=$request->genero;
					$pessoa->por=$user=Session::get('usuario');
					//$pessoa->id=0;
					$pessoa->save();//




					if($request->nome_social != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=8; 
						$info->valor=$request->nome_social;
						$pessoa->dadosContato()->save($info)
					}
					

					if($request->rg != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=4; 
						$info->valor=$request->rg;
						$pessoa->dadosContato()->save($info)
					}

					if($request->cpf != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=3;
						$info->valor=$request->cpf;
						$pessoa->dadosContato()->save($info)
					}

					if($request->email != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=1; 
						$info->valor=$request->email;
						$pessoa->dadosContato()->save($info)
					}

					if($request->tel2 != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=9; 
						$info->valor=$request->tel2;
						$pessoa->dadosContato()->save($info)
					}

					if($request->tel2 != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=9; 
						$info->valor=$request->tel2;
						$pessoa->dadosContato()->save($info)
					}

					if($request->tel3 != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=10; 
						$info->valor=$request->tel2;
						$pessoa->dadosContato()->save($info)
					}

					if($request->logradouro != '')
					{
						$info=new Endereco;					
						$info->pessoa=$pessoa->id;
						$info->logradouro =$request->logradouro; 
						$info->numero=$request->numero;
						$info->complemento=$request->complemento;
						$info->bairro=$request->bairro;
						$info->cidade=$request->cidade;
						$info->estado=$request->estado;
						$info->cep=$request->cep;						
						$pessoa->endereco()->save($info)
					}

					if($request->necessidade_especial != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=11; 
						$info->valor=$request->necessidade_especial;
						$pessoa->dadosClinicos()->save($info)
					}

					if($request->medicamentos != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=12; 
						$info->valor=$request->medicamentos;
						$pessoa->dadosClinicos()->save($info)
					}

					if($request->alergia != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=13; 
						$info->valor=$request->alergia;
						$pessoa->dadosClinicos()->save($info)
					}

					if($request->doenca_cronica != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=14; 
						$info->valor=$request->doenca_cronica;
						$pessoa->dadosClinicos()->save($info)
					}




					
					$dadoContato=new PessoaDadosContato;					
					$dadoContato->pessoa=$pessoa->id;
					$dadoContato->dado=2; //2 = telefone
					$dadoContato->valor=$request->telefone;
					
					$pessoa->dadosContato()->save($dadoContato);


					if($request->email != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=1; 
						$info->valor=$request->email;
					}
					//$pessoa->dadosContato()->save($info);
					//$dadoContato->pessoa()->associate($pessoa);
					//$pessoa->dadosContato()->associate($dadoContato);

				



				
					

					
					//$dadoContato->save();

					return $pessoa;


				}


					;

			}
			else{    // não preencheu o CPF
				if($request->btn_sub==1||$request->btn_sub==3) // Apertou submit para CPF?
				{
					$erros_bd=["Desculpe, mas o preenchimento de CPF é obrigatório. Porém você pode clicar em cadastrar responsável"];
					return $this->mostraFormularioAdicionar($erros_bd); // volta pro form com erro
				}
				elseif($request->btn_sub==2) // Apertou opção para cadastrar Responsável
				{
					//$pessoa->save();
					$pessoa = new Pessoa;
					$pessoa->nome=mb_convert_case($request->nome, MB_CASE_UPPER, 'UTF-8');
					$pessoa->nascimento=$request->nascimento;
					$pessoa->genero=$request->genero;
					$pessoa->por=$user=Session::get('usuario');

					$pessoa->id=1;

					$pessoa->dadosContato()->dado="2";
					$pessoa->dadosContato()->valor=$request->telefone;

					return $pessoa->dadosContato();


					//return $this->mostraFormularioAdicionar('',['Pessoa Cadastrada com sucesso, agora preencha os dados do responsável'],$pessoa->id);

				}
				

			} 
			

		} // fim if de verificação de permissão
		else
			return redirect(asset('/403')); //vai para acesso não autorizado

	}
	public function mostra($id){

	}
	public function edita($id){

	}
	public function apaga($id){

	}
	
}
