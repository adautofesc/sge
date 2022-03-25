<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
     public function curso(){
    	return $this->belongsToMany(Curso::Class);
    }

    public static function getSigla(int $id){
        $programa = Programa::find($id);
        return $programa->sigla;
    }

    public static function getNome(int $id){
        $programa = Programa::find($id);
        return $programa->nome;
    }
}
