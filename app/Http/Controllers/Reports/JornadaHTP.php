<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PessoaDadosAdministrativos;
use App\Jornada;
use Carbon\Carbon;

class JornadaHTP extends Controller
{
    public function index(){

        $pessoal_programa = PessoaDadosAdministrativos::where('dado','relacao_institucional')
            ->where('valor','Educador')
            ->pluck('pessoa')
            ->toArray();
        
        unset($pessoal_programa[array_search('0',$pessoal_programa)]);

        //dd($pessoal_programa);
        


        $educadores = collect();

        
        foreach($pessoal_programa as $id){

            $educador = new \stdClass;
            $educador->id = $id;
            $educador->nome = \App\Pessoa::getNome($id);
            $educador->carga = \App\PessoaDadosJornadas::where('pessoa',$id)
            ->where(function($query){
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

          

            $educador->jornadas = \App\Jornada::where('pessoa',$id)->where('tipo','HTP')->where('status','ativa')->orderBy('tipo')->orderBy('dias_semana')->get();
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
            $educadores = $educadores->sortBy('nome');
        }
           
            
        
        return view('relatorios.jornada-htp')
        ->with('educadores',$educadores);
        
    }


        
}

