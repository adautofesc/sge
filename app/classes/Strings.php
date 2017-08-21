<?php
namespace App\classes;
// http://forum.wmonline.com.br/topic/188764-transformar-primeira-letra-de-cada-palavra-em-maiuscula/
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

}
