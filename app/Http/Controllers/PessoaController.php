<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class PessoaController extends Controller
{
    //
    public function adicionaPrimeiro(){
		

	}
	public function listaTodos(){

	}
	public function adiciona(){

	}
	public function mostra($id){

	}
	public function edita($id){

	}
	public function apaga($id){

	}
	public function loginCheck(Request $request){
		$this->validate($request, [
			'login_name'=>'required|between:3,30|alpha_num',
			'login_pwd'=>'required|between:6,30|alpha_num'

		]);
		/*

		Session::put('sge_fesc_logged','yes');
		return redirect('/');
*/

		$usuario=Pessoa->Pessoa_dados_acesso::where('usuario',$request->login_name)->first();

		if(count($usuario) == 0){
			$erros_bd = ['O usuário fornecido não está cadastrado.'];
			return view('login',compact('erros_bd')); //chama login com a mensagem 
		}
		else{
			if(!Hash::check($request->login_pwd,$usuario->senha)){
			$erros_bd = ['Desculpe, senha incorreta.'];	
			return view('login',compact('erros_bd')); //chama login com a mensagem 
			}
			else{
				if($usuario->status == 0){
					$erros_bd = ['Desculpe, seu cadastro está desativado. Contate-nos.'];	
					return view('login',compact('erros_bd')); //chama login com a mensagem 

				}
				else{
					if($usuario->validade < date('yyyy-mm-dd')){
						$erros_bd = ['Desculpe, seu acesso está vencido. Contate-nos.'];	
						return view('login',compact('erros_bd')); //chama login com a mensagem 

					}
					else{
						Session::put('sge_fesc_logged','yes');
						Session::put('usuario',$usuario->pessoa);

					}
				}
			}	

		}
	}
	public function trocarSenha(){
		return view('login_forgot');
	}
	public function logout(){
		Session::flush();
		return redirect('/');
	}
}
