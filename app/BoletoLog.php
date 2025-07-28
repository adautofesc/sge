<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletoLog extends Model
{
    use HasFactory;
    public $timestamps = false;
    //protected $dates = ['data'];
    protected $casts = [
    'data' => 'date',
    ];

    public function getPessoa(){
        $pessoa = \App\Pessoa::find($this->pessoa);
        return $pessoa->nome_simples;
    }

    


}
