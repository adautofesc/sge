<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AtestadoLog;

class AtestadoLogController extends Controller
{
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
