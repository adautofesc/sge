<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\BarCodeGenrator;
use App\Lancamento;
use App\Boleto;
use App\Pessoa;
use App\Matricula;
use Carbon\Carbon;
use DateTime;
use Cnab;
use Session;

//require '../vendor/autoload.php';


//use App\Http\Controllers\LancamentoController;
//clude 'vendor/autoload.php';
class BoletoController extends Controller
{	
	public function cadastrar(){ //$parcela/mes/ano
		$vencimento=date('Y-m-20 23:59:59');

		$lancamentos_sintetizados=Lancamento::select(\DB::raw('distinct(matriculas.pessoa), sum(lancamentos.valor) as valor'))
							->join('matriculas','lancamentos.matricula','matriculas.id')
							->groupBy('matriculas.pessoa')
							->where('boleto',null)
							->get();

		
		foreach($lancamentos_sintetizados as $ls){
			//verifica se já não foi gerado
			if(!$this->verificaSeCadastrado($ls->pessoa,$ls->valor,$vencimento)){
			//gerar boleto
			$boleto=new Boleto;
			$boleto->pessoa=$ls->pessoa;
			$boleto->vencimento=$vencimento;
			$boleto->valor=$ls->valor;

			$boleto->save();
			LancamentoController::atualizaLancamentos($ls->pessoa,0,$boleto->id);
			}


			
			
			//LancamentosController::atualizaLancamentos(22563,0,$boleto->id);
		}

		return $lancamentos_sintetizados;


	}
	public function imprimirLote(){

		$boletos=Boleto::where('status','gravado')->limit(200)->get();
		foreach($boletos as $boleto){
			$boleto->status='impresso';
			$boleto->save();
			$this->gerar($boleto);
		}
		//return $boletos;

		return view('financeiro.boletos.lote')->with('boletos',$boletos);
	}
	public static function verificaSeCadastrado($pessoa,$valor,$vencimento){
		$cadastrado=Boleto::where('pessoa',$pessoa)->where('valor',$valor)->where('vencimento',$vencimento)->first();
		return $cadastrado;

	}
	public function cadastarIndividualmente(){
		if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
		$vencimento = date('Y-m-d 23:23:59', strtotime("+5 days",strtotime(date('Y-m-d')))); 
		$matriculas = Matricula::select('id')
			->where('pessoa',Session::get('pessoa_atendimento'))
			->where(function($query){
				$query->where('status','ativa')->orwhere('status', 'pendente');
			})
			->get();

		$ids=array();
		foreach($matriculas as $matricula){
			$ids[]=$matricula->id;
		}


		$lancamentos = Lancamento::whereIn('matricula',$ids)
			->where('boleto',null)
			->get();

		if(count($lancamentos) > 0){
				
			//gerar boleto
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
						if($lancamento->valor > 0)
							$acrescimos=$acrescimos+$lancamento->valor;
						else
							$descontos = $descontos + $lancamento->valor;	
					}
					else
						$total = $total + $lancamento->valor;
					$total = $total + $descontos + $acrescimos;
					$lancamento->boleto=$boleto->id;
					$lancamento->save();
				}
			}
			$boleto->valor = $total;
			$boleto->descontos = $descontos;
			$boleto->encargos = $acrescimos;
			$boleto->save();
			if($boleto->valor <=0){
				$boleto->status = 'cancelado';
				$boleto->save();
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
	public function imprimir($boleto){
		$boleto = Boleto::find($boleto);
		if($boleto == null)
			throw new \Exception("Boleto Inexistente", 1);
		if($boleto->status == 'gravado'){
			$boleto->status = 'impresso';
			$boleto->save();
		}
		$boleto = $this->gerar($boleto);

		return view('financeiro.boletos.boleto',compact('boleto'));
		
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
			$boleto->status = 'cancelar';
			$boleto->save();
			LancamentoController::cancelarPorBoleto($id);
		}
		return redirect($_SERVER['HTTP_REFERER']);
		

	}
	public function gerarBoleto(){
		$beneficiario = new \Eduardokum\LaravelBoleto\Pessoa([
		    'documento' => '45.361.904/0001-80',
		    'nome'      => 'Fundação Educacional São Carlos',
		    'cep'       => '13560-230',
		    'endereco'  => 'Rua São Sebastiao, 2828, ',
		    'bairro' => ' Vila Nery',
		    'uf'        => 'SP',
		    'cidade'    => 'São Carlos',
		]);
		$pagador = new \Eduardokum\LaravelBoleto\Pessoa([
		    'documento' => '00.000.000/0000-00',
		    'nome'      => 'Company co.',
		    'cep'       => '00000-000',
		    'endereco'  => 'Street name, 123',
		    'bairro' => 'district',
		    'uf'        => 'UF',
		    'cidade'    => 'City',
		]);
		$bb = new \Eduardokum\LaravelBoleto\Boleto\Banco\Bb([
		    'logo' => '',
		    'dataVencimento' => Carbon::parse('2018-03-21'),
		    'valor' => 100,
		    'numero' => 1,
		    'numeroDocumento' => 1,
		    'pagador' => $pagador,
		    'beneficiario' => $beneficiario,
		    'carteira' => 17,
		    'agencia' => '0295-X',
		    'convenio' => 1231237,
		    'conta' => 22222,
		    'descricaoDemonstrativo' => [
		    	'demonstrativo 1',
		    	'demonstrativo 2', 
		    	'demonstrativo 3'
		    ],
		    'instrucoes' => [
		    	'instrucao 1', 
		    	'instrucao 2', 
		    	'instrucao 3'
		    ],
		]);
			
		    return $bb->renderHTML();

		}

}
