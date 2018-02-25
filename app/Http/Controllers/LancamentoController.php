<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Matricula;
use App\Boleto;
use App\Lancamento;


class LancamentoController extends Controller
{
    //
	public function gerarLancamentos($parcela){
		$matriculas=Matricula::where('status','ativa')->orWhere('status','pendente')->where('valor','>',0)->where('parcelas','>=',$parcela)->get();

//OBS: tem que tratar os bolsistas, tem que analizar o que ja foi pago, e o quanto falta pagar pelas parcelas restantes. Ex.: pessoa pagou 2 parcelas e na terceira quer pagar tudo o que falta.


		foreach($matriculas as $matricula){
			if(!$this->verificaSeLancada($matricula->id,$parcela,$matricula->valor)){
				$lancamento=new Lancamento;
				$lancamento->matricula=$matricula->id;
				$lancamento->parcela=$parcela;
				$lancamento->valor=($matricula->valor-$matricula->valor_desconto)/$matricula->parcelas;
				if($lancamento->valor>0)//se for bolsista integral
					$lancamento->save();
			}
		}
		//gerar os boletos.
		return "lancamentos efetuados com sucesso";

	}
	public static function atualizaLancamentos($boleto,$novo_boleto){
		$lancamentos=Lancamento::where('boleto',$boleto)
								->where('lancamentos.status', null)
								->get();

		foreach($lancamentos as $lancamento){
			$lancamento->boleto=$boleto;
			$lancamento->save();
		}
		return $lancamentos;
	}

	public function verificaSeLancada($matricula,$parcela,$valor){
		$lancamentos=Lancamento::where('matricula',$matricula)->where('parcela',$parcela)->where('valor',$valor)->get();
		if (count($lancamentos)>0)
			return true;
		else
			return false;
	}
	public static function listarPorMatricula($matricula){
		$lancamentos=Lancamento::where('matricula',$matricula)->get();
		return $lancamentos;
	}
	/**
	 * Retorna qual foi a ultima parcela lançada. Serve para decidir se os boletos gerados anteriormente 
	 * serão cancelados ou não em um cancelamento de matrícula
	 * @param  Integer $matricula
	 * @return Integer $valor 
	 */
	public static function ultimaParcelaLancada($matricula){
		$parcela=\DB::table('lancamentos')->where('matricula',$matricula)->max('parcela');
		return $parcela;
	}
	public static function listarPorBoleto($boleto){
		$lancamentos=Lancamento::where('boleto',$boleto)->get();
		return $lancamentos;
	}
	/**
	 * Retorna lista com codigo dos boletos em aberto na lista de lançamentos
	 * @param  [type] $matricula [description]
	 * @return [type]            [description]
	 */
	public static function retornarBoletos($matricula){
		$lancamentos=Lancamento::distinct('boleto')->where('matricula',$matricula)->where('lancamentos.status', null)->where('boleto','<>',null)->get();
		return $lancamentos;
	}
	public static function listarMatriculasporBoleto($boleto){
		$matriculas=Lancamento::distinct('matricula')->where('boleto',$boleto)->where('lancamentos.status', null)->get();
		return $matriculas;
	}


	public static function relancar($matricula_id,$parcela,$valor){
		$matricula=Matricula::find($matricula_id);
		return $matricula;
		if (($matricula->valor - $matricula->valor_desconto) != 0){
			$lancamento = new Lancamento;
			$lancamento->matricula = $matricula;
			$lancamento->parcela = $parcela;
			$lancamento->valor = $valor;
			$lancamento->save();
			return $lancamento->id;
		}
		else
			return "0";
	}
	public static function relancarPorBoleto($anterior){
		$lancamentos = Lancamento::where('boleto',$anterior)
						->where('status',null)
						->get();
		//return $lancamentos;
		foreach($lancamentos as $lancamento){
				$novo_lancamento = new Lancamento;
				$novo_lancamento->matricula = $lancamento->matricula;
				$novo_lancamento->parcela = $lancamento->parcela;
				$novo_lancamento->valor = $lancamento->valor;
				$novo_lancamento->save();
				$lancamento->status='cancelado';
				$lancamento->save();
			
		}
	}
	public static function relancarLancamento($id){
		$lancamento = Lancamento :: find($id);
		$novo_lancamento = new  Lancamento;
		$novo_lancamento = $lancamento;
		$novo_lancamento->boleto = null;
		$novo_lancamento->save();
		return $novo_lancamento;

	}
	public static function cancelarLancamentos($matricula){
		$lancamentos=Lancamento::where('matricula',$matricula)->get();
		foreach($lancamentos as $lancamento){
			$lancamento->status='cancelado';
			$lancamento->save();
			;
		}
	}



	public static function cancelamentoMatricula($matricula){
		if(LancamentoController::ultimaParcelaLancada($matricula) <= 2){ //ultima parcela <2
			$l_boletos=LancamentoController::retornarBoletos($matricula); //selecionas todos boletos dessa matricula com boleto em aberto
			if(count($l_boletos)>0){ // se tiver boletos
				foreach($l_boletos as $boleto_id){ //para cada um dos boletos
					$boleto=Boleto::find($boleto_id->boleto); //instancia boleto
					if($boleto->status == 'impresso' || $boleto->status == 'gravado'){	// ele ja foi impresso/entregue?	
						$lancamentos=LancamentoController::listarMatriculasporBoleto($boleto->id); //listar todas matriculas vinculadas e esse boleto
						//die($lancamentos);
						if(count($lancamentos) == 1){ //só tem a matricula que vai ser cancelada
							$lancamentos->first()->status = 'cancelado';
							//die($lancamentos);
							$lancamentos->first()->save();
							if($boleto->status == 'impresso')
								$boleto->status = 'cancelar';//cancelar boleto impresso
							else
								$boleto->status = 'cancelado';//cancelar boleto gravado
							$boleto->save();// salva cancelamento
						}
						else{ // se tem outras matriculas vinculadas e esse boleto
							//$lancamentos = LancamentoController::listarPorBoleto($boleto->id);//coleção de lançamentos desse boleto
							foreach($lancamentos as $lancamento){ //para cadas lançamento desse boleto

								if($lancamento->matricula == $matricula){ // se o lançamento não for da matricula
									//LancamentoController::relancarlancamento($lancamento->id);
									$lancamento->status = 'cancelado'; //cancela lancamento
									if($boleto->status == 'impresso')
										$boleto->status = 'cancelar';//cancelar boleto impresso
									else
										$boleto->status = 'cancelado';//cancelar boleto gravado
									$lancamento->save();	
								}		
							}
							$boleto->status = 'cancelar';
							$boleto->save();
							//relança boleto com os lancamentos em aberto
							//$novo_boleto = BoletoController::relancarBoleto($boleto->id);
							//refaz os lancamentos caso valor do boleto seja maior que 0, senao atribui cancelado ao lancamento 
							LancamentoController::relancarPorBoleto($boleto->id);

						}
					}
					if($boleto->status == 'pago'){ // ele ja foi pago?
						$lancamentos=LancamentoController::listarMatriculasporBoleto($boleto->id); //listar todas matriculas vinculadas e esse boleto
						//die($lancamentos);
						if(count($lancamentos) == 1){ //só tem a matricula que vai ser cancelada
							$lancamentos->first()->status = 'cancelado';
							$lancamentos->first()->save();
							$novo_lancamento = new Lancamento;
							$novo_lancamento->matricula = $matricula;
							$novo_lancamento->valor = $lancamentos->first()->valor *-1;
							$novo_lancamento->parcela = 0;
							$novo_lancamento->status = 'reembolsar';
							$novo_lancamento->save();
						}
						else{ // se tem outras matriculas vinculadas e esse boleto
							//$lancamentos = LancamentoController::listarPorBoleto($boleto->id);//coleção de lançamentos desse boleto
							foreach($lancamentos as $lancamento){ //para cadas lançamento desse boleto

								if($lancamento->matricula == $matricula){ // se o lançamento não for da matricula
									
									$lancamento->status = 'cancelado'; //cancela lancamento
									$lancamento->save();
									$novo_lancamento = new Lancamento;
									$novo_lancamento->matricula = $matricula;
									$novo_lancamento->valor = $lancamento->valor *-1;
									$novo_lancamento->parcela = 0;
									$novo_lancamento->status = 'reembolsar';
									$novo_lancamento->save();

								}		
							}
							//relança boleto com os lancamentos em aberto
							//$novo_boleto = BoletoController::relancarBoleto($boleto->id);
							//refaz os lancamentos caso valor do boleto seja maior que 0, senao atribui cancelado ao lancamento 
							//LancamentoController::relancarPorBoleto($boleto->id);

						}
					}
					if($boleto->status == 'cancelar' || $boleto->status == 'cancelado'){
						LancamentoController::cancelarLancamentos($matricula);
					}




				}

			}
			else{
				LancamentoController::cancelarLancamentos($matricula);
			}
	

		}
	}
	public static function atualizaMatricula($matricula){
		$parcela_atual=LancamentoController::ultimaParcelaLancada($matricula);
		if( $parcela_atual <= 2){ //ultima parcela < 2
			$ultimo_lancamento = Lancamento::where('matricula',$matricula)->where('parcela',$parcela_atual)->orderBy('id','DESC')->first();
			if(count($ultimo_lancamento)>0){
				$matricula_ins=Matricula::find($matricula);
				$valor_parcela_matricula = ($matricula_ins->valor-$matricula_ins->valor_desconto)/$matricula_ins->parcelas;
				//verificar se o valor da parcela é diferente do valor da matricula
				if( $valor_parcela_matricula  != $ultimo_lancamento->valor){
					/**
					 * ***********************************************************************************
					 */

					$l_boletos=LancamentoController::retornarBoletos($matricula); //selecionas todos boletos dessa matricula com boleto em aberto
					//return $l_boletos;
					if(count($l_boletos)>0){ // se tiver boletos
						foreach($l_boletos as $boleto_id){ //para cada um dos boletos
							$boleto=Boleto::find($boleto_id->boleto); //instancia boleto
							//die($boleto);
							if($boleto->status == 'impresso' || $boleto->status == 'gravado'){	// ele ja foi impresso/entregue?	
								$lancamentos=LancamentoController::listarMatriculasporBoleto($boleto->id); //listar todas matriculas vinculadas e esse boleto
								//die($lancamentos);
								if(count($lancamentos) == 1){ //só tem a matricula que vai ser cancelada
									$lancamentos->first()->status = 'cancelado';
									//die($lancamentos);
									$lancamentos->first()->save();
									if($boleto->status == 'impresso')
										$boleto->status = 'cancelar';//cancelar boleto impresso
									else
										$boleto->status = 'cancelado';//cancelar boleto gravado
									$boleto->save();// salva cancelamento

									$novo_lancamento = new Lancamento;
									$novo_lancamento->matricula = $lancamentos->first()->matricula;
									$novo_lancamento->valor = $valor_parcela_matricula;
									$novo_lancamento->parcela = $lancamentos->first()->parcela;
									$novo_lancamento->save();

								}
								else{ // se tem outras matriculas vinculadas e esse boleto
									//$lancamentos = LancamentoController::listarPorBoleto($boleto->id);//coleção de lançamentos desse boleto
									foreach($lancamentos as $lancamento){ //para cadas lançamento desse boleto

										if($lancamento->matricula == $matricula){ // se o lançamento  for da matricula
											//LancamentoController::relancarlancamento($lancamento->id);
											$lancamento->status = 'cancelado'; //cancela lancamento
											if($boleto->status == 'impresso')
												$boleto->status = 'cancelar';//cancelar boleto impresso
											else
												$boleto->status = 'cancelado';//cancelar boleto gravado
											$lancamento->save();	
										}		
									}
									$boleto->status = 'cancelar';
									$boleto->save();

									//relança boleto com os lancamentos em aberto
									//$novo_boleto = BoletoController::relancarBoleto($boleto->id);
									//refaz os lancamentos caso valor do boleto seja maior que 0, senao atribui cancelado ao lancamento 
									LancamentoController::relancarPorBoleto($boleto->id);

								}
							}
							if($boleto->status == 'pago'){ // ele ja foi pago?
								$lancamentos=LancamentoController::listarMatriculasporBoleto($boleto->id); //listar todas matriculas vinculadas e esse boleto
								//die($lancamentos);
								if(count($lancamentos) == 1){ //só tem a matricula que vai ser cancelada
									$lancamentos->first()->status = 'cancelado';
									$lancamentos->first()->save();
									$novo_lancamento = new Lancamento;
									$novo_lancamento->matricula = $matricula;
									$novo_lancamento->valor = ($lancamentos->first()->valor-$valor_parcela_matricula) *-1;
									$novo_lancamento->parcela = 0;
									$novo_lancamento->status = 'reembolsar';
									$novo_lancamento->save();
								}
								else{ // se tem outras matriculas vinculadas e esse boleto
									//$lancamentos = LancamentoController::listarPorBoleto($boleto->id);//coleção de lançamentos desse boleto
									foreach($lancamentos as $lancamento){ //para cadas lançamento desse boleto

										if($lancamento->matricula == $matricula){ // se o lançamento não for da matricula
											
											$lancamento->status = 'cancelado'; //cancela lancamento
											$lancamento->save();
											$novo_lancamento = new Lancamento;
											$novo_lancamento->matricula = $matricula;
											$novo_lancamento->valor = ($lancamento->valor-$valor_parcela_matricula)*-1;
											$novo_lancamento->parcela = 0;
											$novo_lancamento->status = 'reembolsar';
											$novo_lancamento->save();

										}		
									}
									//relança boleto com os lancamentos em aberto
									//$novo_boleto = BoletoController::relancarBoleto($boleto->id);
									//refaz os lancamentos caso valor do boleto seja maior que 0, senao atribui cancelado ao lancamento 
									//LancamentoController::relancarPorBoleto($boleto->id);

								}
							}
							if($boleto->status == 'cancelar' || $boleto->status == 'cancelado'){
								LancamentoController::cancelarLancamentos($matricula);
							}


						}//end foreach boleto

					}//end if se tem boleto
					else{//não tem boleto lançado.
						$lancamentos = Lancamento::where('matricula',$matricula)->get();//seleciona os lancamentos
						foreach($lancamentos as $lancamento){ //para cada lancamento
							if($lancamento->parcela>0){//se a parcela nao for de diferenca (=0)
								$lancamento->valor= $valor_parcela_matricula;//atualiza valor parcela
								$lancamento->save(); //salvar
							}

						}
						
						return "não tem boletos";
							
					}	
				}
				else{ // o valor da matricula é igual ao da ultima parcela. 
					return "valor igual";
				}
			}// end if se o lancamento for >0
			return "Nao tem lancamentos";
		}//end if se tem lancamentos
	}//end metodo

	/**
	 * Cancelar Lancamentos de Matriculas Canceladas (antes do metodo de cancelar lancamentos)]
	 * @return [type] [description]
	 */
	public function cancelarLMC(){
		$alteradas=array();
		$matriculas=Matricula::where('status','cancelada')->get();
		//return $matriculas;
		foreach($matriculas as $matricula){
			$this->cancelamentoMatricula($matricula->id);
			$alteradas[] = $matricula->id;
		}
		return $alteradas;


	}
	public function atualizarLMC(){
		$alteradas=array();
		$matriculas=Matricula::where('status','ativa')->orWhere('status','pendente')->get();
		//return $matriculas;
		foreach($matriculas as $matricula){
			$this->atualizaMatricula($matricula->id);
			$alteradas[] = $matricula->id;
		}
		return $alteradas;


	}




}
