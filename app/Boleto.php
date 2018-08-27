<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lancamento;


class Boleto extends Model
{
    //
    public $timestamps = false;

    public function getLancamentos(){
    	$this->lancamentos = Lancamento::where('boleto',$this->id)->get();
    	return $this->lancamentos;
    }
}
