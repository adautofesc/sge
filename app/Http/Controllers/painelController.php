<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class painelController extends Controller
{
    public function index(){

    	if(!Session::has('sge_fesc_logged')){
    		return view('login');
    	}
    	else{
    		return view('home');
    	}
    	
    }
    	
}
