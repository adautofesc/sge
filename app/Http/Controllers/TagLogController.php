<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TagLog;

class TagLogController extends Controller
{
    //
    public static function registrar($evento){
        
        $log = new TagLog;
        $log->pessoa = 0;
        $log->evento = $evento;
        $log->data = new \DateTime();
        $log->save();
        return $log;
        
    }
}
