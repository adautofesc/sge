<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\Data;
use App\Pessoa;
use Session;

class painelController extends Controller
{
    public function index(){

    	if(!Session::has('sge_fesc_logged')){
    		return view('login');
    	}
    	else{
    		$hoje=new Data();
            $data=$hoje->getData();
            $user=Session::get('usuario');
            $usuario= Pessoa::where('id',$user)->first();
            $array_nome=explode(' ',$usuario->nome);
            $nome=$array_nome[0].' '.end($array_nome);           
            $dados=['data'=>$data,'usuario'=>$nome];
            
            return view('home', compact('dados'));
    	}

        


    	
    }

    	
}
