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

}
