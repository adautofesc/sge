<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Sala;
use \App\Turma;
use stdClass;


class SalaAgendamentoController extends Controller
{
    public function agendamento(Request $req){ //data-> para pegar a turmas turmas que tem naquele dia. //local
        $salas = Sala::where('local',84)->orderBy('nome')->get();
        if(!$req->data)
            $data = date('d/m/Y');
        else
            $data = \DateTime::createFromFormat('Y-m-d',$req->data)->format('d/m/Y');
        $dia_semana = \App\classes\Data::stringDiaSemana($data);

        //dd($dia_semana);
        $eventos=collect();

        $turmas = Turma::whereIn('status',['andamento','iniciada'])->where('sala','<>',null)->where('dias_semana','like','%'.$dia_semana.'%')->get();
        //dd($turmas);
        
        foreach($turmas as $turma){
            $evento = new stdClass();
            $evento->sala = $turma->sala;
            $evento->inicio = \DateTime::createFromFormat('H:i',$turma->hora_inicio);
            $evento->termino = \DateTime::createFromFormat('H:i',$turma->hora_termino);
            $evento->nome = $turma->getNomeCurso();
            $evento->tipo = "$turma->programa";
            $evento->hinicio = $evento->inicio->format('H');
            $evento->tempo =  $evento->inicio->diff($evento->termino);
            $eventos->push($evento);
        }



        
/*
        $evento2 = new stdClass();
        $evento2->sala = 3;
        $evento2->inicio = \DateTime::createFromFormat('H:i','10:20');
        $evento2->termino = \DateTime::createFromFormat('H:i','10:40');
        $evento2->nome = "Hidroginástica";
        $evento2->tipo = "aula-ce";
        $evento2->hinicio = $evento2->inicio->format('H');
        $evento2->tempo =  $evento2->inicio->diff($evento2->termino);
        $eventos->push($evento2);
        //dd($eventos);

        $evento3 = new stdClass();
        $evento3->sala = 3;
        $evento3->inicio = \DateTime::createFromFormat('H:i','10:50');
        $evento3->termino = \DateTime::createFromFormat('H:i','11:30');
        $evento3->nome = "Natação";
        $evento3->tipo = "aula-ce";
        $evento3->hinicio = $evento3->inicio->format('H');
        $evento3->tempo =  $evento3->inicio->diff($evento3->termino);
        $eventos->push($evento3);
        */
        return view('agendamento-sala.index',compact('eventos'))->with('salas',$salas)->with('data',$data);
    }
}
