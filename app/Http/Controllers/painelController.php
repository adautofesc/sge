<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\Data;
use App\Pessoa;
use Session;

class painelController extends Controller
{
    public function index(){

    	if(!Session::has('sge_fesc_logged'))
    		return view('login');
    	
    	else{
    		$hoje=new Data();
            $data=$hoje->getData();        
            $dados=['data'=>$data];
            
            return view('home', compact('dados'));
    	}

        


    	
    }

    	
}
