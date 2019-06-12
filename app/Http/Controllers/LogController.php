<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Log;

class LogController extends Controller
{
    //
    public static function alteracaoBoleto($boleto,$motivo){
    	$log = new Log;
    	$log->tipo = 'boleto';
    	$log->codigo = $boleto;
    	$log->evento = $motivo;
    	$log->data = date('Y-m-d H:i');
    	$log->pessoa = Session::get('usuario');
    	$log->save();
    }
    public static function registrar($tipo,$codigo,$evento){
        
        $log = new Log;
        $log->tipo = $tipo;
        $log->codigo = $codigo;
        $log->evento = $evento;
        $log->data = date('Y-m-d H:i');
        $log->pessoa = Session::get('usuario');
        $log->save();


    }
}
