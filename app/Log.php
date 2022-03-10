<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    public $timestamps = false;

    public function getPessoa(){
        $pessoa = \App\Pessoa::find($this->pessoa);
        return $pessoa->nome_simples;
    }
}
