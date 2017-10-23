<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\Data;
use App\Pessoa;
use App\Local;
use App\PessoaDadosAcesso;
use App\Http\Controllers\PessoaController;
use Session;

class painelController extends Controller
{
    public function index(){

    	if(!Session::has('sge_fesc_logged'))
    		return loginController::login();
    	
    	else{
    		$hoje=new Data();
            $data=$hoje->getData();        
            $dados=['data'=>$data];
            
            return view('home', compact('dados'));
    	}
	
    }

    public function administrativo(){
        return view('admin.home');
    }
    public function docentes(){
        return view('docentes.home');
    }
    public function financeiro(){
        return view('financeiro.home');
    }
    public function gestaoPessoal(){
        return view('gestaopessoal.home');
    }
    public function atendimentoPessoal(){
        return view('gestaopessoal.inicio-atendimento');
    }
    public function atendimentoPessoalPara($id){
        if(!loginController::check())
            return redirect(asset("/"));

        $pessoa=Pessoa::find($id);
        // Verifica se a pessoa existe
        if(!$pessoa)
            return view('gestaopessoal.inicio-atendimento');

        $pessoa_controller= new PessoaController;
        $pessoa=$pessoa_controller->formataParaMostrar($pessoa);
        $pessoa_acesso=PessoaDadosAcesso::where('pessoa',$pessoa->id)->first();
        if(!$pessoa_acesso)
            $pessoa_acesso=0;
        $pessoa->acesso=$pessoa_acesso;

        return view('gestaopessoal.atendimento', compact('pessoa'));
    }



    public function juridico(){
        return view('juridico.home');
    }
    public function pedagogico(){
        return view('pedagogico.home');
    }
    public function secretaria(){
        return view('secretaria.home');
    }
    public function salasDaUnidade($unidade){
        $salas=Local::where('unidade', 'like', '%'.$unidade.'%')->get();
        return $salas;

    }


    	
}
