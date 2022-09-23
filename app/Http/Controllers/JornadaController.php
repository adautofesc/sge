<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jornada;
use Auth;

class JornadaController extends Controller
{
    public function index($id,$semestre='0'){
        if($id == 0){
            $id = Auth::user()->pessoa;
        }
        $horarios = array();
        $dias = ['seg','ter','qua','qui','sex','sab'];
        $carga_ativa = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo'); ;
        //$carga_ativa = 0;

        $turmas = \App\Http\Controllers\TurmaController::listarTurmasDocente($id,$semestre);
        $jornadas_contagem = \App\Http\Controllers\JornadaController::listarDocente($id,$semestre);
        
        //$jornadas = \App\Jornada::where('pessoa',$id)->get();
        $jornadas_ativas = $jornadas_contagem->where('status','ativa');

        $locais = \App\Local::select(['id','nome'])->orderBy('nome')->get();
        
        $carga = \App\PessoaDadosJornadas::where('pessoa',$id)
                ->where(function($query){
                    $query->where('termino', null)->orwhere('termino','0000-00-00');
                })
                ->orderByDesc('id')
                ->first();
        $ghoras_turmas = array();
        $ghoras_HTP = array();
        $ghoras_projetos = array();
        $ghoras_coordenacao = array();
        $ghoras_outros = array();
        $glocais = array();

        //dd($carga);

        foreach($turmas as $turma){
            foreach($turma->dias_semana as $dia){
                $sala = \App\Sala::find($turma->sala);
                if($sala)
                    $turma->nome_sala = $sala->nome;
                else
                    $turma->nome_sala = '';

                $horarios[$dia][substr($turma->hora_inicio,0,2)][substr($turma->hora_inicio,3,2)] = $turma;
                //dd($turma->hora_inicio);
                $inicio = Carbon::createFromFormat('H:i', $turma->hora_inicio);
                $termino = Carbon::createFromFormat('H:i', $turma->hora_termino);
                $carga_ativa->addMinutes($inicio->diffInMinutes($termino));
                switch($dia){
                    case 'seg':
                        $ndia= 1;
                        break;
                    case 'ter':
                        $ndia= 2;
                        break;
                    case 'qua': 
                        $ndia= 3;
                        break;
                    case 'qui': 
                        $ndia= 4;
                        break;
                    case 'sex': 
                        $ndia= 5;
                        break;
                    case 'sab': 
                        $ndia= 6;
                        break;
                    default:
                        $ndia= 0;
                }
                $ghoras_turmas[] = [$ndia,$turma->hora_inicio,$turma->hora_termino,'Turma '.$turma->id,$turma->local->nome];

            }
            if(!in_array($turma->local->sigla,$glocais))
                $glocais[] = $turma->local->sigla;
        }
        //dd($carga_ativa->floatDiffInHours(\Carbon\Carbon::Today()));
        foreach($jornadas_ativas as $jornada){
            foreach($jornada->dias_semana as $dia){
                $horarios[$dia][substr($jornada->hora_inicio,0,2)][substr($jornada->hora_inicio,3,2)] = $jornada;
                $inicio = Carbon::createFromFormat('H:i', $jornada->hora_inicio);
                $termino = Carbon::createFromFormat('H:i', $jornada->hora_termino);
                $carga_ativa->addMinutes($inicio->diffInMinutes($termino));
                switch($dia){
                    case 'seg':
                        $ndia= 1;
                        break;
                    case 'ter':
                        $ndia= 2;
                        break;
                    case 'qua': 
                        $ndia= 3;
                        break;
                    case 'qui': 
                        $ndia= 4;
                        break;
                    case 'sex': 
                        $ndia= 5;
                        break;
                    case 'sab': 
                        $ndia= 6;
                        break;
                    default:
                        $ndia= 0;
                }
                $ghoras_turmas[] = [$ndia,$jornada->hora_inicio,$jornada->hora_termino,$jornada->tipo,$jornada->getLocal()->nome];

            }
        }

        $docente = \App\Pessoa::withTrashed()->find($id);
        $semestres = \App\classes\Data::semestres();
        $jornadas = Jornada::where('pessoa',$id)->orderByDesc('id')->paginate('20');  
        return view('jornadas.index',compact('jornadas'))
            ->with('turmas',$turmas)
            ->with('semestres',$semestres)
            ->with('semestre_selecionado',$semestre)
            ->with('docente',$docente)
            ->with('horarios',$horarios)
            ->with('dias',$dias)
            ->with('locais',$locais)
            ->with('glocais',$glocais)
            ->with('carga',$carga)
            ->with('carga_ativa',$carga_ativa)
            ->with('ghoras_turmas',$ghoras_turmas);

    }
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
