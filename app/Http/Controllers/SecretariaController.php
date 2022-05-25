<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;
use App\Atendimento;
use App\Matricula;
use App\Boleto;
use App\Lancamento;
use App\Inscricao;
use Session;
use Auth;
use App\classes\Strings;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class SecretariaController extends Controller
{
    //
    public function iniciarAtendimento()
	{
		//dd(Session::all());
		return view('secretaria.inicio-atendimento');
	}

	public function buscaPessoaAtendimento(Request $r){
		$pessoa_controller = new PessoaController;
		$pessoas = $pessoa_controller->procurarPessoas($r->nome);
		
		return view('secretaria.inicio-atendimento')->with('pessoas',$pessoas);
	}


	public function atender($id=0){
	

		if($id>0)
			session('pessoa_atendimento',$id);
		else
			$id=session('pessoa_atendimento');		
		$pessoa=Pessoa::withTrashed()->find($id);
		if(!$pessoa)
			return redirect(asset('/secretaria/pre-atendimento'));
		else
			Session::put('pessoa_atendimento',$id);	
		$pessoa=PessoaController::formataParaMostrar($pessoa);
		//$pessoa->getTelefones();
		if(isset($pessoa->telefone))
			$pessoa->telefone=Strings::formataTelefone($pessoa->telefone);
		if(isset($pessoa->telefone_alternativo))
			$pessoa->telefone_alternativo=Strings::formataTelefone($pessoa->telefone_alternativo);
		if(isset($pessoa->telefone_contato))
			$pessoa->telefone_contato=Strings::formataTelefone($pessoa->telefone_contato);
		
		if(!Session::get('atendimento')){
			
			$atendimento=new Atendimento();
			$atendimento->atendente=Auth::user()->pessoa;
			$atendimento->usuario=$pessoa->id;
			$atendimento->save();
			
			Session::put('atendimento', $atendimento->id);
	
		}
		$errosMsg=\App\PessoaDadosGerais::where('pessoa',$id)->where('dado',20)->get();
		$pendenciasMsg=\App\PessoaDadosAdministrativos::where('pessoa',$id)->where('dado','pendencia')->get();
		
		if(isset($_GET["mostrar"])){
			 $matriculas=Matricula::where('pessoa', Session::get('pessoa_atendimento'))->orderBy('id','desc')->limit(20)->get();
			 foreach($matriculas as $matricula){
			 	$matricula->getInscricoes();
			 	foreach($matricula->inscricoes as $inscricao){
			 		if($inscricao->status == 'transferida')
			 			$inscricao->transferencia = $inscricao->getTransferencia();
			 	}
			 }
			 $boletos = Boleto::where('pessoa',$id)->orderBy('id','desc')->limit(50)->get();
			 foreach($boletos as $boleto){
			 	$boleto->getLancamentos();
			 }
		 	$lancamentos = Lancamento::where('pessoa',$id)->where('boleto',null)->get();
		 				
		}
		else{
			 $matriculas=Matricula::where('pessoa', Session::get('pessoa_atendimento'))
			 	->whereIn('status',['ativa','pendente','espera'])
			 	->orderBy('id','desc')->get();
			 //listar inscrições de cada matricula;
			 foreach($matriculas as $matricula){
			 	$matricula->getInscricoes();
			 	foreach($matricula->inscricoes as $inscricao){
			 		if($inscricao->status == 'transferida')
			 			$inscricao->transferencia = $inscricao->getTransferencia();

			 	}

			 }
			 $boletos = Boleto::where('pessoa',$id)
			 	->whereIn('status',['gravado','impresso','emitido','divida','aberto executado','pago'])
			 	->orderBy('id','desc')
				->limit(20)
			 	->get();
			 foreach($boletos as $boleto){
			 	$boleto->getLancamentos();
			 }
			
			 $lancamentos = Lancamento::where('pessoa',$id)->where('boleto',null)->where('status',null)->get();
			 
		}
		
		$vencimento = \Carbon\Carbon::today()->addDays(-5);
		$boleto_vencido = $boletos->whereIn('status',['emitido','divida','aberto executado'])->where('vencimento','<',$vencimento->toDateString());
		if(count($boleto_vencido)>0)	
			$devedor=true;
		else 
			$devedor=false;
		

		$atestado = \App\Atestado::where('pessoa',$id)->where('tipo','saude')->orderByDesc('id')->first();
		
		if($atestado){
			$atividades_aquaticas = $matriculas->whereIn('status',['ativa','pendente','espera'])->WhereIn('curso',['898','1151','1152','1493']);
			if(count($atividades_aquaticas)>0){
				$atestado->validade = $atestado->calcularVencimento(12);
			}
				
			else{
				$atestado->validade = $atestado->calcularVencimento(3);
			}
				

		}

		

		return view('secretaria.atendimento', compact('pessoa'))
			->with('matriculas',$matriculas)
			->with('boletos',$boletos)
			->with('lancamentos',$lancamentos)
			->with('errosPessoa',$errosMsg)
			->with('pendencias',$pendenciasMsg)
			->with('atestado',$atestado)
			->with('devedor',$devedor);
	}
	public function uploadGlobal_vw(){
		return view('secretaria.upload-global');
	}
	public function uploadGlobal(Request $r){
		$arquivos = $r->file('arquivos');
            foreach($arquivos as $arquivo){
                //dd($arquivo);
                if (!empty($arquivo)) {
                    //$arquivo->move('documentos/pprocessar', $arquivo->getClientOriginalName());
                    switch (substr($arquivo->getClientOriginalName(), 5,2)) {
                    	case 'MT':
                    		if(!file_exists('documentos/matriculas/termos/'.(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf'))
                    			$arquivo->move('documentos/matriculas/termos/',(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf');
                    		else
                    			$arquivo->move('documentos/matriculas/termos/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'_'.date('Ymd').'pdf');
                    		$msg[$arquivo->getClientOriginalName()] = 'Arquivo '.$arquivo->getClientOriginalName().' carregado com sucesso.';
                    		break;

                    	case 'CM':
                    		if(!file_exists('documentos/matriculas/cancelamentos/'.(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf'))
                    			$arquivo->move('documentos/matriculas/cancelamentos/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf');
                    		else
                    			$arquivo->move('documentos/matriculas/cancelamentos/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'_'.date('Ymd').'pdf');
                    		$msg[$arquivo->getClientOriginalName()] = 'Arquivo '.$arquivo->getClientOriginalName().' carregado com sucesso.';
                    		break;
                 
                    	case 'CI':
                    		if(!file_exists('documentos/inscricoes/cancelamentos/'.(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf'))
                    			$arquivo->move('documentos/inscricoes/cancelamentos/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf');
                    		else
                    			$arquivo->move('documentos/inscricoes/cancelamentos/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'_'.date('Ymd').'pdf');
                    		$msg[$arquivo->getClientOriginalName()] = 'Arquivo '.$arquivo->getClientOriginalName().' carregado com sucesso.';
                    		break;
                  
                    	case 'AM':
                    		if(!file_exists('documentos/atestados/'.(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf'))
                    			$arquivo->move('documentos/atestados/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf');
                    		else
                    			$arquivo->move('documentos/atestados/',(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'_'.date('Ymd').'pdf');
                    		$msg[$arquivo->getClientOriginalName()] = 'Arquivo '.$arquivo->getClientOriginalName().' carregado com sucesso.';
                    		break;
                    		
                    	case 'RD':
                    	case 'RQ':
                    		if(!file_exists('documentos/bolsas/requerimentos/'.(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf'))
                    			$arquivo->move('documentos/bolsas/requerimentos/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf');
                    		else
                    			$arquivo->move('documentos/bolsas/requerimentos/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'_'.date('Ymd').'pdf');
                    		$msg[$arquivo->getClientOriginalName()] = 'Arquivo '.$arquivo->getClientOriginalName().' carregado com sucesso.';
                    		break;
                    		
                    	case 'PA':
                    		if(!file_exists('documentos/bolsas/pareceres/'.(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf'))
                    			$arquivo->move('documentos/bolsas/pareceres/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf');
                    		else
                    			$arquivo->move('documentos/bolsas/pareceres/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'_'.date('Ymd').'pdf');
                    		$msg[$arquivo->getClientOriginalName()] = 'Arquivo '.$arquivo->getClientOriginalName().' carregado com sucesso.';
                    		break;
                    	case 'TR':
                    		if(!file_exists('documentos/inscricoes/transferencias/'.(preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf'))
                    			$arquivo->move('documentos/inscricoes/transferencias/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'.pdf');
                    		else
                    			$arquivo->move('documentos/inscricoes/transferencias/', (preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName())*1).'_'.date('Ymd').'pdf');
                    		$msg[$arquivo->getClientOriginalName()] = 'Arquivo '.$arquivo->getClientOriginalName().' carregado com sucesso.';
                    		break;
                    		
                    	default :
                    		$msg[$arquivo->getClientOriginalName()] = 'O arquivo "'.$arquivo->getClientOriginalName().'" não segue o padrão de nomenclatura FESC_XX----.pdf, verifique o nome e envie novamente.';
                    		break;


                    }
                }
            }
		return view('secretaria.upload-global')->withErrors($msg);
	}

	public function processar($arquivo){

	}
	public function processarDocumentos(){

		$dir_iterator = new RecursiveDirectoryIterator('documentos/pprocessar/');
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

		foreach ($iterator as $arquivo) {
		   if($arquivo->isFile()){
			   	switch (substr($arquivo->getFilename(), 5,2)) {
                	case 'MT':
                		 if(!file_exists('documentos/matriculas/termos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf'))
                		 	rename( $arquivo,'documentos/matriculas/termos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf');
                		 else
                		 	rename( $arquivo,'documentos/matriculas/termos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'_'.date('Ymd').'.pdf');
                		//$arquivo->move('documentos/matriculas/cancelamentos/', preg_replace( '/[^0-9]/is', '', $arquivo));
                		 //$arquivo->move('documentos/matriculas/termos/', preg_replace( '/[^0-9]/is', '', $arquivo));
                		 $msgs[$arquivo->getFilename()] = $arquivo->getFilename(). 'processado com sucesso';
                		break;
                	case 'CM':
                		if(!file_exists('documentos/matriculas/cancelamentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf'))
                		 	rename( $arquivo,'documentos/matriculas/cancelamentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf');
                		 else
                		 	rename( $arquivo,'documentos/matriculas/cancelamentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'_'.date('Ymd').'.pdf');
                		//$arquivo->move('documentos/matriculas/cancelamentos/', preg_replace( '/[^0-9]/is', '', $arquivo));
                		$msgs[$arquivo->getFilename()] = $arquivo->getFilename(). ' processado com sucesso';
                		break;
                	case 'CI':
                		if(!file_exists('documentos/inscricoes/cancelamentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf'))
                		 	rename( $arquivo,'documentos/inscricoes/cancelamentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf');
                		 else
                		 	rename( $arquivo,'documentos/inscricoes/cancelamentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'_'.date('Ymd').'.pdf');
                		//$arquivo->move('documentos/inscricoes/cancelamentos/', preg_replace( '/[^0-9]/is', '', $arquivo));
                		$msgs[$arquivo->getFilename()] = $arquivo->getFilename(). ' processado com sucesso';
                		break;
                	case 'AM':
                		if(!file_exists('documentos/atestados/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf'))
                		 	rename( $arquivo,'documentos/atestados/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf');
                		 else
                		 	rename( $arquivo,'documentos/atestados/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'_'.date('Ymd').'.pdf');
                		//$arquivo->move('documentos/atestados/', preg_replace( '/[^0-9]/is', '', $arquivo));
                		$msgs[$arquivo->getFilename()] = $arquivo->getFilename(). ' processado com sucesso';
                		break;
                	case 'RD':
                	case 'RQ':
                		if(!file_exists('documentos/bolsas/requerimentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf'))
                		 	rename( $arquivo,'documentos/bolsas/requerimentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf');
                		 else
                		 	rename( $arquivo,'documentos/bolsas/requerimentos/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'_'.date('Ymd').'.pdf');
                		//$arquivo->move('documentos/bolsas/requerimentos', preg_replace( '/[^0-9]/is', '', $arquivo));
                		$msgs[$arquivo->getFilename()] = $arquivo->getFilename(). ' processado com sucesso';
                		break;
                	case 'PA':
                		if(!file_exists('documentos/bolsas/pareceres/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf'))
                		 	rename( $arquivo,'documentos/bolsas/pareceres/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf');
                		 else
                		 	rename( $arquivo,'documentos/bolsas/pareceres/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'_'.date('Ymd').'.pdf');
                		//$arquivo->move('documentos/atestados/', preg_replace( '/[^0-9]/is', '', $arquivo));
                		$msgs[$arquivo->getFilename()] = $arquivo->getFilename(). ' processado com sucesso';
                		break;
                	case 'TR':
                		if(!file_exists('documentos/inscricoes/transferencias/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf'))
                		 	rename( $arquivo,'documentos/inscricoes/transferencias/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'.pdf');
                		 else
                		 	rename( $arquivo,'documentos/inscricoes/transferencias/'. (preg_replace( '/[^0-9]/is', '', $arquivo->getFilename())*1).'_'.date('Ymd').'.pdf');
                		//$arquivo->move('documentos/atestados/', preg_replace( '/[^0-9]/is', '', $arquivo));
                		$msgs[$arquivo->getFilename()] = $arquivo->getFilename(). ' processado com sucesso';
                		break;
                	default :
                		$msgs[$arquivo->getFilename()]= 'Erro: O arquivo "'.$arquivo.'" não segue o padrão de nomenclatura FESC_XX----.pdf, verifique o nome e envie novamente.';
                		break;

	            }
		   }
		}
		return view('secretaria.arquivos-processados')->with('logs',$msgs);
	}


	/**
	 * Controle de alunos EAD
	 */
	public function alunos(Request $r){
		$filtros =Array();

		$inscricoes = Inscricao::join('turmas','inscricoes.turma','=','turmas.id')->where('turmas.sala',74)->whereIn('inscricoes.status',['regular','pendente'])->get();
		foreach($inscricoes as $inscricao){
			$inscricao->email = \App\PessoaDadosContato::where('pessoa',$inscricao->pessoa->id)->where('dado',1)->orderbyDesc('id')->first();
			$inscricao->email_fesc = \App\PessoaDadosAcademicos::where('pessoa',$inscricao->pessoa->id)->where('dado','email_fesc')->orderbyDesc('id')->first();
			$inscricao->insc_teams = \App\PessoaDadosAcademicos::where('pessoa',$inscricao->pessoa->id)->where('dado','equipe_teams')->where('valor',$inscricao->turma->id)->first();
		}
		//dd($inscricoes);

		return view('secretaria.controle-alunos')
			->with('r',$r)
			->with('periodos',\App\classes\Data::semestres())
			->with('inscricoes',$inscricoes);
	}


	/**
	 * Controle de CANCELAMENTO de alunos EAD
	 */
	public function alunosCancelados(Request $r){
		$filtros =Array();

		$inscricoes = Inscricao::join('turmas','inscricoes.turma','=','turmas.id')->where('turmas.sala',74)->where('inscricoes.status','cancelada')->get();
		foreach($inscricoes as $inscricao){
			$inscricao->email = \App\PessoaDadosContato::where('pessoa',$inscricao->pessoa->id)->where('dado',1)->orderbyDesc('id')->first();
			$inscricao->email_fesc = \App\PessoaDadosAcademicos::where('pessoa',$inscricao->pessoa->id)->where('dado','email_fesc')->orderbyDesc('id')->first();
			$inscricao->insc_teams = \App\PessoaDadosAcademicos::where('pessoa',$inscricao->pessoa->id)->where('dado','equipe_teams')->where('valor',$inscricao->turma->id)->first();
		}
		//dd($inscricoes);

		return view('secretaria.controle-cancelamento-alunos')
			->with('r',$r)
			->with('periodos',\App\classes\Data::semestres())
			->with('inscricoes',$inscricoes);
	}

	public function emailBoletos(){
		$pessoas = array();

		$inscricoes = Inscricao::join('turmas','inscricoes.turma','=','turmas.id')->where('turmas.sala',74)->whereIn('inscricoes.status',['regular','pendente'])->get();
		foreach($inscricoes as $inscricao){
			if(!in_array($inscricao->pessoa->id,$pessoas))
				array_push($pessoas,$inscricao->pessoa->id);
		}
		dd($pessoas);

		foreach($pessoas as $id_pessoa){
			$pessoa = Pessoa::find($id_pessoa);
			$email = \App\PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',1)->orderbyDesc('id')->first();
			$email_fesc = \App\PessoaDadosAcademicos::where('pessoa',$id_pessoa)->where('dado','email_fesc')->orderbyDesc('id')->first();
			
			if($email != null && $email_fesc != null){
				$email = $email->valor;
				$email_fesc = $email_fesc->valor;

				//dd($pessoa);
				//\App\Jobs\EnviaEmails::dispatch($pessoa,$email,$email_fesc);
			}
			

		}

		return 'email postado';

	}

	public function viewMatricula($ids){
		$array_matriculas = explode(',',$ids);
		$matriculas = Matricula::whereIn('id',$array_matriculas)->paginate(50);
		foreach($matriculas as &$matricula){
			$matricula->getInscricoes();
			$matricula->pessoa_obj = \App\Pessoa::withTrashed()->find($matricula->pessoa);
			//if(!$matricula->pessoa_obj)
			//dd($matricula);
			foreach($matricula->inscricoes as $inscricao){
				if($inscricao->status == 'transferida')
					$inscricao->transferencia = $inscricao->getTransferencia();
			}
			$matricula->lancamentos = \App\Lancamento::where('matricula',$matricula->id)->where('status',null)->where('boleto','>','0')->count();
			//dd($matricula->lancamentos);
		}
		/*$matriculas = collect();
		foreach($array_matriculas as $id){
			$matricula = Matricula::find($id);
			if(isset($matricula->id)){
				$matriculas->push($matricula);
			}
		}*/

		return view('secretaria.matricula.listagem')->with('matriculas',$matriculas);
	}
}
