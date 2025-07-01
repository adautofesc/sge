<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GeradorCarnes;
use Illuminate\Support\Facades\Mail;
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
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente','espera'])->where('data','>','2022-11-01')->paginate(50);
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
		$pessoas = Boleto::whereIn('status',['gravado','emitido','impresso'])->where('vencimento','>=',date('Y-m-d'))->groupBy('pessoa')->paginate(20);
		//dd($pessoas);
		foreach($pessoas as $pessoa){
			$html = new \Eduardokum\LaravelBoleto\Boleto\Render\Pdf();
			$boletos = Boleto::where('pessoa',$pessoa->pessoa)->whereIn('status',['gravado','emitido','impresso'])->where('vencimento','>=',date('Y-m-d'))->orderBy('pessoa')->orderBy('vencimento')->get();	
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
			$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$pessoa->pessoa.'.pdf');

			//$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_').$pessoa.'.pdf');
		}

		if(!isset($_GET['page']))
			$_GET['page']=1;

		//!!!!!!!  IMPORTANTE o método gerarCarne da classe Pdf é uma implementação prória!!!!
		return view('financeiro.carne.fase4')->with('boletos',$pessoas);


	}

	/**
	 * [Fase 5 - Muda Status dos boletos para IMPRESSO]
	 * @return [type] [description]
	 */
	public function carneFase5(){
		
			//$boletos =Boleto::where('status','gravado')->orWhere('status','cancelar')->where('pessoa','22610')->paginate(500);
		
			$boletos =Boleto::where('status','gravado')->where('vencimento','>=',date('Y-m-d'))->paginate(500);
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
		
			$boletos =Boleto::whereIn('status',['impresso','cancelar'])->where('vencimento','>=',date('Y-m-d'))->paginate(500);

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
		//Excluir todos boletos gravados e seus lançamentos
		$boletos_gravados = Boleto::where('pessoa',$pessoa)->where('status','gravado')->get();
		foreach($boletos_gravados as $boleto_gravado){
			\App\Lancamento::where('boleto',$boleto_gravado->id)->delete();
			$boleto_gravado->delete();
		}
		
		//Pegar todas matrículas ativas, em espera ou pendentes
		$matriculas = \App\Matricula::whereIn('status',['ativa','pendente', 'espera'])->where('pessoa',$pessoa)->get();	

		//Se não tiver matrícula, retorna erro.
		if($matriculas->count()==0)
			return redirect()->back()->withErrors('Nenhuma matrícula para gerar boletos.');
			
		
		
		foreach($matriculas as $matricula){

			//Verifica se a matrícula tem inscrição
					
			$inscricoes = $matricula->getinscricoes('regular,pendente,finalizada');
			if($inscricoes->count()>0){
				$data_ini_curso = $inscricoes->first()->turma->data_inicio;	
				$data_ini_curso = \DateTime::createFromFormat('d/m/Y', $data_ini_curso);
			}
			else
				continue;

			



			// limpa todos lançamentos da matrícula sem boletos e de status nulo
			$boletos_lancados = \App\Lancamento::leftjoin('boletos','lancamentos.boleto','=','boletos.id')
													->where('lancamentos.matricula',$matricula->id)
													->where('lancamentos.boleto','!=', null)
													->where('lancamentos.status', null)
													->where('boletos.id','=', null)
													->delete();
			
			
			

			//gerar todas parcelas da matricula
			$LC = new LancamentoController;
			$LC->gerarTodosLancamentos($matricula);	

			
			//lista as parcelas e se não tiver pula pra proxima matrícula
			$lancamentos_matricula = \App\Lancamento::where('matricula',$matricula->id)->where('status',null)->get();
			if($lancamentos_matricula->count() ==0)
				continue;			
			 

			//lista boletos já lançados dessa matrícula
			$boletos_lancados = \App\Lancamento::leftjoin('boletos','lancamentos.boleto','=','boletos.id')
													->whereIn('boletos.status',['pago','gravado','emitido','impresso'])
													->where('lancamentos.matricula',$matricula->id)
													->where('lancamentos.status', null)
													->where('boleto','!=', null)
													->get();

			
			//calcula quantos boletos falta gerar a partir da matricula
			$boletos_restantes = $matricula->getParcelas()-$boletos_lancados->count();
			

			//gera o numero de boletos restantes
			if($boletos_restantes > 0){
				//listar todos boletos gravados
				$boletos_gravados = \App\Boleto::where('pessoa',$pessoa)->where('status','gravado')->get();
				$boletos_restantes = $boletos_restantes-$boletos_gravados->count();
				if($boletos_restantes > 0){
					//Enquanto não tiver a quantidade certa de boletos gravados, gerar boletos
					for($i=0;$i<$boletos_restantes;$i++){
						$boleto = new \App\Boleto;
						$boleto->pessoa = $pessoa;
						$boleto->status = 'gravado';
						$boleto->valor = 0;
						if($boleto->pessoa > 0)
							$boleto->save();
						$boleto->matricula = $matricula->id;
					}

				}

			}
		
			/************* atribuição de datas nos boletos */
			$primeiro_vencimento = new \DateTime;
			$data_matricula = \DateTime::createFromFormat('Y-m-d', $matricula->data);	
			


			//se a matricula for feita depois do inicio do curso
			if($data_matricula>$data_ini_curso){
			
				if(date('d') >= $this::data_corte && $primeiro_vencimento->format('m') == 6){
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),'08',$this::vencimento);

				//gerar boletos para pessoas que entram em cursos já iniciados ou fizeram matricula em julho
				}
				elseif(date('d') >= $this::data_corte || $primeiro_vencimento->format('m') == 7){
				//if(date('d') >= $this::data_corte){	
					
					//$primeiro_vencimento->modify('+1 month');
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m')+1,$this::vencimento);
				}
				else{
					
					if(date('d') >= ($this::vencimento-$this::dias_adicionais)){
						//aqui não
						$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m'),date('d'));
						$primeiro_vencimento->modify('+'.$this::dias_adicionais.' days');
					}
					else{
						//não aqui
						$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m'),$this::vencimento);
					}
				}
			}
			//matricula feita antes do inicio do curso
			//senão se mes de inicio do curso for maior que mes atual ou ano de inicio maior que o atual
			elseif($data_ini_curso->format('m')>=date('m')  || $data_ini_curso->format('Y')>date('Y')  ){ 
				
				//Curso inicia no meio do ano
				if($data_ini_curso->format('m')==7 || $data_ini_curso->format('m')==8 )
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),'08',$this::vencimento);
				else
					$primeiro_vencimento->setDate($data_ini_curso->format('Y'),'03',$this::vencimento);
			}
			else{
				
				//boleto gerado no mes do vencimento do primeiro boleto
				if(date('d') >= ($this::vencimento-$this::dias_adicionais)){
					//aquiiii
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m'),date('d'));
					$primeiro_vencimento->modify('+'.$this::dias_adicionais.' days');
					//dd($primeiro_vencimento);
				}
					
					
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
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m')+1,$this::vencimento);
					//$primeiro_vencimento->modify('+1 month');
					$boleto_lancamento = Boleto::join('lancamentos','boletos.id','=','lancamentos.boleto')
													->whereIn('boletos.status',['pago','gravado','emitido','impresso'])
													->where('lancamentos.matricula',$matricula->id)
													->where('lancamentos.status', null)
													->whereMonth('boletos.vencimento','=', $primeiro_vencimento->format('m'))
													->whereYear('boletos.vencimento','=', $primeiro_vencimento->format('Y'))
													->get();
													

				}
													
				//dd($primeiro_vencimento);
				//dd($boleto->vencimento=='0000-00-00 00:00:00'?'yes':'no');


				if($boleto->vencimento == '0000-00-00 00:00:00'){
					$boleto->vencimento = $primeiro_vencimento->format('Y-m-d');
					$primeiro_vencimento->setDate($primeiro_vencimento->format('Y'),$primeiro_vencimento->format('m'),$this::vencimento);
					$primeiro_vencimento->modify('+1 month');
					//$mes++;
					//$dia=10;
					//dd($boleto);
				}
				else{
					//dd($boleto);
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





	   
    /**
	 * Impressão individual
	 *
	 * @param [type] $pessoa
	 * @return void
	 */
    public function imprimirCarne($pessoa){
		//dd('teste');
		$boletos = Boleto::where('pessoa',$pessoa)->whereIn('status',['emitido','gravado','impresso','pelosite'])->get();
		
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
		$boletos = Boleto::where('status','emitido')->orwhere('status','impresso')->orderBy('pessoa')->orderBy('vencimento')->paginate(200);	
		
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


	public function gerarPDF(int $pessoa){
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
			$html->addBoleto($boleto_completo);
		}
		//$html->hideInstrucoes();
		//$html->showPrint();
		
		//return $html->gerarCarne();
		//dd(getcwd());
		if(!isset($_GET['page']))
			$_GET['page']=1;

		$html->gerarCarne($dest = $html::OUTPUT_SAVE, $save_path = 'documentos/carnes/'.date('Y-m-d_P').$pessoa.'.pdf');
		return true;
		

	}
	public function gerarBG(){
		$pessoas = \App\Matricula::where('status','espera')->groupBy('pessoa')->pluck('pessoa')->toArray();  
		
		foreach($pessoas as $pessoa){
			$this->dispatch(new \App\Jobs\GeradorCarnes($pessoa));
			$msg[] =  'Solicitando geração dos boletos para pessoa '.$pessoa;
		}
		/*
		Mail::send('emails.comunicado',['nome'=>'Adauto','mensagem' =>'Gostaría de avisar que os boletos foram gerados como esperado.'], function ($message){
			$message->from('no-reply@fesc.saocarlos.sp.gov.br', 'Assistente SGE');
			$message->to('adauto.oliveira@fesc.saocarlos.sp.gov.br');
			$message->subject('Boletos gerados.');
			});*/

		return view('financeiro.carne.gerador')->with('msg',$msg);
	}

	public function geradorSegundoPlano($pessoa){
		
        echo 'Boleto da pessoa '.$pessoa."ok";
        $this->gerarCarneIndividual($pessoa);
        
		/*
		Mail::send('emails.comunicado',['nome'=>'Adauto','mensagem' =>'Gostaría de avisar que os boletos foram gerados como esperado.'], function ($message) use($user){
			$message->from('no-reply@fesc.saocarlos.sp.gov.br', 'Assistente SGE');
			$message->to('adauto.oliveira@fesc.saocarlos.sp.gov.br');
			$message->subject('Boletos gerados.');
			});*/
			
		
	}






}
