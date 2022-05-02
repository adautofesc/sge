<?php

namespace App\Http\Controllers;

use Auth;
use App\Sala;
use App\UsoLivre;
use Illuminate\Http\Request;


class UsoLivreController extends Controller
{
    function index(){
        $locais = Sala::getUsoLivre();
        $ul = UsoLivre::where('responsavel',Auth::user()->pessoa)->where('hora_termino',null)->get();

     
        
        return view('uso-livre.index')->with('uso_livre',$ul)->with('locais',$locais);
    }

    public function store(Request $r){
        $ul = new UsoLivre;
        $ul->atendido = $r->pessoa;
        $ul->responsavel = Auth::user()->pessoa;
        $ul->sala = $r->local;
        $ul->hora_inicio = $r->inicio;
        $ul->inicio = $r->data;
        $ul->atividade = $r->atividade;
        $ul->save();


       return redirect()->back()->with(['success'=>'Registro '. $r->inicio.' gravado']);
    }

    public function concluir($id){
        $itens = explode(';',$id);
        UsoLivre::whereIn("id", $itens)->update(["hora_termino" => date('H:i')]);
        /*
        foreach($itens as $item){
            $uso = UsoLivre::find($item);
            if(isset($uso->id)){
                $uso->hora_termino = date('H:i');
                $uso->save();
            }
        }*/
    }
    public function excluir($id){
        $itens = explode(';',$id);
        UsoLivre::whereIn("id", $itens)->delete();
        /*
        foreach($itens as $item){
            $uso = UsoLivre::find($item);
            if(isset($uso->id)){
                $uso->hora_termino = date('H:i');
                $uso->save();
            }
        }*/
    }
}
