<?php

namespace App\Http\Controllers;
use App\Evento;
use App\Sala;
use App\Local;

use Illuminate\Http\Request;

class EventoController extends Controller
{

    public function index(Request $r){
        $calendario = new \App\Utils\Calendar();

        $eventos = Evento::where('data_termino','>=',date('Y-m-d'))->orderBy('data_inicio')->get();
        return view('eventos.index')->with('eventos',$eventos)->with('data',$calendario->data)->with('mes',$calendario->dias);

    }

    

   

    public function create($tipo='unico'){

        $locais = Local::all();
        $salas = Sala::where('local',84)->where('locavel','s')->get(); 
        switch($tipo){
            case 'continuo': 
                return view('eventos.cadastrar-multiplos')->with('salas',$salas)->with('tipo',$tipo);
                break;
            default:  
                return view('eventos.cadastrar-unico')->with('locais',$locais)->with('salas',$salas)->with('tipo',$tipo);
        }
    }
    public function store(Request $r){
        $evento =  new Evento;
        $evento->tipo = $r->tipo;
        $evento->nome = $r->nome;
        $evento->responsavel = $r->responsavel;
        $evento->recorrencia = $r->recorrencia;
        $evento->dias_semana = implode(',',$r->dias);
        $evento->data_inicio = $r->data_inicio;
        $evento->data_termino = $r->data_inicio;
        $evento->horario_inicio = $r->h_inicio;
        $evento->horario_termino = $r->h_termino;
        $evento->sala = $r->sala;
        $evento->auto_insc = $r->autoinsc;
        $evento->obs = $r->descricao;
        if($r->tipo == 'continuo'){
            $evento->data_termino = $r->data_termino;
            $evento->dias_semana = implode(', ',$r->dias_semana);
        }
        $evento->save();
        $this->index($r);  
    }

    public function edit($id){

    }
    public function update(Request $r){

    }
    public function delete($ids){

    }

    

}
