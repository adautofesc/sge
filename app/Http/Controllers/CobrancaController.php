<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boleto;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;

class CobrancaController extends Controller
{
    /**
		 * Json com pessoas, seu saldo devedor e endereços
		 * @return [json] [lista de pessoa com seu saldo devedor]
		 */
		public function relatorioDevedores($ativos=1){


			//seleciona boletos de status emitidos, vencido ordenado por pessoa
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
                        $data_ref = \DateTime::createFromFormat('Y-m-d H:i:s',$boleto->vencimento);
						$devedor->pendencias[] = $data_ref->format('Y').' '.$lancamento->referencia. '. Matrícula '.$lancamento->matricula.' R$ '.number_format($lancamento->valor,2,',','.');
                    }
                    $devedor->boletos[] = $boleto;
					//$devedor->pendencias->push($boleto->getLancamentos());				
				}

				//se não tiver na coleção
				else{

					//criar uma nova pessoa e adiciona na coleção
					$pessoa_obj = \App\Pessoa::find($boleto->pessoa);
					$pessoa = new \stdClass;
					$pessoa->id = $boleto->pessoa;
					//$pessoa->nome = \App\Pessoa::getNome($boleto->pessoa);
					$pessoa->nome = $pessoa_obj->nome;
					$pessoa->celular = $pessoa_obj->getCelular();
					$pessoa->pendencias = array();


					//seleciona o id do endereço
					$endereco = \App\PessoaDadosContato::where('pessoa',$boleto->pessoa)->where('dado',6)->orderByDesc('id')->first();
					$cpf = \App\PessoaDadosGerais::where('pessoa',$boleto->pessoa)->where('dado',3)->first();

					if(isset($cpf->valor)==false || \App\classes\Strings::validaCPF($cpf->valor) == false){
						//die('cpf invalido');
						NotificacaoController::notificarErro($pessoa->id,1);
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
						NotificacaoController::notificarErro($pessoa->id,2);
						continue;
					}
					$lancamentos = $boleto->getLancamentos();
					foreach($lancamentos as $lancamento){
                        $data_ref = \DateTime::createFromFormat('Y-m-d H:i:s',$boleto->vencimento);
						$pessoa->pendencias[] = $data_ref->format('Y').' '.$lancamento->referencia. '. Matrícula '.$lancamento->matricula.' R$ '.number_format($lancamento->valor,2,',','.');
					}
					
					$pessoa->boletos[] = $boleto;
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
	        header('Content-Disposition: attachment;filename="'. 'cobranca' .'.xlsx"'); 
	        header('Cache-Control: max-age=0');
			
	        
	        $planilha =  new Spreadsheet();
        	$arquivo = new Xlsx($planilha);
			
	        $planilha = $planilha->getActiveSheet();
	        $planilha->setCellValue('A1', 'Nome');
	        $planilha->setCellValue('B1', 'CPF');
	        $planilha->setCellValue('C1', 'Endereço');
	        $planilha->setCellValue('D1', 'Bairro');
	        $planilha->setCellValue('E1', 'CEP');
	        $planilha->setCellValue('F1', 'Cidade');
			$planilha->setCellValue('G1', 'Celular');
	        $planilha->setCellValue('H1', 'Referência');
	        $planilha->setCellValue('I1', 'Total');

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
				$planilha->setCellValue('G'.$linha, $pessoa->celular);
		    	$planilha->setCellValue('H'.$linha, implode(";\n",$pessoa->pendencias));
		        $planilha->setCellValue('I'.$linha, 'R$ '.number_format($pessoa->divida,2,',','.'));
		     

		    	$linha++;

			}
			


			return $arquivo->save('php://output');

			
		}



		//verificar boletos em aberto.
		//Criar notificação para aqueles que estão frequentando
		//
		public function cobrancaAutomatica($inicio,$termino){
			$data_inicio = \DateTime::createFromFormat('Y-m-d',$inicio);
			$data_termino = \DateTime::createFromFormat('Y-m-d',$termino);

			
			$boletos = Boleto::where('pessoa',$id)
				 ->where('status','emitido')
				 ->whereBetween('vencimento',[$data_inicio->format('Y-m-d'),$data_termino->format('Y-m-d')])	
			 	 ->orderBy('id','desc')
				 ->get();
				 
			 foreach($boletos as $boleto){
				 
				 $boleto->getLancamentos();
				 foreach($boleto->lancamentos as $lancamento){
					 $frequencias = 0;
					 $turma = Turma::find($lancamento->turma->id);
					 $aulas = $turma->getAulasDadas();
					 foreach($aulas as $aula){
						 $presenca = Frequencias::count()->where('turma',$turma->id)->whereIn('aula',$aulas)->get();
						 $frequencias++;

					 }
					 if($frequencias>3){
						 //aluno frequentou no perios
						 //avisar que boletos estão abertos
					 }
					 else{
						 //aluno nao frequentou
					 }



				 }
			 }
			/*
			$lancamentos = Lancamento::where('pessoa',$id)->where('boleto',null)->where('status',null)->get();

			
			$dt_limite_pendencia = \Carbon\Carbon::today()->addDays(-3);
			$dt_limite_cancelamento = \Carbon\Carbon::today()->addDays(-7);

			$boleto_pendencia= $boletos->whereIn('status',['emitido','divida','aberto executado'])->where('vencimento','<',$dt_limite_pendencia->toDateString());
			$boleto_cancelar= $boletos->whereIn('status',['emitido','divida','aberto executado'])->where('vencimento','<',$dt_limite_cancelamento->toDateString());
			
			//return $boletos;
			*/
			return 'Cobranca automatica executada';
			
		}


		public function relatorioDevedoresSms($ativos=1){
			
			header('Content-Type: text/plain');
	        header('Content-Disposition: attachment;filename="'. 'cobranca-sms' .'.txt"'); /*-- $filename is  xsl filename ---*/
			header('Cache-Control: max-age=0');
			
			$CC = new ContatoController;
	        $devedores = $this->relatorioDevedores($ativos);
	        $contador=0;
	        $linha  = 'FESC - '."\n";
	        $linha .= 'ATENÇÃO. Constatamos pendências em seu cadastro. Por favor, entre em contato: 3372-1308'."\n";

	        foreach($devedores as $pessoax){
	        	$pessoa = \App\Pessoa::find($pessoax->id);
	        	$pessoa->celular = $pessoa->getCelular();
	        	if($pessoa->celular == '-')
					continue;
				else
				//$CC->enviarSMS($linha,[$pessoa->id]);
				$CC->novoContato($pessoa->id,'SMS','Alerta de pendências - boleto vencido',0);
	        	$linha .= $pessoa->celular.';'.$pessoa->nome_simples."\n";
	        	$contador++;
	        	

	        }
	        $linha .= $contador;
			

			return $linha;
			//return redirect()->back()->withErrors(['Foram enviadas '.$contador.' mensagens SMS.']);
		}
	

    public function cartas(){
		$devedores = $this->relatorioDevedores();
		if(isset($_GET['gravar_contato'])){
			$CC = new ContatoController;
			foreach($devedores as $pessoa){
				$CC->novoContato($pessoa->id,'carta','Envio de cobrança amigável',0);
			}
		}

		
		
        
        return view('financeiro.cobranca.cartas',compact('devedores'));
    }
}
