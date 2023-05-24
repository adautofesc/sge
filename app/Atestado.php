<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atestado extends Model
{
    use SoftDeletes;
    protected $dates = ['emissao','validade','created_at','deleted_at'];
   

    public function calcularVencimento($programa){
    	if($programa == 12) //se for piscina
    		$validade = "+6 months";
    	else
    		$validade = "+12 months";

    	if($this->emissao == null)
    		return $this->validade;
    	else
    		
    		$vencimento = date('Y-m-d 23:23:59', strtotime($validade,strtotime($this->emissao))); 


    	return $vencimento;



    }

	public function getNome(){
		return \App\Pessoa::getNome($this->pessoa);
	}


}
