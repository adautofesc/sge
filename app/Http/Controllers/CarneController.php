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
		$pessoas = array();
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente','espera'])->paginate(50);
		foreach($matriculas as $matricula){
			if(!in_array($matricula->pessoa,$pessoas))
				array_push($pessoas,$matricula->pessoa);
		}
		foreach($pessoas as $pessoa){
			$boletos = $this->gerarCarneIndividual($pessoa);
		}
				
		return view('financeiro.carne.fase1')->with('matriculas',$matriculas);

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

			try{
				$boleto_completo = BoletoController::gerarBoleto($boleto);
				//$boleto->status = 'impresso';
				//$boleto->save();
				$html->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro ao gerar Boleto');
				continue;
			}
		}
			
		//$html->hideInstrucoes();
		//$html->showPrint();
		
		//return $html->gerarCarne();
		//dd(getcwd());
		if(!isset($_GET['page']))
			$_GET['page']=1;


		//################################################################################################################
		//################################################################################################################
		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!  IMPORTANTE o método gerarCarne da classe Pdf é uma implementação prória!!!!
		
		//$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$_GET['page'].'.pdf');
		$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$_GET['page'].'.pdf');
		//**************************************************************************************************************** */

			
		

		/*finaliza contador
		
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
			return redirect()->back()->withErrors(['Nenhum boleto encontrado']);


		foreach($boletos as $boleto){
            try{ //tentar gerar boleto completo
                
				$boleto_completo = BoletoController::gerarBoleto($boleto);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro na geração do boleto no processo de geração da remessa do carne');
				continue;
			}
			
			
			try{//tentar gerar remessa desse boleto
				$remessa->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro na geração da remessa do carne');
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
	public function gerarCarneIndividual(int $pessoa){
		$num_boletos = 0;
		$data_matricula = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
		$data_ini_curso = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
		
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente', 'espera'])->where('pessoa',$pessoa)->get();
		
		if($matriculas->count()==0)
			return redirect()->back();
		$LC = new LancamentoController;
		
		foreach($matriculas as $matricula){
			$inscricoes = \App\Inscricao::where('matricula',$matricula->id)->whereIn('status',['regular','pendente'])->get();
			if($inscricoes->count()==0)
				continue;

			
			$LC->gerarTodosLancamentos($matricula);
			if($matricula->getParcelas()>$num_boletos)
				$num_boletos = $matricula->getParcelas();
			
			$data_matricula = \DateTime::createFromFormat('Y-m-d', $matricula->data);
			
			$data_ini_curso = $inscricoes->first()->turma->data_inicio;	
			$data_ini_curso = \DateTime::createFromFormat('d/m/Y', $data_ini_curso);
				
			
		

		}

		
		$lancamentos = \App\Lancamento::where('pessoa',$pessoa)->where('status', null )->where('boleto',null)->get();
		if($lancamentos->count()>0){
			
		
			
			//se o mes que esse boleto esta sendo gerado dor maior duqe a data de inicio
			if($data_ini_curso->format('m')<=$data_matricula->format('m') && $data_ini_curso->format('Y') == $data_matricula->format('Y')){

			//Aqui se verifica se o boleto é para o mes corrente ou não
				if($data_matricula->format('d') >= $this::data_corte )	
					$mes=$data_ini_curso->format('m')+1;
				else{
					$mes=$data_ini_curso->format('m');
					if($data_matricula->format('d') >= ($this::vencimento-$this::dias_adicionais))
						$primeiro_vencimento = $data_matricula->format('d')+$this::dias_adicionais;
				}

			}
			else{
				$mes = $data_ini_curso->format('m');
		

			}

			for($i=1;$i<=$num_boletos;$i++){

				$boleto_existente = Boleto::where('pessoa',$pessoa)								
											->whereYear('vencimento',date('Y'))
											->whereMonth('vencimento',$mes)
											->whereIn('status',['gravado','impresso','emitido','pago'])
											->get();


				if($boleto_existente->count()==0){


				
					$boleto =new Boleto;
					if($i==1 && isset($primeiro_vencimento))
						$boleto->vencimento = date('Y-'.$mes.'-'.$primeiro_vencimento);
					else
						$boleto->vencimento = date('Y-'.$mes.'-'.$this::vencimento);
					$boleto->pessoa = $pessoa;
					$boleto->status = 'gravado';
					$boleto->valor = 0;
					if($boleto->pessoa > 0)
						$boleto->save();
				}//endif
				$mes++;
			}//endfor

			//************************************************************************************************ fase 3
			$boletos = Boleto::where('status','gravado')

								->where('pessoa',$pessoa)
								->orderBy('vencimento')
								->get();

			foreach($boletos as $boleto){

				//pegar primeira parcela livre de cada matricula
				$lancamentos = \App\Lancamento::where('pessoa',$boleto->pessoa)
										->where('boleto',null)
										->where('valor','>',0)
										->where('status',null)
										->orderBy('parcela')
										->groupBy('matricula')->get();

				$data_util = new \App\classes\Data(\App\classes\Data::converteParaUsuario($boleto->vencimento));

				foreach($lancamentos as $lancamento){
					$lancamento->boleto = $boleto->id;
					$lancamento->referencia = 'Parcela de '.$data_util->Mes().' - '.$lancamento->referencia;
					$boleto->valor = $boleto->valor+$lancamento->valor;
					$lancamento->save();	
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
					$lancamento = \App\Lancamento::where('pessoa',$boleto->pessoa)
											->where('boleto',null)
											->where('valor','>',0)
											->where('status',null)
											->orderBy('parcela')
											->first();
					if($lancamento){
						$lancamento->boleto = $boleto->id;
						$lancamento->save();	
						$boleto->valor = $boleto->valor+$lancamento->valor;	
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
		//dd('teste');
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
