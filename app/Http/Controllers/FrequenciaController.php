<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;
use App\Frequencia;

class FrequenciaController extends Controller
{
    public function listaChamada(int $turma){
        $aulas = Aula::where('turma',$turma)->get();
        foreach($aulas as $aula){
            $aula->presentes = $aula->getAlunosPresentes();
            
        }

        //dd($aulas);

        $inscritos=\App\Inscricao::where('turma',$turma)->whereIn('status',['regular','espera','ativa','pendente'])->get();
        $inscritos= $inscritos->sortBy('pessoa.nome');
        return view('frequencias.frequencia-unitaria',compact('inscritos'))->with('i',1)->with('aulas',$aulas);
    }

    public function novaFrequencia(int $aula, int $aluno){
        $frequencia =  new Frequencia;
        $frequencia->aula = $aula;
        $frequencia->aluno = $aluno;
        $frequencia->save();
        return $frequencia;
    }
}
