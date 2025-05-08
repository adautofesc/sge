<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AulaDado;


class AulaDadoController extends Controller
{
    /**********Tipos
     * 23 conteudo
     * 24 ocorrencia
     ***********
     */
    public static function createDadoAula(int $aula,  string $tipo, string $conteudo ){
        if(!is_null($conteudo) && $conteudo <> ''){
            $info = new AulaDado();
            $info->dado = $tipo;
            $info->aula = $aula;
            $info->valor = $conteudo;
            $info->save();
            return $info;
        }
    }
    public static function updateDadoAula(int $aula, string $tipo, string $conteudo){
        $dado = AulaDado::where('aula',$aula)->where('dado',$tipo)->first();
        if(isset($dado->id)){
            if($dado->valor <> $conteudo)
                $dado->valor = $conteudo;
                $dado->save();
        }
        else 
            AulaDadoController::createDadoAula($aula,$tipo, $conteudo);

    }
    public function limparDado(Request $r){
        $dados = AulaDado::where('aula',$r->aula)->where('dado',$r->dado)->get();
        foreach($dados as $info){
            $info->delete();
        }
    }

    public function editarConteudo_view(int $turma){
        $turma = \App\Turma::find($turma);
        if(!isset($turma->id))
            return redirect()->back()->withErrors('Turma não encontrada');
        $aulas = \App\Aula::select('*','aulas.id as id')
            ->where('turma',$turma->id)
            ->where('status','executada')
            //->leftjoin('aula_dados', 'aulas.id','=','aula_dados.aula')
            ->leftjoin('aula_dados', function($query){
                $query->on( 'aulas.id','=','aula_dados.aula');
                $query->where('aula_dados.dado','conteudo');
            })
            ->orderBy('data')
            ->get();
        //return $aulas;
        return view('frequencias.conteudos')->with('aulas',$aulas)->with('turma',$turma);

    }

    public function editarConteudo_exec(Request $r){
        foreach($r->conteudo as $aula=>$conteudo){
            $conteudo_db = AulaDado::where('aula',$aula)->where('dado','conteudo')->first();
            if(!is_null($conteudo_db)){
                $conteudo_db->valor = $conteudo;
                $conteudo_db->save();

            }
            else{
                if(!is_null($conteudo))
                    $this->createDadoAula($aula,'conteudo',$conteudo);
            }
        }
        return redirect()->back()->withErrors(['success'=>'Dados atualizados com sucesso']);
    }

    public function relatorioConteudo(string $turmas, string $datas=null){
        $arr_turma = explode(',',$turmas);
        if($datas){
            $arr_datas = explode(',',$datas);
            $conteudo = AulaDado::join('aulas','aulas.id','aula_dados.aula')
                    ->whereBetween('aulas.data',$arr_datas)
                    ->whereIn('aulas.turma',$arr_turma)
                    ->orderByDesc('aulas.turma','aulas.data')
                    ->get();

        }
        else
            $conteudo = AulaDado::join('aulas','aulas.id','aula_dados.aula')
                        ->whereIn('aulas.turma',$arr_turma)
                        ->orderByDesc('aulas.turma','aulas.data')
                        ->get();
        $turmas = \App\Turma::whereIn('id',$arr_turma)->get();

        
        return view('aulas.imprimir')->with('turmas',$turmas)->with('conteudo',$conteudo);

    }

}
