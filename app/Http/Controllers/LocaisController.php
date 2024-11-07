<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Local;

class LocaisController extends Controller
{
    public function listar(Request $request){
        if(isset($request->buscar)){
            $termo = htmlentities($request->buscar);
            $locais = Local::where('nome','like','%'.$termo.'%')->orWhere('sigla','like','%'.$termo.'%')->paginate(50);
        }    
        else
            $locais = Local::orderBy('nome')->paginate(50);
        return view('admin.locais.lista')->with('locais',$locais);
    }


    public function cadastrar(){
        return view('admin.locais.cadastrar');
    }


    public function store(Request $req){
        $this->validate($req, [
            'nome' => 'required|max:200',
            'sigla'=> 'required|max:20'
        ]);
        $local = new Local;
        $local->nome = $req->nome;
        $local->sigla = strtoupper($req->sigla);
        $local->save();
        return redirect('/administrativo/locais')->withErrors(['Local '.$local->sigla.' inserido']);
    }


    public function editar($id){
        $id = htmlentities($id);
        if(!is_numeric($id))
            return redirect()->back()->withErrors(['Local inválido para edição.']);
        $local = Local::find($id);
        if($local != null)
            return view('admin.locais.editar')->with('local',$local);
        else
            return redirect()->back()->withErrors(['Local não encontrado.']);
    }


    public function update(Request $req){
        $this->validate($req, [
            'id' => 'required|numeric',
            'nome' => 'required|max:200',
            'sigla'=> 'required|max:20'
        ]);
        $local = Local::find($req->id);
        if($local == null)
            return redirect()->back()->withErrors(['Local não encontrado.']);
        $local->nome = $req->nome;
        $local->sigla = strtoupper($req->sigla);
        $local->save();

        return redirect('/administrativo/locais')->withErrors(['Local '.$local->sigla.' atualizado.']);
    }


    public function apagar(){
        return redirect()->back()->withErrors(['Recurso desativado no momento.']);
    }
}
