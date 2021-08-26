<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PessoaDadosGerais;
use App\PessoaDadosAcesso;
use App\PessoaDadosContato;
use App\Pessoa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PerfilAuthController extends Controller
{
    public function validaCPF($cpf) { 
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function viewCPF(){
        return view('perfil.cpf');
        
    }

    public function verificarCPF($cpf){
        if(!is_numeric($cpf))
            return redirect()->back()->withErrors(['CPF inválido']);
        elseif(!$this->validaCPF($cpf))
            return redirect()->back()->withErrors(['CPF inválido']);
        else{
            $pessoa = PessoaDadosGerais::where('dado',3)->where('valor',$cpf)->first();
            if($pessoa == null)
                return redirect('/perfil/cadastrar-pessoa/'.$cpf);
            else{
                $senha = PessoaDadosGerais::where('dado',26)->where('pessoa',$pessoa->pessoa)->first();
                if($senha == null)
                    return view('perfil.cadastra-senha')->with('pessoa',$pessoa->pessoa);
                else
                    return view('perfil.senha')->with('pessoa',$senha->pessoa)->with('cpf',$cpf);


            }
        }



    }

    public function autenticaCPF($cpf, Request $r){
        if(session('login_tries')!=null && session('login_tries')>4)
            return redirect()->back()->withErrors(['Excesso de tentivas. Retorne mais tarde.']);
        if(!is_numeric($cpf))
            return redirect()->back()->withErrors(['CPF inválido']);
        elseif(!$this->validaCPF($cpf))
            return redirect()->back()->withErrors(['CPF inválido']);
        else{
            $cpf = PessoaDadosGerais::where('dado',3)->where('valor',$cpf)->first();
            if($cpf->pessoa == null)
                return redirect('/perfil/cadastro');
            else
                $senha = PessoaDadosGerais::where('dado',26)->where('pessoa',$cpf->pessoa)->first();
        }
        if(Hash::check($r->senha,$senha->valor)){
            session(['pessoa_perfil' => $senha->pessoa]);
            return redirect('/perfil');
        }
        else{
            if(session('login_tries')!=null){
                $tentativas = session('login_tries');
                $tentativas++;
                session(['login_tries'=>$tentativas]);
                unset($tentativas);
               
            }
            else
                session(['login_tries'=>1]);
            return redirect()->back()->withErrors(['Senha incorreta. Tentativa '.session('login_tries').'/5']);
        }
        

        
        


    }




    public function cadastrarSenha(Request $r){
        if(!is_numeric($r->pessoa) || $r->pessoa ==0){
            return redirect()->back()->withErrors(['Problemas na identificação da pessoa']);
        }
        $pessoa = Pessoa::find($r->pessoa);
        if($pessoa->id == null)
            return redirect()->back()->withErrors(['Problemas na identificação da pessoa']);

        $rg = PessoaDadosGerais::where('pessoa',$pessoa->id)->where('dado',4)->orderBy('id','desc')->first();
        $email = PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',1)->first();
        $nome = explode(' ',$pessoa->nome_simples);
        $nome = strtolower($nome[0]);

        if($r->senha != $r->contrasenha)
            return redirect()->back()->withErrors(['Os dois campos de senha dever ser iguais.']);
        
        if($rg->valor == $r->rg && $nome == strtolower($r->nome)){
            $dado = new PessoaDadosGerais;
            $dado->pessoa = $r->pessoa;
            $dado->dado = 26;
            $dado->valor = Hash::make($r->senha);
            $dado->save();
        }

        if($email == null || $email->valor != $r->email){
            $dado = new PessoaDadosContato;
            $dado->pessoa = $r->pessoa;
            $dado->dado = 1;
            $dado->valor = $r->email;
            $dado->save();

        }


        session(['pessoa_perfil'=>$r->pessoa]);
        return redirect('/perfil');

           
    }


    public function recuperarSenhaView($cpf){
        if(!$this->validaCPF($cpf))
            return redirect()->back()->withErrors(['CPF inválido']);
        $cpf = PessoaDadosGerais::where('dado',3)->where('valor',$cpf)->first();
        $email = PessoaDadosContato::where('dado', 1)->where('pessoa',$cpf->pessoa)->orderByDesc('id')->first();

        if($email ==null)
            return view('perfil.recovery')->withErrors(['Não foi possivel encontrar e-mail para enviar o link de redefinição de senha. Entre em contato pelo telefone 3372-1308 e solicite a redefinição. (será necessária a confirmação de diversos dados)']);
        $old_hash = PessoaDadosGerais::where('dado',27)->where('pessoa',$cpf->pessoa)->first();
        if($old_hash)
            $old_hash->delete();

        $hash = Str::random(60);
        $token = new PessoaDadosGerais;
        $token->pessoa = $cpf->pessoa;
        $token->dado = 27;
        $token->valor = $hash;
        $token->save();

        
        Mail::send('emails.reset_perfil_password', ['token' => $hash ], function ($message) use($email){
            $message->from('no-reply@fesc.saocarlos.sp.gov.br', 'Sistema Fesc');
            $message->to($email->valor);
            $message->subject('Redefinição de senha do perfil');
            });
        return view('perfil.recovery')->with('email',$email->valor);
        


        
        
        
        //enviar e-mail com a hash

        
        

    }


    public function recuperarSenhaExec($enc_token){
        $token =  urldecode($enc_token);
        $hash = PessoaDadosGerais::where('dado',27)->where('valor',$token)->first();

        if($hash){
            $senha_atual = PessoaDadosGerais::where('dado',26)->where('pessoa',$hash->pessoa)->first();
            $senha_atual->delete();
            $hash->delete();
            return redirect('/perfil/cpf')->withErrors(['Senha redefinida, cadastre uma nova por aqui.']);
            //buscar e apagar a senha atual
            //apagar token
            //redirecionar para tela inicial do cpf

        }
            
        else
            return "Token inválido ou expirado.";

    }

    public function trocarSenhaView(Request $r){
        return view('perfil.trocar-senha')->with('pessoa',$r->pessoa);

    }

    public function trocarSenhaExec(Request $r){
        $r->validate([
            'senha'=>'required',
            'nova-senha'=> 'required|min:6|max:50',
            'redigite-senha' => 'required|same:nova-senha'

        ]);
        

        if($r->nsenha == '123456'){
            return redirect()->back()->withErrors(['Senha insegura. Adicione letras e tente novamente.']);
        }


        
        $senha = PessoaDadosGerais::where('dado',26)->where('pessoa',$r->pessoa->id)->first();
        
        if($senha != null && Hash::check($r->senha,$senha->valor)){
            $senha->valor = Hash::make($r->nsenha);
            $senha->save();
            return redirect('/perfil')->withErrors(['Senha alterada.']);
        }
        else
            return redirect()->back()->withErrors(['Senha atual incorreta. Tente novamente.']);


    }

    public function logout(){
        session()->forget('login_tries');
        session()->forget('pessoa_perfil');
        session()->flush();
        return redirect('perfil/cpf');

    }


    public function resetarSenha($pessoa){
        $senha_atual = PessoaDadosGerais::where('dado',26)->where('pessoa',$pessoa)->first();
        if($senha_atual && in_array('9',\Auth::user()->recursos)){
            $senha_atual->delete();
            return redirect()->back()->withErrors(['Senha resetada. O usuário poderá cadastrar uma nova senha ao acessar o perfil.']);
        }
        else
            return redirect()->back()->withErrors(['Senha não cadastrada. O usuário poderá acessar o perfil e cadastrá-la.']);
        

    }

    
}
