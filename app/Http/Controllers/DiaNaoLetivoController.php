<?php

namespace App\Http\Controllers;

use App\DiaNaoLetivo;
use Illuminate\Http\Request;

class DiaNaoLetivoController extends Controller
{
    public static function eLetivo(\DateTime $data){
        //$data2 = \DateTime::createFromFormat('d/m/Y','08/07/2020');
        $dia = DiaNaoLetivo::whereDate('data',$data->format('Y-m-d'))->first();   
        
        if(is_null($dia))
            return true;
        else
            return false;
    }

    public function addRecesso(string $inicio, string $termino){
      
        $inicio = \DateTime::createFromFormat('d/m/Y',$inicio);
        $termino = \DateTime::createFromFormat('d/m/Y',$termino);
        for($i=$inicio; $i<=$termino; $i->add(new \DateInterval('P1D'))){
            $dia = DiaNaoLetivo::where('data',$i->format('Y-m-d'))->first();
            if(is_null($dia)){
                $novo_dia = new DiaNaoLetivo;
                $novo_dia->data = $i->format('Y-m-d');
                $novo_dia->descricao = 'Recesso Escolar';
                $novo_dia->save();
            }

        }

        return "Recesso inserido com sucesso. Desde ".$inicio->format('d/m/Y')." até ".$termino->format('d/m/Y');
    }

    public function ViewAddRecesso(){

        return $this->addRecesso('06/07/2025','20/07/2025');
    }

    public function cadastroAnual($ano = 2025){
        $feriados_nacionais = \App\classes\Data::diasFeriados($ano);
        $feriados_estaduais =  ['Revolução Constitucionalista' => $ano.'-'.'07-09'];
        $feriados_municipais = ['N.S. da Babilônia' => $ano.'-'.'08-15', 
                                'Aniversário da cidade' => $ano.'-'.'11-04'];
                            
        $pontos_facultativos = [
                                'Ponto facultativo IV'=>$ano.'-04-17',
                                'Ponto facultativo V'=>$ano.'-04-19',
                                'Ponto facultativo VII' => $ano.'-05-02',
                                'Ponto facultativo VIII' => $ano.'-05-03',
                                'Ponto facultativo X' => $ano.'-06-20',
                                'Ponto facultativo XI' => $ano.'-06-21',
                                'Ponto facultativo XVI' => $ano.'-10-27',
                                'Dia do Funcionário Público' => $ano.'-10-28',
                                'Dia do Professor' => $ano.'-10-15',
                                'Ponto facultativo XIX' => $ano.'-11-03',
                                'Ponto facultativo XXIII' => $ano.'-11-21',
                                'Ponto facultativo XXIV' => $ano.'-11-22',
                              

                                
                                

       
                               ]; 

        $feriados = array_merge($feriados_nacionais,$feriados_estaduais,$feriados_municipais,$pontos_facultativos);

        asort($feriados);


        //dd($feriados);

        
        
        foreach($feriados as $feriado=>$data){
            $dia = DiaNaoLetivo::where('data',$data)->first();
            if(is_null($dia)){
                $novo_dia = new DiaNaoLetivo;
                $novo_dia->data = $data;
                $novo_dia->descricao = $feriado;
                $novo_dia->save();
            }
        }

        return $feriados;

    }

   
}
