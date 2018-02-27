<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\BarCodeGenrator;
use App\Lancamento;
use App\Boleto;
use App\Pessoa;
use App\Matricula;
use Carbon\Carbon;
use DateTime;
use Cnab;
use Session;

//require '../vendor/autoload.php';


//use App\Http\Controllers\LancamentoController;
//clude 'vendor/autoload.php';
class BoletoController extends Controller
{	
	public function cadastrar(){ //$parcela/mes/ano
		$vencimento=date('Y-m-20 23:59:59');

		$lancamentos_sintetizados=Lancamento::select(\DB::raw('distinct(matriculas.pessoa), sum(lancamentos.valor) as valor'))
							->join('matriculas','lancamentos.matricula','matriculas.id')
							->groupBy('matriculas.pessoa')
							->where('boleto',null)
							->get();

		
		foreach($lancamentos_sintetizados as $ls){
			//verifica se já não foi gerado
			if(!$this->verificaSeCadastrado($ls->pessoa,$ls->valor,$vencimento)){
			//gerar boleto
			$boleto=new Boleto;
			$boleto->pessoa=$ls->pessoa;
			$boleto->vencimento=$vencimento;
			$boleto->valor=$ls->valor;

			$boleto->save();
			LancamentoController::atualizaLancamentos($ls->pessoa,0,$boleto->id);
			}


			
			
			//LancamentosController::atualizaLancamentos(22563,0,$boleto->id);
		}

		return $lancamentos_sintetizados;


	}
	public function imprimirLote(){

		$boletos=Boleto::where('status','gravado')->limit(200)->get();
		foreach($boletos as $boleto){
			$boleto->status='impresso';
			$boleto->save();
			$this->gerar($boleto);
		}
		//return $boletos;

		return view('financeiro.boletos.lote')->with('boletos',$boletos);
	}
	public static function verificaSeCadastrado($pessoa,$valor,$vencimento){
		$cadastrado=Boleto::where('pessoa',$pessoa)->where('valor',$valor)->where('vencimento',$vencimento)->first();
		return $cadastrado;

	}
	public function cadastarIndividualmente(){
		if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
		$vencimento = date('Y-m-d 23:23:59', strtotime("+5 days",strtotime(date('Y-m-d')))); 
		$matriculas = Matricula::select('id')
			->where('pessoa',Session::get('pessoa_atendimento'))
			->where(function($query){
				$query->where('status','ativa')->orwhere('status', 'pendente');
			})
			->get();

		$ids=array();
		foreach($matriculas as $matricula){
			$ids[]=$matricula->id;
		}


		$lancamentos = Lancamento::whereIn('matricula',$ids)
			->where('boleto',null)
			->get();

		if(count($lancamentos) > 0){
				
			//gerar boleto
			$boleto=new Boleto;
			$boleto->pessoa=Session::get('pessoa_atendimento');
			$boleto->vencimento=$vencimento;
			$boleto->save();

			$total=0;
			$descontos=0;
			$acrescimos=0;

			foreach($lancamentos as $lancamento){
				if($lancamento->status != 'cancelado'){
					if($lancamento->parcela == 0){
						if($lancamento->valor > 0)
							$acrescimos=$acrescimos+$lancamento->valor;
						else
							$descontos = $descontos + $lancamento->valor;	
					}
					else
						$total = $total + $lancamento->valor;
					$total = $total + $descontos + $acrescimos;
					$lancamento->boleto=$boleto->id;
					$lancamento->save();
				}
			}
			$boleto->valor = $total;
			$boleto->descontos = $descontos;
			$boleto->encargos = $acrescimos;
			$boleto->save();
			if($boleto->valor <=0){
				$boleto->status = 'cancelado';
				$boleto->save();
			}
	
			
		}//fim se qnde de lancamentos = 0
		return redirect($_SERVER['HTTP_REFERER']);
	}


	public function gerar(Boleto $boleto){
		$cliente=Pessoa::find($boleto->pessoa);
		$cliente=PessoaController::formataParaMostrar($cliente);
		

		$dias_de_prazo_para_pagamento = 5;
		$taxa_boleto = 0;
		$data_venc =Carbon::parse($boleto->vencimento)->format('d/m/Y');;  // Prazo de X dias OU informe data: "13/04/2006"; 
		$valor_documento = $boleto->valor;
		$valor_cobrado = $boleto->valor+$boleto->encargos-$boleto->descontos; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
        $boleto->valor_desconto=number_format($boleto->descontos, 2, ',', '');
        $boleto->valor_encargo=number_format($boleto->encargos, 2, ',', '');
        $boleto->valor_cobrado= number_format($valor_cobrado, 2, ',', '');

		$dadosboleto["nosso_numero"] = $boleto->id; //numero de identificaçao no sistema interno SEM convenio (7)
		$dadosboleto["numero_documento"] = $boleto->id;	// Num do pedido ou do documento
		$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
		$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = $cliente->nome;
		$dadosboleto["cpf_sacado"]=$cliente->cpf;
		$dadosboleto["logradouro_sacado"]=$cliente->logradouro.' '.$cliente->end_numero.' '.$cliente->complemento;
		$dadosboleto["bairro_sacado"] = ($cliente->bairro=='Outros/Outra cidade' ? $cliente->bairro_alt : $cliente->bairro);
		$dadosboleto["cep_sacado"]= str_replace('-', '',$cliente->cep);


		$dadosboleto["endereco1"] = $cliente->logradouro.' '.$cliente->end_numero.' '.$cliente->complemento.''. ($cliente->bairro=='Outros/Outra cidade' ? $cliente->bairro_alt : $cliente->bairro) ;
		$dadosboleto["endereco2"] = $cliente->cidade.' '.$cliente->estado.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CEP '.$cliente->cep;

		// INFORMACOES PARA O CLIENTE
		$dadosboleto["demonstrativo1"] = "Pagamento FESC";
		$dadosboleto["demonstrativo2"] = "Acréscimos ou descontos são diferenças de valores entre a parcela anterior e a atual.";
		$dadosboleto["demonstrativo3"] = "Mensalidade referente a parcelas de todas as suas atividade na FESC";

		// INSTRUÇÕES PARA O CAIXA
		$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
		$dadosboleto["instrucoes2"] = "- Cobrar juros de 1% ao mês por atraso.";
		$dadosboleto["instrucoes3"] = "- Pagável em qualquer agência bancária ou lotérica até o vencimento";
		$dadosboleto["instrucoes4"] = "- Em caso de dúvidas entre em contato conosco: 3372-1308";

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
		$boleto->dados=$dadosboleto;


		return $boleto;	
	}
	public function gerarRemessa(){
		$boletos=Boleto::where('status','=','gravado')->orWhere('status','=','cancelar')->limit(5)->get();
		$codigo_banco = Cnab\Banco::BANCO_DO_BRASIL;
		$arquivo = new Cnab\Remessa\Cnab240\Arquivo($codigo_banco);
		$arquivo->configure(array(
		    'data_geracao'  => new DateTime(),
		    'data_gravacao' => new DateTime(), 
		    'nome_fantasia' => 'FESC', // seu nome de empresa
		    'razao_social'  => 'FUNDAÇÃO EDUCACIONAL SÃO CARLOS',  // sua razão social
		    'cnpj'          => '45361904000180', // seu cnpj completo
		    'banco'         => $codigo_banco, //código do banco
		    'logradouro'    => 'Rua São Sebastiao ',
		    'numero'        => '2828',
		    'bairro'        => 'Vila Nery', 
		    'cidade'        => 'São Carlos',
		    'uf'            => 'SP',
		    'cep'           => '13560230',
		    'agencia'       => '0295', 
		    'conta'         => '52822', // número da conta
		    'conta_dac'     => '6', // digito da conta
		    'codigo_convenio'=>'2838669',
		    'codigo_carteira'=>'1',//cobrança simples
		    'variacao_carteira'=>'019',
		    'conta_dv'=>'6',
		    'agencia_dv'=>'X',
		    'operacao'=>'0',
		    'numero_sequencial_arquivo'=>'1',


		));

		foreach($boletos as $boleto){
			$boleto=$this->gerar($boleto);
			//return $boleto->dados['cpf_sacado'];
			if(\App\classes\Strings::validaCPF($boleto->dados['cpf_sacado'])){
				$arquivo->insertDetalhe(array(
				    'codigo_de_ocorrencia' => '1', // 1 = Entrada de título, futuramente poderemos ter uma constante
				    'nosso_numero'      => $boleto->id,
				    'numero_documento'  => $boleto->id,
				    'carteira'          => '17',//109
				    'especie'           => Cnab\Especie::BB_CHEQUE, // Você pode consultar as especies Cnab\Especie
				    'valor'             => $boleto->valor, // Valor do boleto
				    'instrucao1'        => 2, // 1 = Protestar com (Prazo) dias, 2 = Devolver após (Prazo) dias, futuramente poderemos ter uma constante
				    'instrucao2'        => 0, // preenchido com zeros
				    'sacado_nome'       => $boleto->dados['sacado'], // O Sacado é o cliente, preste atenção nos campos abaixo
				    'sacado_tipo'       => 'cpf', //campo fixo, escreva 'cpf' (sim as letras cpf) se for pessoa fisica, cnpj se for pessoa juridica
				    'sacado_cpf'        => $boleto->dados['cpf_sacado'],
				    'sacado_logradouro' => $boleto->dados['logradouro_sacado'],
				    'sacado_bairro'     => $boleto->dados['bairro_sacado'],
				    'sacado_cep'        => $boleto->dados['cep_sacado'], // sem hífem
				    'sacado_cidade'     => 'São Carlos',
				    'sacado_uf'         => 'SP',
				    'data_vencimento'   => new DateTime($boleto->vencimento),
				    'data_cadastro'     => new DateTime('2018-02-19'),
				    'juros_de_um_dia'     => 0.10, // Valor do juros de 1 dia'
				    'data_desconto'       => new DateTime('2014-06-01'),
				    'valor_desconto'      => 10.0, // Valor do desconto
				    'prazo'               => 10, // prazo de dias para o cliente pagar após o vencimento
				    'taxa_de_permanencia' => '0', //00 = Acata Comissão por Dia (recomendável), 51 Acata Condições de Cadastramento na CAIXA
				    'mensagem'            => 'Mensalidade referente a parcelas de todas as suas atividade na FESC',
				    'data_multa'          => new DateTime('2018-02-28'), // data da multa
				    'valor_multa'         => 10.0, // valor da multa
				    'codigo_carteira'=>'1', //cobrança simples
				    'registrado'=>'1', // 1 boleto com registro 2 sem registro
				    'movimento'=>'02',
				    'aceite'=>'1'

				));
				$boleto_bd=Boleto::find($boleto->id);
				$boleto_bd->status = 'emitido';
				$boleto_bd->save();
			}// endif de validação do cpf
			else{
				$boleto_bd=Boleto::find($boleto->id);
				$boleto_bd->status = 'erro_CPF';
				$boleto_bd->save();
			}

		}
		return $arquivo->save('meunomedearquivo.txt');



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
		public static function proximoMes(){
			$mes = str_pad(date('m')+1,2,"0",STR_PAD_LEFT);
			return date('Y') . '-' . $mes .'-20 23:59:59';
		}

		public static function relancarBoleto($id){
			$boleto_antigo=Boleto::find($id);
			$lancamentos = Lancamento::select('matricula')->distinct('matricula')->where('boleto',$id)->get();
			$lancamentos_sintetizados=Lancamento::select(\DB::raw('distinct(matriculas.pessoa), sum(lancamentos.valor) as valor'))
							->join('matriculas','lancamentos.matricula','matriculas.id')
							->groupBy('matriculas.pessoa')
							->whereIn('lancamentos.matricula',$lancamentos)
							->where(function($query){
								$query->where('lancamentos.status','!=','cancelado')->orwhere('lancamentos.status', null);
							})							
							->get(); //soma todas parcelas em aberto e agrupa por pessoa
			$proxvencimento= BoletoController::proximoMes();//pega proxima data de vencimento
			foreach($lancamentos_sintetizados as $ls){// para cada lancamento sintetizado _acho que sí vai rolar um mesmo.
				if($ls->valor>0){
				if(!BoletoController::verificaSeCadastrado($ls->pessoa,$ls->valor,$proxvencimento) ) {//verifica se já não foi gerado
				//gerar boleto
					
						$boleto = new Boleto;
						$boleto->pessoa=$ls->pessoa;
						$boleto->vencimento=$proxvencimento;
						$boleto->valor=$ls->valor;

						//return $boleto;

						$boleto->save();
						return $boleto->id;
						
					}
				}
				else return 0;
				//LancamentosController::atualizaLancamentos(22563,0,$boleto->id);
			}

		}
		public function imprimir($boleto){
			$boleto = Boleto::find($boleto);
			if($boleto == null)
				throw new \Exception("Boleto Inexistente", 1);
			if($boleto->status == 'gravado'){
				$boleto->status = 'impresso';
				$boleto->save();
			}
			$boleto = $this->gerar($boleto);

			return view('financeiro.boletos.boleto',compact('boleto'));
			
		}
		public function listarPorPessoa(){
			if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
            $nome = \App\Pessoa::getNome(Session::get('pessoa_atendimento'));
            $boletos=Boleto::where('pessoa',Session::get('pessoa_atendimento'))->paginate(50);

            return view('financeiro.boletos.lista-por-pessoa',compact('boletos'))->with('nome',$nome);
		}
		public function cancelar($id){
			$boleto=Boleto::find($id);

			if($boleto != null){
				$boleto->status = 'cancelar';
				$boleto->save();
				LancamentoController::cancelarPorBoleto($id);
			}
			return redirect($_SERVER['HTTP_REFERER']);
			

		}

}
