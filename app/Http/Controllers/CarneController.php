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
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente','espera'])->where('data','>','2022-01-15')->paginate(50);
		//$matriculas = \App\Matricula::where('status','ativa')->where('obs','like','%IP%')->paginate(50);
		//dd($matriculas);
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
		$boletos = Boleto::where('status','gravado')->orderBy('pessoa')->orderBy('vencimento')->paginate(500);	
		$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();
		foreach($boletos as $boleto){
			try{
				$boleto_completo = BoletoController::gerarBoleto($boleto);
				$html->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro ao gerar Boleto');
				continue;
			}
		}

		if(!isset($_GET['page']))
			$_GET['page']=1;

		//!!!!!!!  IMPORTANTE o método gerarCarne da classe Pdf é uma implementação prória!!!!
		$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$_GET['page'].'.pdf');
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

	public function gerarCarneIndividual(int $pessoa){
		//$boletos = collect();
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente', 'espera'])->where('pessoa',$pessoa)->get();	
		if($matriculas->count()==0)
			return redirect()->back()->withErrors('Nenhuma matrícula para gerar boletos.');
			
		foreach($matriculas as $matricula){
			// limpa todos lançamentos
			$boletos_lancados = \App\Lancamento::leftjoin('boletos','lancamentos.boleto','=','boletos.id')
													->where('lancamentos.matricula',$matricula->id)
													->where('lancamentos.boleto','!=', null)
													->where('lancamentos.status', null)
													->where('boletos.id','=', null)
													->delete();
			
			
			

			//gerar todas parcelas da matricula
			$LC = new LancamentoController;
			$LC->gerarTodosLancamentos($matricula);	

			
			//lista as parcelas e se nçao tiver pula pra proxima matrícula
			$lancamentos_matricula = \App\Lancamento::where('matricula',$matricula->id)->where('status',null)->get();

			//dd($lancamentos_matricula);

			
			if($lancamentos_matricula->count() ==0)
				continue;

		



			
			 

			//****************geração dos boletos
			//lista boletos já lançados dessa matrícula
			$boletos_lancados = \App\Lancamento::leftjoin('boletos','lancamentos.boleto','=','boletos.id')
													->whereIn('boletos.status',['pago','gravado','emitido','impresso'])
													->where('lancamentos.matricula',$matricula->id)
													->where('lancamentos.status', null)
													->where('boleto','!=', null)
													->get();

			
			//calcula quantos boletos falta gerar
			$boletos_restantes = $matricula->getParcelas()-$boletos_lancados->count();
			//dd($matricula->getParcelas());
			//dd($boletos_restantes);
			//dd($boletos_lancados);

			

			//gera o numero de boletos restantes
			if($boletos_restantes > 0){
				$boletos_gravados = \App\Boleto::where('pessoa',$pessoa)->where('status','gravado')->get();
				$boletos_restantes = $boletos_restantes-$boletos_gravados->count();
				if($boletos_restantes > 0){
					
					for($i=0;$i<$boletos_restantes;$i++){
						$boleto = new \App\Boleto;
						$boleto->pessoa = $pessoa;
						$boleto->status = 'gravado';
						$boleto->valor = 0;
						if($boleto->pessoa > 0)
							$boleto->save();
						$boleto->matricula = $matricula->id;
						//$boletos->push($boleto);

					}

				}

			}


			$data_matricula = \DateTime::createFromFormat('Y-m-d', $matricula->data);			
			$inscricoes = $matricula->getinscricoes('regular,pendente,finalizada');

			//dd($inscricoes->count());

			if($inscricoes->count()>0){
				$data_ini_curso = $inscricoes->first()->turma->data_inicio;	
				$data_ini_curso = \DateTime::createFromFormat('d/m/Y', $data_ini_curso);
			}
			else{
				\App\Boleto::where('pessoa',$pessoa)->where('status','gravado')->where('valor',0)->forceDelete();
				\App\Lancamento::where('matricula',$matricula->id)->where('boleto',null)->delete();
				continue;


			}

			//dd('aqui');
				

		
			/*********************************************************** atribuição de datas nos boletos */
			$primeiro_vencimento = new \DateTime;
			//$vencimento = date('Y-m-d 23:23:59', strtotime("+5 days",strtotime(date('Y-m-d')))); 


			
			if($data_matricula>$data_ini_curso){
				
				
				//gerar boletos para pessoas que entram em cursos já iniciados ou fizeram matricula em julho
				
				if(date('d') >= $this::data_corte || $primeiro_vencimento->format('m') == 7){
				//if(date('d') >= $this::data_corte){	
					
					//$primeiro_vencimento->modify('+1 month');
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m')+1,$this::vencimento);
					

				}
				else{
					
					if(date('d') >= ($this::vencimento-$this::dias_adicionais))
						$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m'),date('d')+$this::dias_adicionais);
					else
						$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m'),$this::vencimento);
				}
			}
			
			//matricula feita antes  do início do curso e boleto sendo gerado no mes antes do primeiro vencimento
			elseif($data_ini_curso->format('m')>date('m')  || $data_ini_curso->format('Y')>date('Y')  ){ 
				
				//boleto gerado na data correta, antes do inicio do curso um mes ou mais antes
				$primeiro_vencimento->setDate($data_ini_curso->format('Y'),$data_ini_curso->format('m'),$this::vencimento);
			}
			else{
				
				//boleto gerado no mes do vencimento do primeiro boleto
				if(date('d') >= ($this::vencimento-$this::dias_adicionais))
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m'),date('d')+$this::dias_adicionais);
					
				else
					$primeiro_vencimento->setDate($data_ini_curso->format('Y'),$data_ini_curso->format('m'),$this::vencimento);
					

			}

			//dd($primeiro_vencimento);


			$boletos_gravados = \App\Boleto::where('pessoa',$pessoa)->where('status','gravado')->get();

			//dd($boletos_gravados);
			

			foreach($boletos_gravados as $boleto){
				//seleciona boleto com lancamento da matricula com vencimento no mesmo mes
				$boleto_lancamento = \App\Boleto::join('lancamentos','boletos.id','=','lancamentos.boleto')
													->whereIn('boletos.status',['pago','gravado','emitido','impresso'])
													->where('lancamentos.matricula',$matricula->id)
													->where('lancamentos.status', null)
													->whereMonth('boletos.vencimento','=', $primeiro_vencimento->format('m'))
													->whereYear('boletos.vencimento','=', $primeiro_vencimento->format('Y'))
													->get();	
				while($boleto_lancamento->count()>0){
					$primeiro_vencimento->modify('+1 month');
					$boleto_lancamento = Boleto::join('lancamentos','boletos.id','=','lancamentos.boleto')
													->whereIn('boletos.status',['pago','gravado','emitido','impresso'])
													->where('lancamentos.matricula',$matricula->id)
													->where('lancamentos.status', null)
													->whereMonth('boletos.vencimento','=', $primeiro_vencimento->format('m'))
													->whereYear('boletos.vencimento','=', $primeiro_vencimento->format('Y'))
													->get();
													

				}


				if($boleto->vencimento == '0000-00-00 00:00:00'){
					$boleto->vencimento = $primeiro_vencimento->format('Y-m-d');
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m'),$this::vencimento);
					$primeiro_vencimento->modify('+1 month');
					//$mes++;
					//$dia=10;
					//dd($boleto);
				}
				else{
					$primeiro_vencimento->modify('+1 month');
				}
			
				

				//dd($primeiro_vencimento);
				//pegar primeiro desconto da cada matrícula
				$descontos = \App\Lancamento::where('pessoa',$boleto->pessoa)
										->where('boleto',null)
										->where('valor','<',0)
										->where('status',null)
										->orderBy('parcela')
										->get();
				foreach($descontos as $desconto){
					$desconto->boleto = $boleto->id;
					$boleto->valor += $desconto->valor;
					$desconto->save();
					$boleto->save();
				}


																				
			
				/******************************atribuindo */
				//pegar primeira parcela livre de cada matricula
				$lancamento = \App\Lancamento::where('pessoa',$boleto->pessoa)
										->where('boleto',null)
										->where('valor','>',0)
										->where('status',null)
										->where('matricula',$matricula->id)
										->orderBy('parcela')
										->first();

				//dd($lancamento);
				if(!isset($lancamento->id) && $boleto->valor==0){
					$boleto->forceDelete();
					continue;
				}
				if(!isset($lancamento->id)){
					
					continue;
				}
											
				$data_util = new \App\classes\Data(\App\classes\Data::converteParaUsuario($boleto->vencimento));

				$lancamento->boleto = $boleto->id;
				$lancamento->referencia = 'Parcela de '.$data_util->Mes().' - '.$lancamento->referencia;
				$boleto->valor += $lancamento->valor;
				$lancamento->save();	
				$boleto->save();	
				
				
						
				

				
				//enquanto o boleto nao tiver valor, acrescentar parcela, senão, apagar boleto.
				while($boleto->valor <=0){
					$lancamento = \App\Lancamento::where('pessoa',$boleto->pessoa)
											->where('boleto',null)
											->where('valor','>',0)
											->where('status',null)
											->where('matricula',$matricula->id)
											->orderBy('parcela')
											->first();
					if($lancamento){
						$lancamento->boleto = $boleto->id;
						$lancamento->save();
						$boleto->valor += $lancamento->valor;	 
						$boleto->save();
					}
					
				}


				

				if($boleto->valor <= 0 || $boleto->vencimento == '0000-00-00 00:00:00'){
					\App\Lancamento::where('matricula',$matricula->id)->where('boleto',$boleto->id)->delete();
					$boleto->forceDelete();
				}
					
			}


		}//endforeach
		return redirect()->back();
		//return $boletos_gravados;

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


	/**
	 * Gerar PDF's de boletos já emitidos
	 */
	public function reimpressao(){
		$boletos = Boleto::where('status','emitido')->orderBy('pessoa')->orderBy('vencimento')->paginate(500);	
		$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();
		foreach($boletos as $boleto){
			try{
				$boleto_completo = BoletoController::gerarBoleto($boleto);
				$html->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro ao gerar Boleto');
				continue;
			}
		}

		if(!isset($_GET['page']))
			$_GET['page']=1;

		//!!!!!!!  IMPORTANTE o método gerarCarne da classe Pdf é uma implementação prória!!!!
		$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$_GET['page'].'.pdf');
		return view('financeiro.carne.fase4')->with('boletos',$boletos);


	}






}
