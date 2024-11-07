<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Local;
use App\Sala;



class SalaAgendamentoController extends Controller
{

    public function agendamento(Request $r){
        //return 'ok';

        if(isset($r->local)){
            $salas = Sala::where('local',$r->local)->orderBy('nome')->get();
            $local = $r->local;
        }
        else{
            $salas = Sala::where('local',84)->get();
            $local = 84;

        }

        if(isset($r->inicio))
            $inicio = \DateTime::createFromFormat('Y-m-d',$r->inicio);        
        else
            $inicio = new \DateTime('now'); 
        
        if(isset($r_termino))
            $termino = \DateTime::createFromFormat('Y-m-d',$r->termino);          
        else
            $termino = new \DateTime('now');

        $eventos = Local::agenda($local,$inicio,$termino);
        


        //dd($salas);
        return view('agendamento-sala.index',compact('eventos'))->with('salas',$salas)->with('data',$inicio);
    }
    
}
