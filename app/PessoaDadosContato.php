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
    	$telefones = PessoaDadosContato::where('pessoa',$id)->whereIn('dado',[2,9])->get();
    	return $telefones;

    }



}
