<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;// coloca classe email
use App\PessoaDadosAcesso;
use App\PessoaDadosContato;
use App\Mail\recuperarSenha;
use App\classes\keygen;
use Session;

class loginController extends Controller
{
    //Classe de tratamento exclusivo de Login


	/*
	Metodo de fazer o login - deverá ser futuramente ser trocado pelo Auth
	*/
    public function loginCheck(Request $request){
		$this->validate($request, [
			'login'=>'required|between:3,30|alpha_num',
			'senha'=>'required|between:6,30|alpha_num'

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
						Session::put('sge_fesc_logged','yes');
						Session::put('usuario',$usuario->pessoa);
						return redirect('/');

					}
				}
			}	

		}
	}

	//metodo mostrar a view de esqueci minha senha
	public function viewPwdRescue(){
		return view('login_esqueci_senha');
	}

	//metodo acionado depois do usuário clicou em  "pedir uma nova senha".
	public function pwdRescue(Request $request){
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
			//Mail::to($usuario->valor)->send(new recuperarSenha($senha)); //Envia email
			$erros_bd= ['Desculpe, este recurso ainda está em desenvolvimento. Contate a FESC para reiniciar sua senha.'];
			return view('login_esqueci_senha', compact('erros_bd'));







		}		

	}

	//metodo acionado para encerrar a sessão do usuário
	public function logout(){
		Session::flush();
		return redirect('/');
	}

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
}
