<?php

namespace App\Http\Controllers;
use App\Evento;
use App\Sala;
use App\Local;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function cadastrar_view($tipo='unico'){

        $locais = Local::all();
        $salas = Sala::where('local',84)->where('locavel','s')->get(); 
        switch($tipo){
            case 'multiplos': 
                return view('eventos.cadastrar-multiplos')->with('salas',$salas);
                break;
            default:  
                return view('eventos.cadastrar-unico')->with('locais',$locais)->with('salas',$salas);
        }
    }
    public function cadastrar_exec(Request $r){
        $evento = new Evento;
        

    }
}
