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



    public function apagarAulasTurma(int $turma, string $tipoAula = 'prevista'){
        if($tipoAula == 'todas')
            $aulas = Aula::where('turma',$turma)->get();
        else{
            $aulas_arr = explode(',',$tipoAula);
            $aulas = Aula::where('turma',$turma)->whereIn('status',$aulas_arr)->get();
            unset($aulas_arr);

        }
        $msg = array();
        foreach($aulas as $aula){
            $msg[] = $this->apagarAula($aula->id);
        }

        return $msg;
    }


    public function apagarAula(int $aula){
        $aula = Aula::find($aula);
        if(is_null($aula)){
            return "aula não encontrada";
        }
        else {
            $msg = "Aula do dia " . $aula->data->format('d/m/y') . "foi apagada.";
            $aula->delete();
            //apagra presenças
                
            
            
            return $msg;
        }
            
    }

    public function excluir(Request $r){
        
        if(is_array($r->id)){
            foreach($r->id as $cod){
                $this->apagarAula($cod);
            }
        }
        else
            $this->apagarAula($r->id);


        return response('done',200);
    }

    public function recriarAulas(string $turmas){
        $turmas = explode(',',$turmas);
        foreach($turmas as $turma){
            $this->apagarAulasTurma($turma);
            $this->gerarAulas($turma);
        }
        return response('Turmas recriadas');
    }


    public static function eNova(\DateTime $data,  int $turma){
        $aula = Aula::where('data',$data->format('Y-m-d'))->where('turma',$turma)->first();
        if (is_null($aula))
            return true;
        else
            return false;
    }



    public static function criar(\DateTime $data, int $turma){
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


    
    public function alterar(string $aulas, string $acao){      
        $aulas = explode(',',$aulas);
        $aulas_collection = Aula::whereIn('id',$aulas)->get();

        foreach($aulas_collection as $aula){
            
            switch($acao){
                case 'adiar':
                    $aula->status = 'adiada';
                    $aula->save();
                    break;
                case 'cancelar':
                    $aula->status = 'cancelada';
                    $aula->save();
                    break;

                case 'executar':
                    $aula->status = 'executada';
                    $aula->save();
                    break;

                case 'previsionar': 
                    $aula->status = 'prevista';
                    $aula->save();
                    break;

                

            }
            
                
        }
        return redirect()->back()->withErrors(['Alterações concluídas']);     
    }

    public function alterarStatus(Request $r){
        $DC = new AulaDadoController;

        //$aulas = Aula::whereIn('id',$r->aulas)->get();

        if(isset($r->action)){
            foreach($r->aulas as $aula){
                $this->alterar($aula,$r->action);
                switch($r->action){
                    case 'cancelar':                         
                        if(isset($r->motivo))
                            $DC->createDadoAula($aula,'cancelamento',$r->motivo);                              
                        return response('',200);
                        break;
            
                    case 'adiar' :   
                        $DC->createDadoAula($aula,'adiamento',$r->dia);                              
                        $this->criar(\DateTime::createFromFormat('d/m/Y',$r->dia),$r->turma); 
                        
                    break;
                    case 'atribuir' : 
                        $DC->createDadoAula($aula,'atribuicao',$r->pessoa);   
                        break;
                 
                }
            }
            return response($r->ids,200);

        }
       

    }
    public function cancelamento(Request $r){
        return response($r->ids,200);
    }




}
