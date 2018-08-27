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
		$vencimento=date('Y-m-28 23:59:59');
		$pessoas = \DB::select("select distinct pessoa from lancamentos where status is null and  boleto is null group by pessoa"); //seleciona pessoas com matriculas ativas/pendentes

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
				$boleto->save();
				foreach($lancamentos as $lancamento){ //para cada lancamento
					$lancamento->boleto = $boleto->id;
					$lancamento->save();

				}
				$boletos++;
			}
		}

		return redirect($_SERVER['HTTP_REFERER'])->withErrors([$boletos.' boletos gerados']);


	}
	public function imprimirLote(){

		$boletosx=Boleto::where('status','gravado')->paginate(200);
		$boletos = collect();
		
		$inst = new BoletoFuncional;
		foreach($boletosx as $boleto){
			$boleto_completo = $inst->gerar($boleto);
			$boleto_completo->lancamentos = Lancamento::where('boleto', $boleto->id)->get();
			$boletos->push($boleto_completo);
			
		}
		return view('financeiro.boletos.lote')->with('boletos',$boletos)->with('boletosx',$boletosx);
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
		if($boleto->status == 'gravado'){
			$boleto->status = 'impresso';
			$boleto->save();
		}
		//return $boleto;
		$inst = new BoletoFuncional;
		$boleto_completo = $inst->gerar($boleto);
		
		$lancamentos = Lancamento::where('boleto', $boleto->id)->get();

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
		    'cep'       => preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cliente->cep) ? $cliente->cep : '13500-000' ,
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
		    	'Em caso de dúvidas ou divergências, entre em contato conosco: 3372-1308'
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
			return redirect(asset('secretaria/atender/'.$r->pessoa));



		}
		public function reativar($id){
			$boleto=Boleto::find($id);
			$boleto->status = 'impresso';
			$boleto->save();
			LancamentoController::reativarPorBoleto($id);
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
				'cpf'=>'required|numeric',
				'nascimento'=>'required'			

			]);
			$cpf_alt = str_pad($request->cpf,11,'0');
			$cpf_alt = \App\classes\Strings::mask($cpf_alt,"###.###.###-##");
			$dados_pessoa = \App\PessoaDadosGerais::where('valor','like',$request->cpf)->orWhere('valor','like',$cpf_alt)->get();
			if(count($dados_pessoa) > 0){
				$pessoa = Pessoa::find($dados_pessoa->first()->pessoa);
				if($pessoa->nascimento == \Carbon\Carbon::createFromFormat('d/m/Y', $request->nascimento, 'Europe/London')->format('Y-m-d')){
					$boletos = Boleto::where('pessoa',$pessoa->id)
						->where(function($query){ $query
							->where('status','impresso')
							->orwhere('status', 'gravado')
							->orwhere('status', 'emitido');
					})->get();
					return view('financeiro.boletos.meuboleto-lista',compact('boletos'))->with('nome',$pessoa->nome);


				}

				else
					return $pessoa;
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
			$boletos = Boleto::where('status','emitido')->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();

			foreach($boletos as $boleto){
				$boleto->aluno = \App\Pessoa::find($boleto->pessoa);
			}
			
			return view('relatorios.boletos_vencidos')->with('boletos',$boletos);
		}

		/**
		 * Json com pessoas, seu saldo devedor e endereços
		 * @return [json] [lista de pessoa com seu saldo devedor]
		 */
		public function relatorioDevedores(){
			//seleciona boletos de status emitidos, vencido ordenado por pessoa
			$boletos = Boleto::where('status','emitido')->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();

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

					//seleciona o id do endereço
					$endereco = \App\PessoaDadosContato::where('pessoa',$boleto->pessoa)->where('dado',6)->orderByDesc('id')->first();

					//se achou endereco
					if($endereco)
						//busca na tabela enderecos
						$pessoa->endereco =  \App\Endereco::find($endereco->valor);

					$pessoa->divida = $boleto->valor;
					// adiciona na coleção
					$devedores->push($pessoa);

				}
			}

			dd($devedores);
			
			return $devedores;
		}

		/**
		 * Transforma relatorio de devedores em Xls
		 * @return [type] [description]
		 */
		public function relatorioDevedoresXls(){

			//header para XLS
			header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'. 'relatorio' .'.xls"'); /*-- $filename is  xsl filename ---*/
	        header('Cache-Control: max-age=0');

	        //
	        $planilha =  new Spreadsheet();
        	$arquivo = new Xls($planilha);
			
	        $planilha = $planilha->getActiveSheet();
	        $planilha->setCellValue('A1', 'Nome');
	        $planilha->setCellValue('B1', 'Endereço');
	        $planilha->setCellValue('C1', 'Valor');

	        $linha = 2;
	        

			$devedores = $this->relatorioDevedores();




			foreach($devedores as $pessoa){

				$planilha->setCellValue('A'.$linha, $pessoa->nome);
		        $planilha->setCellValue('B'.$linha, $pessoa->endereco->logradouro.' '.$pessoa->endereco->numero.' '.$pessoa->endereco->complemento);
		        $planilha->setCellValue('C'.$linha, $pessoa->divida);

		        $linha++;

			}

			return $arquivo->save('php://output', 'xls');

			
		}
		

		/**
		 * Função para corrigir boletos em aberto com parcelas canceladas
		 * @return [type] [description]
		 */
		public function corrigirBoletosSemParcelas(){

			$boletos = Boleto::where('status','emitido')->where('vencimento','<',date('Y-m-d'))->orderBy('pessoa')->get();
			$erros=0;
    	
			foreach($boletos as $boleto){

				$lancamentos = Lancamento::where('boleto',$boleto->id)->where('status','cancelado')->get();

				if(count($lancamentos)>0){

					//cancelar boleto
					$boleto->status = 'cancelar';
					$boleto->save();
					$erros++;

					//cancelar todos lancamentos desse boleto
					$lancamentos_todos = Lancamento::where('boleto', $boleto->id)->get();
					foreach($lancamentos_todos as $lancamento){
						$lancamento->status = 'cancelado';
						$lancamento->save();
					}
				}

			}

			return $erros . " boletos corrigidos.";
		}

		

}
