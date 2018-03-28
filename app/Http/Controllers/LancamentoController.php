<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Matricula;
use App\Boleto;
use App\Lancamento;
use Session;


class LancamentoController extends Controller
{
    //
	public function gerarLancamentos(Request $request){
		$parcela_atual = $request->parcela;
		$parcela=$request->parcela;
		// colocar um if de parcela, se for menor que 6,  fazer recursivo
		$matriculas=Matricula::where(function($query){
				$query->where('status','ativa')->orwhere('status', 'pendente');
			})	
			->where('valor','>',0)
			->where('parcelas','>=',$parcela_atual)
			->get();
		//return $matriculas;
//OBS: tem que tratar os bolsistas, tem que analizar o que ja foi pago, e o quanto falta pagar pelas parcelas restantes. Ex.: pessoa pagou 2 parcelas e na terceira quer pagar tudo o que falta.


		foreach($matriculas as $matricula){
			if($parcela>5 && $matricula->parcelas<6)
				$parcela=$parcela-7;
			//for($i=$parcela;$i<=$matricula->parcelas;$i--)
			$valor_parcela=($matricula->valor-$matricula->valor_desconto)/$matricula->parcelas;
			if(!$this->verificaSeLancada($matricula->id,$parcela)){
				$lancamento=new Lancamento;
				$lancamento->matricula=$matricula->id;
				$lancamento->parcela=$parcela;
				$lancamento->valor=$valor_parcela;
				$lancamento->pessoa = $matricula->pessoa;
				$lancamento->referencia = "Parcela ".$parcela." do curso";
				if($lancamento->valor>0)//se for bolsista integral
					$lancamento->save();
			}
		}
		//gerar os boletos.
		return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Lançamentos efetuados']);

	}
	public function gerarLancamentosPorPessoa($parcela_atual){
		if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
           // colocar um if de parcela, se for menor que 6,  fazer recursivo
           // 
          
           
		$matriculas=Matricula::where('pessoa',Session::get('pessoa_atendimento'))//pega mas matriculas ativas e pendentes da pessoa
			->where(function($query){
				$query->where('status','ativa')->orwhere('status', 'pendente');
			})	
			->where('valor','>',0)
			->where('parcelas','>=',$parcela_atual)
			->get();
		if($parcela_atual>5 && $matricula->parcelas<6)//se parcelamento < parcela atual
					$parcela_atual=$parcela_atual-7; //começa parcela novamente

		foreach($matriculas as $matricula){ //para cada matricula

			for($i=$parcela_atual;$i>0;$i--){ //gerador recursivo de parcela
				$valor_parcela=($matricula->valor-$matricula->valor_desconto)/$matricula->parcelas; //calcula valor parcela
				if(!$this->verificaSeLancada($matricula->id,$i) && $valor_parcela > 0  ){ //se não tiver ou for 0
					$lancamento=new Lancamento; //gera novo lançamento
					$lancamento->matricula=$matricula->id;
					$lancamento->parcela=$i;
					$lancamento->valor=$valor_parcela;
					$lancamento->pessoa = Session::get('pessoa_atendimento');
					if($lancamento->valor>0)//se for bolsista integral
						$lancamento->save();
				}
			}
		}
		return redirect($_SERVER['HTTP_REFERER']);

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
	public static function registrarBoletos($pessoa,$boleto){
		$matriculas=Matricula::select('id')->where('pessoa',$pessoa)->get();
        //return $matriculas;
        $lista_matriculas=array();
        foreach($matriculas as $matricula)
        {
        	$lista_matriculas[]=$matricula->id;
        }
        $lancamentos=Lancamento::whereIn('matricula',$lista_matriculas)->where('boleto',null)->get();
        foreach($lancamentos as $lancamento){
        	$lancamento->boleto = $boleto;
        	$lancamento->save();
        }

        return true;

	}

	public function verificaSeLancada($matricula,$parcela){
		$lancamentos=Lancamento::where('matricula',$matricula)
			->where('parcela',$parcela)
			->where('status', null)
			->get();
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
	public static function cancelarPorBoleto($anterior){
		$lancamentos = Lancamento::where('boleto',$anterior)
						->where('status',null)
						->get();
		//return $lancamentos;
		foreach($lancamentos as $lancamento){
			//if($lancamento->status != 'cancelado'){
				$lancamento->status = 'cancelado';
				//$lancamento->status='cancelado';
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
							//LancamentoController::relancarPorBoleto($boleto->id);

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
		$matricula_ins=Matricula::find($matricula);
		if($matricula_ins->status != 'cancelada'){
			$parcela_atual=LancamentoController::ultimaParcelaLancada($matricula);
			if( $parcela_atual <= 2){ //ultima parcela < 2
				$ultimo_lancamento = Lancamento::where('matricula',$matricula)->where('parcela',$parcela_atual)->orderBy('id','DESC')->first();
				if(count($ultimo_lancamento)>0){				
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
										$lancamentos->first()->status = 'cancelado';//cancela lancamento c/valor antigo
										//die($lancamentos);
										$lancamentos->first()->save();
										if($boleto->status == 'impresso')//verifica se vai ter que cancelar ou se ja foi cancelado
											$boleto->status = 'cancelar';//cancelar boleto impresso
										else
											$boleto->status = 'cancelado';//cancelar boleto gravado
										$boleto->save();// salva cancelamento
									}
									else{ // se tem outras matriculas vinculadas e esse boleto
										//$lancamentos = LancamentoController::listarPorBoleto($boleto->id);//coleção de lançamentos desse boleto
										foreach($lancamentos as $lancamento){ //para cadas lançamento desse boleto
												//LancamentoController::relancarlancamento($lancamento->id);
												$lancamento->status = 'cancelado'; //cancela lancamento
												
												$lancamento->save();

											
												
										}
										if($boleto->status == 'impresso')
											$boleto->status = 'cancelar';//cancelar boleto impresso
										else
											$boleto->status = 'cancelado';//cancelar boleto gravado
										$boleto->save();
									}
								}
								if($boleto->status == 'pago'){ // ele ja foi pago?
									$lancamentos=LancamentoController::listarMatriculasporBoleto($boleto->id); //listar todas matriculas vinculadas e esse boleto
									//die($lancamentos);
									if(count($lancamentos) == 1){ //só tem a matricula que vai ser cancelada
										$lancamentos->first()->status = 'reembolsar';
										$lancamentos->first()->save();
										$novo_lancamento = new Lancamento;
										$novo_lancamento->matricula = $matricula;
										$novo_lancamento->valor = ($lancamentos->first()->valor-$valor_parcela_matricula) *-1;
										$novo_lancamento->parcela = 0;
										$novo_lancamento->status = 'reembolsar';
										$novo_lancamento->save();
									}
									else{ // se tem outras matriculas vinculadas e esse boleto

										foreach($lancamentos as $lancamento){ //para cadas lançamento desse boleto
											if($lancamento->matricula == $matricula){ // se o lançamento não for da matricula
												$lancamento->status = 'reembolsar'; //cancela lancamentos
												$lancamento->save(); //salva cancelamentos
												$novo_lancamento = new Lancamento;//lancar parcela de reembolso
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
									LancamentoController::cancelarLancamentos($matricula);//
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
		}//fim se matricula não estiver cancelada
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
	public function listarPorPessoa(){

		if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        $nome = \App\Pessoa::getNome(Session::get('pessoa_atendimento'));

        $lancamentos=Lancamento::where('pessoa',Session::get('pessoa_atendimento'))->where('status', null)->orderBy('matricula','DESC')->orderBy('parcela','DESC')->paginate(30);
        //return $lancamentos;
        //return $lancamentos;
        if(count($lancamentos)>0){
	        foreach($lancamentos as $lancamento){
	        	$curso=\App\Inscricao::where('matricula',$lancamento->matricula)->first();
	        	if(isset($curso->turma->curso->nome))
	        		$lancamento->nome_curso = $curso->turma->curso->nome;
	        	$boleto=Boleto::find($lancamento->boleto);
	        	if($boleto !=null)
	        		$lancamento->boleto_status = $boleto->status;
	        	$lancamento->valor=number_format($lancamento->valor,2,',','.');
	        }
    	}
        
        return view('financeiro.lancamentos.lista-por-pessoa',compact('lancamentos'))->with('nome',$nome);

	}
	public function cancelar($id){
		$lancamento = Lancamento::find($id);
		if($lancamento != null){
			if($lancamento->boleto != 'pago'){ //só apaga lancamento se não tiver boleto gerado !!!!!!!oi? donde vc ta pegando status do boleto maluco?
				$lancamento->status = 'cancelado';
				$lancamento->save();	
			}else
			return redirect(asset("financeiro/lancamentos/listar-por-pessoa"))->withErrors(['Cancele o boleto para cancelar lancamentos']);
			


				
		}
		return redirect($_SERVER['HTTP_REFERER']);
	}

	public static function lancarDesconto($boleto,$valor){
		$lancamento=Lancamento::where('boleto',$boleto)->first();
		if($lancamento != null){
			$reembolso = new Lancamento;
			$reembolso->matricula = $lancamento->matricula;
			$reembolso->valor = $valor*-1;
			$reembolso->parcela = 0;
			$reembolso->save();
			return $reembolso->id;
		}else
			return false;
	}
	

	
	public function addPessoaLancamentos(){
		$lancamentos = Lancamento::all();
		foreach($lancamentos as $lancamento){
			$matricula = Matricula::find($lancamento->matricula);
			if($matricula != null){
				$lancamento->pessoa = $matricula->pessoa;
				$lancamento->save();
			}
		}
		return "Códigos de pessoa importados para Lançamentos";
	}
	public function devincularBoleto($lancamento){
		$lancamento = Lancamento::find($lancamento);
		if($lancamento != null){
			$lancamento->boleto = null;
			$lancamentos->save();
			return redirect($_SERVER['HTTP_REFERER']);
		}
		else
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Lançamentos não encontrado']);

	}






}
