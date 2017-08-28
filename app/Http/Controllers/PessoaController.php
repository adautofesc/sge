<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pessoa;
use App\PessoaDadosGerais;
use App\PessoaDadosContato;
use App\PessoaDadosClinicos;
use App\PessoaDadosAcesso;
use App\Endereco;
use App\TipoDado;
use App\classes\GerenciadorAcesso;
use App\classes\Data;
use App\classes\Strings;
use App\Http\Controllers\loginController;
use App\Http\Controllers\EnderecoController;
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
	} // end adicionaPrimeiro


	/**
	 * Exibe formulário para cadastrar uma nova pessoa
	 *
	 * @param   Array $erros - retorna formulario com os erros das regras de negocio
	 * @param   Array $sucesso - retorna formulario com mensagem de sucesso ao cadastrar pessoa sem cpf
	 * @param   Int $responsavel - retorna formulario com id do dependente dessa pessoa
 	 * @return \Illuminate\Http\Response 
 	 */
	public function mostraFormularioAdicionar($erros='',$sucessos='',$responsavel='')
	{
		//posso cadastrar
		/*
		$hoje=new Data();
		$data=$hoje->getData();
		$user=Session::get('usuario');
		$usuario= Pessoa::where('id',$user)->first();
		$array_nome=explode(' ',$usuario->nome);
		$nome=$array_nome[0].' '.end($array_nome);*/ 
		
		
		if(!loginController::check())
			return redirect(asset("/"));




		if(GerenciadorAcesso::pedirPermissao(1))
		{ // pede permissao para acessar o formulário
			$bairros=DB::table('bairros_sanca')->get();          
			$dados=['bairros'=>$bairros,'alert_danger'=>$erros,'alert_sucess'=>$sucessos,'responsavel_por'=>$responsavel];
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
	public function gravarPessoa(Request $request)
	{	
		if(!loginController::check())
			return redirect(asset("/"));

		// Verifica se pode gravar
			if(!GerenciadorAcesso::pedirPermissao(1))
				return redirect(asset('/403')); //vai para acesso não autorizado
				//Validação dos requisitos
			$this->validate($request, [
				'nome'=>'required',
				'nascimento'=>'required',
				'genero'=>'required'				

			]);
		// Verifica se já tem alguem com mesmo nome e data de nascimento.
			$pessoanobd=Pessoa::where('nome', $request->nome)->where('nascimento',$request->nascimento)->get();
			if(count($pessoanobd)) 
				return $this->mostraFormularioAdicionar(['Ops, parece que essa pessoa já está cadastrada no sistema. Encontrado alguém com o mesmo nome e mesma data de nascimento. Pode confirmar isso?']);
		// se preencheu o CPF
			if(isset($request->cpf))		 
			{
			//se o CPF já está no sistema
				$cpf_no_sistema=PessoaDadosGerais::where('dado','3')->where('valor',$request->cpf)->get();
				if (count($cpf_no_sistema)) 
				{
					$erros_bd=["Desculpe, CPF já cadastrado no sistema."];
				;
					return $this->mostraFormularioAdicionar($erros_bd);
				}
			//se o cpf é valido
				elseif (!Strings::validaCPF($request->cpf)) 
				{
				 	$erros_bd=["Desculpe, o CPF fornecido é inválido."];
					//return $cpf_no_sistema;
					return $this->mostraFormularioAdicionar($erros_bd);
				}		
			}	    
		// Apertou a opção de cadastro com CPF?
			if($request->btn_sub==1||$request->btn_sub==3) 
			{
				$erros_bd=["Desculpe, mas o preenchimento de CPF é obrigatório. Porém você pode clicar em cadastrar responsável"];
				return $this->mostraFormularioAdicionar($erros_bd); // volta pro form com erro
			}
			$pessoa = new Pessoa;
			$pessoa->nome=mb_convert_case($request->nome, MB_CASE_UPPER, 'UTF-8');
			$pessoa->nascimento=$request->nascimento;
			$pessoa->genero=$request->genero;
			$pessoa->por=Session::get('usuario');
			$pessoa->save();//
		//**************** Dados Gerais

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
				$pessoa->dadosContato()->save($info); //cadastra o dependente no titular

				$info=new PessoaDadosGerais;					
				$info->pessoa=$request->responsavel_por;
				$info->dado=15;
				$info->valor=$pessoa->id;
				$pessoa->dadosContato()->save($info); //cadastra o titular no dependente
			}
		//**************** Dados Contato
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
		//**************** Redireciona para o setor responsável

			if($request->btn_sub==2)
				return $this->mostraFormularioAdicionar('',['Dependente inserido com sucesso'],$pessoa->id);
			if($request->btn_sub==3)
				return $this->mostraFormularioAdicionar('',['Pessoa cadastrada com sucesso.'],'');
			else
				return redirect(asset('/pessoa/mostrar/'.$pessoa->id)); 
	}//end gravarPessoa


/**
 * Função para mostrar as pessoas
 *
 * @param \App\Pessoa $id
 *
 */
	public function mostrar($id)
	{

		if(!loginController::check())
			return redirect(asset("/"));


		$pessoa=Pessoa::find($id);
		// Verifica se a pessoa existe
		if(!$pessoa)
			return $this->listarTodos();

		// Verifica se o perfil não é proprio
		if($pessoa->id != Session::get('usuario'))
		{
		//verifica se pode ver outras pessoas
			if(!GerenciadorAcesso::pedirPermissao(4))			
				return view('error-404-alt')->with(array('error'=>['id'=>'403.4','desc'=>'Seu cadastro não permite que você veja os dados de outra pessoa']));
				//return $this->listar();	
		// verifica se a pessoa tem relação institucional
			$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
			if($relacao_institucional && !GerenciadorAcesso::pedirPermissao(5))
			{
				return view('error-404-alt')->with(array('error'=>['id'=>'403.5','desc'=>'Você não possui acesso a dados de pessoas ligadas à instituição.']));		
			}
		// Verifica se a pessoa tem perfil privado.
			$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
			if($pessoa_restrita && !GerenciadorAcesso::pedirPermissao(6))
				return view('error-404-alt')->with(array('error'=>['id'=>'403.6','desc'=>'Esta pessoa possui restrição de acesso aos seus dados']));	

		}
	
		$pessoa=$this->formataParaMostrar($pessoa);

		return view('pessoa.mostrar', compact('pessoa'));
	}
	public function edita($id){

	}
	public function apaga($id)
	{
	}

/**
	*
	* Formata dados da pessoa para colocar na view
	*
	* @param Pessoa 
	*/
	public function formataParaMostrar(Pessoa $pessoa)
	{
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
		
		$dependentes= $pessoa->dadosGerais->where('pessoa',$pessoa->id)->where('dado',7);
		
		foreach($dependentes as $dependente)
		{
			$dependente->nome=$this->getNome($dependente->valor);
		}
		$pessoa->dependentes=$dependentes;
		if(isset($pessoa->responsavel))
			$pessoa->nomeresponsavel=$this->getNome($pessoa->responsavel);
		


		$pessoa->nome=Strings::converteNomeParaUsuario($pessoa->nome);
		$pessoa->idade=Data::calculaIdade($pessoa->nascimento);
		$pessoa->nascimento=Data::converteParaUsuario($pessoa->nascimento);
		

		$pessoa->cadastro=Data::converteParaUsuario($pessoa->created_at). "  Cadastrad".$this->getArtigoGenero($pessoa->genero).' por '. $this->getNome($pessoa->por);

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

		$username=PessoaDadosAcesso::where('pessoa',$pessoa->id)->first();
		if($username)
			$pessoa->username=$username->usuario;


		if(isset($pessoa->endereco)){
			$endereco=Endereco::find($pessoa->endereco);
			$pessoa->logradouro=$endereco->logradouro;
			$pessoa->end_numero=$endereco->numero;
			$pessoa->bairro=EnderecoController::getBairro($endereco->bairro);
			$pessoa->end_complemento=$endereco->complemento;
			$pessoa->cidade=$endereco->cidade;
			$pessoa->estado=$endereco->estado;
			$pessoa->cep=$endereco->cep;
		}

		return $pessoa;

	}

	/**
	 *
	 * Lista de todas pessoas
	 *
	 * @return View pessoa.listar-todos
	 *
	 */
	public function listarTodos()
	{
		if(!loginController::check())
			return redirect(asset("/"));

		if(!GerenciadorAcesso::pedirPermissao(4))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.4','desc'=>'Seu cadastro não permite que você veja os dados de outra pessoa']));

		$pessoas=Pessoa::orderBy('nome','ASC')->paginate(35);
		foreach($pessoas->all() as $pessoa)
		{
			$pessoas->$pessoa=$this->formataParaMostrar($pessoa);
		}
		return view('pessoa.listar-todos', compact('pessoas'));
	}


	/**
	 *
	 * Procurar pessoa e  exibir recultados em uma lista
	 *
	 * @param  Request $
	 *
	 */
	public function procurarPessoa(Request $r)
	{		
		if(isset($r['queryword']))
			//$pessoas=Pessoa::where('nome', 'like', '%'.$r['queryword']."%")->paginate(35);
			$pessoas=Pessoa::leftjoin('pessoas_dados_gerais', 'pessoas_dados_gerais.id', '=', 'pessoas.id')
							->where('pessoas.id',$r['queryword'])
							->orwhere('nome', 'like', '%'.$r['queryword']."%")
							->orwhere('valor', 'like', '%'.$r['queryword']."%")
							->orderby('nome')							
							->paginate(35);
							
		
		else
			return $this->listarTodos();		
		foreach($pessoas->all() as $pessoa)
		{
			$pessoas->$pessoa=$this->formataParaMostrar($pessoa);
		}
		return view('pessoa.listar-todos', compact('pessoas'));
	}

	public function getNome($id)
	{		
		$query=Pessoa::find($id);
		if($query)
			$nome=Strings::converteNomeParaUsuario($query->nome);
		else
			$nome="Impossível encontrar o nome dessa pessoa";

		return $nome;
	}

	public function iniciarAtendimento()
	{
		return view('pessoa.inicio-atendimento');
	}


	public function liveSearchPessoa($query='')
	{
		$pessoas=Pessoa::leftjoin('pessoas_dados_gerais', 'pessoas_dados_gerais.id', '=', 'pessoas.id')
						->where('pessoas.id',$query)
						->orwhere('nome', 'like', '%'.$query."%")
						->orwhere('valor', 'like', '%'.$query."%")
						->orderby('nome')
						->limit(20)
						->get(['pessoas.id','pessoas.nome','pessoas.nascimento']);
		foreach($pessoas->all() as $pessoa)
		{	
			$pessoa->nome=Strings::converteNomeParaUsuario($pessoa->nome);
			$pessoa->nascimento=Data::converteParaUsuario($pessoa->nascimento);
			$pessoa->numero=str_pad($pessoa->id,7,"0",STR_PAD_LEFT);
		}
		return $pessoas;
	}

	public function getArtigoGenero($a)
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

	public function mostrarCadastrarUsuario()
	{
		if(!loginController::check())
			return redirect(asset("/"));

		if(GerenciadorAcesso::pedirPermissao(8))
			return view('pessoa.cadastrar-acesso');
		else
			return view('error-404-alt')->with(array('error'=>['id'=>'403.8','desc'=>'Você não pode cadastrar usuários no sistema.']));
	}

	public function gravarUsuario(Request $request)
	{
		$this->validate($request, [
				'username'=>'required|alpha_num|min:3|max:10',
				'senha'=>'required|alpha_num|min:6',
				'retsenha'=>'required|same:senha'
				]);
		return "ok";	
	}

	public function atender($id){

		if(!loginController::check())
			return redirect(asset("/"));

		$pessoa=Pessoa::find($id);
		// Verifica se a pessoa existe
		if(!$pessoa)
			return $this->listarTodos();

		$pessoa=Pessoa::find($id);
		$pessoa=$this->formataParaMostrar($pessoa);


		return view('pessoa.atendimento', compact('pessoa'));
	}



	
}
