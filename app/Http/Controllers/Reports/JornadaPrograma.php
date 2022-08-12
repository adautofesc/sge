<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PessoaDadosAdministrativos;
use App\Jornada;
use Carbon\Carbon;

class JornadaPrograma extends Controller
{
    public function index(string $programa){

        switch($programa){
            case 'pid':
                $id_programa = 2;
                break;
            case 'unit':
                $id_programa = 1;
                break;
            case 'uati':
                $id_programa = 3;
                break;
            case 'ce':
            case 'cec':
                $id_programa = 12;
                break;
            default:
                $id_programa = 0;
                break; 


        }
        $pessoal_programa = PessoaDadosAdministrativos::where('dado','programa')->where('valor',$id_programa)->pluck('pessoa')->toArray();
        

        $educadores = collect();

        
        foreach($pessoal_programa as $id){
            $educador = new \stdClass;
            $educador->id = $id;
            $educador->nome = \App\Pessoa::getNome($id);
            $educador->carga = \App\PessoaDadosJornadas::where('pessoa',$id)->where(function($query){
                $query->where('termino', null)->orwhere('termino','0000-00-00');
            })->pluck('carga')->first();
            $educador->carga_ativa = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');
            $educador->carga_aula = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');
            $educador->carga_jornada = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');

            $educador->carga_htp = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');
            $educador->carga_projeto = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');
            $educador->carga_coordenacao = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');
            $educador->carga_uso = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');
            $educador->carga_outros = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');

            $educador->turmas = \App\Turma::where('professor',$id)->where('status','iniciada')->orderBy('dias_semana')->get();
            foreach($educador->turmas as $turma){
                $turma->carga_semanal = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');
                $inicio = Carbon::createFromFormat('H:i', $turma->hora_inicio);
                $termino = Carbon::createFromFormat('H:i', $turma->hora_termino);
                $turma->carga_semanal->addMinutes($inicio->diffInMinutes($termino)*count($turma->dias_semana));
                $educador->carga_ativa->addMinutes($inicio->diffInMinutes($termino)*count($turma->dias_semana));
                $educador->carga_aula->addMinutes($inicio->diffInMinutes($termino)*count($turma->dias_semana));    
            }

            $educador->jornadas = \App\Jornada::where('pessoa',$id)->where('status','ativa')->orderBy('tipo')->orderBy('dias_semana')->get();
            foreach($educador->jornadas as $jornada){
                $jornada->carga_semanal = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo');
                $inicio = Carbon::createFromFormat('H:i', $jornada->hora_inicio);
                $termino = Carbon::createFromFormat('H:i', $jornada->hora_termino);
                $jornada->carga_semanal->addMinutes($inicio->diffInMinutes($termino)*count($jornada->dias_semana));
                $educador->carga_ativa->addMinutes($inicio->diffInMinutes($termino)*count($jornada->dias_semana));
                $educador->carga_jornada->addMinutes($inicio->diffInMinutes($termino)*count($jornada->dias_semana));
                switch($jornada->tipo){
                    case 'HTP':
                        $educador->carga_htp->addMinutes($inicio->diffInMinutes($termino)*count($jornada->dias_semana));
                        break;
                    case 'Projeto':
                        $educador->carga_projeto->addMinutes($inicio->diffInMinutes($termino)*count($jornada->dias_semana));
                        break;
                    case 'Coordenação':
                        $educador->carga_coordenacao->addMinutes($inicio->diffInMinutes($termino)*count($jornada->dias_semana));
                        break;
                    case 'Uso Livre':
                        $educador->carga_uso->addMinutes($inicio->diffInMinutes($termino)*count($jornada->dias_semana));
                        break;
                    default:
                        $educador->carga_outros->addMinutes($inicio->diffInMinutes($termino)*count($jornada->dias_semana));
                        break;

                }  
            }

            $educadores->push($educador);
        }
           
            
        
        return view('relatorios.jornada-programas')
        ->with('programa',$programa)
        ->with('educadores',$educadores);
        
    }


        
}

