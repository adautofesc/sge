<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtestadoLog extends Model
{
    use HasFactory;
    public $timestamps = false;
    //protected $dates = ['data'];
    protected $casts = [
    'data' => 'date',
    ];


    public function getNomeResponsavel(){
		return \App\Pessoa::getNome($this->pessoa,'simples');
	}

    public static function registrar($codigo,$evento,$autor=0){
        if($autor == 0)
            $autor = Auth::user()->pessoa;
        
        $log = new AtestadoLog;
        $log->atestado = $codigo;
        $log->evento = $evento;
        $log->data = date('Y-m-d H:i');
        $log->pessoa = $autor;
        $log->save();

    }

	
}
