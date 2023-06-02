<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PessoaDadosAdministrativos;
use App\Jornada;
use Carbon\Carbon;

class JornadaDocentes extends Controller
{
    public function relatorioGeral($ano = null)
    {
        if(!$ano)
            $ano = date('Y');

        $dias = ['seg','ter','qua','qui','sex','sab'];
        $ano_anterior = $ano-1;
        
        $educadores = PessoaDadosAdministrativos::getFuncionarios('Educador');
        //dd($educadores);
        //$educadores->pull(29);//retira o cadastro 0 SEG a definir
        $locais = \App\Local::select(['id','sigla'])->orderBy('sigla')->get();

        //dd($educadores);
        foreach($educadores as $key=>$educador){
            //retirar o cadastro 0
            if($educador->id == 0){
                $educadores->forget($key);
                continue;
            }
            $educador->carga_semanal = new \stdClass;
            $educador->carga_ativa = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo'); 
            $educador->jornadas = collect();


            //$educador->turmas = \App\Http\Controllers\TurmaController::listarTurmasDocente($educador->id,'0'.$ano);
           
            if($ano == date('Y')){
                $educador->turmas = \App\Turma::where('professor',$educador->id)->where('data_inicio','>',$ano.'-01-01')->where('data_termino','>',date('Y-m-d'))->where('status','iniciada')->get();
                $jornadas_ativas = \App\Jornada::where('pessoa',$educador->id)->where('status','ativa')->get();
                $carga = \App\PessoaDadosJornadas::where('pessoa',$educador->id)->where('status','ativa')->first();

            }
            else{
                $educador->turmas = \App\Turma::where('professor',$educador->id)->whereBetween('data_termino',[$ano.'-11-01',$ano.'-12-31'])->where('status','encerrada')->get();
                $jornadas_ativas = \App\Jornada::where('pessoa',$educador->id)
                                                ->whereIn('status',['ativa','encerrada'])
                                                ->where('inicio','<=',$ano.'-12-01')
                                                ->where(function($query) use($ano){
                                                        return $query->where('termino','>=',$ano.'-12-01')
                                                        ->orwhere('termino',null);})
                                                ->orderByDesc('id')->get();
                $carga = \App\PessoaDadosJornadas::where('pessoa',$educador->id)
                ->where('inicio','<=',$ano.'-12-01')
                ->where(function($query) use($ano){
                        return $query->where('termino','>=',$ano.'-12-01')
                        ->orwhere('termino',null)
                        ->orwhere('termino','0000-00-00');})
                ->orderByDesc('id')->first();
            }

            

            
            if($carga)
                $educador->carga = $carga->carga;
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
                    $atividade->inicio = $jornada->hora_inicio;
                    $atividade->termino = $jornada->hora_termino;
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
                        
                    $inicio = Carbon::createFromFormat('H:i', $jornada->hora_inicio);
                    $termino = Carbon::createFromFormat('H:i', $jornada->hora_termino);

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
            ->with('ano',$ano)
            ->with('educadores',$educadores);

    }

    
    
    public function relatorioHTP($programas,$ano = null)
    {
        if(!$ano)
            $ano = date('Y');

        $dias = ['seg','ter','qua','qui','sex','sab'];
        $ano_anterior = $ano-1;
        
        $educadores = PessoaDadosAdministrativos::getFuncionarios('Educador');
        //dd($educadores);
        //$educadores->pull(29);//retira o cadastro 0 SEG a definir
        $locais = \App\Local::select(['id','sigla'])->orderBy('sigla')->get();

        //dd($educadores);
        foreach($educadores as $key=>$educador){
            //retirar o cadastro 0
            if($educador->id == 0){
                $educadores->forget($key);
                continue;
            }
            $educador->carga_semanal = new \stdClass;
            $educador->carga_ativa = Carbon::createFromTime(0, 0, 0, 'America/Sao_Paulo'); 
            $educador->jornadas = collect();


            //$educador->turmas = \App\Http\Controllers\TurmaController::listarTurmasDocente($educador->id,'0'.$ano);
           
            if($ano == date('Y')){
                $educador->turmas = \App\Turma::where('professor',$educador->id)->where('data_inicio','>',$ano.'-01-01')->where('data_termino','>',date('Y-m-d'))->where('status','x')->get();
                $jornadas_ativas = \App\Jornada::where('pessoa',$educador->id)->where('status','ativa')->get();
                $carga = \App\PessoaDadosJornadas::where('pessoa',$educador->id)->where('status','ativa')->first();

            }
            else{
                $educador->turmas = \App\Turma::where('professor',$educador->id)->whereBetween('data_termino',[$ano.'-11-01',$ano.'-12-31'])->where('status','x')->get();
                $jornadas_ativas = \App\Jornada::where('pessoa',$educador->id)
                                                ->whereIn('status',['ativa','encerrada'])
                                                ->where('inicio','<=',$ano.'-12-01')
                                                ->where(function($query) use($ano){
                                                        return $query->where('termino','>=',$ano.'-12-01')
                                                        ->orwhere('termino',null);})
                                                ->orderByDesc('id')->get();
                $carga = \App\PessoaDadosJornadas::where('pessoa',$educador->id)
                ->where('inicio','<=',$ano.'-12-01')
                ->where(function($query) use($ano){
                        return $query->where('termino','>=',$ano.'-12-01')
                        ->orwhere('termino',null)
                        ->orwhere('termino','0000-00-00');})
                ->orderByDesc('id')->first();
            }

            

            
            if($carga)
                $educador->carga = $carga->carga;
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
                    $atividade->inicio = $jornada->hora_inicio;
                    $atividade->termino = $jornada->hora_termino;
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
                        
                    $inicio = Carbon::createFromFormat('H:i', $jornada->hora_inicio);
                    $termino = Carbon::createFromFormat('H:i', $jornada->hora_termino);

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

        return view('relatorios.jornada-htp')
            ->with('dias',$dias)
            ->with('ano',$ano)
            ->with('educadores',$educadores);

    }
}