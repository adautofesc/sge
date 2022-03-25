<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PessoaDadosAdministrativos;
use App\Jornada;
use Carbon\Carbon;

class JornadaDocentes extends Controller
{
    public function relatorioGeral(Request $r)
    {
        
        $dias = ['seg','ter','qua','qui','sex','sab'];
        
        $educadores = PessoaDadosAdministrativos::getFuncionarios('Educador');
        $educadores->pull(29);
        $locais = \App\Local::select(['id','sigla'])->orderBy('sigla')->get();

        //dd($educadores);
        foreach($educadores as $educador){
            $educador->carga_semanal = new \stdClass;
            $educador->carga_ativa = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo'); 
            $educador->jornadas = collect();

            $educador->turmas = \App\Http\Controllers\TurmaController::listarTurmasDocente($educador->id,0);
            $jornadas = \App\Jornada::where('pessoa',$educador->id)->get();
            $jornadas_ativas = $jornadas->where('status','ativa');
            $carga = \App\PessoaDadosAdministrativos::where('dado','carga_horaria')->where('pessoa',$educador->id)->first();

            
            if($carga)
                $educador->carga = $carga->valor;
            else
                $educador->carga = 0;



            foreach($educador->turmas as &$turma){
                foreach($turma->dias_semana as $dia){
                    if(!isset($educador->jornadas[$dia]))
                        $educador->jornadas[$dia] = collect();
                    if(!isset($educador->carga_semanal->$dia))
                        $educador->carga_semanal->$dia = 0;

                    $jornada = new \stdClass;
                    $jornada->inicio = $turma->hora_inicio;
                    $jornada->termino = $turma->hora_termino;
                    $jornada->descricao = 'Aula na turma '.$turma->id;
                    $jornada->local = $turma->local->sigla;
                    
                    $inicio = Carbon::createFromFormat('H:i', $turma->hora_inicio);
                    $termino = Carbon::createFromFormat('H:i', $turma->hora_termino);
                    $jornada->carga = $inicio->diffInMinutes($termino);
                    $educador->jornadas[$dia]->push($jornada);                    
                    $educador->carga_ativa->addMinutes($inicio->diffInMinutes($termino));
                    $educador->carga_semanal->$dia += $inicio->diffInMinutes($termino);
                }
            }
            foreach($jornadas_ativas as $jornada){
                foreach($jornada->dias_semana as $dia){
                   
                    if(!isset($educador->jornadas[$dia]))
                        $educador->jornadas[$dia] = collect();
                    if(!isset($educador->carga_semanal->$dia))
                        $educador->carga_semanal->$dia = 0;

                    $atividade = new \stdClass;
                    $atividade->inicio = substr($jornada->hora_inicio,0,5);
                    $atividade->termino = substr($jornada->hora_termino,0,5);
                    $atividade->descricao = $jornada->tipo;
                    $atividade->local = '-';
                  
                    $sala = \App\Sala::find($jornada->sala);                    
                
                    if(isset($sala->id)){
                        $local = $locais->where('id',$sala->local);
                        if(isset($local->first()->sigla))                  
                            $atividade->local = $local->first()->sigla;
                    }
                    else
                        $atividade->local = '-';
                        
                    $inicio = Carbon::createFromFormat('H:i:s', $jornada->hora_inicio);
                    $termino = Carbon::createFromFormat('H:i:s', $jornada->hora_termino);

                    $atividade->carga = $inicio->diffInMinutes($termino);
                    $educador->carga_semanal->$dia += $inicio->diffInMinutes($termino);
                    $educador->carga_ativa->addMinutes($inicio->diffInMinutes($termino));

                    if($atividade->descricao != 'Translado' && $atividade->descricao != 'Intervalo entre aulas')
                        $educador->jornadas[$dia]->push($atividade); 

                    


    
                }
            }

           foreach($dias as $dia){
                if(isset($educador->jornadas[$dia]))
                    $educador->jornadas[$dia] = $educador->jornadas[$dia]->sortBy('inicio');
                if(!isset($educador->carga_semanal->$dia))
                    $educador->carga_semanal->$dia = 0;

            }
                

           /*if($educador->id == '13474'){
                $educador->jornadas['seg'] = $educador->jornadas['seg']->sortBy('inicio');
                //dd($educador->jornadas['seg']->skip(1)->take(1)->first()->inicio);
            }*/
                
    

        }




        //return $educadores;
        $dias = ['seg','ter','qua','qui','sex','sab'];

        return view('relatorios.jornada-docentes')
            ->with('dias',$dias)
            ->with('educadores',$educadores);

    }
}
