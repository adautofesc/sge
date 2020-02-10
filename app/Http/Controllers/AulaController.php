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
        $aulas = collect();
        $data_iteracao = \DateTime::createFromFormat('d/m/Y', $turma->data_inicio);
        $data_mal = \DateTime::createFromFormat('d/m/Y','08/07/2020');
        $termino = \DateTime::createFromFormat('d/m/Y', $turma->data_termino); 
        while($data_iteracao <= $termino){
            if(in_array(Data::stringDiaSemana($data_iteracao->format('d/m/Y')), $turma->dias_semana)){
                $letivo = DiaNaoLetivoController::eLetivo($data_iteracao);
                if($letivo){     
                    if(AulaController::eNova($data_iteracao,$turma->id)){  
                        $aulas->push(AulaController::criar($data_iteracao,$turma->id));
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
                //apagra presenças
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
       return $aula;
    }



    public function aulasTurma(int $turma){
        $aulas = Aula::where('turma',$turma)->get();
        return $aulas;

    }


    public function viewAulasTurma(int $turma){
        return count($this->aulasTurma($turma));

    }


    public function alterar($aulas, $acao){
        
        
        $aulas = explode(',',$aulas);

        //dd($aulas);
        foreach($aulas as $aula){
            if(is_numeric($aula)){
                switch($acao){
                    case 'adiar':
                        $this->alterarStatus($aula,'adiada');
                        break;
                    case 'cancelar':
                        $this->alterarStatus($aula,'cancelada');
                        break;
                    case 'atribuir':
                        $this->alterarStatus($aula,'cancelada');
                        break;
                    case 'executar':
                        $this->alterarStatus($aula,'executada');
                        break;
                    

                }
            }
                
        }

        return redirect()->back()->withErrors(['Alterações concluídas']);

        
    }

    public function alterarStatus(Request $r){
        $DC = new AulaDadoController;

        $aulas = Aula::whereIn('id',$r->aulas)->get();

        if(isset($r->action)){
            switch($r->action){
                case 'cancelar': 
                    foreach($aulas as $aula){
                        $aula->status = 'cancelada';
                        $aula->save();
                        if(isset($r->motivo))
                            $DC->createDadoAula($aula->id,'cancelamento',$r->motivo);       
                    }
                    return response('',200);
                break;
                case 'previsionar' : 
                    foreach($aulas as $aula){
                        //$motivos = $DC->
                        $aula->status = 'prevista';
                        $aula->save();
                    }
                break;
                case 'adiar' : 
                    foreach($aulas as $aula){
                        $DC->createDadoAula($aula->id,'atribuicao',$r->pessoa);   
                        $aula->status = 'adiada';
                        $aula->save();
                        criar(\DateTime::createFromFormat('d/m/Y',$r->dia),$aula->turma); 
                    }
                break;
                case 'atribuir' : 
                    foreach($aulas as $aula){
                        $DC->createDadoAula($aula->id,'atribuicao',$r->pessoa);   
                    }
                break;
                case 'executar' : 
                    foreach($aulas as $aula){
                        $aula->status = 'executada';
                        $aula->save();
                    }
                break;
            }
            return response($r->ids,200);

        }
       

    }
    public function cancelamento(Request $r){
        return response($r->ids,200);
    }




}
