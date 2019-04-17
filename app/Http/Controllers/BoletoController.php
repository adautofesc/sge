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
use ZipArchive;
ini_set('max_execution_time', 300);

//require '../vendor/autoload.php';


//use App\Http\Controllers\LancamentoController;
//clude 'vendor/autoload.php';
class BoletoController extends Controller
{	
	public function logMe($msg){
		$fp = fopen("log.txt", "a");
		$msg = "\n".$msg;

		// Escreve a mensagem passada através da variável $msg
		$escreve = fwrite($fp, $msg);

		// Fecha o arquivo
		fclose($fp);
	

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

				if(count($lancamentos)>0 && $valor>0 ){// tem lancamentos? é maior que zero?
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

	public function imprimirCarne($pessoa){
		$boletos = Boleto::where('pessoa',$pessoa)->whereIn('status',['emitido','gravado','impresso'])->get();
		
		//$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Html();
		$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();


		foreach($boletos as $boleto){
			if($boleto->status == 'gravado'){
				$boleto->status = 'impresso';
				$boleto->save();
			}
			$boleto_completo = $this->gerarBoleto($boleto);
			//$boleto->status = 'impresso';
			//$boleto->save();
			$html->addBoleto($boleto_completo);
		}
		//$html->hideInstrucoes();
		//$html->showPrint();
		
		//return $html->gerarCarne();
		//dd(getcwd());
		if(!isset($_GET['page']))
			$_GET['page']=1;

		//$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$_GET['page'].'.pdf');
		return $html->gerarCarne($dest = $html::OUTPUT_STANDARD,$save_path=null);

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

	//****************************************************************************************************************************************
	//****************************************************************************************************************************************
	//****************************************************************************************************************************************

	/**
	 * Fase 1 - Geração de lançamentos de todas as matriculas.
	 * @return [view]
	 */
	public function carneFase1(){

		$matriculas = Matricula::whereIn('status',['ativa','pendente'])->paginate(50);
		$LC = new LancamentoController;
		foreach($matriculas as $matricula){
			$LC->gerarTodosLancamentos($matricula);

		}
		return view('financeiro.carne.fase1')->with('matriculas',$matriculas);

	}

	
	/**
	 * Fase 2 - criação dos boletos por meses
	 * @return [View]
	 */
	public function carneFase2(){

		$boletos = array();
		////peguei as pessoas que tem parcelas em aberto
		
			//$pessoas = Lancamento::where('pessoa','7514')->paginate(100);
		
			$pessoas = Lancamento::select('pessoa')
									->where('boleto',null)
									->where('status',null)
									->groupBy('pessoa')
									->orderBy('pessoa')
									->orderBy('parcela')
									->paginate(100);
			//dd($pessoas);


		foreach($pessoas as $pessoa){

			//Aqui são gerados os meses.******************************************************************** Atenção!
			for($i=2;$i<8;$i++){
				//verificar se tem boletoabero
				$boleto_existente = Boleto::where('pessoa',$pessoa->pessoa)
											->where('vencimento', 'like', date('Y-'.str_pad($i,2, "0", STR_PAD_LEFT).'-20%'))
											->whereIn('status',['gravado','impresso','emitido','pago'])
											->get();
				if(count($boleto_existente)==0){
					$boletos[$pessoa->pessoa][$i] = 'Boleto para '.date('20/'.$i.'/Y') ;
					$boleto =new Boleto;
					$boleto->vencimento = date('Y-'.$i.'-20');
					$boleto->pessoa = $pessoa->pessoa;
					$boleto->status = 'gravado';
					$boleto->valor = 0;
					if($boleto->pessoa > 0)
						$boleto->save();
				}
				


			}
		}
		return view('financeiro.carne.fase2')->with('pessoas',$pessoas);


	}
	

	/**
	 * Fase 3  - Associação das parcelas (lançamentos) com os boletos.
	 * @return [View]
	 */
	public function carneFase3(){

		
			/*$boletos = Boleto::where('status','gravado')
								->where('valor','<=',0)
								->where('pessoa','7514')
								->orderBy('pessoa')
								->orderBy('vencimento')
								->paginate(100);*/

		
			$boletos = Boleto::where('status','gravado')
								->where('valor','<=',0)
								->orderBy('pessoa')
								->orderBy('vencimento')
								->paginate(100);

		foreach($boletos as $boleto){

			//pegar primeira parcela livre de cada matricula
			$inscricoes = Lancamento::where('pessoa',$boleto->pessoa)
									->where('boleto',null)
									->where('valor','>',0)
									->where('status',null)
									->orderBy('parcela')
									->groupBy('matricula')->get();

			$data_util = new \App\classes\Data(\App\classes\Data::converteParaUsuario($boleto->vencimento));

			foreach($inscricoes as $inscricao){
				$inscricao->boleto = $boleto->id;
				$inscricao->referencia = 'Parcela de '.$data_util->Mes().' - '.$inscricao->referencia;
				$boleto->valor = $boleto->valor+$inscricao->valor;
				$inscricao->save();	
				$boleto->save();		
			}
			

			//pegar primeiro desconto da cada matrícula
			$descontos = Lancamento::where('pessoa',$boleto->pessoa)
									->where('boleto',null)
									->where('valor','<',0)
									->where('status',null)
									->orderBy('parcela')
									->groupBy('matricula')
									->get();

			foreach($descontos as $desconto){
				$desconto->boleto = $boleto->id;
				$boleto->valor = $boleto->valor+$desconto->valor;
				$desconto->save();
			}

			//enquanto o boleto nao tiver valor, acrescentar parcela, senão, apagar boleto.
			while($boleto->valor <=0){
				$inscricao = Lancamento::where('pessoa',$boleto->pessoa)
										->where('boleto',null)
										->where('valor','>',0)
										->where('status',null)
										->orderBy('parcela')
										->first();
				if($inscricao){
					$inscricao->boleto = $boleto->id;
					$inscricao->save();	
					$boleto->valor = $boleto->valor+$inscricao->valor;	
					$boleto->save();

				}
				else{
					$boleto->forceDelete();
					break;
				}



			}
			
			
		}

		return view('financeiro.carne.fase3')->with('boletos',$boletos);


	}
	public function carneFase4(){
		

		//contador
		/*
		list($usec, $sec) = explode(' ', microtime());
		$script_start = (float) $sec + (float) $usec;
		*/

		
			//$boletos = Boleto::where('status','gravado')->where('pessoa', '22610')->paginate(500);
	
			$boletos = Boleto::where('status','gravado')->orderBy('pessoa')->paginate(500);
		
		//$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Html();
		$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();


		foreach($boletos as $boleto){
			$boleto_completo = $this->gerarBoleto($boleto);
			//$boleto->status = 'impresso';
			//$boleto->save();
			$html->addBoleto($boleto_completo);
		}
		//$html->hideInstrucoes();
		//$html->showPrint();
		
		//return $html->gerarCarne();
		//dd(getcwd());
		if(!isset($_GET['page']))
			$_GET['page']=1;

		//$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$_GET['page'].'.pdf');
		$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$_GET['page'].'.pdf');

		//********************* finaliza contador
		/*
		list($usec, $sec) = explode(' ', microtime());
		$script_end = (float) $sec + (float) $usec;
		$elapsed_time = round($script_end - $script_start, 5);*/
		//****************************************************

		//$this->logMe(date('Y-m-d H:i:s').' Executado metodo fase 4 em '.$elapsed_time.' secs. Consumindo '.round(((memory_get_peak_usage(true) / 1024) / 1024), 2).' Mb de memória.');


		return view('financeiro.carne.fase4')->with('boletos',$boletos);


	}

	public function carneFase5(){
		
			//$boletos =Boleto::where('status','gravado')->orWhere('status','cancelar')->where('pessoa','22610')->paginate(500);
		
			$boletos =Boleto::where('status','gravado')->orWhere('status','cancelar')->paginate(500);
		foreach($boletos as $boleto){
			$boleto->status = 'impresso';
			$boleto->save();
		}

		return view('financeiro.carne.fase5')->with('boletos',$boletos);

	}

	public function carneFase6(){

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
		
		
			//$boletos =Boleto::where('status','impresso')->orWhere('status','cancelar')->where('pessoa', '22610')->paginate(500);
		
			$boletos =Boleto::where('status','impresso')->orWhere('status','cancelar')->paginate(500);

		if(count($boletos) == 0)
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhum boleto encontrado']);


		foreach($boletos as $boleto){
			try{ //tentar gerar boleto completo
				$boleto_completo = $this->gerarBoleto($boleto);
			}
			catch(\Exception $e){
				PessoaController::notificarErro($boleto->pessoa,5);
				continue;
			}
			
			
			try{//tentar gerar remessa desse boleto
				$remessa->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				PessoaController::notificarErro($boleto->pessoa,6);
				continue;
			}
			if($boleto->status == 'cancelar'){
				$boleto_completo->baixarBoleto();
			}		
			
		}
		
		//dd($remessa);
		$remessa->save( 'documentos/remessas/'.date('YmdHis').'.rem');
		$arquivo = date('YmdHis').'.rem';
		return view('financeiro.carne.fase6',compact('boletos'))->with('arquivo',$arquivo);
	}

	public function carneFase7(){
		
			//$boletos =Boleto::where('status','impresso')->orWhere('status','cancelar')->where('pessoa', '22610')->paginate(100);
		
			$boletos =Boleto::where('status','impresso')->orWhere('status','cancelar')->paginate(100);
		foreach($boletos as $boleto){
			if($boleto->status == 'cancelar'){
				//$boleto->status = 'cancelado';
			}
			else{
				//$boleto->status = 'emitido';
				$boleto->remessa = date('YmdHis');

			}

			$boleto->save();
		}

		return view('financeiro.carne.fase7',compact('boletos'));
	}

	public function carneFase8(){
		//gerar zip
		
		//dd(getcwd());
		$zip = new ZipArchive();
		$filename = 'documentos/carnes/carnes_'.date('Ymd').'zip';
		if($zip->open( $filename , ZipArchive::CREATE ) === FALSE){
			dd("Erro ao criar arquivo Zip.");
		}
		chdir( 'documentos/remessas/' );
		//$files = glob("{*.rem}", GLOB_BRACE);
		$remessas= glob(date('Ymd')."*rem", GLOB_BRACE);
		

		//dd($files);
		foreach($remessas as $remessa){
			if(file_exists($remessa)){
				$zip->addFile($remessa, $remessa);
			}else
				dd('Arquivo não encontrado: '.$file);
			
		}

		chdir( '../carnes' );
		//$files = glob("{*.rem}", GLOB_BRACE);
		$carnes= glob(date('Y-m-d')."*.pdf", GLOB_BRACE);

		foreach($carnes as $carne){
			if(file_exists($carne)){
				$zip->addFile($carne, $carne);
			}else
				dd('Arquivo não encontrado: '.$file);
			
		}


		$zip->close();

		
		//entrar na pasta pdf
		//pegar todos arquivos , verificar quais começam com a data de hoje

		//enrtrar na pasta remessas e fazer a mesma coisa

		//retornar arquivo zip.


		return view('financeiro.carne.fase8')->with('remessas',$remessas)->with('carnes',$carnes);

	}

	//****************************************************************************************************************************************
	//**************************************************************************************************************************************** fim do gerador
	//****************************************************************************************************************************************

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
		
		$boletos =Boleto::where('status','impresso')->orWhere('status','cancelar')->paginate(500);

		if(count($boletos) == 0)
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhum boleto encontrado']);


		foreach($boletos as $boleto){
			try{ //tentar gerar boleto completo
				$boleto_completo = $this->gerarBoleto($boleto);
			}
			catch(\Exception $e){
				PessoaController::notificarErro($boleto->pessoa,5);
				continue;
			}
			
			
			try{//tentar gerar remessa desse boleto
				$remessa->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				PessoaController::notificarErro($boleto->pessoa,6);
				continue;
			}

			if($boleto->status == 'cancelar')
				$boleto_completo->baixarBoleto();
				
		
			/*
			if($boleto->status == 'cancelar'){
				$boleto_completo->baixarBoleto();
				$boleto->status='cancelado';	
			}
			else{
				
				$boleto->status='emitido';
				
			}
			 */

			$boleto->remessa = intval(date('ymdHi'));
			$boleto->save();
	
		}
		
		//dd($remessa);
		if(isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = 1;
		$remessa->save( 'documentos/remessas/'.date('Ymd').'_'.$page.'.rem');
		$arquivo = date('Ymd').'_'.$page.'.rem';
		return view('financeiro.remessa.arquivo',compact('boletos'))->with('arquivo',$arquivo);

	}
	public function downloadRemessa($arquivo){
		$arquivo='documentos/remessas/'.$arquivo;
		$arquivo = str_replace('/','-.-', $arquivo);
		return \App\classes\Arquivo::download($arquivo);

	}
	public function listarRemessas(){
		chdir( 'documentos/remessas/' );
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


	public function cancelarView($id){
		return view('financeiro.boletos.cancelamento')->with('boleto',$id);
	}
	public function cancelar(Request $r){



		$boleto=Boleto::find($r->boleto);

		if($boleto != null){
			if($boleto->status == 'impresso'){
				$boleto->status = 'cancelar';
				$boleto->save();
				LancamentoController::cancelarPorBoleto($boleto->id);
			}
			if($boleto->status == 'gravado'){
				$boleto->status = 'cancelado';
				$boleto->save();
				LancamentoController::atualizaLancamentos($boleto->id,null);
			}
			if($boleto->status == 'emitido'){
				$boleto->status = 'cancelar';
				$boleto->save();
				LancamentoController::cancelarPorBoleto($boleto->id);
			}
			if($boleto->status == 'divida'){
				$boleto->status = 'cancelado';
				$boleto->save();
				LancamentoController::cancelarPorBoleto($boleto->id);
			}
			if($boleto->status == 'cancelar'){
				LancamentoController::cancelarPorBoleto($boleto->id);
			}
			if($boleto->status == 'cancelado'){
				LancamentoController::cancelarPorBoleto($boleto->id);
			}

		}

		LogController::alteracaoBoleto($boleto->id, 'Solicitação de cancelamento. Motivo:' . $r->motivo.$r->motivo2);

		return redirect('/secretaria/atender/'.$boleto->pessoa);

		

	}
	public function cancelamentoDireto($id,$motivo){
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
			if($boleto->status == 'divida'){
				$boleto->status = 'cancelado';
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

		LogController::alteracaoBoleto($boleto->id, 'Solicitação de cancelamento. Motivo: '.$motivo);
		
	}


	public function cancelarTodosVw($pessoa){
		$pessoa = Pessoa::find($pessoa);
		if($pessoa)
			return view('financeiro.boletos.cancelamento-todos')->with('pessoa', $pessoa);
		else
			return Redirect::back()->withErrors(['Pessoa não encontrada']);
	}


	public function cancelarTodos(Request $r){
		$boletos = Boleto::where('pessoa',$r->pessoa)->where('vencimento', '>', date('Y-m-d H:i:s'))->get();
		//dd($boletos);
		foreach($boletos as $boleto){
			$this->cancelamentoDireto($boleto->id,$r->motivo.$r->motivo2);
		}
		return redirect('/secretaria/atender/'.$r->pessoa);
	}





	/**
	 * Gerador de parcelas e boletos 
	 * @param  [integer] Pessoa
	 * @return [type]
	 */
	public function gerarCarneIndividual($pessoa){

		$matriculas = Matricula::whereIn('status',['ativa','pendente'])->where('pessoa',$pessoa)->get();
		$LC = new LancamentoController;
		foreach($matriculas as $matricula){
			$LC->gerarTodosLancamentos($matricula);

		}

		$lancamentos = Lancamento::where('pessoa',$pessoa)->where('status', null )->where('boleto',null)->get();
		//dd($lancamentos);


		if(count($lancamentos)>0){

			//Aqui são gerados os meses.******************************************************************** Atenção! Fase 2
			if(date('d')>=20)
				$mes=date('m')+1;
			else
				$mes=date('m');


			for($i=$mes;$i<8;$i++){
				//verificar se tem boletoabero
				$boleto_existente = Boleto::where('pessoa',$pessoa)
											->where('vencimento', 'like', date('Y-'.str_pad($i,2, "0", STR_PAD_LEFT).'-20%'))
											->whereIn('status',['gravado','impresso','emitido','pago'])
											->get();
				if(count($boleto_existente)==0){
				
					$boleto =new Boleto;
					$boleto->vencimento = date('Y-'.$i.'-20');
					$boleto->pessoa = $pessoa;
					$boleto->status = 'gravado';
					$boleto->valor = 0;
					if($boleto->pessoa > 0)
						$boleto->save();
				}//endif
			}//endfor

			//************************************************************************************************ fase 3
			$boletos = Boleto::where('status','gravado')
								->where('valor','<=',0)
								->where('pessoa',$pessoa)
								->orderBy('vencimento')
								->get();

			foreach($boletos as $boleto){

				//pegar primeira parcela livre de cada matricula
				$inscricoes = Lancamento::where('pessoa',$boleto->pessoa)
										->where('boleto',null)
										->where('valor','>',0)
										->where('status',null)
										->orderBy('parcela')
										->groupBy('matricula')->get();

				$data_util = new \App\classes\Data(\App\classes\Data::converteParaUsuario($boleto->vencimento));

				foreach($inscricoes as $inscricao){
					$inscricao->boleto = $boleto->id;
					$inscricao->referencia = 'Parcela de '.$data_util->Mes().' - '.$inscricao->referencia;
					$boleto->valor = $boleto->valor+$inscricao->valor;
					$inscricao->save();	
					$boleto->save();		
				}
				
				//pegar primeiro desconto da cada matrícula
				$descontos = Lancamento::where('pessoa',$boleto->pessoa)
										->where('boleto',null)
										->where('valor','<',0)
										->where('status',null)
										->orderBy('parcela')
										->groupBy('matricula')
										->get();

				foreach($descontos as $desconto){
					$desconto->boleto = $boleto->id;
					$boleto->valor = $boleto->valor+$desconto->valor;
					$desconto->save();
				}

				//enquanto o boleto nao tiver valor, acrescentar parcela, senão, apagar boleto.
				while($boleto->valor <=0){
					$inscricao = Lancamento::where('pessoa',$boleto->pessoa)
											->where('boleto',null)
											->where('valor','>',0)
											->where('status',null)
											->orderBy('parcela')
											->first();
					if($inscricao){
						$inscricao->boleto = $boleto->id;
						$inscricao->save();	
						$boleto->valor = $boleto->valor+$inscricao->valor;	
						$boleto->save();

					}
					else{
						$boleto->forceDelete();
						break;
					}
				}
			}

		}//endif lancamentos (fase 2)

		return redirect()->back();




	}





	
	/**
	 * Gerador de boleto para impressão ou remessa.
	 * @param  Boleto
	 * @return [type]
	 */
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

		public function novo($pessoa){
			$lancamentos = Lancamento::where('pessoa',$pessoa)->where('boleto',null)->where('status',null)->get();
			return view('financeiro.boletos.novo')->with('lancamentos',$lancamentos)->with('pessoa',$pessoa);

		}


		public function create(Request $r){
			if($r->valor >0){
				if(isset($r->lancamentos)){
					$boleto = new Boleto;
					$boleto->vencimento = $r->vencimento;
					$boleto->pessoa = $r->pessoa;
					$boleto->valor = $r->valor;
					$boleto->status = 'gravado';
					$boleto->save();
					foreach ($r->lancamentos as $lancamento){
						$lancamento_bd = Lancamento::find($lancamento);
						if($lancamento_bd != null){
							$lancamento_bd->boleto = $boleto->id;
							$lancamento_bd->save();
						}

					}	
				}
				else{
					return redirect()->back()->withErrors(['Para gerar um boleto é necessário pelo menos uma parcela (lançamento).']);
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
				$valor = $this->valorSoma($id);
				return view('financeiro.boletos.editar')->with('boleto',$boleto)->with('valor',$valor);
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
		public function relatorioBoletosAbertos($ativos=1){
			if($ativos)
			$boletos = Boleto::whereIn('status',['emitido','gravado','impresso'])->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();
			else
				$boletos = Boleto::where('status','divida')->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();

			foreach($boletos as $boleto){
				$boleto->aluno = \App\Pessoa::find($boleto->pessoa);
				$boleto->aluno->telefones =  $boleto->aluno->getTelefones();


			}
			
			return view('relatorios.boletos_vencidos')->with('boletos',$boletos)->with('ativos',$ativos);
		}

		/**
		 * Json com pessoas, seu saldo devedor e endereços
		 * @return [json] [lista de pessoa com seu saldo devedor]
		 */
		public function relatorioDevedores($ativos=1){


			//seleciona boletos de status emitidos, vencido ordenado por pessoa
			if($ativos)
				$boletos = Boleto::whereIn('status',['emitido','gravado','impresso'])->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();
			else
				$boletos = Boleto::where('status','divida')->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();
			

			//dd($boletos);

			//cria uma coleção para armazenar as pessoas
			$devedores = collect();

			
			//para cada boleto aberto
			foreach($boletos as $boleto){

				//seleciona devedor na coleção
				$devedor= $devedores->where('id',$boleto->pessoa)->first();


				//se ele estiver na coleção
				if(isset($devedor)){

					//soma valor do boleto atual	
					$devedor->divida +=  $boleto->valor;
					$lancamentos = $boleto->getLancamentos();
					foreach($lancamentos as $lancamento){
						$devedor->pendencias[] = $lancamento->referencia. ' mt'.$lancamento->matricula.' R$'.number_format($lancamento->valor,2,',','.');
					}
					//$devedor->pendencias->push($boleto->getLancamentos());				
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
					$lancamentos = $boleto->getLancamentos();
					foreach($lancamentos as $lancamento){
						$pessoa->pendencias[] = $lancamento->referencia. ' mt'.$lancamento->matricula.' R$'.number_format($lancamento->valor,2,',','.');
					}
					
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
		public function relatorioDevedoresXls($ativos=1){
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

	       
			$devedores = $this->relatorioDevedores($ativos);

			foreach($devedores as $pessoa){

						$planilha->setCellValue('A'.$linha, $pessoa->nome);
						$planilha->setCellValue('B'.$linha, $pessoa->cpf);
				        $planilha->setCellValue('C'.$linha, $pessoa->endereco->logradouro.' '.$pessoa->endereco->numero.' '.$pessoa->endereco->complemento);
				 
				        $planilha->setCellValue('D'.$linha, $pessoa->endereco->getBairro());
				        $planilha->setCellValue('E'.$linha, $pessoa->endereco->cep);
				        $planilha->setCellValue('F'.$linha, $pessoa->endereco->cidade);

				        $referencias='';
				        $valor=0;

				//dd($pessoa->pendencias);
				/*
				foreach($pessoa->pendencias as $pendencia){


					if($pendencia->valor>0){

						 //dd($pendencia);
						$referencias .= $pendencia->referencia. '; R$ '.$pendencia->valor. '; Mt.'.$pendencia->matricula.';'. "\n";
						//$valor += $pendencia->valor;

				       
			    	}//end if($pendencia->valor>0)
		    	}// end foreach($pessoa->pendencias as $pendencia)
		    	*/

		    	$planilha->setCellValue('G'.$linha, implode(";\n",$pessoa->pendencias));
		        $planilha->setCellValue('H'.$linha, 'R$ '.number_format($pessoa->divida,2,',','.'));
		     

		    	$linha++;

			}
			


			return $arquivo->save('php://output', 'xls');

			
		}
		public function relatorioDevedoresSms($ativos=1){
			header('Content-Type: text/plain');
	        header('Content-Disposition: attachment;filename="'. 'cobranca-sms' .'.txt"'); /*-- $filename is  xsl filename ---*/
	        header('Cache-Control: max-age=0');

	        $devedores = $this->relatorioDevedores($ativos);
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
		
		public function valorSoma($boleto){
			$lancamentos = Lancamento::where('boleto',$boleto)->where('status',null)->get();
			$valor = 0;
			foreach($lancamentos as $lancamento){
				$valor+=$lancamento->valor;
			}
			return $valor;

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

			return count($boletos)." boletos atualizados.";
		}

	
	/**
	*
	* Metodo para colocar os boletos abertos do ano como dívida
	*
	**/	
	public function dividaAtiva(){
		$boletos = Boleto::whereIn('status',['emitido'])->where('vencimento','<',date('2018-12-31'))->paginate(1000);
			
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
		

		if(count($boletos) == 0)
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhum boleto encontrado']);


		foreach($boletos as $boleto){
			try{ //tentar gerar boleto completo
				$boleto_completo = $this->gerarBoleto($boleto);
			}
			catch(\Exception $e){
				PessoaController::notificarErro($boleto->pessoa,5);
				continue;
			}
			
			
			try{//tentar gerar remessa desse boleto
				$remessa->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				PessoaController::notificarErro($boleto->pessoa,6);
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

		

}