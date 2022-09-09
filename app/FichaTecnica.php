<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTecnica extends Model
{
    use HasFactory;
    protected $table  = 'fichas_tecnicas';
    protected $dates = ['data_inicio','data_termino'];


    public function getDocente(){
        $pessoa = \App\Pessoa::find($this->docente);
        return $pessoa->nome_simples;
    }

    public function getPrograma(){
        $programa = \App\Programa::find($this->programa);
        return $programa->nome;
        
    }

    public function getLocal(){
        $local = \App\Local::find($this->local);
        return $local->nome;

    }

    public function getSala(){
        $sala = \App\Sala::find($this->sala);
        return $sala->nome;


    }

    public function getHoraInicioAttribute($value){
        return substr($value,0,5);
    }

    public function getHoraTerminoAttribute($value){
        return substr($value,0,5);
    }
}
