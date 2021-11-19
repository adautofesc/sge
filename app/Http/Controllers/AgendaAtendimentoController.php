<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgendaAtendimento;

class AgendaAtendimentoController extends Controller
{
    const ATENDENTES = 2;
    const HORARIOS = ['08:15','08:30','08:45','09:00','09:15','09:30','09:45','10:00','10:15','10:30','10:45','11:00','11:00','11:15',
    '14:00','14:15','14:30','14:45','15:00','15:15','15:30','15:45','16:00','16:15','16:30','16:45','17:00','17:15','17:30','17:45','18:00','18:15'];

    public function index(){
        $final = date('Y-m-d', strtotime("+2Month",strtotime(date('Y-m-d')))); 
        $agendamentos = AgendaAtendimento::where('data',date('Y-m-d'))->where('status','aguardando')->get();
        
        foreach($agendamentos as &$agendamento){
            
            $agendamento->pessoa_obj = \App\Pessoa::find($agendamento->pessoa);
        }
        return view('secretaria.agenda-atendimento')->with('agendamentos',$agendamentos)->with('final',$final);
    }
    public function indexPerfil(Request $r){
        $final = date('Y-m-d', strtotime("+2Month",strtotime(date('Y-m-d')))); 

        $agendamentos = AgendaAtendimento::where('pessoa',$r->pessoa->id)->where('status','aguardando')->get();
        return view('perfil.agenda-atendimento')->with('pessoa',$r->pessoa)->with('agendamentos',$agendamentos)->with('final',$final);
    }

    public function gravar(Request $r){
        $r->validate(['dia => required', 'horario => required']);
        $agendamento = new AgendaAtendimento;
        if(isset($r->pessoa)){
            $agendamento->pessoa = $r->pessoa;
        }
        else{
            $r->validate([
				'nome'=>'required',
				'nascimento'=>'required',
				'genero'=>'required'				

			]);
            $pessoanobd=Pessoa::where('nome', $request->nome)->where('nascimento',\Carbon\Carbon::createFromFormat('d/m/Y',$r->nascimento))->first();
            if($pessoanobd)
                $agendamento->pessoa = $pessoanobd->id;
            else{
                $pessoa = new \App\Pessoa;
                $pessoa->nome=mb_convert_case($r->nome, MB_CASE_UPPER, 'UTF-8');
                $pessoa->nascimento=\Carbon\Carbon::createFromFormat('d/m/Y',$r->nascimento)->toDateString();
                $pessoa->genero=$r->genero;
                $pessoa->por=  \Auth::user()->pessoa;
                $pessoa->save();
                $agendamento->pessoa = $pessoa->id;
            }


        }
            
            
            $agendamento->data = $r->dia;
            $agendamento->horario = $r->horario.":00";
            $agendamento->status = 'aguardando';
            $agendamento->save();

            return redirect()->back()->withErrors(['Agendamento realizado.']);

    }

    public function agendarPerfil(Request $r){
        $r->validate(['dia => required', 'horario => required']);
        $agendamento = new AgendaAtendimento;
        $agendamento->pessoa = $r->pessoa->id;
        $agendamento->data = $r->dia;
        $agendamento->horario = $r->horario.":00";
        $agendamento->status = 'aguardando';
        $agendamento->save();

        return redirect()->back()->withErrors(['Agendamento realizado.']);

    }
    public function horariosData($data){
        $disponiveis = array();
        $fds = \DateTime::createFromFormat('Y-m-d',$data);
        if($fds->format('w')==0 || $fds->format('w')==6 )
            return "Fim de semana";

        $feriado = \App\DiaNaoLetivo::where('data',$data)->get();
        if($feriado->count()>0)
            return "Dia não letivo";

        $horarios_ja_agendados = AgendaAtendimento::where('data',$data)->pluck('horario')->toArray();
        $contagem_agendados = array_count_values($horarios_ja_agendados); //gera array com a contagem de cada item

        //dd($contagem_agendados);
        foreach(self::HORARIOS as $horario ){
            if(array_key_exists($horario.":00",$contagem_agendados)){
                if($contagem_agendados[$horario.":00"]<self::ATENDENTES)
                    array_push($disponiveis, $horario);
            }        
            else
                array_push($disponiveis, $horario);

        }
        
       
        return $disponiveis;
        
        
    }

    public function cancelarPerfil(Request $r,$id){
        $horario = AgendaAtendimento::find($id);
        if($horario){
            if($horario->pessoa == $r->pessoa->id)
                $horario->delete();

        }
    }

    public function alterarStatus($id,$estado){
        $horario = AgendaAtendimento::find($id);
        if($horario){
                $horario->status = $estado;
                $horario->atendente = \Auth::user()->pessoa;
                $horario->save();

        }
    }
    
}
