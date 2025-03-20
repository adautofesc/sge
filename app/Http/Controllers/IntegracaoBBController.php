<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IntegracaoBBController extends Controller
{
	CONST BB_URL = 'https://api.sandbox.bb.com.br/cobrancas/v2';
	CONST OAUTH_BB_URL =  'https://oauth.sandbox.bb.com.br/oauth/token';

	// URLs do ambiente de homologação

	

	// Função para obter o token de acesso
	function getAccessToken() {
		$auth = base64_encode(env('BB_client_id').':'.env('BB_client_secret'));

		$responsex = Http::withHeaders([
			
			'Authorization' =>'Basic '.$auth,
			'Content-Type'=>'application/x-www-form-urlencoded'
		
		])->withOptions(['verify' => false,])->post(self::OAUTH_BB_URL,[
			'grant_type'=>'client_credentials',
			'scope'=>'cobrancas.boletos-info'

			
		
		]);
		
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => self::OAUTH_BB_URL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_SSL_VERIFYPEER=>false,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=cobrancas.boletos-requisicao',
			CURLOPT_HTTPHEADER => [
				'Authorization: Basic ' . $auth,
				'Content-Type: application/x-www-form-urlencoded'
			],
		]);
		
		// Executar a requisição
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		// Fechar a conexão cURL
		curl_close($curl);
		//dd($err);
		
		
		return json_decode($response, true);
	}
	
    
    public function registrarBoletos($ids){
		$url = self::BB_URL.'/boletos/'; 

		$response = Http::withHeaders([
			'gw-app-key' => env('BB_gw'),
		
		])->post($url);

		return $response;
      
	}

	public function listarBoletos(){
		
		//dd($this->getAccessToken());
		$url = self::BB_URL.'/boletos/'; //BB

		$response = Http::withHeaders([
			
			'Authorization' =>$this->getAccessToken()["access_token"
		]])->withOptions(['verify' => false,])->get($url,[
			
			'gw-app-key' => env('BB_dev_app_key'),
		]);

		return $response;

	}
}
