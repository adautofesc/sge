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

        return $this->addRecesso('06/07/2020','31/07/2020');
    }

    public function cadastroAnual($ano = 2022){
        $feriados_nacionais = \App\classes\Data::diasFeriados($ano);
        $feriados_estaduais =  ['Revolução Constitucionalista' => $ano.'-'.'07-09'];
        $feriados_municipais = ['N.S. da Babilônia' => $ano.'-'.'08-15', 
                                'Aniversário da cidade' => $ano.'-'.'11-04'];
                            
        $pontos_facultativos = ['Dia dos professores' => $ano.'-'.'10-15', 
                               'Compensação do Dia do funcionalismo público 28/10' => $ano.'-'.'11-03']; 

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
