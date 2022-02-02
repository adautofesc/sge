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
use Auth;



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

		

		if(in_array('1', Auth::user()->recursos))
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
	

		// Verifica se pode gravar
		if(!in_array('1', Auth::user()->recursos))
				return redirect(asset('/403')); //vai para acesso não autorizado
				//Validação dos requisitos
			$this->validate($request, [
				'nome'=>'required',
				'nascimento'=>'required',
				'genero'=>'required'				

			]);
		// Verifica se já tem alguem com mesmo nome e data de nascimento.
			$pessoanobd=Pessoa::where('nome', $request->nome)->where('nascimento',$request->nascimento)->get();
			if($pessoanobd->count()) 
				return $this->create(['Ops, parece que essa pessoa já está cadastrada no sistema. Encontrado alguém com o mesmo nome e mesma data de nascimento. Pode confirmar isso?']);
		// se preencheu o CPF
			if(isset($request->cpf))		 
			{
			//se o CPF já está no sistema
				$cpf_no_sistema=PessoaDadosGerais::where('dado','3')->where('valor',$request->cpf)->get();
				if ($cpf_no_sistema->count()) 
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
			$pessoa->por=  Auth::user()->pessoa;
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
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->rg);
				$pessoa->dadosContato()->save($info);
			}
			if($request->cpf != '')
			{
				$info=new PessoaDadosGerais;					
				$info->pessoa=$pessoa->id;
				$info->dado=3;
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->cpf);
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
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->telefone);
				$pessoa->dadosContato()->save($info);
			}

			if($request->tel2 != '')
			{
				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=9; 
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->tel2);
				$pessoa->dadosContato()->save($info);
			}

			if($request->tel3 != '')
			{
				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=10; 
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->tel3);
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
					if($endereco->bairro == 0)
						$endereco->bairro_str=$request->bairro_str;
					$endereco->cidade=mb_convert_case($request->cidade, MB_CASE_UPPER, 'UTF-8');
					$endereco->estado=$request->estado;
					$endereco->cep=preg_replace( '/[^0-9]/is', '',$request->cep);
					$endereco->atualizado_por=  Auth::user()->pessoa;
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
				$info->dado='necessidade_especial'; 
				$info->valor=mb_convert_case($request->necessidade_especial, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}					
			if($request->medicamentos != '')
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado='medicamento'; 
				$info->valor=mb_convert_case($request->medicamentos, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}
			if($request->alergias != '')
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado='alergia'; 
				$info->valor=mb_convert_case($request->alergias, MB_CASE_UPPER, 'UTF-8');
				$pessoa->dadosClinicos()->save($info);
			}
			if($request->doenca_cronica != '')
			{
				$info=new PessoaDadosClinicos;					
				$info->pessoa=$pessoa->id;
				$info->dado='doenca'; 
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
		if($pessoa->id !=   Auth::user()->pessoa)
		{
		//verifica se pode ver outras pessoas
			if(!in_array('4', Auth::user()->recursos))
					return view('error-404-alt')->with(array('error'=>['id'=>'403.41','desc'=>'Seu cadastro não permite que você veja os dados de outra pessoa']));
					//return $this->listar();	
			// verifica se a pessoa tem relação institucional
				$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
				if($relacao_institucional && !in_array('5', Auth::user()->recursos))
				{
					return view('error-404-alt')->with(array('error'=>['id'=>'403.5','desc'=>'Você não possui acesso a dados de pessoas ligadas à instituição.']));		
				}
			// Verifica se a pessoa tem perfil privado.
				$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
				if($pessoa_restrita && !in_array('6', Auth::user()->recursos))
					return view('error-404-alt')->with(array('error'=>['id'=>'403.6','desc'=>'Esta pessoa possui restrição de acesso aos seus dados']));	

		}
	
		$pessoa=$this->formataParaMostrar($pessoa);

		return $pessoa;
	}

	public function mostrar($id)
	{	
		
		$pessoa=$this->dadosPessoa($id);

		//return $pessoa;
		//return redirect(asset('/secretaria/atender/'.$id));

		$pessoa->cpf = \App\classes\Strings::mask($pessoa->cpf,'###.###.###-##');
		$pessoa->rg = \App\classes\Strings::mask($pessoa->rg,'##.###.###-##');
		$atestados = \App\Atestado::where('pessoa',$pessoa->id)->get();
		$atendimentos = \App\Atendimento::where('usuario', $pessoa->id)->orderBy('created_at','desc')->get();
		$contatos = \App\Contato::where('para',$pessoa->id)->get();
		$perfil = PessoaDadosGerais::where('dado',26)->where('pessoa',$pessoa->id)->first();
		return view('pessoa.mostrar',compact('pessoa'))->with('atestados',$atestados)->with('atendimentos',$atendimentos)->with('contatos',$contatos)->with('perfil',$perfil);

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

		$pessoa->dadosClinicos = PessoaDadosClinicos::where('pessoa',$pessoa->id)->get();

		foreach($pessoa->dadosClinicos as $dado){
			$nomedado = $dado->dado;
			$pessoa->$nomedado = $dado->valor;
		}
		//dd($pessoa);
		
		
		foreach( $pessoa->dadosAdministrativos->all() as $dado){

			//$tipoDado=TipoDado::find($dado['dado'])->tipo;
			$pessoa->$dado = $dado['dado'];
		}
		/*
		foreach( $pessoa->dadosAcademicos->all() as $dado){
			$tipoDado=$dado['dado'];
			$pessoa->$tipoDado=$dado['valor'];
		}*/
		
		
		
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
		$pessoa->idade= $pessoa->getIdade();
		//$pessoa->aniversario=$pessoa->nascimento;
		$pessoa->nascimento=Data::converteParaUsuario($pessoa->nascimento);
		

		$pessoa->cadastro=Data::converteParaUsuario($pessoa->created_at). "  Cadastrad".Pessoa::getArtigoGenero($pessoa->genero).' por '. Pessoa::getNome($pessoa->por);

		$username=PessoaDadosAcesso::where('pessoa',$pessoa->id)->first();
		if($username)
			$pessoa->username=$username->usuario;

		if(isset($pessoa->cpf)){;
			if(Strings::validaCPF($pessoa->cpf) == false){
				NotificacaoController::notificarErro($pessoa->id,1);
				$pessoa->cpf = null;
			}
		}	



		if(isset($pessoa->endereco)){
			$endereco=Endereco::find($pessoa->endereco);
			if($endereco){
				$pessoa->end_id=$endereco->id;
				$pessoa->logradouro=$endereco->logradouro;
				$pessoa->end_numero=$endereco->numero;
				$pessoa->bairro=$endereco->getBairro();
				$pessoa->id_bairro=$endereco->bairro;
				$pessoa->end_complemento=$endereco->complemento;
				$pessoa->cidade=$endereco->cidade;
				$pessoa->estado=$endereco->estado;
				$pessoa->cep=Strings::mask(preg_replace( '/[^0-9]/is', '',$endereco->cep),'#####-###');
				$pessoa->bairro_alt=$endereco->bairro_str;
			}
		}
		
		//dd($pessoa);
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
		

		if(!in_array('4', Auth::user()->recursos))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.42','desc'=>'Seu cadastro não permite que você veja os dados de outras pessoas']));

		$pessoas=Pessoa::orderBy('nome','ASC')->paginate(35);
		foreach($pessoas->all() as $pessoa)
		{
			$pessoas->$pessoa=$this->formataParaMostrar($pessoa);
		}
		return view('pessoa.listar-todos', compact('pessoas'));
	}


	
	public function procurarPessoas($termo)
	{		
		if(isset($termo))
			$pessoas=Pessoa::leftjoin('pessoas_dados_gerais', 'pessoas.id', '=', 'pessoas_dados_gerais.pessoa')
							->where('pessoas.id',$termo)
							->orwhere('nome', 'like', "%".$termo."%")
							->orwhere('nascimento', 'like', '%'.$termo."%")
							->orwhere('pessoas_dados_gerais.valor', 'like', '%'.$termo."%")					
							->orderby('nome')								
							->groupBy('pessoas.id')							
							->select('pessoas.id','pessoas.nome','pessoas.nascimento','pessoas.genero')
							->paginate(35);
	
					
		foreach($pessoas->all() as $pessoa){
			$pessoas->$pessoa=$this->formataParaMostrar($pessoa);
			$pessoa->nome=Strings::converteNomeParaUsuario($pessoa->nome);
			//$pessoa->nascimento=Data::converteParaUsuario($pessoa->nascimento);
			$pessoa->numero=str_pad($pessoa->id,7,"0",STR_PAD_LEFT);
		}
		return $pessoas;
	}


	public function procurarPessoasAjax(Request $r){
		$pessoas = $this->procurarPessoa($r->queryword);
		if($pessoas)
			return view('pessoa.listar-todos', compact('pessoas'));
		else
			return $this->listarTodos();

	}


	public function liveSearchPessoa($query='')
	{
		$pessoas=Pessoa::leftjoin('pessoas_dados_gerais', 'pessoas_dados_gerais.pessoa', '=', 'pessoas.id')
						->where('pessoas.id',$query)
						->orwhere('nome', 'like', "%".$query."%")
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
		

		if(in_array('8', Auth::user()->recursos))
			return view('pessoa.cadastrar-acesso');
		else
			return view('error-404-alt')->with(array('error'=>['id'=>'403.8','desc'=>'Você não pode cadastrar usuários no sistema.']));
	}

	public function gravarUsuario(Request $request)
	{
		$this->validate($request, [
				'username'=>'required|min:3|max:10',
				'senha'=>'required|min:6',
				'retsenha'=>'required|same:senha'
				]);
		return "ok";	
	}

	
	public function editarGeral_view($id){
		

		
		if(!in_array('3', Auth::user()->recursos) && $id != Auth::user()->pessoa)
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));


		$dados=$this->dadosPessoa($id);
		//return $dados;
		if(isset($dados['genero']) ){
				
				switch ($dados['genero']) {
					case 'M':
						$dados['generom']="checked";
						break;
					case 'F':
						$dados['generof']="checked";
						break;
					case 'X':
						$dados['generox']="checked";
						break;
					case 'Y':
						$dados['generoy']="checked";
						break;
					case 'Z':
						$dados['generoz']="checked";
						break;
				}
		}

		$dados['cpf'] =  \App\classes\Strings::mask($dados['cpf'] ,'###.###.###-##');
		//dd($dados['genero']);
		return view('pessoa.editar-dados-gerais', compact('dados'));
	}
	public function editarGeral_exec(Request $request){
		$erros=array();
		
		if(!in_array('3', Auth::user()->recursos) && $request->pessoa != Auth::user()->pessoa)
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
		$erros[] = " Nome, nascimento e gênero gravados com sucesso,";
		if($request->rg!='' || $request->rg!=$dados_atuais->rg){

			$rg=new PessoaDadosGerais;
			$rg->pessoa=$pessoa->id;
			$rg->dado=4;
			$rg->valor=preg_replace( '/[^0-9]/is', '',$request->rg);
			$rg->save();
			$erros[] = " RG gravado com sucesso,";

			
		}
		//******************************************************


		if($request->cpf!='' || $request->cpf!=$dados_atuais->cpf )
		{	
			if($request->cpf==''){
				$dado = PessoaDadosGerais::where('dado',3)->where('pessoa',$request->pessoa)->first();
				$dado->delete();
				$pessoa->alert_sucess.=" CPF gravado com sucesso.";

			}else{

				if (!Strings::validaCPF($request->cpf)) 
				{
					$erros[] = " Erro ao gravar CPF: valor informado não é válido.";
					
				}
				elseif(PessoaDadosGerais::where('dado',3)->where('valor', $request->cpf)->where('pessoa','!=',$request->pessoa)->first()){
					$erros[] = " Erro ao gravar CPF: já consta no cadastro de outra pessoa.";
				}
				else{
			
					$cpf=new PessoaDadosGerais;
					$cpf->pessoa=$pessoa->id;
					$cpf->dado=3;
					$cpf->valor=preg_replace( '/[^0-9]/is', '',$request->cpf);
					$cpf->save();
					$erros[] = " CPF gravado com sucesso,";
				}

			}
			

		}
		else{
			if($request->cpf==''){
				$dado = PessoaDadosGerais::where('dado',3)->where('pessoa',$request->pessoa)->first();
				if($dado)
					$dado->delete();
				$erros[] = " CPF gravado com sucesso,";

			}
		}


		//************************************************************
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
		return redirect()->back()->withErrors($erros);
	}
	public function editarContato_view($id){


		
		if(!in_array('3', Auth::user()->recursos) && $id != Auth::user()->pessoa)
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!in_array('4', Auth::user()->recursos) && $id != Auth::user()->pessoa)
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));
		

		$bairros=DB::table('bairros_sanca')->get(); 
		$dados=$this->dadosPessoa($id);
		$dados->bairros=$bairros;

		
		//return $dados;
				
		return view('pessoa.dados-contato.editar-dados-contato', compact('dados'));
	}
	public function editarContato_exec(Request $request){
		
		if(!in_array('3', Auth::user()->recursos) && $request->pessoa != Auth::user()->pessoa)
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Desculpe, você não possui autorização para alterar dados de outras pessoas']));

		if(!in_array('4', Auth::user()->recursos) && $request->pessoa != Auth::user()->pessoa)
			return view('error-404-alt')->with(array('error'=>['id'=>'403.4','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel.']));

	
		$pessoa=Pessoa::find($request->pessoa);
		if(!$pessoa){
			return redirect(asset("/pessoa/listar/"))->withErrors(['Erro ao localizar código de pessoa.']);
		}
		$dadosAtuais=$this->dadosPessoa($request->pessoa);
		//dd($dadosAtuais);

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
				$info->valor=preg_replace( '/[^0-9]/is', '',$request->telefone);
				$pessoa->dadosContato()->save($info);
			}

			if($request->tel2 != '' || $request->tel2 != $dadosAtuais->telefone_celular)
			{
				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=9; 
				$info->valor=preg_replace( '/[^0-9]/is', '',$request->tel2);
				$pessoa->dadosContato()->save($info);
			}

			if($request->tel3 != '' || $request->tel3!= $dadosAtuais->telefone_contato)
			{
				$info=new PessoaDadosContato;					
				$info->pessoa=$pessoa->id;
				$info->dado=10; 
				$info->valor=preg_replace( '/[^0-9]/is', '',$request->tel3);
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
					$endereco->cep=preg_replace( '/[^0-9]/is', '',$request->cep);
					$endereco->atualizado_por=Auth::user()->pessoa;
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
		return redirect()->back()->withErrors(['Alterções salvas com sucesso.']);
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
		return redirect()->back()->withErrors(['Alterções salvas com sucesso.']);

	}
	public function remVinculo_exec($vinculo)
	{
		$vinculo=PessoaDadosGerais::find($vinculo);
		$pessoa=$vinculo->pessoa;
		$vinculo->delete();
		
		return redirect()->back()->withErrors(['Alterções salvas com sucesso.']);

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
		if(!in_array('3', Auth::user()->recursos))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel. O código de pessoa também pode ser inválido']));

		$nome = Pessoa::getNome($id);
		if(!$nome)
			return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Pessoa não encontrada']));


		return view('gestaopessoal.relacao-institucional')->with('nome',$nome)->with('id',$id);



	}
	public function relacaoInstitucional_exec(Request $request){
		
		if(!in_array('3', Auth::user()->recursos))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($request->pessoa))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional, não está acessivel ou não existe.']));
		/*
		$rel_atual=PessoaDadosAdministrativos::where('pessoa',$request->pessoa)->where('dado',16)->first();

		if($rel_atual)
			$rel_atual->delete();
		*/
		$nova_relacao=new PessoaDadosAdministrativos;
		//$nova_relacao->timestamps=false;
		$nova_relacao->dado=16;
		$nova_relacao->pessoa=$request->pessoa;
		$nova_relacao->valor=$request->cargo;
		$nova_relacao->save();




		return redirect(asset('gestaopessoal/atender').'/'.$request->pessoa);



	}
	
	public function iniciarRecadastramento(Request $rq){
		$dado = PessoaDadosGerais::where('dado',3)->where('valor',preg_replace( '/[^0-9]/is', '',$rq->cpf))->get();
		if($dado->count()>0){
			$pessoa = \App\Pessoa::find($dado->first()->pessoa);
			if(is_null($pessoa))
				return redirect($_SERVER['HTTP_REFERER'])->withErrors(['CPF encontrado sem vínculos no sistema. Tente inserir o RG. Caso já tenha inserido, procure a secretaria.']);
			
			return view('pessoa.recadastrar')->with('pessoa',$this->formataParaMostrar($pessoa));
		}
		else{
			$dado = PessoaDadosGerais::where('dado',4)->where('valor',preg_replace( '/[^0-9]/is', '',$rq->cpf))->get();
			if($dado->count()>0){
				$pessoa = \App\Pessoa::find($dado->first()->pessoa);
				if(is_null($pessoa))
					return redirect($_SERVER['HTTP_REFERER'])->withErrors(['RG encontrado sem vínculos no sistema. Tente inserir o CPF. Caso já tenha inserido, procure a secretaria.']);
				return view('pessoa.recadastrar')->with('pessoa',$this->formataParaMostrar($pessoa));

			} 
			else
				return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Desculpe, mas o RG/CPF '.preg_replace( '/[^0-9]/is', '',$rq->cpf).' não foi encontrado. Tente novamente.']);
		}
	}
	public function gravarRecadastro(Request $request){
			$pessoa = Pessoa::find($request->pessoa);

			$pessoa->nome=mb_convert_case($request->nome, MB_CASE_UPPER, 'UTF-8');
			$pessoa->nascimento=\Carbon\Carbon::createFromFormat('d/m/Y', $request->nascimento, 'Europe/London')->format('Y-m-d');
			$pessoa->genero=$request->genero;

			
			$pessoa->save();//
		//**************** Dados Gerais


			if($request->rg != '')
			{
				$dado = PessoaDadosGerais::where('pessoa',$pessoa->id)->where('dado',4)->get();
				if($dado->count()== 0)
					$info=new PessoaDadosGerais;
				else
					$info = $dado->first();					
				$info->pessoa=$pessoa->id;
				$info->dado=4; 
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->rg);
				$info->save();
				$pessoa->rg = $info->valor;
			}

			
			if($request->cpf != '')
			{
				$dado = PessoaDadosGerais::where('pessoa',$pessoa->id)->where('dado',3)->get();
				if($dado->count()== 0)
					$info=new PessoaDadosGerais;
				else
					$info = $dado->first();
				if(Strings::validaCPF($request->cpf) == false){
					return 'Desculpe, mas o CPF '.preg_replace( '/[^0-9]/is', '',$request->cpf).' não é valido em nosso sistema. Volte e tente novamente.';
				}					
				$info->pessoa=$pessoa->id;
				$info->dado=3;
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->cpf);
				$info->save();
				$pessoa->cpf = $info->valor;
			}

	
		//**************** Dados Contato
			if($request->email != '')
			{
				$dado = PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',1)->get();
				if($dado->count()== 0)
					$info=new PessoaDadosContato;
				else
					$info = $dado->first();						
				$info->pessoa=$pessoa->id;
				$info->dado=1; 
				$info->valor=mb_convert_case($request->email, MB_CASE_LOWER, 'UTF-8');
				$info->save();
				$pessoa->email = $info->valor;
			}

			if($request->telefone != '')
			{
				$dado = PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',2)->get();
				if($dado->count()== 0)
					$info=new PessoaDadosContato;
				else
					$info = $dado->first();					
				$info->pessoa=$pessoa->id;
				$info->dado=2; 
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->telefone);
				$info->save();
				$pessoa->telefone = $info->valor;
			}

			if($request->tel2 != '')
			{
				$dado = PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',9)->get();
				if($dado->count()== 0)
					$info=new PessoaDadosContato;
				else
					$info = $dado->first();						
				$info->pessoa=$pessoa->id;
				$info->dado=9; 
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->tel2);
				$info->save();
				$pessoa->celular = $info->valor;
			}

			if($request->tel3 != '')
			{
				$dado = PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',10)->get();
				if($dado->count()== 0)
					$info=new PessoaDadosContato;
				else
					$info = $dado->first();						
				$info->pessoa=$pessoa->id;
				$info->dado=10; 
				$info->valor=preg_replace( '/[^0-9]/is', '', $request->tel3);
				$info->save();
				$pessoa->contato = $info->valor;
			}
			//se tiver vincular
			if($request->rua != '')
			{
				$dado = PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',6)->get();
				if($dado->count()== 0){
					$info=new PessoaDadosContato;
					$endereco=new Endereco;	
				}
				else{
					$info = $dado->first();	
					$endereco=Endereco::find($info->valor);	
				}				
					$endereco->logradouro =mb_convert_case($request->rua, MB_CASE_UPPER, 'UTF-8'); 
					$endereco->numero=$request->numero_endereco;
					$endereco->complemento=mb_convert_case($request->complemento_endereco, MB_CASE_UPPER, 'UTF-8');
					$endereco->bairro=$request->bairro;
					$endereco->cidade=mb_convert_case($request->cidade, MB_CASE_UPPER, 'UTF-8');
					$endereco->estado=$request->estado;
					$endereco->cep=preg_replace( '/[^0-9]/is', '',$request->cep);
					$endereco->atualizado_por=Auth::user()->pessoa;
					$endereco->save();
					$id_endereco=$endereco->id;
					$endereco->bairro_str = $request->bairro_str;
					$pessoa->endereco = $endereco;
				


					
				$info->pessoa=$pessoa->id;
				$info->dado=6; 
				$info->valor=$id_endereco;
				$info->save();

				//return $endereco;
			}
			
				
			//seleciona todas natriculas
			$matriculas = \App\Matricula::Where('pessoa',$pessoa->id)->Where(function($query) {
            $query->where('status','ativa')->orWhere('status','pendente');
        	})->get();
			//para cara matricula pegar as inscrições
			foreach($matriculas as $matricula){
				$inscri=\App\Inscricao::where('matricula',$matricula->id)->where('status','like','regular')->get();
				$matricula->inscri = $inscri;
				
			}
			//dd($matriculas);


			//cria registro de REMATRICULADO 2018
			$info = new PessoaDadosGerais;
			$info->pessoa=$pessoa->id;
			$info->dado=22;
			$info->valor=date('d/m/Y H:i');
			$info->save();

			//manda para view termos de matricula em lote
			//return $pessoa;
			return view('juridico.documentos.termos-lote')->with('matriculas',$matriculas)->with('pessoa',$pessoa);
	}
	public function listarFuncionarios(){ // lista pessoas com relação institucional (RI)
		$com_ri = PessoaDadosAdministrativos::select('pessoa')->where('dado',16)->groupBy('pessoa')->get();
		$pessoas = Pessoa::whereIn('id',$com_ri)->orderBy('nome')->paginate(50);
		foreach($pessoas as $pessoa){
			$pessoa->cargo = PessoaDadosAdministrativos::where('pessoa',$pessoa->id)->where('dado',16)->first()->valor;
			$telefone = PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',2)->first();
			if($telefone)
			 $pessoa->telefone = Strings::formataTelefone($telefone->valor);
			else
			 $pessoa->telefone = "Necessita de atualização";	
		}
		return view('gestaopessoal.listarusuarios')->with('pessoas',$pessoas);
	}
	public function apagarAtributo($id){
		PessoaDadosGerais::destroy($id);
		return redirect()->back();
	}
	public function apagarPendencia($id){
		$pendencia = \App\PessoaDadosAdministrativos::find($id);
		PessoaDadosAdminController::liberarPendencia($pendencia->pessoa,$pendencia->valor);
		return redirect()->back();
	}

	/**
	 * Cadastra as pessoas diretamente por função;
	 * @param [$nome] Nome da pessoa
	 * @param[$genero] Como a pessoa gostaria de ser tratada
	 * @param[$nascimento] Data de nascimento da pessoa
	 */
	public static function cadastrarPessoa($nome, $genero, \DateTime $nascimento){
		$pessoa = new Pessoa;
			$pessoa->nome=mb_convert_case($nome, MB_CASE_UPPER, 'UTF-8');
			$pessoa->nascimento = $nascimento->format('Y-m-d');
			$pessoa->genero = $genero;
			$pessoa->por = \Auth::user()->pessoa;
			$pessoa->save();
		return $pessoa;

	}

	/**
	 * Relatorio com os alunos ativos com seus respectivos numeros de celular
	 */
	public function relatorioCelulares(){
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=celulares.csv');
		$output = fopen('php://output', 'w');
		fputcsv($output, array('Id', 'Nome', 'Celular'));

		$subscriptions = \App\Inscricao::where('status','regular')->get();
		$alumns = collect();
		foreach($subscriptions as $subscripted){
			
			$contains = $alumns->where('id',$subscripted->pessoa->id);
			
			if($contains->count()==0){
				$alumn = new \stdClass;
				$alumn->id = $subscripted->pessoa->id;
				$alumn->name = $subscripted->pessoa->nome_simples;
				$alumn->cellphone = $subscripted->pessoa->getCelular();
				if($alumn->cellphone != '-'){
					//$alumns->add($alumn);
					fputcsv($output,[$alumn->id,$alumn->name,$alumn->cellphone]);
				}

			}
				
			

		}
		return 'gerado.';
	}



	





	
}
