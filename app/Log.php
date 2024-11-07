<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    public $timestamps = false;
    protected $dates = ['data'];

    public function getPessoa(){
        $pessoa = \App\Pessoa::withTrashed()->find($this->pessoa);
        return $pessoa->nome_simples;
    }
}
