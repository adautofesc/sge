<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\TurmaLog;

class TurmaLogController extends Controller
{
    
    public static function registrar($tipo,$codigo,$evento,$autor=0){
        if($autor == 0)
            $autor = Auth::user()->pessoa;
        
        $log = new TurmaLog;
        $log->turma = $codigo;
        $log->evento = $evento;
        $log->data = date('Y-m-d H:i');
        $log->pessoa = $autor;
        $log->save();


    }
}
