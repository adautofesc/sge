<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BoletoLog;
use Auth;

class BoletoLogController extends Controller
{
    
    public function migrarLogs(){
        $logs = \App\Log::where('tipo','boleto')->get();
        foreach($logs as $log){
            $boleto = \App\Boleto::find($log->codigo);
            
            if(isset($boleto->id)){
                $new_log = new BoletoLog;
                $new_log->boleto = $log->codigo;
                $new_log->evento = $log->evento;
                $new_log->data = $log->data;
                $new_log->pessoa = $log->pessoa;
                $new_log->save();
                $log->delete();
                echo $new_log->boleto.' - '.$new_log->evento.'<br>';
            }
            else{
                echo $log->codigo.' NÃO ENCONTRADO '.'<br>';
                $log->delete();

            }


        }

    }

    public static function alteracaoBoleto($boleto,$motivo){
    	$log = new BoletoLog;
    	$log->boleto = $boleto;
    	$log->evento = $motivo;
    	$log->data = date('Y-m-d H:i');
    	$log->pessoa = Auth::user()->pessoa;
    	$log->save();
    }

    public static function registrar($boleto,$evento,$autor=0){
        if($autor == 0)
            $autor = Auth::user()->pessoa;
        
        $log = new BoletoLog;
        $log->boleto = $boleto;
        $log->evento = $evento;
        $log->data = date('Y-m-d H:i');
        $log->pessoa = $autor;
        $log->save();


    }

}
