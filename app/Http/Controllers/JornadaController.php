<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jornada;
use Auth;

class JornadaController extends Controller
{
    public function indexModal(){
        if(isset($p))
            $jornadas = Jornada::where('pessoa',$p)->paginate('20');       
        else
            $jornadas =  Jornada::where('pessoa', \Auth::user()->pessoa)->paginate('20');

        return view('docentes.modal.index-jornada',compact('jornadas'));
        
    }

    public function cadastrar(Request $r)
    {
        $r->validate([
            'pessoa => required|number'
        ]);
        $jornada = new Jornada;
        $jornada->pessoa = $r->pessoa;
        $jornada->sala = $r->sala;
        $jornada->dias_semana = $r->dias;
        $jornada->hora_inicio = $r->hr_inicio;
        $jornada->hora_termino = $r->hr_termino;
        $jornada->inicio = $r->dt_inicio;
        $jornada->termino = $r->dt_termino;
        $jornada->tipo = $r->tipo;

        if($jornada->termino)
            $jornada->status = 'encerrada';
        else{
            $jornada->status = 'solicitada';

            if(in_array('17', Auth::user()->recursos))
                $jornada->status = 'ativa';
        }
            

        $jornada->save();


        return redirect()->back()->with('success','Jornada cadastrada com sucesso.');

    }

    public function excluir(Request $r){

       $jornada = Jornada::find($r->jornada);
       $jornada->delete();


        return response('Done!',200);
    }

    public function encerrar(Request $r){
       $jornada = Jornada::find($r->jornada);
       if($jornada->status =='encerrada'){
           $jornada->status = 'ativa';
           $jornada->termino = null;

       }else{
        $jornada->status = 'encerrada';
        $jornada->termino= $r->encerramento;

       }
      
       $jornada->save();

       return response('Done',200);

    }

    public static function listarDocente($docente,$semestre){
        if($semestre > 0){
            $intervalo = \App\classes\Data::periodoSemestre($semestre);
            $jornadas = Jornada::where('pessoa', $docente)->whereIn('status',['ativa','solicitada','encerrada'])->whereBetween('inicio', $intervalo)->orderBy('hora_inicio')->get();
        }
        else{
            $jornadas = Jornada::where('pessoa', $docente)->where('status','ativa')->orderBy('hora_inicio')->get();
        }

        foreach($jornadas as $jornada){
              
            $jornada->weekday = \App\classes\Strings::convertWeekDay($jornada->dias_semana[0]);

        }
    
        $jornadas = $jornadas->sortBy('weekday');
         return $jornadas;
    }
}
