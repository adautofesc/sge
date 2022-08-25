<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsoLivre extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = ['inicio'];

    public function getUsuario(){
        $pessoa = \App\Pessoa::find($this->atendido);
        return $pessoa->nome;
    }
    public function getResponsavel(){
        $pessoa = \App\Pessoa::find($this->responsavel);
        return $pessoa->nome;

    }
}
