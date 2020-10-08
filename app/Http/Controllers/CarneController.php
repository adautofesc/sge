<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boleto;
use ZipArchive;

class CarneController extends Controller
{
	private const vencimento = 10;
	private const data_corte = 20;
	private const dias_adicionais = 5;
    /**
	 * Fase 1 - Geração de lançamentos de todas as matriculas.
	 * @return [view]
	 */
	public function carneFase1(){

		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente','espera'])->paginate(50);
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
		
			$pessoas = \App\Lancamento::select('pessoa')
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
											->where('vencimento', 'like', date('Y-'.str_pad($i,2, "0", STR_PAD_LEFT).'-'.$this::vencimento.'%'))
											->whereIn('status',['gravado','impresso','emitido','pago'])
											->get();
				if(count($boleto_existente)==0){
					$boletos[$pessoa->pessoa][$i] = 'Boleto para '.date( $this::vencimento.'/'.$i.'/Y') ;
					$boleto =new Boleto;
					$boleto->vencimento = date('Y-'.$i.'-'.$this::vencimento);
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
			$inscricoes = \App\Lancamento::where('pessoa',$boleto->pessoa)
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
			$descontos = \App\Lancamento::where('pessoa',$boleto->pessoa)
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
				$inscricao = \App\Lancamento::where('pessoa',$boleto->pessoa)
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
	/**
	 * Gerar PDF's
	 */
	public function carneFase4(){
		

		//contador
		/*
		list($usec, $sec) = explode(' ', microtime());
		$script_start = (float) $sec + (float) $usec;
		*/

		
			//$boletos = Boleto::where('status','gravado')->where('pessoa', '22610')->paginate(500);
	
			$boletos = Boleto::where('status','gravado')->orderBy('pessoa')->orderBy('vencimento')->paginate(500);

			//dd($boletos);
		
		//$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Html();
		$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();


		foreach($boletos as $boleto){
			$boleto_completo = BoletoController::gerarBoleto($boleto);
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

	/**
	 * [Fase 5 - Muda Status dos boletos para IMPRESSO]
	 * @return [type] [description]
	 */
	public function carneFase5(){
		
			//$boletos =Boleto::where('status','gravado')->orWhere('status','cancelar')->where('pessoa','22610')->paginate(500);
		
			$boletos =Boleto::where('status','gravado')->orWhere('status','cancelar')->paginate(500);
		foreach($boletos as $boleto){
			$boleto->status = 'impresso';
			$boleto->save();
		}

		return view('financeiro.carne.fase5')->with('boletos',$boletos);

	}

	/**
	 * [Fase 6 - Gerar arquivos de remessas]
	 * @return [type] [description]
	 */
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
                
				$boleto_completo = BoletoController::gerarBoleto($boleto);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,5);
				continue;
			}
			
			
			try{//tentar gerar remessa desse boleto
				$remessa->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,6);
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

	/**
	 * Fase 7 - Compactar todos arquivos gerados e retornar ela com os arquivos.
	 * @return [type] [description]
	 */
	public function carneFase7(){
		//gerar zip
		
		//dd(getcwd());
		$zip = new ZipArchive();
		$filename = 'documentos/carnes/carnes_'.date('Ymd').'.zip';
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


		return view('financeiro.carne.fase7')->with('remessas',$remessas)->with('carnes',$carnes);

    }


    /**
	 * Gerador de Carnês individual 
	 * @param  [integer] Pessoa
	 * @return [type]
	 */
	public function gerarCarneIndividual($pessoa){

		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente', 'espera'])->where('pessoa',$pessoa)->get();
		$LC = new LancamentoController;
		foreach($matriculas as $matricula){
			$LC->gerarTodosLancamentos($matricula);

		}

		$lancamentos = \App\Lancamento::where('pessoa',$pessoa)->where('status', null )->where('boleto',null)->get();
		//dd($lancamentos);


		if(count($lancamentos)>0){

			//Aqui são gerados os meses.******************************************************************** Atenção! Fase 2
			if(date('d')>$this::data_corte)
			//if(date('d')>=$this::vencimento) -> caso também for cobrar o mes do dia do vencimento
				$mes=date('m')+1;
			else
				$mes=date('m');

				/*
			if($mes == 7)
				$mes = 8;*/
			if(date('d')>=5 && date('d') <= $this::data_corte )
				$primeiro_vencimento = date('d')+$this::dias_adicionais;

			
			if($mes>=8)
				$meses = 13;
			else 
				$meses = 8;



			for($i=$mes;$i<$meses;$i++){//i = mes. trocar o 8 por $mes
				// ->where('vencimento', 'like', date('Y-'.str_pad($i,2, "0", STR_PAD_LEFT).'-'.$this::vencimento.'%'))
				//verificar se tem boletoabero
				$boleto_existente = Boleto::where('pessoa',$pessoa)								
											->whereYear('vencimento',date('Y'))
											->whereMonth('vencimento',$i)
											->whereIn('status',['gravado','impresso','emitido','pago'])
											->get();
				if(count($boleto_existente)==0){
				
					$boleto =new Boleto;
					if($i==$mes && isset($primeiro_vencimento))
						$boleto->vencimento = date('Y-'.$i.'-'.$primeiro_vencimento);
					else
						$boleto->vencimento = date('Y-'.$i.'-'.$this::vencimento);
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
				$inscricoes = \App\Lancamento::where('pessoa',$boleto->pessoa)
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
				$descontos = \App\Lancamento::where('pessoa',$boleto->pessoa)
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
					$inscricao = \App\Lancamento::where('pessoa',$boleto->pessoa)
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
    
    public function imprimirCarne($pessoa){
		$boletos = Boleto::where('pessoa',$pessoa)->whereIn('status',['emitido','gravado','impresso'])->get();
		
		//$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Html();
		$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();


		foreach($boletos as $boleto){
			if($boleto->status == 'gravado'){
				$boleto->status = 'impresso';
				$boleto->save();
			}
			$boleto_completo = BoletoController::gerarBoleto($boleto);
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



}
