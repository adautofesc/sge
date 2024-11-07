<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Pessoa;

class FichaTecnicaDados extends Model
{
    use HasFactory;
    protected $table  = 'ficha_tecnica_dados';

    public function getPessoa($dado='nome'){
        $pessoa = Pessoa::find($this->agente);
        if(!isset($pessoa->id))
            return 'N/A';
        else
            return $pessoa->$dado;
    }

    
}
