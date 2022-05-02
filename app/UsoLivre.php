<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsoLivre extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function getUsuario(){
        $pessoa = \App\Pessoa::find($this->atendido);
        return $pessoa->nome;
    }
}
