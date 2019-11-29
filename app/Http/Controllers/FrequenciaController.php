<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;
use App\AulaDado;
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
        return view('frequencias.lista-unitaria',compact('inscritos'))->with('i',1)->with('aulas',$aulas);
    }

    public function novaFrequencia(int $aula, int $aluno){
        $frequencia =  new Frequencia;
        $frequencia->aula = $aula;
        $frequencia->aluno = $aluno;
        $frequencia->save();
        return $frequencia;
    }

    public function novaChamada(int $turma){
        $aulas = Aula::where('turma',$turma)->whereIn('status',['prevista','planejada'])->orderBy('data')->get();
        if(count($aulas)==0){
            $AULA_CONTROLER = new AulaController;
            $aulas = $AULA_CONTROLER->gerarAulas($turma);

        }    
        /*
        foreach($aulas as $aula){
            $aula->data = \DateTime::createFromFormat('Y-m-d',$aula->data);
        }*/
        $turma = \App\Turma::find($turma);

        $turma->getInscricoes('regulares');

        $aulas_anteriores = Aula::where('turma',$turma->id)->whereIn('status',['executada','adiada','cancelada'])->orderByDesc('data')->get();
        foreach($aulas_anteriores as $aula_anterior){
            if($aula_anterior->status == 'executada')
                $aula_anterior->conteudo = $aula_anterior->getConteudo();
            else
                $aula_anterior->conteudo = 'Aula '.$aula_anterior->status;
            $aula_anterior->ocorrencia = $aula_anterior->getOcorrencia();
        }

        //dd($aulas_anteriores);

        return view('frequencias.chamada')->with('turma',$turma)->with('aulas',$aulas)->with('anteriores',$aulas_anteriores);

    }

    public function gravarChamada(Request $req){
       
        $aula = Aula::find($req->aula);
    
        if(!is_null($req->conteudo)){
            $info = new AulaDado();
            $info->dado = 23;
            $info->aula = $req->aula;
            $info->valor = $req->conteudo;
            $info->save();
        }
        if(!is_null($req->ocorrencia)){
            $info = new AulaDado();
            $info->dado = 24;
            $info->aula = $req->aula;
            $info->valor = $req->ocorrencia;
            $info->save();
        }
        foreach($req->aluno as $aluno){  
            $this->novaFrequencia($req->aula,$aluno);
        }

        $aula->status = 'executada';
        $aula->save();
        
        return redirect(asset('/docentes'))->withErrors(['Chamada registrada.']);

    }
}
