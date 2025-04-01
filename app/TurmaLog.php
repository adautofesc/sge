<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaLog extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $dates = ['data'];

    public function getPessoa(){
        $pessoa = \App\Pessoa::withTrashed()->find($this->pessoa);
        return $pessoa->nome_simples;
    }
}
