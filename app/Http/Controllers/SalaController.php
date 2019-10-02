<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sala;
use App\Local;
use Hamcrest\Type\IsNumeric;

class SalaController extends Controller
{
    function sanitizeId($var){
        $var= htmlentities($var);
        if(!is_numeric($var))
            return redirect()->back()->withErrors(['ID inválido']);
    }



    public function listarPorLocal(Request $r, $id_local) {
        
        $this->sanitizeId($id_local);
        if(isset($r->buscar))
            $salas = Sala::where('local',$id_local)->where('nome', 'like','%'.$r->buscar.'%')->orderBy('nome')->paginate(20);
        else
            $salas = Sala::where('local',$id_local)->orderBy('nome')->paginate(20);
        $local = Local::find($id_local);

        //dd($salas);

        return view('admin.salas.lista',compact('salas'))->with('local',$local);
    }



    public function listarporLocalApi($id_local){
        $this->sanitizeId($id_local);
        $salas = Sala::where('local',$id_local)->orderBy('nome')->get();
        return $salas;

    }



    public function cadastrar($id_local){
        $this->sanitizeId($id_local);
        $local = Local::find($id_local);
        return view('admin.salas.cadastrar')->with('local',$local);
    }



    public function store(Request $req){
        $this->validate($req,[
            'nome'=>'required'
        ]);
        $sala = new Sala;
        $sala->nome = $req->nome;
        $sala->local = $req->local;
        $sala->capacidade = $req->capacidade;
        $sala->metragem = $req->metragem;
        $sala->posicaogps = $req->gps;
        $sala->obs = $req->obs;
        $sala->status = $req->status;
        $sala->locavel = $req->locavel;
        $sala->save();
        return redirect('/administrativo/locais/salas/'.$sala->local)->withErrors(['Sala "'.$sala->nome.'" cadastrada com sucesso.']);
    }



    public function editar($id){
        $this->sanitizeId($id);
        $sala = Sala::find($id);
        if($sala == null)
            return redirect()->back()->withErrors(['Sala cod.'.$id.' não encontrada']);
        else
            return view('admin.salas.editar')->with('sala',$sala);
    }




    public function update(Request $req){
        $this->validate($req,[
            'nome'=>'required'
        ]);
        $sala = Sala::find($req->id);
        if($sala == null)
            return redirect()->back()->withErrors(['Sala cod.'.$req->id.' não encontrada']);
        $sala->nome = $req->nome;
        $sala->local = $req->local;
        $sala->capacidade = $req->capacidade;
        $sala->metragem = $req->metragem;
        $sala->posicaogps = $req->gps;
        $sala->obs = $req->obs;
        $sala->status = $req->status;
        $sala->locavel = $req->locavel;
        $sala->save();
        return redirect('/administrativo/locais/salas/'.$sala->local)->withErrors(['Sala "'.$sala->nome.'" alterada com sucesso.']);
    }



    public static function verificarDisponibilidade($sala, $dias_semana,$horario_entrada,$horario_saida,$data_inicio,$data_termino){
        return true;
    }
   
}
