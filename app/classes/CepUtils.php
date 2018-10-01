<?php
namespace App\classes;

use Illuminate\Support\Facades\DB;

class CepUtils{
	private $cep;
	private $logradouro;
	private $bairro;
	private $cidade;
	private $uf;


	public static function getBairro($cep){
		$url = "https://viacep.com.br/ws/".$cep."/json/";

		$ch = curl_init();
        //não exibir cabeçalho
        curl_setopt($ch, CURLOPT_HEADER, false);
        // redirecionar se hover
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // desabilita ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //envia a url
        curl_setopt($ch, CURLOPT_URL, $url);
        //executa o curl
        $result = curl_exec($ch);
        //encerra o curl

        $status = curl_getinfo($ch);

       

        if($status["http_code"]== 400 || $status["http_code"]== 500)
        		return 'ERRO.';

        curl_close($ch);





        $ws = json_decode($result);
       
        if(isset($ws->erro))
        		return 'ERRO.';
        	


        $obj = new CepUtils();
        $obj->cep  = $ws->cep;
        $obj->logradouro  = $ws->logradouro;
        $obj->bairro  = $ws->bairro;
        $obj->cidade  = $ws->localidade;
        $obj->uf = $ws->uf;
        return $obj->bairro;


	}

	public static function bairroCompativel($cep){
		$bairro_cep = CepUtils::getBairro($cep);
		if($bairro_cep == 'ERRO.')
			return 0;


		$bairro_cep_array=explode(' ',$bairro_cep);
		$q_nomes=count($bairro_cep_array);
		if($q_nomes>1){
			$bairro_cep='';
			for($i=1;$i<$q_nomes;$i++){
				$bairro_cep.=' '.$bairro_cep_array[$i];
			}
		}
		$bairro_cep = substr($bairro_cep,1);
		//eturn $bairro_cep;
		$compativel = DB::table('bairros_sanca')->where('nome','like','%'.$bairro_cep)->get();
		if(count($compativel)==1)
			return $compativel->first()->id;
		else
			return 0;
	}
}

?>