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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
ini_set('max_execution_time', 300);

//require '../vendor/autoload.php';


//use App\Http\Controllers\LancamentoController;
//clude 'vendor/autoload.php';
class BoletoController extends Controller
{	
	public function cadastrar(){ //$parcela/mes/ano
		$boletos=0;
		$vencimento=date('Y-m-20 23:59:59');
		//$pessoas = \DB::select("select distinct pessoa from lancamentos where status is null and  boleto is null group by pessoa"); //seleciona pessoas com matriculas ativas/pendentes


		$pessoas = Lancamento::distinct('pessoa')->where('status',null)->where('boleto',null)->groupBy('pessoa')->paginate(50);

		//dd($pessoas);

		foreach($pessoas as $pessoa){
			$valor=0;

	
			$lancamentos = Lancamento::where('status',null)
				->where('boleto',null)
				->where('pessoa',$pessoa->pessoa)
				->get();
			foreach($lancamentos as $lancamento){
				$valor = $valor + $lancamento->valor;
			}

			if(count($lancamentos)>0 && $valor>0 ){// tem lancamentos? é maior que zero?
				$boleto = new Boleto; //cria boleto
				$boleto->vencimento = $vencimento;
				$boleto->pessoa = $pessoa->pessoa;
				$boleto->status = 'gravado';
				$boleto->valor = $valor;
				if($pessoa->pessoa>0){
					$boleto->save();
					foreach($lancamentos as $lancamento){ //para cada lancamento
						$lancamento->boleto = $boleto->id;
						$lancamento->save();
					}
				$boletos++;

				}

			}
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
	public function imprimir($boleto){
		$boleto = Boleto::find($boleto);
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
		
		if($boleto->status == 'gravado' || $boleto->status == 'impresso' || $vencido==true){

			$pessoa = Pessoa::find($boleto->pessoa);
			$pessoa = PessoaController::formataParaMostrar($pessoa);
			//dd($pessoa);
			//$pessoa->formataParaMostrar();
			$boleto->status = 'emitido';
			$boleto->save();

			return view('financeiro.boletos.registrar')->with('boleto',$boleto)->with('lancamentos',$str_lancamentos)->with('pessoa',$pessoa)->with('vencido',$vencido);

		}
			
		if($boleto->status =='emitido'){
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
		$cadastrado=Boleto::where('pessoa',$pessoa)->where('valor',$valor)->where('vencimento',$vencimento)->first();
		return $cadastrado;

	}
	public function cadastarIndividualmente($pessoa){
		$vencimento = date('Y-m-d 23:23:59', strtotime("+5 days",strtotime(date('Y-m-d')))); 

		$lancamentos = Lancamento::where('boleto',null)
			->where('pessoa',$pessoa)
			->get();

		if(count($lancamentos) > 0){
				
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
	
	
	public function confirmarImpressao(){
		$boletos = Boleto::where('status','gravado')->get();
		foreach($boletos as $boleto){
			$boleto->status = 'impresso';
			$boleto->save();
		}
		return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Confirmação gravada em '.count($boletos).' boletos']);

	}
	public function gerarRemessa(){
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
		
		$boletos =Boleto::where('status','impresso')->orWhere('status','cancelar')->get();
		if(count($boletos) == 0)
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhum boleto encontrado']);
		foreach($boletos as $boleto){
			$boleto_completo = $this->gerarBoleto($boleto);
			if($boleto->status == 'cancelar'){
				$boleto_completo->baixarBoleto();
				$boleto->status='cancelado';	

			}
			else{
				
				$boleto->status='emitido';
				
			}

			$boleto->remessa = intval(date('ymdHi'));
			$boleto->save();

			$remessa->addBoleto($boleto_completo);
	
		}
		
		//dd($remessa);
		$remessa->save( 'remessas/'.date('YmdHi').'.rem');
		$arquivo = date('YmdHi').'.rem';
		return view('financeiro.remessa.arquivo',compact('arquivo'));

	}
	public function downloadRemessa($arquivo){
		$arquivo='remessas/'.$arquivo;
		return \App\classes\Arquivo::download($arquivo);

	}
	public function listarRemessas(){
		chdir( 'remessas/' );
		$arquivos = glob("{*.rem}", GLOB_BRACE);
		rsort($arquivos);
		//return $arquivos;
		return view('financeiro.remessa.lista')->with('arquivos',$arquivos);
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
			if($boleto->status == 'impresso'){
				$boleto->status = 'cancelar';
				$boleto->save();
				LancamentoController::cancelarPorBoleto($id);
			}
			if($boleto->status == 'gravado'){
				$boleto->status = 'cancelado';
				$boleto->save();
				LancamentoController::atualizaLancamentos($id,null);
			}
			if($boleto->status == 'emitido'){
				$boleto->status = 'cancelar';
				$boleto->save();
				LancamentoController::cancelarPorBoleto($id);
			}
			if($boleto->status == 'cancelar'){
				LancamentoController::cancelarPorBoleto($id);
			}
			if($boleto->status == 'cancelado'){
				LancamentoController::cancelarPorBoleto($id);
			}
		}

		AtendimentoController::novoAtendimento("Solicitação de cancelamento de boleto: ".$id, $boleto->pessoa, Session::get('usuario'));
		return redirect($_SERVER['HTTP_REFERER']);

		

	}
	public function gerarBoleto(Boleto $boleto){
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
			$cliente->cpf = '111.111.111-11';

		//dd($cliente->cpf);
		}
		$pagador = new \Eduardokum\LaravelBoleto\Pessoa([
			'documento' => $cliente->cpf,
		    //'documento' => $cliente->cpf > 0 ? $cliente->cpf : PessoaController::notificarCPFInvalido($cliente->id), //verificar cpf
		    'nome'      =>  str_replace(['º','ª','°'],'',substr($cliente->nome,0,37)), //nome até x cara
		    'cep'       => preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cliente->cep) ? $cliente->cep : '13970-000' ,
		    'endereco'  => str_replace(['º','ª','°'], '',$cliente->logradouro.' '.$cliente->end_numero.' '.$cliente->complemento),
		    'bairro' => substr(($cliente->bairro=='Outros/Outra cidade' ? $cliente->bairro_alt : $cliente->bairro),0,15),
		    'uf'        => $cliente->estado,
		    'cidade'    => $cliente->cidade,
		]);
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
			if(count($dados_pessoa) == 0){
				return "CPF não encontrado.";
			}
			foreach($dados_pessoa as $dado){
				$pessoa = Pessoa::where('id',$dado->pessoa)->where('nascimento',$request->nascimento)->get();
				if (count($pessoa)>0){
					echo "hi";
				}

			}
			


		}

		/*
		public function corrigirBoletos(){
			$boletos = \DB::select("select distinct boleto from lancamentos l join boletos b on l.boleto = b.id where vencimento like '2018-03-28 23:59:00' and parcela = 0 group by b.id");
			foreach($boletos as $boleto){
				$lancamentos=Lancamento::where('boleto',$boleto->boleto)
								->get();

				foreach($lancamentos as $lancamento){
					$lancamento->boleto=null;
					$lancamento->save();
				}
				$boletao = Boleto::find($boleto->boleto);
				$boletao->delete();

			}
		}*/
		public function novo($pessoa){
			$lancamentos = Lancamento::where('pessoa',$pessoa)->where('boleto',null)->where('status',null)->get();
			return view('financeiro.boletos.novo')->with('lancamentos',$lancamentos)->with('pessoa',$pessoa);

		}
		public function create(Request $r){
			if($r->valor >0){
				$boleto = new Boleto;
				$boleto->vencimento = $r->vencimento;
				$boleto->pessoa = $r->pessoa;
				$boleto->valor = $r->valor;
				$boleto->status = 'gravado';
				$boleto->save();

				if(isset($r->lancamentos)){
					foreach ($r->lancamentos as $lancamento){
						$lancamento_bd = Lancamento::find($lancamento);
						if($lancamento_bd != null){
							$lancamento_bd->boleto = $boleto->id;
							$lancamento_bd->save();
						}

					}	
				}
				
				
			}
			AtendimentoController::novoAtendimento("Criação manual de boleto: ".$boleto->id, $boleto->pessoa, Session::get('usuario'));
			return redirect(asset('secretaria/atender/'.$r->pessoa));



		}
		public function reativar($id){
			$boleto=Boleto::find($id);
			$boleto->status = 'impresso';
			$boleto->save();
			LancamentoController::reativarPorBoleto($id);
			AtendimentoController::novoAtendimento("Solicitação de reativação de boleto: ".$id, $boleto->pessoa, Session::get('usuario'));
			return redirect($_SERVER['HTTP_REFERER']);



		}
		public function editar($id){
			$boleto = Boleto::find($id);
			if($boleto != null){
				$boleto->vencimento = \Carbon\Carbon::parse($boleto->vencimento)->format('d/m/Y');
				return view('financeiro.boletos.editar')->with('boleto',$boleto);
			}
			else 
				return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Boleto '.$id.' não encontrado.']);
		}
		public function update(Request $r){
			if($r->boleto > 0){
				$boleto = Boleto::find($r->id);
				$boleto->vencimento = \Carbon\Carbon::createFromFormat('d/m/Y', $r->vencimento, 'Europe/London')->format('Y-m-d 23:59:59');
				$boleto->valor = str_replace(',','.',$r->valor);
				$boleto->status = $r->status;
				$boleto->save();
				
			}
			return redirect(asset('secretaria/atendimento'));

		}
		public function segundaVia(Request $request){
			$this->validate($request, [
				'cpf'=>'required'
							

			]);
			$cpf_alt = str_pad($request->cpf,11,'0');
			$cpf_alt = \App\classes\Strings::mask($cpf_alt,"###.###.###-##");
			$dados_pessoa = \App\PessoaDadosGerais::where('valor','like',$request->cpf)->first();
			//dd($dados_pessoa);
			if($dados_pessoa){
				$pessoa = Pessoa::find($dados_pessoa->pessoa);
				
					$boletos = Boleto::where('pessoa',$pessoa->id)
						->where(function($query){ $query
							->where('status','impresso')
							->orwhere('status', 'gravado')
							->orwhere('status', 'emitido');
					})->get();
					return view('financeiro.boletos.meuboleto-lista',compact('boletos'))->with('nome',$pessoa->nome);


				

				
					//return redirect('/meuboleto')->withErrors(["Desculpe, os dados estão incorretos. Verifique e tente novamente."]);
			}
			else
				return redirect('/meuboleto')->withErrors(["Desculpe, não encontramos registro com os dados informados."]);


		}
		
		/**
		 * [Gera relatório (view) com todos boletos em aberto]
		 * @return [type] [description]
		 */
		public function relatorioBoletosAbertos(){
			$boletos = Boleto::whereIn('status',['emitido','gravado','impresso'])->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();

			foreach($boletos as $boleto){
				$boleto->aluno = \App\Pessoa::find($boleto->pessoa);
				$boleto->aluno->telefones =  $boleto->aluno->getTelefones();


			}
			
			return view('relatorios.boletos_vencidos')->with('boletos',$boletos);
		}

		/**
		 * Json com pessoas, seu saldo devedor e endereços
		 * @return [json] [lista de pessoa com seu saldo devedor]
		 */
		public function relatorioDevedores(){
			//seleciona boletos de status emitidos, vencido ordenado por pessoa
			$boletos = Boleto::whereIn('status',['emitido','gravado','impresso'])->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();

			//dd($boletos);

			//cria uma coleção para armazenar as pessoas
			$devedores = collect();

			
			//para cada boleto aberto
			foreach($boletos as $boleto){

				//seleciona devedor na coleção
				$devedor= $devedores->where('id',$boleto->pessoa)->first();


				//se ele estiver na coleção
				if($devedor){

					//soma valor do boleto atual	
					$devedor->divida +=  $boleto->valor;					
				}

				//se não tiver na coleção
				else{

					//criar uma nova pessoa e adiciona na coleção
					$pessoa = new \stdClass;
					$pessoa->id = $boleto->pessoa;
					$pessoa->nome = \App\Pessoa::getNome($boleto->pessoa);
					$pessoa->pendencias = array();


					//seleciona o id do endereço
					$endereco = \App\PessoaDadosContato::where('pessoa',$boleto->pessoa)->where('dado',6)->orderByDesc('id')->first();
					$cpf = \App\PessoaDadosGerais::where('pessoa',$boleto->pessoa)->where('dado',3)->first();

					if(isset($cpf->valor)==false || \App\classes\Strings::validaCPF($cpf->valor) == false){
						//die('cpf invalido');
						PessoaController::notificarErro($pessoa->id,1);
						continue;
					}
					else
					$pessoa->cpf = $cpf->valor;
					//se achou endereco
					if($endereco)
						//busca na tabela enderecos
						$pessoa->endereco =  \App\Endereco::find($endereco->valor);

					else{
						//die('endereço invalidao'.$pessoa->id);
						PessoaController::notificarErro($pessoa->id,2);
						continue;
					}
					$pessoa->pendencias = $boleto->getLancamentos();
					$pessoa->boleto = $boleto;
					$pessoa->vencimento= $boleto->vencimento;

					$pessoa->divida = $boleto->valor;
					// adiciona na coleção
					$devedores->push($pessoa);

				}//else de não estiver na coleção
			}//end foreach boletos

			//dd($devedores);
			return $devedores;
		}

		/**
		 * Transforma relatorio de devedores em Xls
		 * @return [type] [description]
		 */
		public function relatorioDevedoresXls(){
			//header para XLS

			
			header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'. 'cobranca' .'.xls"'); 
	        header('Cache-Control: max-age=0');

	        
	        $planilha =  new Spreadsheet();
        	$arquivo = new Xls($planilha);
			
	        $planilha = $planilha->getActiveSheet();
	        $planilha->setCellValue('A1', 'Nome');
	        $planilha->setCellValue('B1', 'CPF');
	        $planilha->setCellValue('C1', 'Endereço');
	        $planilha->setCellValue('D1', 'Bairro');
	        $planilha->setCellValue('E1', 'CEP');
	        $planilha->setCellValue('F1', 'Cidade');
	        $planilha->setCellValue('G1', 'Referência');
	        $planilha->setCellValue('H1', 'Total');

	        $linha = 2;


			$devedores = $this->relatorioDevedores();

			foreach($devedores as $pessoa){

						$planilha->setCellValue('A'.$linha, $pessoa->nome);
						$planilha->setCellValue('B'.$linha, $pessoa->cpf);
				        $planilha->setCellValue('C'.$linha, $pessoa->endereco->logradouro.' '.$pessoa->endereco->numero.' '.$pessoa->endereco->complemento);
				 
				        $planilha->setCellValue('D'.$linha, $pessoa->endereco->getBairro());
				        $planilha->setCellValue('E'.$linha, $pessoa->endereco->cep);
				        $planilha->setCellValue('F'.$linha, $pessoa->endereco->cidade);

				        $referencias='';
				        $valor=0;



				foreach($pessoa->pendencias as $pendencia){


					if($pendencia->valor>0){

						 //dd($pendencia);
						$referencias .= $pendencia->referencia. ' R$ '.$pendencia->valor. ' Mt.'.$pendencia->matricula. "\n";
						$valor += $pendencia->valor;

				       
			    	}//end if($pendencia->valor>0)
		    	}// end foreach($pessoa->pendencias as $pendencia)

		    	$planilha->setCellValue('G'.$linha, $referencias);
		        $planilha->setCellValue('H'.$linha, $valor);
		     

		    	$linha++;

			}
			


			return $arquivo->save('php://output', 'xls');

			
		}
		public function relatorioDevedoresSms(){
			header('Content-Type: text/plain');
	        header('Content-Disposition: attachment;filename="'. 'cobranca-sms' .'.txt"'); /*-- $filename is  xsl filename ---*/
	        header('Cache-Control: max-age=0');

	        $devedores = $this->relatorioDevedores();
	        $contador=0;
	        $linha  = 'FESC - '."\n";
	        $linha .= 'ATENÇÂO. Constatamos pendências relacionadas a seu cadastro. Por favor, entre em contato conosco.'."\n";

	        foreach($devedores as $pessoax){
	        	$pessoa = \App\Pessoa::find($pessoax->id);
	        	$pessoa->celular = $pessoa->getCelular();
	        	if($pessoa->celular == '-')
	        		continue;
	        	
	        	$linha .= $pessoa->celular.';'.$pessoa->nome_simples."\n";
	        	$contador++;
	        	

	        }
	        $linha .= $contador;



			return $linha;
		}
		

		

}
