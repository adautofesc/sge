<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Matricula;
use App\Boleto;
use App\Lancamento;
use ValorController;
use Session;

ini_set('max_execution_time', 300);


class LancamentoController extends Controller
{
    const MES_PARCELA_PRIMEIRO_SEMESTRE = 2-1;
    const MES_PARCELA_SEGUNDO_SEMESTRE = 8-1;
    
	public function gerarLancamentos(Request $request){

		//dd($request->parcela);
		$this->validate($request,
			[
				'parcela' => 'min:1'
			]

		);
		


		if($request->parcela < 0 || !is_numeric($request->parcela))
			die('Erro. Parcela inválida: '.$request->parcela );


		
		$referencia= '01/'.($request->parcela+1).'/'.date('Y');
		$data_util = new \App\classes\Data($referencia);
		$parcelas = array();



		$parcela_atual = $request->parcela;
		$parcela=$request->parcela;
		// colocar um if de parcela, se for menor que 6,  fazer recursivo
		$matriculas=Matricula::whereIn('status',['ativa','pendente'])	
			->paginate(50);
		//dd(count($matriculas)); //ver a matricula
		//return $matriculas;
//OBS: tem que tratar os bolsistas, tem que analizar o que ja foi pago, e o quanto falta pagar pelas parcelas restantes. Ex.: pessoa pagou 2 parcelas e na terceira quer pagar tudo o que falta.

		
		foreach($matriculas as $matricula){

			$pessoa = \App\Pessoa::find($matricula->pessoa);
			
			$pessoa = PessoaController::formataParaMostrar($pessoa);
			if(!isset($pessoa->cpf)){
				NotificacaoController::notificarErro($pessoa->id,1);
				continue;

			} 
			if(!isset($pessoa->end_id)){
				NotificacaoController::notificarErro($pessoa->id,2);
				continue;

			}



			//verifica se matricula é primeiro ou segundo semenstre e lança a parcela.
			if($parcela_atual>5 && $matricula->valor->parcelas<6)
				$parcela=$parcela_atual-6;
			else
				$parcela = $parcela_atual;



			if($parcela <= $matricula->valor->parcelas){
				
				//for($i=$parcela;$i<=$matricula->parcelas;$i--)
				$valor_parcela=($matricula->valor->valor-$matricula->valor_desconto)/$matricula->valor->parcelas;
				

				if(!$this->verificaSeLancada($matricula->id,$parcela)){
					//$parcelas[$matricula->id] = $parcela;

					$lancamento=new Lancamento;
					$lancamento->matricula=$matricula->id;
					$lancamento->parcela=$parcela;
					$lancamento->valor=$valor_parcela;
					$lancamento->pessoa = $matricula->pessoa;
					$lancamento->referencia = "Parcela de ".$data_util->Mes().' - '.$matricula->getNomeCurso();
					if($lancamento->valor>0)//se for bolsista integral
						$lancamento->save();
					
				}
				
			}


			

			

				
		}
		//return $parcelas;

		return view('financeiro.lancamentos.processando')->with('matriculas',$matriculas);

	}
	

	
	public function gerarTodosLancamentos(\App\Matricula $matricula){
		//dd($matricula->valor);
		if($matricula->valor->valor>0){
			//dd($matricula->valor->parcelas);
			for($i=1;$i<=$matricula->getParcelas();$i++){
				$this->gerarIndividual19($matricula->pessoa, $i,$matricula->id,($matricula->valor->valor-$matricula->valor_desconto)/$matricula->getParcelas());

			}
		}
		
	}

	public function gerarLancamentosMatricula(\App\Matricula $matricula){
		/*
		// quantas parcelas tenho que gerar SEM RETROATIVAS
		//relacionar parcela com os meses.
		// pegar todas parcelas já geradas
		$data = $matricula->turma->getParcelas();
		for($i=1;$i<=$data;$i++){
			if($i==1)
				$parcela[$i] = 10/$matricula->turma->data_inicio('m')/year;
			else
				$parcela[$i] = $parcela[$i-1] + 1mes;
		}
		//$parcela[1] = 02/2022;
		//$parcela[2] = 03/2022;
*/
	}

	public function gerarIndividual19($pessoa,$parcela,$matricula,$valor){
		if(!$this->verificaSeLancada($matricula,$parcela,$valor)){
			$matricula = Matricula::find($matricula);
			$lancamento = new Lancamento; //gera novo lançamento
			$lancamento->matricula=$matricula->id;
			$lancamento->parcela=$parcela;
			$lancamento->valor=$valor;
			$lancamento->pessoa = $pessoa;
			$lancamento->referencia = $matricula->getNomeCurso();
			if($lancamento->valor>0)
				$lancamento->save();
		}
	}

	public function verificaSeLancada19($pessoa,$parcela,$matricula,$valor){
		$lancamentos=Lancamento::where('matricula',$matricula)
			->where('parcela',$parcela)
			->where('status', null)
			->get();

		if ($lancamentos->count()>0){
			foreach($lancamentos as $lancamento){
				if($lancamento->valor == $valor)
					return true;
				else{
					$lancamento->delete();
					return false;
				}
			}

			return true;
		}
		else
			return false;

	}

	public function gerarLancamentosPorPessoa($pessoa){
	
           // colocar um if de parcela, se for menor que 6,  fazer recursivo
           // 

         //! se dia for >=20  parcela atual = m senão   
		if(date('d')>=20)
			$parcela_atual = date('m');
		else
		 	$parcela_atual = date('m')-1;

		$matriculas=Matricula::where('pessoa',$pessoa)//pega mas matriculas ativas e pendentes da pessoa
			->where(function($query){
				$query->where('status','ativa')->orwhere('status', 'pendente');
			})	
			->get();
		



		foreach($matriculas as $matricula){ //para cada matricula


			$pessoa = \App\Pessoa::find($matricula->pessoa);
			
			$pessoa = PessoaController::formataParaMostrar($pessoa);
			if(!isset($pessoa->cpf)){
				NotificacaoController::notificarErro($pessoa->id,1);
				continue;

			} 
			if(!isset($pessoa->end_id)){
				NotificacaoController::notificarErro($pessoa->id,2);
				continue;

			}

			/*
			if($parcela_atual>5 && $matricula->valor->parcelas<6)//se parcelamento < parcela atual
					$parcela_atual=$parcela_atual-6; //começa parcela novamente
			*/

			if($parcela_atual <= $matricula->valor->parcelas){

				for($i=$parcela_atual;$i>0;$i--){ //gerador recursivo de parcela

					$referencia= '01/'.($i+1).'/'.date('Y');
					$referencia = new \App\classes\Data($referencia);


					$valor_parcela=($matricula->valor->valor-$matricula->valor_desconto)/$matricula->valor->parcelas; //calcula valor parcela
					if(!$this->verificaSeLancada($matricula->id,$i) && $valor_parcela > 0  ){ //se não tiver ou for 0
						$lancamento=new Lancamento; //gera novo lançamento
						$lancamento->matricula=$matricula->id;
						$lancamento->parcela=$i;
						$lancamento->valor=$valor_parcela;
						$lancamento->pessoa = $pessoa;
						$lancamento->referencia = "Parcela de ".$referencia->Mes().' - '.$matricula->getNomeCurso();
						if($lancamento->valor>0)//se for bolsista integral
							$lancamento->save();
					}
				}
			}
		}
		return redirect()->back();

	}
	public static function atualizaLancamentos($boleto,$novo_boleto){
		$lancamentos=Lancamento::where('boleto',$boleto)
								->where('lancamentos.status', null)
								->get();

		foreach($lancamentos as $lancamento){
			$lancamento->boleto=$novo_boleto;
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
		if($matricula == '' || $matricula == null || $parcela==0)
			return false;
		$lancamentos=Lancamento::where('matricula',$matricula)
			->where('parcela',$parcela)
			->where('status', null)
			->get();
		if ($lancamentos->count()>0)
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

	/*
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
	}*/
	public function relancarParcela($parcela){
		$anterior = Lancamento::find($parcela);
		if(!$this->verificaSeLancada($anterior->matricula,$anterior->parcela)){	
			$lancamento = new Lancamento;
			$lancamento->matricula = $anterior->matricula;
			$lancamento->parcela = $anterior->parcela;
			$lancamento->valor = $anterior->valor;
			$lancamento->pessoa = $anterior->pessoa;
			$lancamento->referencia = $anterior->referencia;
			$lancamento->save();
			return redirect($_SERVER['HTTP_REFERER']);
		}
		else
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Parcela já ativa']);
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
	public static function reativarPorBoleto($boleto){
		$lancamentos = Lancamento::where('boleto',$boleto)
						->get();
		//return $lancamentos;
		foreach($lancamentos as $lancamento){	
				$lancamento->status = null;
				$lancamento->save();			
		}
		return $lancamentos;
	}
	public static function relancarLancamento($id){
		$lancamento = Lancamento :: find($id);
		if($lancamento != null && !LancamentoController::verificaSeLancada($lancamento->matricula,$lancamento->parcela)){
		$novo_lancamento = new  Lancamento;
		$novo_lancamento = $lancamento;
		$novo_lancamento->boleto = null;
		$novo_lancamento->save();

		}
		return $novo_lancamento;

	}
	public static function cancelarLancamentos($matricula){
		$lancamentos=Lancamento::where('matricula',$matricula)->get();
		foreach($lancamentos as $lancamento){
			$lancamento->status='cancelado';
			$lancamento->save();
			
		}

	}

	//retorna view de edição da parcela
	public function editar($lancamento){
		$lancamento = Lancamento::find($lancamento);
		return view('financeiro.lancamentos.editar',compact('lancamento'));
	}

	/**
	 * Gravação da edição da parcela
	 * @param  Request $r [description]
	 * @return [type]     [description]
	 */
	public function update(Request $r){
		$lancamento = Lancamento::find($r->lancamento);
		if($lancamento == null)
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Parcela não encontrada']);
		if($r->valor <0 && !in_array('25', \Auth::user()->recursos))
			return redirect('403');

		$boleto = $lancamento->boleto;
		
		$lancamento->matricula = $r->matricula;
		$lancamento->parcela = $r->parcela;
		$lancamento->referencia = $r->referencia;
		$lancamento->boleto = $r->boleto;
		$lancamento->valor =  str_replace(',','.',$r->valor);
		$lancamento->save();
		if($r->boleto>0)
			BoletoController::atualizarValor($r->boleto);
		if($boleto>0)
			BoletoController::atualizarValor($boleto);

		
		

		return redirect(asset('secretaria/atender/').'/'.$lancamento->pessoa);




	}


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
        if($lancamentos->count()>0){
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

		//Carrega os dados
		$lancamento = Lancamento::find($id);
		$boleto = Boleto::find($lancamento->boleto);

		//Tem boleto?
		if(isset($boleto) && $lancamento != null){

			//Ele não está pago né?
			if($boleto->status == 'gravado' || $boleto->status == 'impresso'){ 
				$lancamento->status = 'cancelado';
				$lancamento->save();
				
			}
			else{
				return redirect()->back()->withErrors(['Impossível cancelar lancamento de boleto pago. '.$boleto->status]);

			}
				

		}
		else{
			$lancamento->status = 'cancelado';
			$lancamento->save();
		}

		return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Parcela cancelada, altere o valor do boleto se necessário.']);
			
	}




	public function excluir($id){

		//Carrega os dados
		$lancamento = Lancamento::find($id);
		$boleto = Boleto::find($lancamento->boleto);

		//Tem boleto?
		if(isset($boleto) && $lancamento != null){

			//Ele não está pago né?
			if($boleto->status != 'pago'){ //só apaga lancamento se não tiver boleto gerado !!!!!!!oi? donde vc ta pegando status do boleto maluco?
				$boleto_c = new BoletoController;
				$boleto_c->cancelar($boleto->id);
			}

			else
				return redirect()->back()->withErrors(['Impossível cancelar lancamento de boleto pago.']);

		}
		else{
			$lancamento->delete();
		}

		return redirect($_SERVER['HTTP_REFERER']);
	}
	public function excluirAbertos($pessoa){

		$lancamentos = Lancamento::where('pessoa',$pessoa)->where('status',null)->where('boleto',null)->get();
		foreach($lancamentos as $lancamento){
			$lancamento->delete();
		}

		return redirect()->back()->withErrors(['Lançamentos excluídos']);
	}
	public function reativar($id){
		$lancamento = Lancamento::find($id);
		if($lancamento != null){
		$lancamento->status = null;
		$lancamento->save();
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
				$lancamento->referencia = 'Parcela '.$lancamento->parcela.' - '.$matricula->getNomeCurso();
				$lancamento->save();
			}
		}
		return "Códigos de pessoa importados para Lançamentos";
	}
	public function devincularBoleto($lancamento){
		$lancamento = Lancamento::find($lancamento);
		if($lancamento != null){
			$lancamento->boleto = null;
			$lancamento->save();
			return redirect($_SERVER['HTTP_REFERER']);
		}
		else
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Lançamentos não encontrado']);

	}
	public function novo($id){
		$matriculas = Matricula::where('pessoa', Session::get('pessoa_atendimento'))
			 	->whereIn('status',['ativa','espera','pendente'])
			 	->orderBy('id','desc')->get();
		



		return view('financeiro.lancamentos.novo')->with('pessoa',$id)->with('matriculas',$matriculas);
	}
	public function create(Request $r){
		$erros=array();


		

		if(isset($r->matriculas)){

			if(!empty($r->matriculas) && $r->parcela*1>=0){

				foreach($r->matriculas as $matricula){

					$matricula = Matricula::find($matricula);
					//dd($matricula);

					if($r->parcela>5 && $matricula->valor->parcelas<6)
						$parcela=$r->parcela-6;
					else
						$parcela = $r->parcela;



					if($r->retroativas > 0){
						for($i=1;$i <= $parcela;$i++){
							$referencia= '01/'.($i+1).'/'.date('Y');
							$data_util = new \App\classes\Data($referencia);

							$valor_parcela=($matricula->valor->valor-$matricula->valor_desconto)/$matricula->valor->parcelas;
							if(!$this->verificaSeLancada($matricula->id,$i) && $valor_parcela > 0  ){ //se não tiver ou for 0
							$referencia= '01/'.($i+1).'/'.date('Y');
							$data_util = new \App\classes\Data($referencia);
							$lancamento=new Lancamento; //gera novo lançamento
							$lancamento->matricula=$matricula->id;
							$lancamento->parcela=$i;
							$lancamento->valor=$valor_parcela;
							$lancamento->pessoa = $r->pessoa;
							$lancamento->referencia = "Parcela referente à ".$data_util->Mes().' - '.$matricula->getNomeCurso(). ' '.$matricula->id;
							if($lancamento->valor>0)//se for bolsista integral
								$lancamento->save();
								$erros[] = 'Parcela referente à '.$data_util->Mes().' da matricula '.$matricula->id.' foi lançada com sucesso.';
							}

						}
					}
					else{
						$valor_parcela=($matricula->valor->valor-$matricula->valor_desconto)/$matricula->valor->parcelas;
						//return $matricula->valor;
						$referencia= '01/'.($r->parcela+1).'/'.date('Y');
						$data_util = new \App\classes\Data($referencia);

						if($this->verificaSeLancada($matricula->id,$r->parcela)){
							$erros[] = 'Parcela referente à '.$data_util->Mes().' da matricula '.$matricula->id.' já consta como lançada.';
						}
						else{

							if($valor_parcela > 0  ){ //se não tiver ou for 0
								$lancamento=new Lancamento; //gera novo lançamento
								$lancamento->matricula=$matricula->id;
								$lancamento->parcela=$parcela;
								$lancamento->valor=$valor_parcela;
								$lancamento->pessoa = $r->pessoa;
								$lancamento->referencia = "Parcela ".$data_util->Mes().' - '.$matricula->getNomeCurso();
								if($lancamento->valor>0){
									$lancamento->save();
									$erros[] = 'Parcela referente à '.$data_util->Mes().' da matricula '.$matricula->id.' foi lançada com sucesso.';
								}
								else
									$erros[] = 'Matricula '.$matricula->id.' não gerou parcelas pois o valor da matricula foi zero';
							}
						}

					}
				}
				return redirect(asset('secretaria/atender'.'/'.$r->pessoa))->withErrors($erros);
			}

		}
		else
		{
			$lancamento=new Lancamento; //gera novo lançamento
			$lancamento->pessoa = 	$r->pessoa;
			$lancamento->referencia = "Parcela ";
			$lancamento->save();
		}
		
		return redirect(asset('secretaria/atender'.'/'.$r->pessoa));

	}
	

	
	public function descontao1(){
		$turmas1 = \App\Turma::where('status', 'iniciada')->where(function($query){
							$query->where('dias_semana','like','%qui%')
							->orwhere('dias_semana','like','%sex%');
							})
							->where('local', 84 )
							->get();
		

		foreach($turmas1 as $turma){
			if($turma->tempo_curso<9)
				$tempo = 5;
			else
				$tempo = 11;

			if($turma->valor)
				$valor = 1;
				$this->descontoTurma($turma->id,$valor,'Desconto de aulas não dadas - 27 e 28 de setembro');
		}

		
		
		return $turmas1->count().' turmas receberam descontos.';
	}
	
	public function descontao2(){
		$turmas = \App\Turma::where('local',86)->where('status','iniciada')->get();
		foreach($turmas as $turma){
			if($turma->tempo_curso<9)
				$tempo = 5;
			else
				$tempo = 11;
			$valor = count($turma->dias_semana);
			$this->descontoTurma($turma->id,$valor,'Desconto de aulas não dadas por uso do espaço pelos Jogos Regionais');
		}

		return $turmas->count().' turmas receberam descontos na FESC 3.';



	}

	public function descontoTurma($turma,$valor,$referencia){
		$inscricoes = \App\Inscricao::where('turma',$turma)->whereIn('status',['regular','pendente'])->get();
		foreach($inscricoes as $inscricao){

			//verifica se não bolsista 
			$matricula = \App\Matricula::find($inscricao->matricula);
			if($matricula->valor->valor>0){ 

				//lançar desconto
				$lancamento=new Lancamento; //gera novo lançamento
				$lancamento->pessoa = 	$inscricao->pessoa->id;
				$lancamento->matricula= $inscricao->matricula;
				$lancamento->referencia = $referencia;
				$lancamento->parcela=0;
				$lancamento->valor = (($matricula->valor->valor/$matricula->valor->parcelas)/4)*$valor*-1;
				$lancamento->save();
			}

		}
		return 'Descontos lançados.';

	}

	/**
	 * Excluir lançamentos sem boletos associados de uma matrícula.
	 * @param  [int] $matricula [id da matrícula ]
	 * @return [void]           
	 */
	public static function excluirSemBoletosPorMatricula(int $matricula){
		$lancamentos = Lancamento::where('matricula',$matricula)->where('boleto',null)->get();
		foreach($lancamentos as $lancamento){
			$lancamento->delete();
		}
	}

}
