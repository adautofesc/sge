<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\BarCodeGenrator;

class BoletoController extends Controller
{
	public function gerar(){
		$dias_de_prazo_para_pagamento = 5;
		$taxa_boleto = 0;
		$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
		$valor_cobrado = "54,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

		$dadosboleto["nosso_numero"] = "6164210154"; //numero de identificaçao no sistema interno SEM convenio (7)
		$dadosboleto["numero_documento"] = "6164210154";	// Num do pedido ou do documento
		$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
		$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = "Nome do seu Cliente";
		$dadosboleto["endereco1"] = "Endereço do seu Cliente";
		$dadosboleto["endereco2"] = "Cidade - Estado -  CEP: 00000-000";

		// INFORMACOES PARA O CLIENTE
		$dadosboleto["demonstrativo1"] = "Pagamento Piscina";
		$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
		$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";

		// INSTRUÇÕES PARA O CAIXA
		$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
		$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
		$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: 3372-1308";
		$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$dadosboleto["quantidade"] = "1";
		$dadosboleto["valor_unitario"] = "";
		$dadosboleto["aceite"] = "N";		
		$dadosboleto["especie"] = "R$";
		$dadosboleto["especie_doc"] = "DM";


		// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


		// DADOS DA SUA CONTA - BANCO DO BRASIL
		$dadosboleto["agencia"] = "0295"; // Num da agencia, sem digito
		$dadosboleto["conta"] = "52822"; 	// Num da conta, sem digito

		// DADOS PERSONALIZADOS - BANCO DO BRASIL
		$dadosboleto["convenio"] = "2838669";  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
		$dadosboleto["contrato"] = ""; // Num do seu contrato
		$dadosboleto["carteira"] = "17";
		$dadosboleto["variacao_carteira"] = "01-9";  // Variação da Carteira, com traço (opcional)

		// TIPO DO BOLETO
		$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
		$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos

		/*
		#################################################
		DESENVOLVIDO PARA CARTEIRA 18

		- Carteira 18 com Convenio de 8 digitos
		  Nosso número: pode ser até 9 dígitos

		- Carteira 18 com Convenio de 7 digitos
		  Nosso número: pode ser até 10 dígitos

		- Carteira 18 com Convenio de 6 digitos
		  Nosso número:
		  de 1 a 99999 para opção de até 5 dígitos
		  de 1 a 99999999999999999 para opção de até 17 dígitos

		#################################################
		*/


		// SEUS DADOS
		$dadosboleto["identificacao"] = "Fundação Educacional São Carlos";
		$dadosboleto["cpf_cnpj"] = "45.361.904/0001-80";
		$dadosboleto["endereco"] = "Rua São Sebastiao, 2828, Vila Nery ";
		$dadosboleto["cidade_uf"] = "São Carlos / SP";
		$dadosboleto["cedente"] = "FUNDAÇÃO EDUCACIONAL SÃO CARLOS";

		#####################################################################################
		$codigobanco = "001";
		$codigo_banco_com_dv = $this->geraCodigoBanco($codigobanco);
		$nummoeda = "9";
		$fator_vencimento = $this->fator_vencimento($dadosboleto["data_vencimento"]);



		//valor tem 10 digitos, sem virgula
		$valor = $this->formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
		//agencia é sempre 4 digitos
		$agencia = $this->formata_numero($dadosboleto["agencia"],4,0);
		//conta é sempre 8 digitos
		$conta = $this->formata_numero($dadosboleto["conta"],8,0);
		//carteira 18
		$carteira = $dadosboleto["carteira"];
		//agencia e conta
		$agencia_codigo = $agencia."-". $this->modulo_11($agencia) ." / ". $conta ."-". $this->modulo_11($conta);
		//Zeros: usado quando convenio de 7 digitos
		$livre_zeros='000000';

		// Carteira 18 com Convênio de 8 dígitos
		if ($dadosboleto["formatacao_convenio"] == "8") {
			$convenio = $this->formata_numero($dadosboleto["convenio"],8,0,"convenio");
			// Nosso número de até 9 dígitos
			$nossonumero = $this->formata_numero($dadosboleto["nosso_numero"],9,0);
			$dv=modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira");
			$linha="$codigobanco$nummoeda$dv$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira";
			//montando o nosso numero que aparecerá no boleto
			$nossonumero = $convenio . $nossonumero ."-". modulo_11($convenio.$nossonumero);
		}

		// Carteira 18 com Convênio de 7 dígitos
		if ($dadosboleto["formatacao_convenio"] == "7") {
			$convenio = $this->formata_numero($dadosboleto["convenio"],7,0,"convenio");
			// Nosso número de até 10 dígitos
			$nossonumero = $this->formata_numero($dadosboleto["nosso_numero"],10,0);
			$dv=BoletoController::modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira");
			$linha="$codigobanco$nummoeda$dv$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira";
		  $nossonumero = $convenio.$nossonumero;
			//Não existe DV na composição do nosso-número para convênios de sete posições
		}

		// Carteira 18 com Convênio de 6 dígitos
		if ($dadosboleto["formatacao_convenio"] == "6") {
			$convenio = $this->formata_numero($dadosboleto["convenio"],6,0,"convenio");
			
			if ($dadosboleto["formatacao_nosso_numero"] == "1") {
				
				// Nosso número de até 5 dígitos
				$nossonumero = $this->formata_numero($dadosboleto["nosso_numero"],5,0);
				$dv = $this->modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$convenio$nossonumero$agencia$conta$carteira");
				$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$convenio$nossonumero$agencia$conta$carteira";
				//montando o nosso numero que aparecerá no boleto
				$nossonumero = $convenio . $nossonumero ."-". $this->modulo_11($convenio.$nossonumero);
			}
			
			if ($dadosboleto["formatacao_nosso_numero"] == "2") {
				
				// Nosso número de até 17 dígitos
				$nservico = "21";
				$nossonumero = $this->formata_numero($dadosboleto["nosso_numero"],17,0);
				$dv = $this->modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$convenio$nossonumero$nservico");
				$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$convenio$nossonumero$nservico";
			}
		}

		$dadosboleto["codigo_barras"] = $linha;
		$dadosboleto["linha_digitavel"] = BoletoController::monta_linha_digitavel($linha);
		$dadosboleto["agencia_codigo"] = $agencia_codigo;
		$dadosboleto["nosso_numero"] = $nossonumero;
		$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

		//$dadosboleto["codebar"] = BoletoController::fbarcode($dadosboleto["codigo_barras"]);
































		return view('financeiro.boletos.boleto', compact('dadosboleto'));	
	}

	public static function formata_numero($numero,$loop,$insert,$tipo = "geral") {
		if ($tipo == "geral") {
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "valor") {
			/*
			retira as virgulas
			formata o numero
			preenche com zeros
			*/
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "convenio") {
			while(strlen($numero)<$loop){
				$numero = $numero . $insert;
			}
		}
		return $numero;
	}  
	public static function esquerda($entra,$comp){
		return substr($entra,0,$comp);
	}

	public static function direita($entra,$comp){
		return substr($entra,strlen($entra)-$comp,$comp);
	}

	public static function fator_vencimento($data) {
		$data = explode("/",$data);
		$ano = $data[2];
		$mes = $data[1];
		$dia = $data[0];
	    return(abs((BoletoController::_dateToDays("1997","10","07")) - (BoletoController::_dateToDays($ano, $mes, $dia))));
	}

	public static function _dateToDays($year,$month,$day) {
	    $century = substr($year, 0, 2);
	    $year = substr($year, 2, 2);
	    if ($month > 2) {
	        $month -= 3;
	    } else {
	        $month += 9;
	        if ($year) {
	            $year--;
	        } else {
	            $year = 99;
	            $century --;
	        }
	    }

	    return ( floor((  146097 * $century)    /  4 ) +
	            floor(( 1461 * $year)        /  4 ) +
	            floor(( 153 * $month +  2) /  5 ) +
	                $day +  1721119);
	}

	/*
	#################################################
	FUNÇÃO DO MÓDULO 10 RETIRADA DO PHPBOLETO

	ESTA FUNÇÃO PEGA O DÍGITO VERIFICADOR DO PRIMEIRO, SEGUNDO
	E TERCEIRO CAMPOS DA LINHA DIGITÁVEL
	#################################################
	*/
	public static function modulo_10($num) { 
		$numtotal10 = 0;
		$fator = 2;
	 
		for ($i = strlen($num); $i > 0; $i--) {
			$numeros[$i] = substr($num,$i-1,1);
			$parcial10[$i] = $numeros[$i] * $fator;
			$numtotal10 .= $parcial10[$i];
			if ($fator == 2) {
				$fator = 1;
			}
			else {
				$fator = 2; 
			}
		}
		
		$soma = 0;
		for ($i = strlen($numtotal10); $i > 0; $i--) {
			$numeros[$i] = substr($numtotal10,$i-1,1);
			$soma += $numeros[$i]; 
		}
		$resto = $soma % 10;
		$digito = 10 - $resto;
		if ($resto == 0) {
			$digito = 0;
		}

		return $digito;
	}

	/*
	#################################################
	FUNÇÃO DO MÓDULO 11 RETIRADA DO PHPBOLETO

	MODIFIQUEI ALGUMAS COISAS...

	ESTA FUNÇÃO PEGA O DÍGITO VERIFICADOR:

	NOSSONUMERO
	AGENCIA
	CONTA
	CAMPO 4 DA LINHA DIGITÁVEL
	#################################################
	*/

	public static function modulo_11($num, $base=9, $r=0) {
		$soma = 0;
		$fator = 2; 
		for ($i = strlen($num); $i > 0; $i--) {
			$numeros[$i] = substr($num,$i-1,1);
			$parcial[$i] = $numeros[$i] * $fator;
			$soma += $parcial[$i];
			if ($fator == $base) {
				$fator = 1;
			}
			$fator++;
		}
		if ($r == 0) {
			$soma *= 10;
			$digito = $soma % 11;
			
			//corrigido
			if ($digito == 10) {
				$digito = "X";
			}

			/*
			alterado por mim, Daniel Schultz

			Vamos explicar:

			O módulo 11 só gera os digitos verificadores do nossonumero,
			agencia, conta e digito verificador com codigo de barras (aquele que fica sozinho e triste na linha digitável)
			só que é foi um rolo...pq ele nao podia resultar em 0, e o pessoal do phpboleto se esqueceu disso...
			
			No BB, os dígitos verificadores podem ser X ou 0 (zero) para agencia, conta e nosso numero,
			mas nunca pode ser X ou 0 (zero) para a linha digitável, justamente por ser totalmente numérica.

			Quando passamos os dados para a função, fica assim:

			Agencia = sempre 4 digitos
			Conta = até 8 dígitos
			Nosso número = de 1 a 17 digitos

			A unica variável que passa 17 digitos é a da linha digitada, justamente por ter 43 caracteres

			Entao vamos definir ai embaixo o seguinte...

			se (strlen($num) == 43) { não deixar dar digito X ou 0 }
			*/
			
			if (strlen($num) == "43") {
				//então estamos checando a linha digitável
				if ($digito == "0" or $digito == "X" or $digito > 9) {
						$digito = 1;
				}
			}
			return $digito;
		} 
		elseif ($r == 1){
			$resto = $soma % 11;
			return $resto;
		}
	}

	/*
	Montagem da linha digitável - Função tirada do PHPBoleto
	Não mudei nada
	*/
	public static function monta_linha_digitavel($linha) {
	    // Posição 	Conteúdo
	    // 1 a 3    Número do banco
	    // 4        Código da Moeda - 9 para Real
	    // 5        Digito verificador do Código de Barras
	    // 6 a 19   Valor (12 inteiros e 2 decimais)
	    // 20 a 44  Campo Livre definido por cada banco

	    // 1. Campo - composto pelo código do banco, código da moéda, as cinco primeiras posições
	    // do campo livre e DV (modulo10) deste campo
	    $p1 = substr($linha, 0, 4);
	    $p2 = substr($linha, 19, 5);
	    $p3 = BoletoController::modulo_10("$p1$p2");
	    $p4 = "$p1$p2$p3";
	    $p5 = substr($p4, 0, 5);
	    $p6 = substr($p4, 5);
	    $campo1 = "$p5.$p6";

	    // 2. Campo - composto pelas posiçoes 6 a 15 do campo livre
	    // e livre e DV (modulo10) deste campo
	    $p1 = substr($linha, 24, 10);
	    $p2 = BoletoController::modulo_10($p1);
	    $p3 = "$p1$p2";
	    $p4 = substr($p3, 0, 5);
	    $p5 = substr($p3, 5);
	    $campo2 = "$p4.$p5";

	    // 3. Campo composto pelas posicoes 16 a 25 do campo livre
	    // e livre e DV (modulo10) deste campo
	    $p1 = substr($linha, 34, 10);
	    $p2 = BoletoController::modulo_10($p1);
	    $p3 = "$p1$p2";
	    $p4 = substr($p3, 0, 5);
	    $p5 = substr($p3, 5);
	    $campo3 = "$p4.$p5";

	    // 4. Campo - digito verificador do codigo de barras
	    $campo4 = substr($linha, 4, 1);

	    // 5. Campo composto pelo valor nominal pelo valor nominal do documento, sem
	    // indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
	    // tratar de valor zerado, a representacao deve ser 000 (tres zeros).
	    $campo5 = substr($linha, 5, 14);

	    return "$campo1 $campo2 $campo3 $campo4 $campo5"; 
	}

	public static function geraCodigoBanco($numero) {
	    $parte1 = substr($numero, 0, 3);
	    $parte2 = BoletoController::modulo_11($parte1);
	    return $parte1 . "-" . $parte2;
	}

	public static function fbarcode($valor){

		$fino = 1 ;
		$largo = 3 ;
		$altura = 50 ;

		  $barcodes[0] = "00110" ;
		  $barcodes[1] = "10001" ;
		  $barcodes[2] = "01001" ;
		  $barcodes[3] = "11000" ;
		  $barcodes[4] = "00101" ;
		  $barcodes[5] = "10100" ;
		  $barcodes[6] = "01100" ;
		  $barcodes[7] = "00011" ;
		  $barcodes[8] = "10010" ;
		  $barcodes[9] = "01010" ;

		  for($f1=9;$f1>=0;$f1--){ 
		    for($f2=9;$f2>=0;$f2--){  
		      $f = ($f1 * 10) + $f2 ;
		      $texto = "" ;
		      for($i=1;$i<6;$i++){ 
		        $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
		      }
		      $barcodes[$f] = $texto;
		    }
		  }


		//Desenho da barra


		//Guarda inicial
		$barcodeline='
			<img src='.asset('img/p.png').' width="'.$fino.'" height="'.$altura.'" border=0>
			<img src='.asset('img/b.png').' width="'.$fino.'" height="'.$altura.'" border=0>
			<img src='.asset('img/p.png').' width="'.$fino.'" height="'.$altura.'" border=0>
			<img src='.asset('img/b.png').' width="'.$fino.'" height="'.$altura.'" border=0>';

		
		$texto = $valor ;
		if((strlen($texto) % 2) <> 0){
			$texto = "0" . $texto;
		}

		// Draw dos dados
		while (strlen($texto) > 0) {
		  $i = round(BoletoController::esquerda($texto,2));
		  $texto = BoletoController::direita($texto,strlen($texto)-2);
		  $f = $barcodes[$i];
		  for($i=1;$i<11;$i+=2){
		    if (substr($f,($i-1),1) == "0") {
		      $f1 = $fino ;
		    }else{
		      $f1 = $largo ;
		    }
		
			$barcodeline.='<img src='.asset('img/p.png').' width="'.$f1.'" height="'.$altura.'" border=0>';
		
		    if (substr($f,$i,1) == "0") {
		      $f2 = $fino ;
		    }else{
		      $f2 = $largo ;
		    }
		
		    $barcodeline.='<img src='.asset('img/b.png').' width="'.$f2.'" height="'.$altura.'" border=0>'; 
		  }
		}

		// Draw guarda final
		
		$barcodeline.='
		<img src='.asset('img/p.png').' width="'.$largo.'" height="'.$altura.'" border=0>
		<img src='.asset('img/b.png').' width="'.$fino.'" height="'.$altura.'" border=0>
		<img src='.asset('img/p.png').' width="1" height="'.$altura.'" border=0> ';
		  
		return $barcodeline;
		} //Fim da função

}