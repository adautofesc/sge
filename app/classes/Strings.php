<?php
namespace App\classes;
// http://forum.wmonline.com.br/topic/188764-transformar-primeira-letra-de-cada-palavra-em-maiuscula/
// adaptada com mb_convert_case por @Adautonet
Class Strings
{
	public static function converteNomeParaUsuario($s, $e = array('da', 'das', 'de', 'do', 'dos', 'e'))
	{
		return join(' ',
				   array_map(
					   create_function(
						   '$s',
						   'return (!in_array($s, ' . var_export($e, true) . ')) ? mb_convert_case($s, MB_CASE_TITLE, "UTF-8") : $s;'
					   ),
					   explode(
						   ' ',
						   strtolower($s)
					   )
				   )
			   );
	}
	/**
	 *
	 * https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
	 * Função de validar o CPF
	 * @param cpf - número fornecido pelo usuário
	 * @return valido ou não
	 *
	 */
	public static function validaCPF($cpf)
	 {
 
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf{$c} * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf{$c} != $d) {
            return false;
        }
    }
    return true;
	}


	/**
	* Mascara Universal para PHP
	* por: Rafael Clares: http://blog.clares.com.br/php-mascara-cnpj-cpf-data-e-qualquer-outra-coisa
	* baixado em 04/09/2017
	*
	* @param $val valor da string a ser convertida ex.: 1633721308
	* @param $mask: formato da string '(##) ####-####'
	* @return String formatada: (16) 3372-1308
	**/
	public static function mask($val, $mask)
	{
	 $maskared = '';
	 $k = 0;
	 for($i = 0; $i<=strlen($mask)-1; $i++)
	 {
		 if($mask[$i] == '#')
		 {
			 if(isset($val[$k]))
			 $maskared .= $val[$k++];
		 }
		 else
		 {
			 if(isset($mask[$i]))
			 $maskared .= $mask[$i];
		 }
	 }
	 return $maskared;
	}
	public static function formataTelefone($tel){
		$telefone=str_replace('-', '', $tel);
		$tipo=strlen($telefone);
		switch ($tipo) {
			case '8':
				//fixo sem DDD
				return substr($telefone, 0,4).' - '.substr($telefone, 4,4);
				break;
			case '9':
				//fixo sem DDD
				return "9 ".substr($telefone, 1,4).' - '.substr($telefone, 5,4);
				break;
			case '10':
				//fixo com DDD
				return "(".substr($telefone, 0,2).") ".substr($telefone, 2,4).' - '.substr($telefone, 6,4);
				break;
			case '11':
				//fixo com DDD
				return "(".substr($telefone, 0,2).") 9 ".substr($telefone, 3,4).' - '.substr($telefone, 7,4);
				break;
			
			default:
				return $telefone.'* verificar';
				break;
		}

	}


}
