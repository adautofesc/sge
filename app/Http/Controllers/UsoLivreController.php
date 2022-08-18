<?php

namespace App\Http\Controllers;

use Auth;
use App\Sala;
use App\Local;
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
        if($r->local ==0)
            return redirect()->back()->with('danger','Local não selecionado');
        $ul = new UsoLivre;
        $ul->atendido = $r->pessoa;
        $ul->responsavel = Auth::user()->pessoa;
        $ul->local = $r->local;
        $ul->hora_inicio = $r->inicio;
        $ul->inicio = $r->data;
        $ul->atividade = $r->atividade;
        $ul->save();
        session(['local'=>$r->local]);


       return redirect()->back()->with(['success'=>'Registro '. $r->inicio.' gravado']);
    }

    public function concluir(Request $r){
        
        $itens = explode(';',$r->usuarios_conclusao);
        if($r->atividade_fim)
            UsoLivre::whereIn("id", $itens)->update(["hora_termino" => $r->termino,"obs"=>$r->obs,'atividade' => $r->atividade_fim]);
        else
            UsoLivre::whereIn("id", $itens)->update(["hora_termino" => $r->termino,"obs"=>$r->obs]);

        return redirect()->back()->with(['success'=>'Iten(s) atualizados com sucesso.']);
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

    public function relatorio(Request $r){
        $locais = Local::orderBy('nome')->get();
        //dd($r->local);

        if($r->local)
            $registros = UsoLivre::whereIn('local',$r->local)->orderByDesc('inicio')->get();
        else
            $registros = UsoLivre::whereYear('inicio',2022)->orderByDesc('inicio')->get();

      


        //dd($registros);
        return view('relatorios.uso-livre')
            ->with('registros',$registros)
            ->with('local_filtro',$r->local)
            ->with('locais',$locais);
    }
}
