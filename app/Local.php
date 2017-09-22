<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table  = 'locais';

    public static function getUnidades(){
    	$unidades=Local::distinct('unidade')->get(['unidade']);

    	return $unidades;



    }
    public static function getSalasUnidade($unidade){
    	$salas=Local::where('unidade',$unidade)->get();

    	return $salas;

    }




}
