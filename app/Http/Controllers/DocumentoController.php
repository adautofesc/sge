<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    //
    public function index(){
    	return view('juridico.documentos.lista');
    }

    public function cadastrar(){
    	return view('juridico.documentos.cadastrar');
    }
}
