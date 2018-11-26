<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;// coloca classe email
use App\Pessoa;
use App\RecursoSistema;
use App\PessoaDadosAcesso;
use App\PessoaDadosContato;
use App\ControleAcessoRecurso;
use App\Mail\recuperarSenha;
use App\classes\keygen;
use App\classes\Strings;
use App\classes\Data;
use Session;

class loginController extends Controller
{
    //Classe de tratamento exclusivo de Login


	/*
	Metodo de fazer o login - deverá ser futuramente ser trocado pelo Auth
	*/
	public static function login(){
		
		/*if(isset($_COOKIE['sge_token'])){

			$usuario=PessoaDadosAcesso::where('remember_token',$_COOKIE['sge_token'])->first();
			dd($usuario);
			if(count($usuario)==1){
				$pessoa= Pessoa::where('id',$usuario->pessoa)->first();
				return view('login')->with('nome', $pessoa->nome_simples);
			}
			else{
				unset($_COOKIE['sge_token']);
				return redirect()->back();

			}

		}*/
		return view('login');
	}
	public function loginSaved(){
		$usuario=PessoaDadosAcesso::where('remember_token',$_COOKIE['sge_token'])->first();
		Session::put('sge_fesc_logged','yes');
		Session::put('usuario',$usuario->pessoa);
		$pessoa=Pessoa::where('id',$usuario->pessoa)->first();
		Session::put('nome_usuario', $pessoa->nome_simples);	
		return redirect(asset('/'));

	}

	public function recuperarConta($given_token){
		$usuario=PessoaDadosAcesso::where('remember_token', urldecode($given_token))->first();
		if($usuario)
			return view('change-password')->with('token',urldecode($given_token));
		else
			return "Token inválida";


	}
	public function recuperarContaExec(Request $r){
		$this->validate($request, [
			'senha'=>'required|between:6,30',
			'contrasenha'=>'required|same:senha'

		]);
		$usuario=PessoaDadosAcesso::where('remember_token', $r->token)->first();
		if($usuario){
			$usuario->senha=Hash::make($r->novasenha);
			$usuario->save();
			return $this->logout();
		}
		else
			return "Token inválida";

	}
    public function loginCheck(Request $request)
    {
		$this->validate($request, [
			'login'=>'required|between:4,30',
			'senha'=>'required|between:6,30'

		]);

		/*
		Session::put('sge_fesc_logged','yes');
		return redirect('/');*/


		$usuario=PessoaDadosAcesso::where('usuario',$request->login)->first();

		if(count($usuario) == 0){
			$erros_bd = ['O usuário fornecido não está cadastrado.'];
			return view('login',compact('erros_bd')); 
		}
		else{
			if(!Hash::check($request->senha,$usuario->senha)){
			$erros_bd = ['Desculpe, senha incorreta.'];	
			return view('login',compact('erros_bd')); 
			}
			else{
				if($usuario->status == 0){
					$erros_bd = ['Desculpe, seu cadastro foi desativado. Contate-nos.'];	
					return view('login',compact('erros_bd')); 

				}
				else{
					if($usuario->validade < date('Y-m-d')){
						$erros_bd = ['Desculpe, seu acesso está vencido. Contate-nos.'];	
						return view('login',compact('erros_bd')); 

					}
					else{
						if(isset($request->lembrar_senha)){
							$custo=11;
							$salt='BpuKl267TczRgPlkm7R6VV';
							$hash=crypt($request->login,'$2a$'.$custo.'$'.$salt.'$');
							setcookie('sge_token',$hash,time()+3600*24*7);
							$usuario->remember_token=$hash;
							$usuario->save();

						}
						else{
							if(isset($_COOKIE['sge_token']))
								setcookie('sge_token');
						}
						Session::put('sge_fesc_logged','yes');
						Session::put('usuario',$usuario->pessoa);

						$usuario = Pessoa::where('id',$usuario->pessoa)->first();
            			$array_nome = explode(' ',$usuario->nome);
            			$nome=$array_nome[0].' '.end($array_nome);
						Session::put('nome_usuario', $nome);

						$recursos = ControleAcessoRecurso::where('pessoa', $usuario->id)->get();
						Session::put('recursos_usuario', serialize($recursos));

						return redirect(asset('/'));

					}
				}
			}	

		}
	}

	//metodo mostrar a view de esqueci minha senha
	public function viewPwdRescue()
	{
		return view('login_esqueci_senha');
	}

	/**
	 * Metodo acionado depois do usuário clicou em  "pedir uma nova senha".*/
	public function pwdRescue(Request $request)
	{
		$this->validate($request, [
			'email'=>'required|email'
			]);

		$usuario=PessoaDadosContato::where([
			['dado','=','1'], //dado 1 na tabela tipos_dados = email
			['valor','like',$request->email],
			])->get()->first();

		if(count($usuario) == 0){
			$erros_bd= ['Desculpe, mas esse e-mail não consta em nosso cadastro.'];
			return view('login_esqueci_senha', compact('erros_bd'));
		}
		else{

			$novasenha = keyGen::generate();
			Mail::to($usuario->valor)->send(new recuperarSenha($usuario->pessoa)); //Envia email
			$erros_bd= ['Acesse seu email para recuperar o acesso à sua conta.'];
			return view('login_esqueci_senha', compact('erros_bd'));
		}		
	}

	/**
	 * Encerra todas sessões */
	public function logout()
	{
		Session::flush();
		return redirect('/');
	}
/*
	//Metodo para adicionar o primeiro registro no BD vem pela route /addpessoa
	public function addPrimeiro(){
		$user= new PessoaDadosAcesso;
		$user->pessoa = 1;
		$user->usuario = 'adauto';
		$user->senha=Hash::make('123456');
		$user->validade = '2017-08-10';
		$user->status = 1;
		$user->save();

		return 'Acesso ao usuário 1 ativado';

	}
*/

	/**
	 * Checa se houve o login */
	public static function check()
	{
		if(Session::has('sge_fesc_logged') && Session::get('usuario')>0)
    		return True;
    	else
    		return False;
	}

	public static function pedirPermissao($recurso){

        $query=ControleAcessoRecurso::where('pessoa', Session::get('usuario'))
                                    ->where('recurso', $recurso)->first();
        
        if(count($query))
            return True;
        else
            return False;

    }
    public static function autorizarDadosPessoais($pessoa){
    	$pessoa=Pessoa::find($pessoa);
		// Verifica se a pessoa existe
		if(!$pessoa)
			return False;

		// Verifica se o perfil não é proprio
		if($pessoa->id != Session::get('usuario'))
		{
		//verifica se pode ver outras pessoas
			if(!loginController::pedirPermissao(4))			
				return false;	
		// verifica se a pessoa tem relação institucional
			$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
			if($relacao_institucional && !loginController::pedirPermissao(5))
			{
				return false;	
			}
		// Verifica se a pessoa tem perfil privado.
			$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
			if($pessoa_restrita && !loginController::pedirPermissao(6))
				return false;
		// ja verifiquei tudo pode liberar
			return True;	

		}
		else
			return True;
    }

	public function trocarMinhaSenha_view()
	{
		if(!loginController::check())
			return redirect(asset("/"));
		else
		return view('pessoa.trocar-senha');
	}

	/**
	 * Efetua a troca da senha */
	public function trocarMinhaSenha_exec(Request $r)
	{
		if(!loginController::check())
			return redirect(asset("/"));
		if($r->userid != Session::get('usuario'))
			return $this->logout();
		$this->validate($r , [
			'novasenha'=>'required|between:6,10',
			'confirmanovasenha'=>'required|same:novasenha'
		]);
		$usuario=PessoaDadosAcesso::where('pessoa', Session::get('usuario'))->first();
		if(count($usuario)!=1){
			$erros_bd= ['Erro ao carregar dados de usuário.'];
			return view('pessoa.trocar-senha', compact('erros_bd'));
		}
		if(!Hash::check($r->senha, $usuario->senha))
		{
			$erros_bd= ['Senha anterior incorreta.'];
			return view('pessoa.trocar-senha', compact('erros_bd'));
		}
		else
		{	
			$usuario->senha= \Hash::make($r->novasenha);
			$usuario->save();
			return $this->logout();
		}
	}

	/**
	 * Mostra formulário de adicionar usuario ao sistema
	 * @param Integer id da pessoa que se quer criar o acesso */
	public function cadastrarAcesso_view($p)	
	{
		$pessoa=Pessoa::find($p);
		if(!count($pessoa))
		{
			$erros_bd= ['Código de pessoa inválido'];
			return view('pessoa.cadastrar-acesso', compact('erros_bd'));
		}
		$acesso=PessoaDadosAcesso::where('pessoa', $p)->first();
		if(count($acesso))
		{
			$erros_bd= ['Esta pessoa já possui login: '.$acesso->usuario];
			return view('pessoa.cadastrar-acesso', compact('erros_bd'));

		}
		
		$pessoa->nome=Strings::converteNomeParaUsuario($pessoa->nome);
		return view('pessoa.cadastrar-acesso',compact('pessoa'));
	}

	/**
	 * Grava usuário no sistema */	 
	public function cadastrarAcesso_exec(Request $request)
	{
		if(!$this->check())
			return redirect(asset("/"));
		$this->validate($request, [
			'nome_usuario'=>'required|between:4,20',
			'senha'=>'required|between:6,20',
			'repetir_senha'=>'required|same:senha',
			]);
		$acesso=PessoaDadosAcesso::where('usuario', $request->nome_usuario)->get();
		if(count($acesso)>0)
		{
			$erros_bd= ['Este nome de usuário já está em uso. '];
			return view('pessoa.cadastrar-acesso', compact('erros_bd'));
		}
		$novo=new PessoaDadosAcesso;

		$novo->usuario=mb_convert_case($request->nome_usuario, MB_CASE_LOWER, 'UTF-8');
		$novo->senha=Hash::make($request->senha);
		$novo->status=1;
		$novo->pessoa=$request->pessoa;
		if(!isset($request->validade))				
			$novo->validade=date('Y').'-12-31';
		else
			$novo->validade=$request->validade;
		$novo->save();

		$dados=['alert_sucess'=>['Usuario cadastrado com sucesso']];
		return view('pessoa.cadastrar-acesso', compact('dados'));
	}

	public function trocarSenhaUsuario_view($usuario)
	{
		if(!$this->check())
			return redirect(asset("/"));
		$pessoa=Pessoa::find($usuario);
		if(!count($pessoa))
		{
			$erros_bd= ['Código de pessoa inválido'];
			return view('pessoa.cadastrar-acesso', compact('erros_bd'));
		}
		$acesso=PessoaDadosAcesso::where('pessoa', $usuario)->first();
		if(count($acesso)==0)
		{
			$erros_bd= ['Este nome de usuário ainda não possui Login'];
			return view('pessoa.trocar-senha-usuario', compact('erros_bd'));
		}
		if(!$this->pedirPermissao(9))
		{
			$erros_bd= ['Desculpe, você não tem permissão para alterar senha de outras pessoas'];
			return view('pessoa.cadastrar-acesso', compact('erros_bd'));
		}
		$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
		if($relacao_institucional && !$this->pedirPermissao(10))
		{
			$erros_bd= ['Desculpe, você não tem permissão para alterar senha de pessoas ligadas à FESC'];
			return view('pessoa.cadastrar-acesso', compact('erros_bd'));	
		}
		$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
		if($pessoa_restrita && !$this->pedirPermissao(11))
		{
			$erros_bd= ['Desculpe, você não tem permissão para alterar senha de pessoas restritas'];
			return view('pessoa.cadastrar-acesso', compact('erros_bd'));
		}
		return view('pessoa.trocar-senha-usuario', compact('pessoa'));
	}

	public function trocarSenhaUsuario_exec(Request $request)
	{
		if(!$this->check())
			return redirect(asset("/"));

		$this->validate($request, [
			'pessoa'=>'required|integer',
			'nova_senha'=>'required|between:6,10',
			'repetir_senha'=>'required|same:nova_senha'
			]);
		$pessoa=Pessoa::find($request->pessoa);
		if(!count($pessoa))
		{
			$erros_bd= ['Código de pessoa inválido'];
			return view('pessoa.trocar-senha-usuario', compact('erros_bd'));
		}
		$acesso=PessoaDadosAcesso::where('pessoa', $request->pessoa)->first();
		if(count($acesso)==0)
		{
			$erros_bd= ['Este nome de usuário ainda não possui Login'];
			return view('pessoa.trocar-senha-usuario', compact('erros_bd'));
		}

		if(!$this->pedirPermissao(9))
		{
			$erros_bd= ['Desculpe, você não tem permissão para alterar senha de outras pessoas'];
			return view('pessoa.trocar-senha-usuario', compact('erros_bd'));
		}
		$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
		if($relacao_institucional && !$this->pedirPermissao(10))
		{
			$erros_bd= ['Desculpe, você não tem permissão para alterar senha de pessoas ligadas à FESC'];
			return view('pessoa.trocar-senha-usuario', compact('erros_bd'));	
		}
		$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
		if($pessoa_restrita && !$this->pedirPermissao(11))
		{
			$erros_bd= ['Desculpe, você não tem permissão para alterar senha de pessoas restritas'];
			return view('pessoa.trocar-senha-usuario', compact('erros_bd'));
		}
		if(!isset($request->validade))				
			$acesso->validade=date('Y').'-12-31';
		else
		{
			$this->validate($request,[
				'validade'=>'date'
				]);
			$acesso->validade=$request->validade;
		}
		$acesso->senha=Hash::make($request->nova_senha);
		$acesso->save();
		$dados=['alert_sucess'=>['Senha alterada com sucesso!']];

		return view('pessoa.trocar-senha-usuario', compact('dados'));

	}
	public function listarUsuarios_data($r='')
	{
		if(!$this->check())
			return redirect(asset("/"));

		if(!$this->pedirPermissao(10))			
				return view('error-404-alt')->with(array('error'=>['id'=>'403.10','desc'=>'Desculpe, você não tem autorização para listar os usuários.']));

		if($r=='')
			$usuarios=PessoaDadosAcesso::orderBy('usuario','ASC')->paginate(35);
		else
			$usuarios=PessoaDadosAcesso::where('usuario', 'like', '%'.$r.'%')->orderBy('usuario','ASC')->paginate(35);
		
		$dados=['usuarios'=> $usuarios];

		foreach($dados['usuarios'] as $usuario)
		{
			if(strtotime($usuario->validade) < strtotime(date('Y-m-d')))
				$usuario->status=2;

			switch($usuario->status){
				case 0:
				$usuario->status="Bloqueado";
				break;			
				case 1:
				$usuario->status="Ativado";
				break;
				case 2:
				$usuario->status="Vencido";
				break;


			}
			$usuario->nome=Pessoa::getNome($usuario->pessoa);
			$usuario->validade=Data::converteParaUsuario($usuario->validade);
		}
		return $dados;
		
	}

	public function listarUsuarios_view(Request $r = Request)
	{
		$dados=$this->listarUsuarios_data($r->buscar);
		return view('admin/listarusuarios', compact('dados'));	
	}

	public function alterar($acao,$itens)
	{
		if(!$this->check())
			return redirect(asset("/"));

		if(!$this->pedirPermissao(9))
		{
			$erros_bd= ['Desculpe, você não tem permissão para alterar dados de acesso de outras pessoas.'];
			return view('admin.listarusuarios', compact('erros_bd'));
		}


		$logins=explode(',',$itens);
		//$items=array_pop($logins);
		
		$filtered_login=[];
		foreach($logins as $l){
			if(is_numeric($l))
				array_push($filtered_login,$l);
		}

		switch($acao)
		{
			case 1: // Renovar a validade
				foreach ($filtered_login as $id_acesso){
					$acesso=PessoaDadosAcesso::find($id_acesso);
					if(!$acesso)
						return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Código de pessoa não encontrado. LoginController(442) ']));
					$pessoa=Pessoa::find($acesso->pessoa);
					if(!$pessoa)
						return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Código de pessoa não encontrado. LoginController(445) ']));
					$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
					if($relacao_institucional && !$this->pedirPermissao(10))
					{
						$dados['alert_warning'][]='Desculpe, você não tem permissão para alterar: '.$acesso->usuario.' por ser uma pessoa com relação institucional.';	
							
					}
					$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
					if($pessoa_restrita && !$this->pedirPermissao(11))
					{
						$dados['alert_warning'][]='Desculpe, você não tem permissão para alterar: '.$acesso->usuario.' por se tratar de uma pessoa de acesso restrito.';
						
					}
					
					$acesso->validade=date('Y').'-12-31';
					$acesso->save();
					$dados['alert_sucess'][]= $acesso->usuario." alterado com sucesso.";


				}
				$dados=array_merge($dados,$this->listarUsuarios_data());
				return view('admin.listarusuarios', compact('dados'));
			break;
			case 2: // Ativar acesso
				foreach ($filtered_login as $id_acesso){
					$acesso=PessoaDadosAcesso::find($id_acesso);
					if(!$acesso)
						return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Código de pessoa não encontrado. LoginController(742) ']));
					$pessoa=Pessoa::find($acesso->pessoa);
					if(!$pessoa)
						return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Código de pessoa não encontrado. LoginController(475) ']));
					$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
					if($relacao_institucional && !$this->pedirPermissao(10))
					{
						$dados['alert_warning'][]='Desculpe, você não tem permissão para alterar: '.$acesso->login.' por ser uma pessoa ligada à FESC';	
					}
					$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
					if($pessoa_restrita && !$this->pedirPermissao(11))
					{
						$dados['alert_warning'][]='Desculpe, você não tem permissão para alterar: '.$acesso->login.' por se tratar de uma pessoa de acesso restrito';
					}
					$acesso->status=1;
					$acesso->save();
					$dados['alert_sucess'][]=$acesso->usuario." alterado com sucesso";
				}
				$dados=array_merge($dados,$this->listarUsuarios_data());
			
				return view('admin.listarusuarios', compact('dados'));
			break;
			case 3: // desativar acesso
				foreach ($filtered_login as $id_acesso)
				{
					$acesso=PessoaDadosAcesso::find($id_acesso);
					if(!$acesso)
						return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Código de pessoa não encontrado. LoginController(499) ']));
					$pessoa=Pessoa::find($acesso->pessoa);
					if(!$pessoa)
						return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Código de pessoa não encontrado. LoginController(502) ']));
					$relacao_institucional=count($pessoa->dadosAdministrativos->where('dado', 16));
					if($relacao_institucional && !$this->pedirPermissao(10))
					{
						$dados['alert_warning'][]='Desculpe, você não tem permissão para alterar: '.$acesso->login.' por ser uma pessoa ligada à FESC';	
					}
					$pessoa_restrita=count($pessoa->dadosGerais->where('dado',17));
					if($pessoa_restrita && !$this->pedirPermissao(11))
					{
						$dados['alert_warning'][]='Desculpe, você não tem permissão para alterar: '.$acesso->login.' por se tratar de uma pessoa de acesso restrito';
					}
					$acesso->status=0;
					$acesso->save();
					$dados['alert_sucess']=[$acesso->usuario." alterado com sucesso"];
					}
				$dados=array_merge($dados,$this->listarUsuarios_data());
				return view('admin.listarusuarios', compact('dados'));
				break;
		}// end switch
	}//end alterar()
	public function credenciais_view($id,$msg=''){
		$pessoa=Pessoa::find($id);
		if(!$pessoa)
			return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Código de pessoa não encontrado. LoginController(525) ']));
		$recursos_usuario=ControleAcessoRecurso::where('pessoa',$id)->get();
		$dados=RecursoSistema::all();
		foreach($dados->all() as $recurso){
			foreach($recursos_usuario as $recurso_usuario){
				if($recurso_usuario->recurso==$recurso->id)
					$recurso->checked='checked';
			}

		}
		//return $dados;
		$pessoa->alert_sucess=$msg;


		return view('gestaopessoal.credenciais', compact('dados'))->with('pessoa',$pessoa);

	}
	public function credenciais_exec(Request $request){

		$login=PessoaDadosAcesso::where('pessoa',$request->pessoa);
		if(!$login)
			return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Nenhum login vinculado à essa pessoa. LoginController(545) ']));
		$recursos_atuais=ControleAcessoRecurso::where('pessoa', $request->pessoa)->get();
		foreach($recursos_atuais->all() as $recurso_atual){
			$recurso_atual->delete();
		}

		if(is_array($request->recurso)){
			foreach($request->recurso as $item){
				$novo_recurso= new ControleAcessoRecurso;
				$novo_recurso->timestamps=false;
				$novo_recurso->pessoa=$request->pessoa;
				$novo_recurso->recurso=$item;
				$novo_recurso->save();
			}
		}
		

		return $this->credenciais_view($request->pessoa,'Credenciais atualizadas' );






	}

}
