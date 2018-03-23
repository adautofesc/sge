<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pessoa;
use App\PessoaDadosGerais;
use App\PessoaDadosContato;
use App\PessoaDadosClinicos;
use App\PessoaDadosAcesso;
use App\PessoaDadosAdministrativos;
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

	/**
	 * Exibe formulário para cadastrar uma nova pessoa
	 *
	 * @param   Array $erros - retorna formulario com os erros das regras de negocio
	 * @param   Array $sucesso - retorna formulario com mensagem de sucesso ao cadastrar pessoa sem cpf
	 * @param   Int $responsavel - retorna formulario com id do dependente dessa pessoa
 	 * @return \Illuminate\Http\Response 
 	 */
	public function create ($erros='',$sucessos='',$responsavel='')
	{

		if(!loginController::check())
			return redirect(asset("/"));

		if(loginController::pedirPermissao(1))
		{ // pede permissao para acessar o formulário
			$bairros=DB::table('bairros_sanca')->get();          
			$dados=['bairros'=>$bairros,'alert_danger'=>$erros,'alert_sucess'=>$sucessos,'responsavel_por'=>$responsavel];
			return view('pessoa.cadastrar', compact('dados'));

		}
		else
			return redirect(asset('/403'));
	} // end create()


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
			if(!loginController::pedirPermissao(1))
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
				return $this->create(['Ops, parece que essa pessoa já está cadastrada no sistema. Encontrado alguém com o mesmo nome e mesma data de nascimento. Pode confirmar isso?']);
		// se preencheu o CPF
			if(isset($request->cpf))		 
			{
			//se o CPF já está no sistema
				$cpf_no_sistema=PessoaDadosGerais::where('dado','3')->where('valor',$request->cpf)->get();
				if (count($cpf_no_sistema)) 
				{
					$erros_bd=["Desculpe, CPF já cadastrado no sistema."];
				;
					return $this->create($erros_bd);
				}
			//se o cpf é valido
				elseif (!Strings::validaCPF($request->cpf)) 
				{
				 	$erros_bd=["Desculpe, o CPF fornecido é inválido."];
					//return $cpf_no_sistema;
					return $this->create($erros_bd);
				}		
			}	    
		// Apertou a opção de cadastro com CPF?
			if($request->btn_sub==1||$request->btn_sub==3)
				if($request->cpf=='')
				{
				$erros_bd=["Desculpe, mas o preenchimento de CPF é obrigatório. Porém você pode clicar em cadastrar responsável"];
				return $this->create($erros_bd); // volta pro form com erro
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
				$pessoa->dadosGerais()->save($info);
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
			//se tiver vincular
			if($request->rua != '')
			{
				if($request->vinculara!=''){
					$vinculo=$this->buscarEndereco($request->vinculara);				
					if($vinculo->logradouro==$request->rua && $vinculo->numero==$request->numero_endereco){
						$id_endereco=$vinculo->id;
						$cadastrarend=False;
					}
					
					else
						$cadastrarend=true;
				}
				else
					$cadastrarend=True;
				if($cadastrarend){
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
					$id_endereco=$endereco->id;
				}


				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=6; 
				$info->valor=$id_endereco;
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
				return $this->create('',['Dependente inserido com sucesso'],$pessoa->id);
			if($request->btn_sub==3)
				return $this->create('',['Pessoa cadastrada com sucesso.'],'');
			else
				return redirect(asset('/secretaria/atender/'.$pessoa->id)); 
	}//end gravarPessoa


/**
 * Função para mostrar as pessoas
 *
 * @param \App\Pessoa $id
 *
 */
	public function dadosPessoa($id)
	{
		$pessoa=Pessoa::find($id);
		// Verifica se a pessoa existe
		if(!$pessoa)
			return $this->listarTodos();

		// Verifica se o perfil não é proprio
		if($pessoa->id != Session::get('usuario'))
		{
		//verifica se pode ver outras pessoas
			if(!loginController::pedirPermissao(4))			
				return view('error-404-alt')->with(array('error'=>['id'=>'403.4','desc'=>'Seu cadastro não permite que você veja os dados de outra pessoa']));
				//return $this->listar();	
		// verifica se a pessoa tem relação institucional
			$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
			if($relacao_institucional && !loginController::pedirPermissao(5))
			{
				return view('error-404-alt')->with(array('error'=>['id'=>'403.5','desc'=>'Você não possui acesso a dados de pessoas ligadas à instituição.']));		
			}
		// Verifica se a pessoa tem perfil privado.
			$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
			if($pessoa_restrita && !loginController::pedirPermissao(6))
				return view('error-404-alt')->with(array('error'=>['id'=>'403.6','desc'=>'Esta pessoa possui restrição de acesso aos seus dados']));	

		}
	
		$pessoa=$this->formataParaMostrar($pessoa);

		return $pessoa;
	}

	public function mostrar($id)
	{	
		if(!loginController::check())
			return redirect(asset("/"));
		$pessoa=$this->dadosPessoa($id);

		//return $pessoa;
		//return redirect(asset('/secretaria/atender/'.$id));
		return view('pessoa.mostrar',compact('pessoa'));

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
	public static function formataParaMostrar(Pessoa $pessoa)
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
		foreach( $pessoa->dadosAdministrativos->all() as $dado){
			$tipoDado=TipoDado::find($dado['dado'])->tipo;
			$pessoa->$tipoDado=$dado['valor'];
		}
		foreach( $pessoa->dadosAcademicos->all() as $dado){
			$tipoDado=TipoDado::find($dado['dado'])->tipo;
			$pessoa->$tipoDado=$dado['valor'];
		}
		
		$dependentes= $pessoa->dadosGerais->where('pessoa',$pessoa->id)->where('dado',7);
		
		foreach($dependentes as $dependente)
		{
			$dependente->nome=Pessoa::getNome($dependente->valor);
		}
		$pessoa->dependentes=$dependentes;
		if(isset($pessoa->responsavel))
			$pessoa->nomeresponsavel=Pessoa::getNome($pessoa->responsavel);
		


		$pessoa->nome=Strings::converteNomeParaUsuario($pessoa->nome);
		$pessoa->nome_registro=Strings::converteNomeParaUsuario($pessoa->nome_registro);
		$pessoa->idade=Data::calculaIdade($pessoa->nascimento);
		//$pessoa->aniversario=$pessoa->nascimento;
		$pessoa->nascimento=Data::converteParaUsuario($pessoa->nascimento);
		

		$pessoa->cadastro=Data::converteParaUsuario($pessoa->created_at). "  Cadastrad".Pessoa::getArtigoGenero($pessoa->genero).' por '. Pessoa::getNome($pessoa->por);

		switch ($pessoa->genero) {
			case 'M':
				$pessoa->genero="Masculino";
				break;
			case 'F':
				$pessoa->genero="Feminino";
				break;
			case 'X':
				$pessoa->genero="Trans Masculino";
				break;
			case 'Y':
				$pessoa->genero="Trans Feminino";
				break;
			case 'Z':
				$pessoa->genero="Não especificado";
				break;
			
			default:
				$pessoa->genero="Não especificado";
				break;
		}

		$username=PessoaDadosAcesso::where('pessoa',$pessoa->id)->first();
		if($username)
			$pessoa->username=$username->usuario;

		if(isset($pessoa->cpf)){
			$pessoa->cpf = str_replace(['.','-'], '', $pessoa->cpf);
			if(!Strings::validaCPF($pessoa->cpf)){
				$pessoa->cpf ='';
			}
		}	



		if(isset($pessoa->endereco)){
			$endereco=Endereco::find($pessoa->endereco);
			$pessoa->logradouro=$endereco->logradouro;
			$pessoa->end_numero=$endereco->numero;
			$pessoa->bairro=EnderecoController::getBairro($endereco->bairro);
			$pessoa->end_complemento=$endereco->complemento;
			$pessoa->cidade=$endereco->cidade;
			$pessoa->estado=$endereco->estado;
			$pessoa->cep=Strings::mask($endereco->cep,'#####-###');
			$pessoa->bairro_alt=$endereco->bairro_str;
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
		if(isset($r->queryword))
			$pessoas=Pessoa::leftjoin('pessoas_dados_gerais', 'pessoas.id', '=', 'pessoas_dados_gerais.pessoa')
							->where('pessoas.id',$r->queryword)
							->orwhere('nome', 'like', '%'.$r->queryword."%")
							->orwhere('nascimento', 'like', '%'.$r->queryword."%")
							->orwhere('pessoas_dados_gerais.valor', 'like', '%'.$r->queryword."%")					
							->orderby('nome')								
							->groupBy('pessoas.id')							
							->select('pessoas.id','pessoas.nome','pessoas.nascimento','pessoas.genero')
							->paginate(35);
		else
			return $this->listarTodos();		
		foreach($pessoas->all() as $pessoa)
		{
			$pessoas->$pessoa=$this->formataParaMostrar($pessoa);
		}
		return view('pessoa.listar-todos', compact('pessoas'));
	}

	

	


	public function liveSearchPessoa($query='')
	{
		$pessoas=Pessoa::leftjoin('pessoas_dados_gerais', 'pessoas_dados_gerais.pessoa', '=', 'pessoas.id')
						->where('pessoas.id',$query)
						->orwhere('nome', 'like', '%'.$query."%")
						->orwhere('nascimento', 'like', '%'.$query."%")
						->orwhere('pessoas_dados_gerais.valor', 'like', '%'.$query."%")
						->orderby('nome')
						->groupBy('pessoas.id')
						->limit(30)
						->get(['pessoas.id','pessoas.nome','pessoas.nascimento']);
		
		foreach($pessoas->all() as $pessoa)
		{	
			$pessoa->nome=Strings::converteNomeParaUsuario($pessoa->nome);
			$pessoa->nascimento=Data::converteParaUsuario($pessoa->nascimento);
			$pessoa->numero=str_pad($pessoa->id,7,"0",STR_PAD_LEFT);
		}
		return $pessoas;
	}

	

	public function mostrarCadastrarUsuario()
	{
		

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

	
	public function editarGeral_view($id){
		
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));


		$dados=$this->dadosPessoa($id);
		//return $dados;
				switch ($dados['genero']) {
			case 'Masculino':
				$dados['generom']="checked";
				break;
			case 'Feminino':
				$dados['generof']="checked";
				break;
			case 'Trans Masculino':
				$dados['generox']="checked";
				break;
			case 'Trans Feminino':
				$dados['generoy']="checked";
				break;
			case 'Não especificado':
				$dados['generoz']="checked";
				break;
			default:
				$pessoa->genero="Não especificado";
				break;
		}
		return view('pessoa.editar-dados-gerais', compact('dados'));
	}
	public function editarGeral_exec(Request $request){
		
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Desculpe, você não possui autorização para alterar dados de outras pessoas']));
		$this->validate($request, [
				'pessoa'=>'required|integer',
				'nome'=>'required',
				'nascimento'=>'required',
				'genero'=>'required'
			]);
		$pessoa=Pessoa::find($request->pessoa);
		if(!$pessoa){
			return redirect(asset("/pessoa/listar/"));
		}

		$dados_atuais=$this->dadosPessoa($request->pessoa);

		$pessoa->nome=mb_convert_case($request->nome, MB_CASE_UPPER, 'UTF-8');
		$pessoa->nascimento=Data::converteParaBd($request->nascimento);
		$pessoa->genero=$request->genero;
		$pessoa->save();
		$pessoa->alert_sucess=" Nome, nascimento e gênero gravados com sucesso,";
		if($request->rg!='' || $request->rg!=$dados_atuais->rg){

			$rg=new PessoaDadosGerais;
			$rg->pessoa=$pessoa->id;
			$rg->dado=4;
			$rg->valor=$request->rg;
			$rg->save();
			$pessoa->alert_sucess.=" RG gravado com sucesso,";

			
		}
		if($request->cpf!='' || $request->cpf!=$dados_atuais->cpf )
		{	
			if (!Strings::validaCPF($request->cpf)) 
			{
				$pessoa->alert_warning.=" Erro ao gravar: O CPF informado não é válido,";
				
			}
			elseif(PessoaDadosGerais::where('dado',3)->where('valor', $request->cpf)->where('pessoa','!=',$request->pessoa)->first()){
				$pessoa->alert_warning.=" Erro ao gravar: O CPF informado já consta no sistema,";
			}
			else{
		
				$cpf=new PessoaDadosGerais;
				$cpf->pessoa=$pessoa->id;
				$cpf->dado=3;
				$cpf->valor=$request->cpf;
				$cpf->save();
				$pessoa->alert_sucess.=" CPF gravado com sucesso,";
			}

		}
		if($request->nome_registro!='' || $request->nome_registro!=$dados_atuais->nome_registro )
		{
			$nome=new PessoaDadosGerais;
			$nome->pessoa=$pessoa->id;
			$nome->dado=8;
			$nome->valor=mb_convert_case($request->nome_registro, MB_CASE_UPPER, 'UTF-8');
			$nome->save();
			$pessoa->alert_sucess.=" Nome de registro gravado com sucesso,";
			
		}
		$pessoa=$this->formataParaMostrar($pessoa);
		return view('pessoa.mostrar', compact('pessoa'));
	}
	public function editarContato_view($id){
		
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));
		

		$bairros=DB::table('bairros_sanca')->get(); 
		$dados=$this->dadosPessoa($id);
		$dados->bairros=$bairros;


		//return $dados;
				
		return view('pessoa.editar-dados-contato', compact('dados'));
	}
	public function editarContato_exec(Request $request){
		
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Desculpe, você não possui autorização para alterar dados de outras pessoas']));

		if(!loginController::autorizarDadosPessoais($request->pessoa))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));

	
		$pessoa=Pessoa::find($request->pessoa);
		if(!$pessoa){
			return redirect(asset("/pessoa/listar/"));
		}
		$dadosAtuais=$this->dadosPessoa($request->pessoa);

		if($request->email != '' || $request->email!= $dadosAtuais->email)
			{
				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=1; 
				$info->valor=mb_convert_case($request->email, MB_CASE_LOWER, 'UTF-8');
				$pessoa->dadosContato()->save($info);
			}

			if($request->telefone != '' || $request->telefone!= $dadosAtuais->telefone)
			{
				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=2; 
				$info->valor=$request->telefone;
				$pessoa->dadosContato()->save($info);
			}

			if($request->tel2 != '' || $request->tel2 != $dadosAtuais->telefone_alternativo)
			{
				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=9; 
				$info->valor=$request->tel2;
				$pessoa->dadosContato()->save($info);
			}

			if($request->tel3 != '' || $request->tel3!= $dadosAtuais->telefone_contato)
			{
				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=10; 
				$info->valor=$request->tel3;
				$pessoa->dadosContato()->save($info);
			}
			//se tiver vincular
			if($request->rua != '' || $request->rua!= $dadosAtuais->logradouro)
			{
				if($request->vinculara!=''){
					$vinculo=$this->buscarEndereco($request->vinculara);				
					if($vinculo->logradouro==$request->rua && $vinculo->numero==$request->numero_endereco){
						$id_endereco=$vinculo->id;
						$cadastrarend=False;
					}
					
					else
						$cadastrarend=true;
				}
				else
					$cadastrarend=True;
				if($cadastrarend){
					$endereco=new Endereco;					
					$endereco->logradouro =mb_convert_case($request->rua, MB_CASE_UPPER, 'UTF-8'); 
					$endereco->numero=$request->numero_endereco;
					$endereco->complemento=mb_convert_case($request->complemento_endereco, MB_CASE_UPPER, 'UTF-8');
					$endereco->bairro=$request->bairro;
					$endereco->cidade=mb_convert_case($request->cidade, MB_CASE_UPPER, 'UTF-8');
					$endereco->estado=$request->estado;
					$endereco->cep=str_replace('-', '', $request->cep);
					$endereco->atualizado_por=Session::get('usuario');
					$endereco->save();
					$id_endereco=$endereco->id;
				}


				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=6; 
				$info->valor=$id_endereco;
				$pessoa->dadosContato()->save($info);
				
			}

		$pessoa=$this->formataParaMostrar($pessoa);
		return redirect(asset("/secretaria/atender/"));
	}	
	public function editarDadosClinicos_view($id){
		
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));
		
		$dados=$this->dadosPessoa($id);

		//return $dados;



		return view('pessoa.editar-dados-clinicos', compact('dados'));


	}
	public function editarDadosClinicos_exec(Request $request){
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($request->pessoa))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));

		$pessoa=Pessoa::find($request->pessoa);
		if(!$pessoa)
			return redirect(asset("/pessoa/listar/"));

		$dadosAtuais=$this->dadosPessoa($request->pessoa);


		if($request->necessidade_especial != '' || $dadosAtuais->necessidade_especial!=$request->necessidade_especial)
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado=11; 
				$info->valor=mb_convert_case($request->necessidade_especial, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}					
		if($request->medicamentos != '' || $request->medicamentos!= $dadosAtuais->medicamentos)
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado=12; 
				$info->valor=mb_convert_case($request->medicamentos, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}
		if($request->alergias != '' || $request->alergias !=  $dadosAtuais->alergias)
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado=13; 
				$info->valor=mb_convert_case($request->alergias, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}
		if($request->doenca_cronica != '' || $request->doenca_cronica !=  $dadosAtuais->doenca_cronica )
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado=14; 
				$info->valor=mb_convert_case($request->doenca_cronica, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}



		
		return redirect(asset("/secretaria/atender/"));
	}



	public function editarObservacoes_view($id){
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));


		$dados=$this->dadosPessoa($id);

		return view('pessoa.editar-observacao', compact('dados'));

	}
	public function editarObservacoes_exec(Request $request){
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($request->pessoa))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));

		$pessoa=Pessoa::find($request->pessoa);
		if(!$pessoa)
			return redirect(asset("/pessoa/listar/"));

		$dados=$this->dadosPessoa($pessoa->id);

		if($request->obs != '' || $dados->obs!=$request->obs )
			{
				$dado=PessoaDadosGerais::where('dado', 5)->where('pessoa',$pessoa->id)->first();
				if($dado)
					$dado->delete();
				$info=new PessoaDadosGerais;					
				$info->pessoa=$pessoa->id;
				$info->dado=5;
				$info->valor=$request->obs;
				$pessoa->dadosGerais()->save($info);
			}





		return redirect(asset("/secretaria/atender/"));

	}





	public function addDependente_view($pessoa)
	{
		return View('pessoa.dependente.adicionar-dependente')->with('pessoa',$pessoa);

	}
	public function addDependente_exec($pessoa,$dependente)
	{
		$pessoa=$this->dadosPessoa($pessoa);
		$dado= new PessoaDadosGerais;
		$dado->pessoa=$pessoa->id;
		$dado->dado=7;
		$dado->valor=$dependente;
		$dado->save();
		return redirect(asset("/secretaria/atender/"));

	}
	public function remVinculo_exec($vinculo)
	{
		$vinculo=PessoaDadosGerais::find($vinculo);
		$pessoa=$vinculo->pessoa;
		$vinculo->delete();
		
		return redirect(asset("/secretaria/atender/"));

	}
	public function addResponsavel_view($pessoa)
	{
		return View('pessoa.adicionar-responsavel')->with('pessoa',$pessoa);
	}
	public function addResponsavel_exec(Request $r)
	{
		$pessoa=$this->dadosPessoa($r->pessoa);
		return view('pessoa.mostrar')->with('pessoa',$pessoa)->with('dados',$dados);
	}
	public function remResponsavel_exec(Request $r)
	{
		$pessoa=$this->dadosPessoa($r->pessoa);
		return view('pessoa.mostrar')->with('pessoa',$pessoa)->with('dados',$dados);
	}

	public static function buscarEndereco($id){
		
		if(!loginController::autorizarDadosPessoais($id))
			return null;
		$dado=PessoaDadosContato::where('pessoa',$id)->where('dado',6)->first();
		if(!$dado)
			return null;
		$endereco=Endereco::find($dado->valor);
		if(!$endereco)
			return null;
		else
			return $endereco;

	}
	public function relacaoInstitucional_view($id){
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel. O código de pessoa também pode ser inválido']));

		$nome = Pessoa::getNome($id);
		if(!$nome)
			return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Pessoa não encontrada']));


		return view('gestaopessoal.relacao-institucional')->with('nome',$nome)->with('id',$id);



	}
	public function relacaoInstitucional_exec(Request $request){
		
		if(!GerenciadorAcesso::pedirPermissao(3))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($request->pessoa))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional, não está acessivel ou não existe.']));

		$rel_atual=PessoaDadosAdministrativos::where('pessoa',$request->pessoa)->where('dado',16)->first();

		if($rel_atual)
			$rel_atual->delete();
		$nova_relacao=new PessoaDadosAdministrativos;
		//$nova_relacao->timestamps=false;
		$nova_relacao->dado=16;
		$nova_relacao->pessoa=$request->pessoa;
		$nova_relacao->valor=$request->cargo;
		$nova_relacao->save();




		return redirect(asset('gestaopessoal/atender').'/'.$request->pessoa);



	}
	public static function notificarCPFInvalido($pessoa){
		// abre um protocolo de correção de dados
		// 
		return '45.361.904/0001-80';




	}




	
}
