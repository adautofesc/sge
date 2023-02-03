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

        return "Recesso inserido com sucesso.";
    }

    public function ViewAddRecesso(){

        return $this->addRecesso('03/07/2023','14/07/2023');
    }

    public function cadastroAnual($ano = 2023){
        $feriados_nacionais = \App\classes\Data::diasFeriados($ano);
        $feriados_estaduais =  ['Revolução Constitucionalista' => $ano.'-'.'07-09'];
        $feriados_municipais = ['N.S. da Babilônia' => $ano.'-'.'08-15', 
                                'Aniversário da cidade' => $ano.'-'.'11-04'];
                            
        $pontos_facultativos = ['Quarta de cinzas'=>$ano.'-02-22',
                                'Ponto facultativo' => $ano.'-06-09',
                                'Ponto facultativo' => $ano.'-08-14',
                                'Ponto facultativo' => $ano.'-09-08',
                                'Ponto facultativo' => $ano.'-10-13',
                                'Ponto facultativo' => $ano.'-11-03',
                                'Ponto facultativo' => $ano.'-12-26',

                                'Dia do Funcionário Público' => $ano.'-10-28',
                                

       
                               ]; 

        $feriados = array_merge($feriados_nacionais,$feriados_estaduais,$feriados_municipais,$pontos_facultativos);

        asort($feriados);

        
        
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
