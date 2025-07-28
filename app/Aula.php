<?php

namespace App;
use App\AulaDado;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aula extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    //protected $dates = ['data'];
    protected $casts = [
    'data' => 'date',
    ];

    /*public function getDataAttribute($value){
        $newdata = \DateTime::createFromFormat('Y-m-d',$value);
        return $newdata;
    }*/

    public function getAlunosPresentes(){
        $presentes = array();
        $frequencias = \App\Frequencia::select('aluno')->where('aula',$this->id)->get();
        foreach($frequencias as $frequencia){
            $presentes[] = $frequencia->aluno;
        }
        return $presentes;

    }

    public function getConteudo(){
        $conteudo = AulaDado::where('aula',$this->id)->where('dado','conteudo')->get();
        if($conteudo->count())
            return $conteudo->implode('valor','. ');
        else
            return 'Nenhum conteúdo registrado.';
    }

    public function getOcorrencia(){
        $ocorrencias = AulaDado::where('aula',$this->id)->where('dado','ocorrencia')->get();
        if($ocorrencias->count())
            return $ocorrencias->implode('valor','. ');
        else
            return 'Nenhuma ocorrência registrada.';

    }

    public function getDados($dado){
        $dados = AulaDado::where('aula',$this->id)->where('dado',$dado)->get();
        if($dados->count())
            return $dados->implode('valor','. ');
        else
            return '';

    }
}
