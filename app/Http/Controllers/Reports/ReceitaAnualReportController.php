<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceitaAnualReportController extends Controller
{

    public function receitaPorPrograma(int $ano = 2019){

        $array_matriculas = array();
        $array_valor = array();
        $valor_total = 0;

        $lancamentos = \App\Lancamento::select(['*','lancamentos.valor as valor_parcela'])
                                    ->leftjoin('boletos','boletos.id','=','lancamentos.boleto')
                                    ->whereYear('vencimento','=',$ano)
                                    ->where('boletos.status','pago')
                                    ->get();

        foreach($lancamentos as $lancamento){
            
        
            if(!in_array($lancamento->matricula,$array_matriculas))
            $array_matriculas[] = $lancamento->matricula;

            if(isset($array_valor[$lancamento->matricula]))
                $array_valor[$lancamento->matricula] += $lancamento->valor_parcela;
            else
                $array_valor[$lancamento->matricula] = $lancamento->valor_parcela*1;

        }

        $programas = \App\Programa::whereIn('id',[1,2,3,4,12])->get();

        foreach($programas as $programa){
            $array_pessoas = array();
            $array_matriculas_join = array();
            $matriculas = \App\Matricula::join('inscricoes','matriculas.id','=','inscricoes.matricula')
                                        ->join('turmas','inscricoes.turma','=','turmas.id')
                                        ->whereIn('matriculas.id',$array_matriculas)
                                        ->where('turmas.programa',$programa->id)
                                        ->get();
                            
            foreach($matriculas as $matricula){  
                    
                    if(!in_array($matricula->pessoa,$array_pessoas))                        
                        $array_pessoas[] = $matricula->pessoa;

                    if(!in_array($matricula->matricula,$array_matriculas_join)){
                        $array_matriculas_join[] = $matricula->matricula;
                        $programa->valor += $array_valor[$matricula->matricula];
                        unset($array_valor[$matricula->matricula]);      
                    }

            }
            $valor_total +=  $programa->valor;

            $programa->pessoas = count($array_pessoas);
            $programa->matriculas = count($array_matriculas_join);

        }
        return view('relatorios.receitas')->with('programas',$programas)->with('ano',$ano)->with('valor_total',$valor_total);

    }
}