<?php
namespace App\classes;

Class KeyGen {

	public static function generate(){
		//Cria chave para validar recurso de esquecimento de email
		$valor='';
		$caracteres = 'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&1234567890';
		for($m=0;$m<6;$m++){
			$index=rand(0,strlen($caracteres));
			$valor.=substr($caracteres,$index,1);


		}
		return $valor;

	}
}
?>