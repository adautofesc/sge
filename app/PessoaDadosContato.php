<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaDadosContato extends Model
{
    //
    protected $table  = 'pessoas_dados_contato';

    public function pessoa(){
    	return $this->belongsTo('App\Pessoa','pessoa'); // (Pessoa::class)
    }
    public function dado(){
    	return $this->hasOne('App\TipoDado','dado'); // (Pessoa::class)
    }
    public static function getTelefone($id){
    	$telefone = PessoaDadosContato::where('pessoa',$id)->where('dado',2)->get();
    	if(count($telefone)>0)
    		return $telefone->first()->valor;
    	else
    		return '';

    }



}
