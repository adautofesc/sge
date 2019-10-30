<?php

namespace App;
use App\AulaDado;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    public $timestamps = false;

    public function getDataAttribute($value){
        $newdata = \DateTime::createFromFormat('Y-m-d',$value);
        return $newdata;
    }

    public function getAlunosPresentes(){
        $presentes = array();
        $frequencias = \App\Frequencia::select('aluno')->where('aula',$this->id)->get();
        foreach($frequencias as $frequencia){
            $presentes[] = $frequencia->aluno;
        }
        return $presentes;

    }

    public function getConteudo(){
        $conteudo = AulaDado::where('aula',$this->id)->where('dado',23)->get();
        if(count($conteudo))
            return $conteudo->implode('valor','. ');
        else
            return 'Nenhum conteúdo registrado.';
    }

    public function getOcorrencia(){
        $ocorrencias = AulaDado::where('aula',$this->id)->where('dado',24)->get();
        if(count($ocorrencias))
            return $ocorrencias->implode('valor','. ');
        else
            return 'Nenhuma ocorrência registrada.';

    }
}
