<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;
use App\AulaDado;
use App\Turma;
use App\classes\Data;
use App\DiaNaoLetivo;
use Exception;

class AulaController extends Controller
{
    public function gerarAulas(int $turma){   
        $turma = Turma::find($turma);
        $data_iteracao = \DateTime::createFromFormat('d/m/Y', $turma->data_inicio);
        $data_mal = \DateTime::createFromFormat('d/m/Y','08/07/2020');
        $termino = \DateTime::createFromFormat('d/m/Y', $turma->data_termino); 
        while($data_iteracao <= $termino){
            if(in_array(Data::stringDiaSemana($data_iteracao->format('d/m/Y')), $turma->dias_semana)){
                $letivo = DiaNaoLetivoController::eLetivo($data_iteracao);
                if($letivo){     
                    if(AulaController::eNova($data_iteracao,$turma->id)){  
                        $aulas[] = AulaController::criar($data_iteracao,$turma->id);
                        $data_iteracao->add(new \DateInterval('P1D'));
                    }
                    else
                        $data_iteracao->add(new \DateInterval('P1D'));
                }
                else
                    $data_iteracao->add(new \DateInterval('P1D'));
            }
            else
                $data_iteracao->add(new \DateInterval('P1D'));

        }
        return $aulas;
        
    }



    public function apagarAulasTurma(int $turma){
        $aulas = Aula::where('turma',$turma)->get();
        $msg = array();
        foreach($aulas as $aula){
            $msg[] = $this->apagarAula($aula->id);
        }

        return $msg;
    }


    public function apagarAula(int $aula){
        $aula = Aula::find($aula);
        if(is_null($aula))
            return "aula não encontrada";
        else {
            try {
                $aula->delete();
                $msg = "Aula do dia " . $aula->data . "foi apagada.";
            }
            catch(\Exception $exception){
                $msg = "Aula do dia " . $aula->data . " (" . $aula->id . ") não pôde ser apagada: " . $exception->code . " " . $exception->message; 

            }
            return $msg;
        }
            

    }


    public function eNova(\DateTime $data,  int $turma){
        $aula = Aula::where('data',$data->format('Y-m-d'))->where('turma',$turma)->first();
        if (is_null($aula))
            return true;
        else
            return false;
    }



    public function criar(\DateTime $data, int $turma){
       $aula = new Aula;
       $aula->data = $data->format('Y-m-d');
       $aula->turma = $turma;
       $aula->status = 'prevista';
       $aula->save();
       return 'Aula ' . $aula->id .' cadastrada dia '.$data->format('d/m/Y').' na turma '.$turma;
    }



    public function aulasTurma(int $turma){
        $aulas = Aula::where('turma',$turma)->get();
        return $aulas;

    }


    public function viewAulasTurma(int $turma){
        return count($this->aulasTurma($turma));

    }

    public function novaChamada(int $turma){
        $aulas = \App\Aula::where('turma',$turma)->whereIn('status',['prevista','planejada'])->orderBy('data')->get();
        /*
        foreach($aulas as $aula){
            $aula->data = \DateTime::createFromFormat('Y-m-d',$aula->data);
        }*/
        $turma = Turma::find($turma);

        $turma->getInscricoes('regulares');

        $aulas_anteriores = \App\Aula::where('turma',$turma->id)->whereIn('status',['executada','adiada','cancelada'])->orderByDesc('data')->get();
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
        $FC = new FrequenciaController;
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
            $FC->novaFrequencia($req->aula,$aluno);
        }

        $aula->status = 'executada';
        $aula->save();
        
        return redirect(asset('/docentes'))->withErrors(['Chamada registrada.']);

    }


}
