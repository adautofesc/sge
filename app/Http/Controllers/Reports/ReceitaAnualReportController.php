<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceitaAnualReportController extends Controller
{

    public function receitaPorPrograma(int $ano, int $mes=null){

        $array_matriculas = array();
        $array_valor = array();
        $valor_total = 0;

        //dd(str_pad($mes,2,'0'));

       if($mes){
       $lancamentos = \App\Boleto::select(['*','lancamentos.valor as valor_parcela'])
                                    ->join('lancamentos','boletos.id','=','lancamentos.boleto')
                                    ->where('boletos.vencimento','like', $ano.'-'.str_pad($mes,2,'0',STR_PAD_LEFT).'%')                                   
                                    ->where('boletos.status','pago')
                                    //->toSql();
                                    ->get();
        //dd($lancamentos);
        $data = new \App\classes\Data('01/'.$mes.'/'.$ano);
        $mes = $data->mes();
       }else{
            $lancamentos = \App\Boleto::select(['*','lancamentos.valor as valor_parcela'])
            ->join('lancamentos','boletos.id','=','lancamentos.boleto')
            ->whereYear('vencimento',$ano)                       
            ->where('boletos.status','pago')
            //->toSql();
            ->get();
    

       }
       
 

        foreach($lancamentos as $lancamento){
            
        
            if(!in_array($lancamento->matricula,$array_matriculas))
            $array_matriculas[] = $lancamento->matricula;

            if(isset($array_valor[$lancamento->matricula]))
                $array_valor[$lancamento->matricula] += $lancamento->valor_parcela;
            else
                $array_valor[$lancamento->matricula] = $lancamento->valor_parcela*1;

        }

        $programas = \App\Programa::whereIn('id',[1,2,3,4,12])->get();

        /*
        $matriculas_programa = array();

        foreach($programas as $programa){
            $programa->matriculas = 0;
            $programa->valor = 0;
            $programa->pessoas = 0;
            $turmas = \App\Turma::whereYear('data_inicio',$ano)->where('programa',$programa->id)->whereIn('status',['lancada','iniciada'])->pluck('id')->toArray();
            //dd($turmas);
            $matriculas_programa[$programa->id] = \App\Inscricao::whereIn('turma',$turmas)->whereIn('status',['pendente','regular'])->groupBy('matricula')->pluck('matricula')->toArray();
           
        } */ 






        foreach($programas as $programa){
            $array_pessoas = array();
            $array_matriculas_join = array();
            $matriculas = \App\Matricula::join('inscricoes','matriculas.id','=','inscricoes.matricula')
                                        ->join('turmas','inscricoes.turma','=','turmas.id')
                                        ->whereIn('matriculas.id',$array_matriculas)
                                        ->where('turmas.programa',$programa->id)
                                        ->get();
                            
            foreach($matriculas as $matricula){  
               // if($programa->id == 3 && $matricula->matricula == 15518)
                //dd($array_valor);
                    
                    if(!in_array($matricula->pessoa,$array_pessoas))                        
                        $array_pessoas[] = $matricula->pessoa;

                    if(!in_array($matricula->matricula,$array_matriculas_join)){
                        $array_matriculas_join[] = $matricula->matricula;
                        if(isset($array_valor[$matricula->matricula])){
                            $programa->valor += $array_valor[$matricula->matricula];
                            unset($array_valor[$matricula->matricula]); 
                        }    
                    }

            }
            $valor_total +=  $programa->valor;

            $programa->pessoas = count($array_pessoas);
            $programa->matriculas = count($array_matriculas_join);

        }
        return view('relatorios.receitas')->with('programas',$programas)->with('ano',$ano)->with('valor_total',$valor_total)->with('mes',$mes);

    }

    public function receitaPorCurso($cursos, int $ano, int $mes=null){
        //return 'relatório receita por curso';

        $array_matriculas = array();
        $array_valor = array();
        $array_cursos = explode(',', $cursos);

        $valor_total = 0;

        //dd($array_cursos);

        if(count($array_cursos) == 0)
            return redirect()->back()->with('error','Nenhum curso selecionado');
        
        foreach($array_cursos as $curso_id){
            $curso = \App\Curso::find($curso_id);
            if($curso == null)
                return redirect()->back()->with('error','Curso inválido: '.$curso_id);
            else{
                $array_valor[$curso->id] ['valor']= 0;
                $array_valor[$curso->id] ['nome']= $curso->nome;

                $turmas = \App\Turma::whereYear('data_inicio',$ano)
                                            ->where('curso',$curso->id)
                                            ->pluck('id')->toArray();

                if(count($turmas) > 0){
                    $matriculas = \App\Inscricao::whereIn('turma',$turmas)
                                                ->groupBy('matricula')
                                                ->pluck('matricula')->toArray();

                    if(count($matriculas) > 0){
                        $soma_lancamentos = \App\Lancamento::join('boletos','boletos.id','=','lancamentos.boleto')
                            ->whereIn('boletos.status',['pago'])
                            ->whereIn('lancamentos.matricula',$matriculas)
                            ->sum('lancamentos.valor');
                        $valor_total += $soma_lancamentos;
                        $array_valor[$curso->id] ['valor'] = $soma_lancamentos;
                    }
                    
                }
                
            }
        }
        //dd($array_valor);

        return view('relatorios.receitas-curso')->with('valores',$array_valor)->with('ano',$ano)->with('valor_total',$valor_total);

    }
        

        
}