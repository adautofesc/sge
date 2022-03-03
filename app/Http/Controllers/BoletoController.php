<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\BarCodeGenrator;
use App\classes\BoletoFuncional;
use App\Lancamento;
use App\Boleto;
use App\Pessoa;
use App\Retorno;
use App\Matricula;
use Carbon\Carbon;
use DateTime;
use Cnab;
use Session;
use Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

ini_set('max_execution_time', 300);

//require '../vendor/autoload.php';


//use App\Http\Controllers\LancamentoController;
//clude 'vendor/autoload.php';
class BoletoController extends Controller
{	
	public function painel(Request $r){
		if(isset($r->codigo)){
			$tipo = 'por código';
			$codigos = explode(',',$r->codigo);
			$boletos = Boleto::whereIn('id',$codigos)->paginate(50);
		}
		elseif(isset($r->status)){
			$boletos = Boleto::where('status',$r->status)->whereYear('vencimento',date('Y'))->paginate(50);
			$tipo = 'por status';
		}
		elseif(isset($r->pessoa)){
			$boletos = Boleto::where('pessoa',$r->pessoa)->whereYear('vencimento',date('Y'))->paginate(50);
			$tipo = 'por pessoa';
		}
		else{
			$boletos = Boleto::where('status','emitido')->where('vencimento','<',date('Y-m-d'))->whereYear('vencimento',date('Y'))->paginate(50);
			$tipo = 'vencidos';
		}
		foreach($boletos as &$boleto){
			$boleto->lancamentos = $boleto->getLancamentos();
			$boleto->vencimento = \DateTime::createFromFormat('Y-m-d H:i:s',$boleto->vencimento);
		}

		//dd($boletos);
		return view('boletos.index')->with('boletos',$boletos)->with('tipo',$tipo);

	}
	public function logMe($msg){
		$fp = fopen("log.txt", "a");
		$msg = "\n".$msg;

		// Escreve a mensagem passada através da variável $msg
		$escreve = fwrite($fp, $msg);

		// Fecha o arquivo
		fclose($fp);
	

	}

	public static function alterarStatus(Boleto $boleto, string $status, string $motivo = ''){
		switch($status){
			
			case 'cancelar':
				$BC = new BoletoController;
				if($motivo)
					$BC->cancelamentoDireto($boleto->id, 'Solicitação de cancelamento motivo: '.$motivo);
				else
					$BC->cancelamentoDireto($boleto->id, 'Solicitação de cancelamento pelo sistema');

			break;
			case 'reativar':
				$boleto->status = 'emitido';
				LogController::alteracaoBoleto($boleto->id,'Boleto reativado');
			break;
			case 'renegociar':
				$boleto->status = 'renegociado';
				LogController::alteracaoBoleto($boleto->id,'Boleto renegociado');
			break;
			case 'inscrever':
				$boleto->status = 'divida';
				LogController::alteracaoBoleto($boleto->id,'Boleto inscrito em dívida');
			break;
			case 'pago':
				$boleto->status = 'pago';
				LogController::alteracaoBoleto($boleto->id,'Boleto pago diretamente à FESC');
			break;
			

		}

	}

	public function cadastrar(){ //$parcela/mes/ano
		$boletos=0;
		$vencimento=date('Y-m-20 23:59:59');
		//$pessoas = \DB::select("select distinct pessoa from lancamentos where status is null and  boleto is null group by pessoa"); //seleciona pessoas com matriculas ativas/pendentes


		$pessoas = Lancamento::distinct('pessoa')->where('status',null)->where('pessoa','>','0')->where('boleto',null)->groupBy('pessoa')->paginate(50);

		//dd($pessoas);

		foreach($pessoas as $pessoa){
			//if($pessoa->pessoa>0){
				//dd($pessoa);
				$valor=0;
				$lancamentos = Lancamento::where('status',null)
					->where('boleto',null)
					->where('pessoa',$pessoa->pessoa)
					->get();
				//dd($lancamentos);
				foreach($lancamentos as $lancamento){
					$valor = $valor + $lancamento->valor;
				}

				if($lancamentos->count()>0 && $valor>0 ){// tem lancamentos? é maior que zero?
					$boleto = new Boleto; //cria boleto
					$boleto->vencimento = $vencimento;
					$boleto->pessoa = $pessoa->pessoa;
					$boleto->status = 'gravado';
					$boleto->valor = $valor;
					//if($pessoa->pessoa>0){
					$boleto->save();
					foreach($lancamentos as $lancamento){ //para cada lancamento
						$lancamento->boleto = $boleto->id;
						$lancamento->save();
					}
					$boletos++;

					//}//

				}//if lancamentos e valor>0
			//}//end if pessoa>0
		}

		return view('financeiro.boletos.gerador', compact('pessoas'));


	}
	public function imprimirLote(){

		$boletosx=Boleto::where('status','gravado')->paginate(200);
		$boletos = collect();
		
		$inst = new BoletoFuncional;
		foreach($boletosx as $boleto){
			$boleto_completo = $inst->gerar($boleto);
			$boleto = new \stdClass();
			$boleto = $boleto_completo->dados;
			$boletos->push($boleto);
		}
		//return $boletos;
		return view('financeiro.boletos.lote')->with('boletos',$boletos)->with('boletosx',$boletosx);
	}

	
	public function gerarArquivoCSV(){
/*
		header('Content-Type: text/csv; charset=utf-8');
	    header('Content-Disposition: attachment;filename="'. 'lote_boletos' .'.csv"'); 
	    header('Cache-Control: max-age=0');

*/
	    if(isset($_GET['page'])){
	    	$file = fopen('lote-boletos.csv', 'a+');
	    }

	    else{
	    	$file = fopen('lote-boletos.csv', 'w');
			$linha["pessoa_id"] = "id";
			$linha["pessoa_nome"] = "Nome";
			$linha["pessoa_cpf"] = "cpf";
			$linha["endereco_rua"] = "rua";
			$linha["endereco_numero"] = "numero";
			$linha["endereco_complemento"] = "complemento";
			$linha["endereco_bairro"] = "bairro";
			$linha["endereco_cidade"] = "cidade_uf";
			$linha["endereco_cep"] = "cep";
			$linha["boleto_nossonumero"] = "nosso_numero";
			$linha["boleto_documento"] = "documento";
			$linha["boleto_vencimento"] = "vencimento";
			$linha["boleto_emissao"] = "emissao";
			$linha["boleto_valor"] = "valor";
			$linha["boleto_referencias"] = "referencias";
			$linha["boleto_linha_digitavel"] = "linha_digitavel";
			$linha["boleto_codigo_barras"] = "codigo_barras";
			fputcsv($file, $linha,';');


	    }

		


		$boletos=Boleto::where('status','gravado')->paginate(100);
		//$boletos=Boleto::where('vencimento','like','2018-10-20%');
		
		
		
		$inst = new BoletoFuncional;
		foreach($boletos as $boleto){
			
			$pessoa = Pessoa::find($boleto->pessoa);
			

			$boleto_completo = $inst->gerar($boleto);

			$lancamentos = $boleto->getLancamentos();
		

			$linha["pessoa_id"] = $boleto->pessoa;
			$linha["pessoa_nome"] = $boleto->dados['sacado'];
			$linha["pessoa_cpf"] = '"'.$boleto->dados['cpf_sacado'].'"';
			$linha["endereco_rua"] = $boleto->cliente->logradouro;
			$linha["endereco_numero"] = $boleto->cliente->end_numero;
			$linha["endereco_complemento"] = $boleto->cliente->end_complemento;
			if($boleto->cliente->bairro=='Outros/Outra cidade')
				$linha["endereco_bairro"] = $boleto->cliente->bairro_alt;
			else
				$linha["endereco_bairro"] = $boleto->cliente->bairro;

			$linha["endereco_cidade"] =  $boleto->cliente->cidade.' - '.$boleto->cliente->estado;
			$linha["endereco_cep"] = $boleto->cliente->cep;
			$linha["boleto_nossonumero"] = '"'.$boleto->dados['nosso_numero'].'"';
			$linha["boleto_documento"] = '"'.$boleto->dados['numero_documento'].'"';
			$linha["boleto_vencimento"] = $boleto->dados['data_vencimento'];
			$linha["boleto_emissao"] = $boleto->dados['data_processamento'];
			$linha["boleto_valor"] = $boleto->valor;
			$linha["boleto_referencias"] ='';
			foreach ($lancamentos as $lancamento){
				$linha["boleto_referencias"] .= $lancamento->referencia." ".$lancamento->matricula.'. ';
			}

			$linha["boleto_linha_digitavel"] = '"'.$boleto->dados['linha_digitavel'].'"';
			$linha["boleto_codigo_barras"] = '"'.$boleto->dados['codigo_barras'].'"';
			
			


/*
			foreach($linha as $valor){
				$valor = utf8_decode($valor);
			}
*/
			fputcsv($file, $linha,';');


		}//fim foreach boletos
		fclose($file);

		//die(mb_detect_encoding($linha["endereco_cidade"] ) );


		return view('financeiro.boletos.gerador-csv',compact('boletos'));
	}
	public function imprimirLotex(){
		$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Html();
		$boletos = Boleto::where('status','gravado')->get();
		foreach($boletos as $boleto){
			$boleto_completo = $this->gerarBoleto($boleto);
			$boleto->status = 'impresso';
			//$boleto->save();
			$html->addBoleto($boleto_completo);
		}
		$html->hideInstrucoes();
		//$html->showPrint();
		
		return $html->gerarBoleto(false,false);

	}
	public function imprimir($boleto,Request $r){
		$boleto = Boleto::find($boleto);
		if(!isset(Auth::user()->pessoa))
			if(!isset($r->pessoa->id) || $r->pessoa->id != $boleto->pessoa)
				//dd($boleto->pessoa.$r->pessoa->id);
				return redirect()->back()->withErrors(['Usuário não corresponde ao boleto requerido']);

		

		$vencido = false;

		if(!$boleto)
			return redirect()->back();

		if($boleto->vencimento < date('Y-m-d')){
			$vencido = true;

		}

		
		
		$lancamentos = Lancamento::where('boleto', $boleto->id)->get();
		$str_lancamentos ='';
		foreach ($lancamentos as $lancamento){
				$str_lancamentos.= $lancamento->referencia." ".$lancamento->matricula.'<br>';
			}
		
		if($boleto->status == 'gravado' || $boleto->status == 'impresso'){

			$pessoa = Pessoa::find($boleto->pessoa);
			$pessoa = PessoaController::formataParaMostrar($pessoa);
			//dd($pessoa);
			//$pessoa->formataParaMostrar();
			$boleto->status = 'emitido';
			$boleto->remessa=intval(date('YmdHi'));
			$boleto->save();

			LogController::alteracaoBoleto($boleto->id,'Registro do boleto pelo site BB');

			return view('financeiro.boletos.registrar')->with('boleto',$boleto)->with('lancamentos',$str_lancamentos)->with('pessoa',$pessoa)->with('vencido',$vencido);

		}
			
		else {
			$inst = new BoletoFuncional;
			$boleto_completo = $inst->gerar($boleto);
			//return $boleto_completo; 
			return view('financeiro.boletos.boleto')->with('boleto',$boleto_completo)->with('lancamentos',$lancamentos);

		}
		
		
		
		$inst = new BoletoFuncional;
		$boleto_completo = $inst->gerar($boleto);
		//return $boleto_completo; 
		return view('financeiro.boletos.boleto')->with('boleto',$boleto_completo)->with('lancamentos',$lancamentos);

	}
	public function imprimirx($boleto){
		$boleto = Boleto::find($boleto);
		if($boleto == null)
			throw new \Exception("Boleto Inexistente", 1);
		if($boleto->status == 'gravado'){
			$boleto->status = 'impresso';
			$boleto->save();
		}
		$boleto_completo = $this->gerarBoleto($boleto);
		

		return $boleto_completo->renderHTML();
		
	}
	public static function verificaSeCadastrado($pessoa,$valor,$vencimento){
		$cadastrado=Boleto::where('pessoa',$pessoa)
							->where('valor',$valor)
							->where('vencimento',$vencimento)
							->first();
		return $cadastrado;

	}
	/**
	 * Gerar boletos unicos e individuais para 5 dias corridos
	 * @param  [type]
	 * @return [type]
	 */
	public function cadastarIndividualmente($pessoa){
		$vencimento = date('Y-m-d 23:23:59', strtotime("+5 days",strtotime(date('Y-m-d')))); 

		$lancamentos = Lancamento::where('boleto',null)
			->where('pessoa',$pessoa)
			->get();

		if($lancamentos->count() > 0){
				
			//gerar boleto
			$total=0;
			foreach($lancamentos as $lancamento){
				$total = $total + $lancamento->valor;
			}

			if($total>0){
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
							if($lancamento->valor > 0){
								$total = $total + $lancamento->valor;
								$acrescimos=$acrescimos+$lancamento->valor;
							}
							else{
								$total = $total + $lancamento->valor;
								$descontos = $descontos + $lancamento->valor;	
							}
						}
						else
							$total = $total + $lancamento->valor;
						
						$lancamento->boleto=$boleto->id;
						$lancamento->save();
					}
				}
				$boleto->valor = $total;
				$boleto->descontos = $descontos;
				$boleto->encargos = $acrescimos;
				if($boleto->valor >0){
					$boleto->save();
				}
			}
		
			
		}//fim se qnde de lancamentos = 0
		return redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	public function confirmarImpressao(){
		$boletos = Boleto::where('status','gravado')->get();
		foreach($boletos as $boleto){
			$boleto->status = 'impresso';
			$boleto->save();
		}
		return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Confirmação gravada em '.$boletos->count().' boletos']);

	}
	


	public function listarPorPessoa(){
		if(!Session::get('pessoa_atendimento'))
        return redirect(asset('/secretaria/pre-atendimento'));
        $nome = \App\Pessoa::getNome(Session::get('pessoa_atendimento'));
        $boletos=Boleto::where('pessoa',Session::get('pessoa_atendimento'))->paginate(50);

        return view('financeiro.boletos.lista-por-pessoa',compact('boletos'))->with('nome',$nome);
	}


	public function cancelarView($id){
		return view('financeiro.boletos.cancelamento')->with('boleto',$id);
	}



	public function cancelar(Request $r){
		$this->cancelamentoDireto($r->boleto, $r->motivo.' '.$r->motivo2);
		return redirect('/secretaria/atender/');

	}



	public function cancelamentoDireto($id,$motivo){
		$boleto=Boleto::find($id);

		if($boleto != null){

			switch($boleto->status){
				case 'impresso':
				case 'gravado':
				case 'divida':
					$boleto->status = 'cancelado';
					$boleto->save();
					LancamentoController::cancelarPorBoleto($boleto->id);
					break;
				case 'emitido':
				case 'erro':
					$boleto->status = 'cancelar';
					$boleto->save();
					LancamentoController::cancelarPorBoleto($boleto->id);
					break;
				case 'pago':
					break;
				default :
					$boleto->status = 'cancelar';
					$boleto->save();
					LancamentoController::cancelarPorBoleto($boleto->id);
					break;
			}
			
			LogController::alteracaoBoleto($boleto->id, 'Solicitação de cancelamento.: '.$motivo);
			LogController::alteracaoBoleto($boleto->id, 'Solicitação de cancelamento por: '.Session::get('nome_usuario'));
			

		}
		else
			return redirect()->back()->withErrors(['Boleto não encontrado']);
		
	}


	public function cancelarTodosVw($pessoa){
		$pessoa = Pessoa::find($pessoa);
		if($pessoa)
			return view('financeiro.boletos.cancelamento-todos')->with('pessoa', $pessoa);
		else
			return Redirect::back()->withErrors(['Pessoa não encontrada']);
	}

	/**
	 * Cancelar todos boletos FUTUROS
	 * @param  Request $r [POST pessoa e motivo]
	 * @return [type]     [description]
	 */
	public function cancelarTodos(Request $r){
		$boletos = Boleto::where('pessoa',$r->pessoa)->where('vencimento', '>', date('Y-m-d H:i:s'))->get();
		//dd($boletos);
		foreach($boletos as $boleto){
			$this->cancelamentoDireto($boleto->id,$r->motivo.$r->motivo2);
		}
		return redirect('/secretaria/atender/'.$r->pessoa);
	}
	
	/**
	 * Gerador de boleto para impressão ou remessa.
	 * @param  Boleto
	 * @return [type]
	 */
	public static function gerarBoleto(Boleto $boleto){
		$cliente=Pessoa::find($boleto->pessoa);
		$cliente=PessoaController::formataParaMostrar($cliente);
		$lancamentos= LancamentoController::listarPorBoleto($boleto->id); //objetos lancamentos
		$array_lancamentos = array();
		foreach($lancamentos as $lancamento){
			$array_lancamentos[] = $lancamento->referencia;
		}
		$array_lancamentos = array_slice($array_lancamentos,0,4);
		$beneficiario = new \Eduardokum\LaravelBoleto\Pessoa([
		    'documento' => '45.361.904/0001-80',
		    'nome'      => 'Fundação Educacional São Carlos',
		    'cep'       => '13560-230',
		    'endereco'  => 'Rua São Sebastiao, 2828, ',
		    'bairro' => ' Vila Nery',
		    'uf'        => 'SP',
		    'cidade'    => 'São Carlos',
		]);
		if(is_null($cliente->cpf)){	
			//############# Return erro e envia notificação pra secretaria
			$cliente->cpf = '111.111.111-11';

		
		}
		//dd($cliente->cep);
		$pagador = new \Eduardokum\LaravelBoleto\Pessoa([
			'documento' => $cliente->cpf,
		    //'documento' => $cliente->cpf > 0 ? $cliente->cpf : NotificacaoController::notificarCPFInvalido($cliente->id), //verificar cpf
		    'nome'      =>  str_replace(['º','ª','°','´','~','^','`','\''],'',substr($cliente->nome,0,37)), //nome até x cara
		    'cep'       => $cliente->cep ? $cliente->cep : '13560-970' ,
		    'endereco'  => str_replace(['º','ª','°','´','~','^','`','\''], '',$cliente->logradouro.' '.$cliente->end_numero.' '.$cliente->end_complemento),
		    'bairro' => substr(($cliente->bairro=='Outros/Outra cidade' ? $cliente->bairro_alt : $cliente->bairro),0,15),
		    'uf'        => $cliente->estado,
		    'cidade'    => $cliente->cidade,
		]);
		//dd($pagador);
		$bb = new \Eduardokum\LaravelBoleto\Boleto\Banco\Bb([
		    'logo' =>'img/logo-small.png',
		    'dataVencimento' => Carbon::parse($boleto->vencimento),
		    'valor' => $boleto->valor,
		    'numero' =>$boleto->id,
		    'numeroDocumento' => $boleto->id,
		    'pagador' => $pagador,
		    'beneficiario' => $beneficiario,
		    'carteira' => 17,
		    'variacaoCarteira' =>'019',
		    'agencia' => '0295-X',
		    'convenio' => 2838669,
		    'conta' => 52822,
		    'descricaoDemonstrativo' => $array_lancamentos,
		    'instrucoes' => [
		    	'Sr. Caixa, cobrar multa de 2% após o vencimento', 
		    	'Cobrar juros de 1% ao mês por atraso.', 
		    	'Após o vencimento, o pagamento dever ser feito no Banco do Brasil',
		    	'Em caso de dúvidas ou divergências entre em contato conosco: 3372-1308'
		    ],
		]);
			//dd($bb);
		    return $bb;

		}

		public function consultarBoletosCPF(Request $request){
			$dados_pessoa = PessoaDadosGerais::where('dado',3)->where('valor',$requent->cpf)->get();
			if($dados_pessoa->count() == 0){
				return "CPF não encontrado.";
			}
			foreach($dados_pessoa as $dado){
				$pessoa = Pessoa::where('id',$dado->pessoa)->where('nascimento',$request->nascimento)->get();
				if ($pessoa->count()>0){
					echo "hi";
				}

			}
			


		}

		public function novo($pessoa){



			$matriculas = \App\Matricula::where('pessoa',$pessoa)->whereIn('status',['ativa','pendente','espera'])->get();
			//$lancamentos = Lancamento::where('pessoa',$pessoa)->where('boleto',null)->where('status',null)->get();
			return view('financeiro.boletos.novo')->with('matriculas',$matriculas)->with('pessoa',$pessoa);

		}


		public function create(Request $r){
			if($r->valor >0){
				if(isset($r->matriculas)){
					$boleto = new Boleto;
					$boleto->vencimento = $r->vencimento;
					$boleto->pessoa = $r->pessoa;
					$boleto->valor = $r->valor;
					$boleto->status = 'gravado';
					$boleto->save();
				
					foreach ($r->matriculas as $id_matricula){
						$matricula = \App\Matricula::find($id_matricula);
						if($matricula){
							$lancamento = new Lancamento;
							$lancamento->pessoa = $r->pessoa;
							$lancamento->matricula = $matricula->id;
							$lancamento->referencia = 'Parcela de '.$matricula->getNomeCurso();
							$lancamento->valor = $matricula->valor->valor/$matricula->valor->parcelas;
							$lancamento->boleto = $boleto->id;
							$lancamento->save();
						}

						/*
						$lancamento_bd = Lancamento::find($lancamento);
						if($lancamento_bd != null){
							$lancamento_bd->boleto = $boleto->id;
							$lancamento_bd->save();
						}*/

					}	
				}
				else{
					return redirect()->back()->withErrors(['Para gerar um boleto é necessário selecionar uma matrícula.']);
				}
				
				
			}
			AtendimentoController::novoAtendimento("Criação manual de boleto: ".$boleto->id, $boleto->pessoa, Auth::user()->pessoa);
			return redirect(asset('secretaria/atender/'.$r->pessoa));



		}
		public function reativar($id){
			$boleto=Boleto::find($id);
			$boleto->status = 'impresso';
			$boleto->save();
			LancamentoController::reativarPorBoleto($id);
			LogController::alteracaoBoleto($boleto->id,'Solicitação de reativação de boleto por '.Session::get('nome_usuario'));
			//AtendimentoController::novoAtendimento("Solicitação de reativação de boleto: ".$id, $boleto->pessoa, Auth::user()->pessoa);
			return redirect($_SERVER['HTTP_REFERER']);



		}
		public function editar($id){
			$boleto = Boleto::find($id);
			if($boleto != null){
				$boleto->vencimento = \Carbon\Carbon::parse($boleto->vencimento)->format('d/m/Y');
				$valor = $this->valorSoma($id);
				return view('financeiro.boletos.editar')->with('boleto',$boleto)->with('valor',$valor);
			}
			else 
				return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Boleto '.$id.' não encontrado.']);
		}
		public function update(Request $r){
			
			if($r->boleto > 0){
				$boleto = Boleto::find($r->id);
				LogController::alteracaoBoleto($boleto->id,'Boleto editado por '.Auth::user()->getPessoa()->nome_simples);
				LogController::alteracaoBoleto($boleto->id,'Boleto editado: '.\Carbon\Carbon::parse($boleto->vencimento)->format('d/m/Y').'->'.$r->vencimento.' status: '.$boleto->status.' ->'.$r->status) .'por '.Auth::user()->pessoa;
				
				$boleto->vencimento = \Carbon\Carbon::createFromFormat('d/m/Y', $r->vencimento, 'Europe/London')->format('Y-m-d 23:59:59');
				$boleto->valor = str_replace(',','.',$r->valor);
				$boleto->status = $r->status;
				$boleto->save();

				
			}
			return redirect(asset('secretaria/atendimento'));

		}


		public function valorSoma($boleto){
			$lancamentos = Lancamento::where('boleto',$boleto)->where('status',null)->get();
			$valor = 0;
			foreach($lancamentos as $lancamento){
				$valor+=$lancamento->valor;
			}
			return $valor;

		}

		public function segundaVia(Request $request){
			//dd($request);
			$this->validate($request, [
				'cpf'=>'required'
							

			]);
			$cpf_alt = preg_replace( '/[^0-9]/is', '', $request->cpf);
			$cpf_alt_formated = \App\classes\Strings::mask(str_pad($cpf_alt,11,'0'),"###.###.###-##");

			if($cpf_alt == '' || $cpf_alt_formated == '')
				return redirect('/meuboleto')->withErrors(["Desculpe, mas os dados fornecidos não são validos: ".$cpf_alt ]);


			$dados_pessoa = \App\PessoaDadosGerais::where('valor','like',$cpf_alt)->orWhere('valor','like',$cpf_alt_formated)->first();
			if($dados_pessoa){
				$pessoa = Pessoa::find($dados_pessoa->pessoa);
					
					$boletos = Boleto::where('pessoa',$pessoa->id)
							->where('status','emitido')
							->get();
					
					return view('financeiro.boletos.meuboleto-lista',compact('boletos'))->with('nome',$pessoa->nome);

			}
			else

				return redirect('/meuboleto')->withErrors(["Desculpe, não encontramos registro com os dados informados. Verifique o preenchimento e tente novamente. Caso o problema persistir entre em contato conosco pelo telefone 3372-1308 ou 3372-1325."]);


		}
		
		
		/**
		 * [Gera relatório (view) com todos boletos em aberto]
		 * @return [type] [description]
		 */
		public function relatorioBoletosAbertos($ativos=1){
			switch($ativos){
				case 1:
					$boletos = Boleto::where('status','emitido')->where('vencimento','<',date('Y-m-d'))->whereYear('vencimento',date('Y'))->orderBy('pessoa')->get();
					break;
				case 2:
					$boletos = Boleto::where('status','divida')->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();
					break;
				case 0:
					$boletos = Boleto::where('status','emitido')->where('vencimento','<',date('Y-m-d'))->whereYear('vencimento',date('Y')-1)->orderBy('pessoa')->get();
					foreach($boletos as $boleto){
						BoletoController::alterarStatus($boleto, 'inscrever');
					}
					break;
				default:
					$boletos = Boleto::where('status','emitido')->where('vencimento','<',date('Y-m-d'))->whereYear('vencimento',date('Y'))->orderBy('pessoa')->get();
					break;
	
				}

			foreach($boletos as $boleto){
				$boleto->aluno = \App\Pessoa::find($boleto->pessoa);
				$boleto->aluno->telefones =  $boleto->aluno->getTelefones();


			}
			
			return view('relatorios.boletos_vencidos')->with('boletos',$boletos)->with('ativos',$ativos);
		}

		
		public function atualizarBoletosGravados(){
			$boletos = Boleto::where('status','gravado')->get();
			foreach($boletos as $boleto){
				$valor=0;
				$lancamentos1 = Lancamento::where('boleto',$boleto->id)->where('status',null)->get();
				foreach($lancamentos1 as $lancamentox){
					$valor+=$lancamentox->valor;
				}
				$lancamentos2 = Lancamento::where('pessoa',$boleto->pessoa)->where('boleto',null)->where('status',null)->get();
				foreach($lancamentos2 as $lancamentoy){
					$lancamentoy->boleto = $boleto->id;
					$lancamentoy->save();
					$valor+=$lancamentoy->valor;
				}
				$boleto->valor = $valor;
				$boleto->save();
			}

			return $boletos->count()." boletos atualizados.";
		}

	
	/**
	*
	* Metodo para colocar os boletos abertos do ano como dívida
	*
	**/	
	public function dividaAtiva(){
		$boletos = Boleto::whereIn('status',['emitido'])->whereYear('vencimento','<',date('Y'))->paginate(1000);
			
		$beneficiario = new \Eduardokum\LaravelBoleto\Pessoa([
		    'documento' => '45.361.904/0001-80',
		    'nome'      => 'Fundação Educacional São Carlos',
		    'cep'       => '13560-230',
		    'endereco'  => 'Rua São Sebastiao, 2828, ',
		    'bairro' => ' Vila Nery',
		    'uf'        => 'SP',
		    'cidade'    => 'São Carlos',
		]);
		$remessa = new \Eduardokum\LaravelBoleto\Cnab\Remessa\Cnab240\Banco\Bb(
		    [
		        'agencia'      => '0295',
		        'carteira'     => 17,
		        'conta'        => 52822,
		        'convenio'     => 2838669,
		        'variacaoCarteira' => '019',
		        'beneficiario' => $beneficiario,
		    ]
		);
		

		if($boletos->count() == 0)
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhum boleto encontrado']);


		foreach($boletos as $boleto){
			try{ //tentar gerar boleto completo
				$boleto_completo = $this->gerarBoleto($boleto);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro ao gerar Boleto');
				continue;
			}
			
			
			try{//tentar gerar remessa desse boleto
				$remessa->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro ao gerar Remessa');
				continue;
			}
			if($boleto->status == 'emitido'){
				$boleto_completo->baixarBoleto();
				$boleto->status='divida';	
			}
			else{
				
				$boleto->status='emitido';
				
			}

			
			$boleto->save();

		}
		$remessa->save( 'remessas/'.date('YmdHi').'.rem');
		$arquivo = date('YmdHi').'.rem';
		return view('financeiro.remessa.arquivo',compact('boletos'))->with('arquivo',$arquivo);
	}

	public function limparDebitos(){
		$matriculas = array();
		/*
		1 - selecionar todos debitos da divida ativa
		para cada boleto pegar os lançamentos
		para cada lançamento
		verificar SE tem o termo de matricula
			SIM - blza
			NÃO - cancelar o Boleto
		*/
		$boletos = Boleto::where('status','divida')->get();
		foreach ($boletos as $boleto){
			$boleto->getLancamentos();
			foreach($boleto->lancamentos as $lancamento){
				if(!file_exists('documentos/matriculas/termos/'.$lancamento->matricula.'.pdf')){
					$matriculas[] = $lancamento->matricula;
					$boleto_obj = Boleto::find($boleto->id);
					// Falta colocar no histórico do boleto
					$boleto_obj->status = 'cancelado';
					$boleto_obj->save();
				}


			}
		}
		return $matriculas;


	}
	public function historico($id){
		$boleto = Boleto::find($id);
		if(!is_null($boleto)){
			$pessoa= Pessoa::find($boleto->pessoa);
			$dados = \App\Log::where('tipo','boleto')->where('codigo',$id)->get();
			$dados_pessoa = \App\Atendimento::where('descricao','like','%boleto%'.$id."%")->get();
			return view('financeiro.boletos.informacoes')->with('boleto',$boleto)->with('logs',$dados)->with('pessoais',$dados_pessoa)->with('pessoa',$pessoa);
		}
		else{
			return view('financeiro.boletos.informacoes');
		}
	}




	public function cancelarCovid(){
		$boletos = Boleto::where('status','emitido')->where('vencimento','like','2020-08-10%')->get();
		foreach($boletos as $boleto){
			$boleto->status = 'cancelar';
			$boleto->save();
			LogController::alteracaoBoleto($boleto->id, 'Solicitação de cancelamento.: Res. 05/2020, medidas administrativas sobre a COVID-19');
		}
		if($boletos->isNotEmpty())
			return $boletos->count().' boletos cancelados';
		else
			return 'Nenhum boleto cancelado';
	}

		

}