<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pessoa;
use App\PessoaDadosGerais;
use App\PessoaDadosContato;
use App\PessoaDadosClinicos;
use App\Endereco;
use App\TipoDado;
use App\classes\GerenciadorAcesso;
use App\classes\Data;
use App\classes\Strings;
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


	/**
	 * Exibe formulário para cadastrar uma nova pessoa
	 *
	 * @param   Array $erros - retorna formulario com os erros das regras de negocio
	 * @param   Array $sucesso - retorna formulario com mensagem de sucesso ao cadastrar pessoa sem cpf
	 * @param   Int $responsavel - retorna formulario com id do dependente dessa pessoa
 	 * @return \Illuminate\Http\Response 
 	 */
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
		

		if(GerenciadorAcesso::pedirPermissao(1))
		{ // pede permissao para acessar o formulário
			
			return view('pessoa.cadastrar', compact('dados'));
			//return $erros;
			//return $dados;

		}
		else
			return redirect(asset('/403'));
	} // end mostraFormularioAdicionar()


	/**
	 * Faz todas verificações de requisitos e autorizações
	 *
	 * @param  \Illuminate\Http\Request  $request
 	 * @return \Illuminate\Http\Response 
 	 */
	public function gravarPessoa(Request $request){

	
		if(GerenciadorAcesso::pedirPermissao(1))
		{ 
			//Validação dos requisitos
			$this->validate($request, [
				'nome'=>'required',
				'nascimento'=>'required',
				'genero'=>'required'
						

			]);
			$pessoanobd=Pessoa::where('nome', $request->nome)->where('nascimento',$request->nascimento)->get();
			if(count($pessoanobd))
				return $this->mostraFormularioAdicionar(['Esta pessoa parece já estar cadastrada no sistema. Mesmo nome e mesma data de nascimento']);
			
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


					//se nome e data de nascimento já no sistema************************************ to do
					$pessoa = new Pessoa;
					$pessoa->nome=mb_convert_case($request->nome, MB_CASE_UPPER, 'UTF-8');
					$pessoa->nascimento=$request->nascimento;
					$pessoa->genero=$request->genero;
					$pessoa->por=Session::get('usuario');
					//$pessoa->id=0;
					$pessoa->save();//


					//*************************** Dados Gerais

					if($request->nome_social != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=8; 
						$info->valor=mb_convert_case($request->nome_social, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosContato()->save($info);
					}
					

					if($request->rg != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=4; 
						$info->valor=$request->rg;
						$pessoa->dadosContato()->save($info);
					}

					if($request->cpf != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=3;
						$info->valor=$request->cpf;
						$pessoa->dadosContato()->save($info);
					}

					if($request->obs != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=5;
						$info->valor=$request->obs;
						$pessoa->dadosContato()->save($info);
					}

					if($request->responsavel_por != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=7;
						$info->valor=$request->responsavel_por;
						$pessoa->dadosContato()->save($info);
					}


					//******************************Dados Contato
					if($request->email != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=1; 
						$info->valor=mb_convert_case($request->email, MB_CASE_LOWER, 'UTF-8');
						$pessoa->dadosContato()->save($info);
					}

					if($request->telefone != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=2; 
						$info->valor=$request->telefone;
						$pessoa->dadosContato()->save($info);
					}

					if($request->tel2 != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=9; 
						$info->valor=$request->tel2;
						$pessoa->dadosContato()->save($info);
					}

					if($request->tel3 != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=10; 
						$info->valor=$request->tel3;
						$pessoa->dadosContato()->save($info);
					}
					if($request->rua != '')
					{
						$endereco=new Endereco;					
						$endereco->logradouro =mb_convert_case($request->rua, MB_CASE_UPPER, 'UTF-8'); 
						$endereco->numero=$request->numero_endereco;
						$endereco->complemento=mb_convert_case($request->complemento_endereco, MB_CASE_UPPER, 'UTF-8');
						$endereco->bairro=$request->bairro;
						$endereco->cidade=mb_convert_case($request->cidade, MB_CASE_UPPER, 'UTF-8');
						$endereco->estado=$request->estado;
						$endereco->cep=$request->cep;
						$endereco->atualizado_por=Session::get('usuario');
						$endereco->save();
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=6; 
						$info->valor=$endereco->id;
						$pessoa->dadosContato()->save($info);
					}

					//**************** Dados Clinicos
					if($request->necessidade_especial != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=11; 
						$info->valor=mb_convert_case($request->necessidade_especial, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosClinicos()->save($info);
					}					
					if($request->medicamentos != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=12; 
						$info->valor=mb_convert_case($request->medicamentos, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosClinicos()->save($info);
					}
					if($request->alergias != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=13; 
						$info->valor=mb_convert_case($request->alergias, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosClinicos()->save($info);
					}
					if($request->doenca_cronica != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=14; 
						$info->valor=mb_convert_case($request->doenca_cronica, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosClinicos()->save($info);
					}

					if($request->btn_sub==3)
						return $this->mostraFormularioAdicionar('',['Pessoa cadastrada com sucesso.'],'');

					else
						return redirect(asset('/pessoa/mostrar/'.$pessoa->id));
				}	//*********************************************************************************
			}
			else{    // não preencheu o CPF
				if($request->btn_sub==1||$request->btn_sub==3) // Apertou submit para CPF?
				{
					$erros_bd=["Desculpe, mas o preenchimento de CPF é obrigatório. Porém você pode clicar em cadastrar responsável"];
					return $this->mostraFormularioAdicionar($erros_bd); // volta pro form com erro
				}
				elseif($request->btn_sub==2) // Apertou opção para cadastrar Responsável
				{


					$pessoa = new Pessoa;
					$pessoa->nome=mb_convert_case($request->nome, MB_CASE_UPPER, 'UTF-8');
					$pessoa->nascimento=$request->nascimento;
					$pessoa->genero=$request->genero;
					$pessoa->por=Session::get('usuario');
					//$pessoa->id=0;
					$pessoa->save();//


					//*************************** Dados Gerais

					if($request->nome_social != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=8; 
						$info->valor=mb_convert_case($request->nome_social, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosContato()->save($info);
					}
					

					if($request->rg != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=4; 
						$info->valor=$request->rg;
						$pessoa->dadosContato()->save($info);
					}

					if($request->cpf != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=3;
						$info->valor=$request->cpf;
						$pessoa->dadosContato()->save($info);
					}

					if($request->obs != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=5;
						$info->valor=$request->obs;
						$pessoa->dadosContato()->save($info);
					}

					if($request->responsavel_por != '')
					{
						$info=new PessoaDadosGerais;					
						$info->pessoa=$pessoa->id;
						$info->dado=7;
						$info->valor=$request->responsavel_por;
						$pessoa->dadosContato()->save($info);
					}


					//******************************Dados Contato
					if($request->email != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=1; 
						$info->valor=mb_convert_case($request->email, MB_CASE_LOWER, 'UTF-8');
						$pessoa->dadosContato()->save($info);
					}

					if($request->telefone != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=2; 
						$info->valor=$request->telefone;
						$pessoa->dadosContato()->save($info);
					}

					if($request->tel2 != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=9; 
						$info->valor=$request->tel2;
						$pessoa->dadosContato()->save($info);
					}

					if($request->tel3 != '')
					{
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=10; 
						$info->valor=$request->tel3;
						$pessoa->dadosContato()->save($info);
					}
					if($request->rua != '')
					{
						$endereco=new Endereco;					
						$endereco->logradouro =mb_convert_case($request->rua, MB_CASE_UPPER, 'UTF-8'); 
						$endereco->numero=$request->numero_endereco;
						$endereco->complemento=mb_convert_case($request->complemento_endereco, MB_CASE_UPPER, 'UTF-8');
						$endereco->bairro=$request->bairro;
						$endereco->cidade=mb_convert_case($request->cidade, MB_CASE_UPPER, 'UTF-8');
						$endereco->estado=$request->estado;
						$endereco->cep=$request->cep;
						$endereco->atualizado_por=Session::get('usuario');
						$endereco->save();
						$info=new PessoaDadosContato;					
						$info->pessoa=$pessoa->id;
						$info->dado=6; 
						$info->valor=$endereco->id;
						$pessoa->dadosContato()->save($info);
					}

					//**************** Dados Clinicos
					if($request->necessidade_especial != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=11; 
						$info->valor=mb_convert_case($request->necessidade_especial, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosClinicos()->save($info);
					}					
					if($request->medicamentos != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=12; 
						$info->valor=mb_convert_case($request->medicamentos, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosClinicos()->save($info);
					}
					if($request->alergias != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=13; 
						$info->valor=mb_convert_case($request->alergias, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosClinicos()->save($info);
					}
					if($request->doenca_cronica != '')
					{
						$info=new PessoaDadosClinicos;					
						$info->pessoa=$pessoa->id;
						$info->dado=14; 
						$info->valor=mb_convert_case($request->doenca_cronica, MB_CASE_UPPER, 'UTF-8');
						$pessoa->dadosClinicos()->save($info);
					}


					return $this->mostraFormularioAdicionar('',['Dependente inserido com sucesso'],$pessoa->id);

				}
				

			} 
			

		} // fim if de verificação de permissão
		else
			return redirect(asset('/403')); //vai para acesso não autorizado
	}//end gravarPessoa


	
	public function mostrar($id){

		$pessoa=Pessoa::find($id);
		
		foreach( $pessoa->dadosGerais->all() as $dado){
			$tipoDado=TipoDado::find($dado['dado'])->tipo;			
			$pessoa->$tipoDado=$dado['valor'];
		}
		foreach( $pessoa->dadosContato->all() as $dado){
			$tipoDado=TipoDado::find($dado['dado'])->tipo;			
			$pessoa->$tipoDado=$dado['valor'];
		}
		foreach( $pessoa->dadosClinicos->all() as $dado){
			$tipoDado=TipoDado::find($dado['dado'])->tipo;
			$pessoa->$tipoDado=$dado['valor'];
		}
		
		$pessoa->nome=Strings::converteNomeParaUsuario($pessoa->nome);
		$pessoa->idade=Data::converteParaUsuario($pessoa->nascimento).' ('.Data::calculaIdade($pessoa->nascimento).' anos)';

		switch ($pessoa->genero) {
			case 'h':
				$pessoa->genero="Masculino";
				break;
			case 'm':
				$pessoa->genero="Feminino";
				break;
			case 'x':
				$pessoa->genero="Trans Masculino";
				break;
			case 'y':
				$pessoa->genero="Trans Feminino";
				break;
			case 'z':
				$pessoa->genero="Não especificado";
				break;
			
			default:
				$pessoa->genero="Não especificado";
				break;
		}

		//return $pessoa;

		return view('pessoa.mostrar', compact('pessoa'));

	}
	public function edita($id){

	}
	public function apaga($id){

	}
	
}
