<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Documento;

class DocumentoController extends Controller
{
    //
    public function index(){
        $documentos=Documento::select()->paginate(35);
    	return view('juridico.documentos.lista',compact('documentos'));
    }

    public function cadastrar(){
    	return view('juridico.documentos.cadastrar');
    }
    public function apagar($id){
        $documento=Documento::find($id);
        if(!$documento)
            return $this->index();
        else
            $documento->delete();
        return $this->index();
    }
    public function editar($id){
        $documento=Documento::find($id);
        if(!$documento)
            return $this->index();
        return view('juridico.documentos.editar',compact('documento'));
    }



    public function store(Request $request){
    	$documento = new Documento();
    	$documento->tipo_documento=$request->tipo_documento;
    	$documento->tipo_objeto=$request->tipo_objeto;
    	$documento->objeto=$request->objeto;
    	$documento->conteudo=htmlentities($request->content);
    	$documento->save();
    	return $this->index();

    }
}
