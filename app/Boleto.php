<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Lancamento;


class Boleto extends Model
{
    //
    use SoftDeletes;
    public $timestamps = false;

    public function getLancamentos(){
    	$this->lancamentos = Lancamento::where('boleto',$this->id)->get();
    	return $this->lancamentos;
    }
}
