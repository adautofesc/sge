<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Endereco extends Model
{

	public function getBairro(){
		$bairro=DB::table('bairros_sanca')->find($this->bairro);
        if($bairro->id>0)
            return $bairro->nome;
        else
            return $this->bairro_str;
	}
	
}
