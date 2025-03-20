<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;
use App\PessoaDadosJornadas;
use App\PessoaDadosAdministrativos;

class PessoaDadosJornadasController extends Controller
{
    public function modalCargaDocente($pessoa = 0){
        return 'oi';

    }
    //
    public function cadastrar($pessoa){
        return view('carga-horaria.cadastrar')->with('pessoa',$pessoa);

    }
    public function store(Request $r){

        
        $carga =  new PessoaDadosJornadas;
        $carga->pessoa = $r->pessoa;
        $carga->carga = $r->horas;
        $carga->inicio = $r->inicio;
        $carga->termino = $r->termino;
        $carga->status = $r->status;
        $carga->save();

        return redirect('/jornadas'.'/'. $r->pessoa);

    }

    public function editar($id){

        $carga =  PessoaDadosJornadas::find($id);    
        return view('carga-horaria.editar')->with('carga',$carga);

    }
    public function update(Request $r){
        
        $carga = PessoaDadosJornadas::find($r->id);
        $carga->carga = $r->horas;
        $carga->inicio = $r->inicio;
        $carga->termino = $r->termino;
        $carga->status = $r->status;
        $carga->save();

        return redirect('/jornadas'.'/'. $carga->pessoa);

    }

    public function excluir(Request $r){

        $ids = explode(',',$r->id);

        foreach($ids as $id){
            $carga = PessoaDadosJornadas::find($id);
            if(isset($carga->id))
                $carga->delete();
        } 

        return response('OK',200);

    }

    public function importar(){
        $dados = PessoaDadosAdministrativos::where('dado','carga')->get();
        foreach($dados as $dado){
            $carga =  new CargaHoraria;
            $carga->pessoa = $dado->pessoa;
            $carga->carga = $dado->valor;
            $carga->inicio = '2018-01-01';
            $carga->save();
        }
    }
}
