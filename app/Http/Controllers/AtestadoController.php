<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atestado;
use App\AtestadoLog;
use Auth;
use Carbon\Carbon;

class AtestadoController extends Controller
{
	public function novo($id){
		$pessoa=\App\Pessoa::find($id);
		$pessoa=PessoaController::formataParaMostrar($pessoa);
		if(isset($pessoa->telefone))
			$pessoa->telefone=\App\classes\Strings::formataTelefone($pessoa->telefone);
		if(isset($pessoa->telefone_alternativo))
			$pessoa->telefone_alternativo=\App\classes\Strings::formataTelefone($pessoa->telefone_alternativo);
		if(isset($pessoa->telefone_contato))
			$pessoa->telefone_contato=\App\classes\Strings::formataTelefone($pessoa->telefone_contato);

		return view('atestados.cadastrar-atestado',compact('pessoa'));
	}
	public function create(Request $r){
		if(substr($r->emissao,0,4)<(date('Y')-1))
			return redirect()->back()->withErrors(['Digite o ano com 4 algarismos']);
		
		if(isset($r->validade) && substr($r->validade,0,4)<(date('Y')-1))
			return redirect()->back()->withErrors(['Digite o ano com 4 algarismos']);    

		if(isset($r->validade) && $r->emissao > $r->validade)
			return redirect()->back()->withErrors(['Data de emissão maior que a data de validade']);    


		$arquivo = $r->file('arquivo');
		$atestado = new Atestado;
				$atestado->pessoa = $r->pessoa;
				$atestado->tipo = $r->tipo;
				$atestado->emissao = $r->emissao;

				if(isset($r->validade))
					$atestado->validade = $r->validade;
				else
					$atestado->validade = $r->emissao;


				$atestado->atendente = Auth::user()->pessoa;
				$atestado->status = 'aprovado';
				$atestado->save();
        if (!empty($arquivo)) {	
                $arquivo->move('documentos/atestados/', $atestado->id.'.pdf');
        }
		AtestadoLogController::registrar($atestado->id,'Atestado cadastrado pela secretaria.', Auth::user()->pessoa);
		if($atestado->tipo == 'vacinacao')					
			PessoaDadosAdminController::liberarPendencia($atestado->pessoa,'Falta atestado de vacinação aprovado.');
		if($atestado->tipo == 'saude')					
			PessoaDadosAdminController::liberarPendencia($atestado->pessoa,'Falta atestado de saúde aprovado.');
      
        

        return redirect('/secretaria/atender/'.$r->pessoa)->withErrors(['Atestado '.$atestado->id.' cadastrado com sucesso.']);


	}
	public function listar(){
		$atestados = Atestado::where('emissao','>=', (date('Y')-1).'-01-01')->orderByDESC('id')->paginate(50);
		$logs = \App\Log::where('tipo','atestado')->get();
		foreach($logs as $log){
			$atestado_log = new AtestadoLog;
			$atestado_log->atestado = $log->codigo;
			$atestado_log->evento = $log->evento;
			$atestado_log->pessoa = $log->pessoa;
			$atestado_log->data = $log->data;
			$atestado_log->save();
			$log->delete();
		}
		
		return view('atestados.listar',compact('atestados'));
	}
	public function buscar(Request $r){
		
	}
	public function editar($id){
		$atestado = Atestado::find($id);
		if($atestado){
			//$atestado->validade = \Carbon\Carbon::parse($atestado->validade)->format('d/m/Y');
			$pessoa=\App\Pessoa::find($atestado->pessoa);
			$pessoa=PessoaController::formataParaMostrar($pessoa);
			if(isset($pessoa->telefone))
				$pessoa->telefone=\App\classes\Strings::formataTelefone($pessoa->telefone);
			if(isset($pessoa->telefone_alternativo))
				$pessoa->telefone_alternativo=\App\classes\Strings::formataTelefone($pessoa->telefone_alternativo);
			if(isset($pessoa->telefone_contato))
				$pessoa->telefone_contato=\App\classes\Strings::formataTelefone($pessoa->telefone_contato);

			return view('atestados.editar-atestado')->with('atestado',$atestado)->with('pessoa',$pessoa);
		}else
		 return redirect()->back()->withErrors(['Atestado não encontrado.']);
	}
	public function update(Request $r){

		$atestado = Atestado::find($r->atestado);
		if($atestado){
			if(substr($r->emissao,0,4)<(date('Y')-1))
				return redirect()->back()->withErrors(['Digite o ano com 4 algarismos']);
		
			if(isset($r->validade) && substr($r->validade,0,4)<(date('Y')-1))
				return redirect()->back()->withErrors(['Digite o ano com 4 algarismos']); 
			
			if(isset($r->validade) && $r->emissao > $r->validade)
				return redirect()->back()->withErrors(['Data de emissão maior que a data de validade']);    
		
			$atestado->emissao = $r->emissao;
			$atestado->tipo = $r->tipo;
			$atestado->save();
			$arquivo = $r->file('arquivo');
       		if (!empty($arquivo)) {
       			$arquivo->move('documentos/atestados/', $atestado->id.'.pdf');
       		}

			AtestadoLogController::registrar($atestado->id,'Atestado editado', Auth::user()->pessoa);
       		return redirect()->back()->with(['success'=>'Atestado atualizado.']);
		}
		else
			return redirect()->back()->withErrors(['Atestado não encontrado.']);
	}
	public function apagar($id){
		$atestado = Atestado::find($id);
		if($atestado != null){
			$atestado->delete();
			return redirect()->back()->withErrors(['Atestado arquivado.']);
		}

	
    //
	}
	public function apagarArquivo($id){
		if(file_exists('documentos/atestados/'.$id.'.pdf'))
			unlink('documentos/atestados/'.$id.'.pdf');

	}
	public function arquivo($id){
		if(file_exists('documentos/atestados/'.$id.'.pdf')){
			header("Content-type:application/pdf");

// It will be called downloaded.pdf
			//header("Content-Disposition:attachment;filename='downloaded.pdf'");

// The PDF source is in original.pdf
			readfile('documentos/atestados/'.$id.'.pdf');
		}
			
		else
			return 'arquivo não encontrado';

	}

	public function Analisar_view(int $id){
		$atestado = Atestado::find($id);
		
		if($atestado){
			$logs = \App\AtestadoLog::where('atestado',$id)->get();
			//$atestado->validade = \Carbon\Carbon::parse($atestado->validade)->format('d/m/Y');
			$pessoa=\App\Pessoa::find($atestado->pessoa);
			$pessoa=PessoaController::formataParaMostrar($pessoa);
			if(isset($pessoa->telefone))
				$pessoa->telefone=\App\classes\Strings::formataTelefone($pessoa->telefone);
			if(isset($pessoa->telefone_alternativo))
				$pessoa->telefone_alternativo=\App\classes\Strings::formataTelefone($pessoa->telefone_alternativo);
			if(isset($pessoa->telefone_contato))
				$pessoa->telefone_contato=\App\classes\Strings::formataTelefone($pessoa->telefone_contato);
			if(file_exists('documentos/atestados/'.$atestado->id.'.pdf')){
				$arquivo = file_get_contents('documentos/atestados/'.$atestado->id.'.pdf');
			}
			else
				$arquivo = 'Arquivo não encontrado';

			return view('atestados.analisar-atestado')->with('atestado',$atestado)
						->with('pessoa',$pessoa)
						->with('logs',$logs)
						->with('arquivo',$arquivo);
		}else
		 return redirect()->back()->withErrors(['Atestado não encontrado.']);

	}
	public function analisar(Request $r, int $id){
		$r->validate([
			'status'=>'required'
		]);
		$atestado = Atestado::find($id);
		
		if($atestado){
			$atestado->status = $r->status;
			if($r->status == 'aprovado'){
				AtestadoLogController::registrar($id,'Atestado aprovado.', Auth::user()->pessoa);
				if($atestado->tipo == 'vacinacao')					
					PessoaDadosAdminController::liberarPendencia($atestado->pessoa,'Falta atestado de vacinação aprovado.');
				if($atestado->tipo == 'saude')					
					PessoaDadosAdminController::liberarPendencia($atestado->pessoa,'Falta atestado de saúde aprovado.');
				
			}
			if($r->status == 'recusado'){
				AtestadoLogController::registrar($id,'Atestado RECUSADO: '."\n".$r->obs, Auth::user()->pessoa);
				$dado_email = \App\PessoaDadosContato::where('pessoa',$atestado->pessoa)->where('dado',1)->orderbyDesc('id')->first();

				if($dado_email){
				
						\Illuminate\Support\Facades\Mail::send('emails.atestado_recusado', ['atestado' => $atestado,'motivo' => $r->obs], function ($message) use($dado_email){
						$message->from('no-reply@fesc.saocarlos.sp.gov.br', 'Sistema Fesc');
						$message->to($dado_email->valor);
						$message->subject('Atestado recusado');
						});
					
						
				}
				//enviar email
			}
		
		$atestado->save();	
		return redirect("/pessoa/atestado/listar")->with('success','Atestado '.$atestado->id.' avaliado.');
		}
		else
		 return redirect()->back()->withErrors(['Atestado não encontrado.']);

	}

	/**
	 * Verifica requisitos de saúde
	 *
	 * @param integer $pessoa
	 * @param \App\Turma $turma
	 * @return void
	 */
	public static function verificaParaInscricao(int $pessoa, \App\Turma $turma){
		if($turma->local->id == 118)
			return true;
		$vacina = true;
		$atestado = true;
		/* Verificação do atestado de vacinação COVID-19
		$vacinacao = Atestado::where('pessoa',$pessoa)->where('tipo','vacinacao')->where('status','aprovado')->first();
		if(!$vacinacao){
			\App\PessoaDadosAdministrativos::cadastrarUnico($pessoa,'pendencia','Falta atestado de vacinação aprovado.');
			$vacina = false;		
		}*/
		
		$requisito_turma = \App\CursoRequisito::where('para_tipo','turma')->where('curso',$turma->id)->where('requisito',18)->first();
		if(isset($requisito_turma->id)){
			$saude =  Atestado::where('pessoa',$pessoa)->where('tipo','saude')->where('status','aprovado')->first();
			if(!$saude){
				$atestado = false;
			}

		}

		if($atestado && $vacina)
			return true;
		else
			return false;		

	}

	public function analiseAtestados(){
		$atestados = Atestado::where('tipo','saude')->where('status','aprovado')->get();
		$atual = $atestados->first();
		$vencido = $atual->emissao->addMonths(12);
		//dd($atual);
		
		foreach($atestados as $atestado){
			$hoje = Carbon::now();
			$vencimento = $atestado->emissao->addMonths(12);
			//se venceu
			if($hoje->gte($vencimento)){
				$atestado->status = 'vencido';
				$atestado->save();

			}
			/*
			//verificar se a pessoa que tem outro atestado senão valida os atuais
			$outro_atestado = Atestado::where('tipo','saude')->where('status','aprovado')->where('pessoa',$atestado->pessoa)->first();
			if(is_null($outro_atestado)){
				//verificar se a pessoa tem matricula ativa que precisa de atestado
				$inscricoes = App\Inscricao::where('pessoa',$atestado->pessoa)->where('status','regular')->get();
				foreach($inscricoes as $inscricao){
					if($inscricao->turma->verificaSeAtividadeFisica() != false){
						//coloca pessoa pendente se necessário.
						$inscricao->alterarStatus('pendente');
						\App\PessoaDadosAdministrativos::cadastrarUnico($pessoa,'pendencia','Atestado médico vencido.');


					}
				}


			}*/

		}
		return $atestados;
	}

	/**
	 * Verifica se todos os atestados, colocando as inscrições como pendentes e os atestados como vencidos
	 * @return void
	 */
	public function verificadorDiario(){
		$itens = array();
		//lista todas turmas que precisam de atestado médico - atividade fisica
		$turmas = \App\CursoRequisito::join('turmas','cursos_requisitos.curso','turmas.id')
		->where('turmas.status','iniciada')
		->where('cursos_requisitos.para_tipo','turma')
		->whereIn('cursos_requisitos.requisito',[18,27])
		->pluck('turmas.id')->toArray();

		$inscricoes = \App\Inscricao::whereIn('turma',$turmas)->where('status','regular')->get();


		foreach($inscricoes as $inscricao){
			$atestado = Atestado::where('pessoa',$inscricao->pessoa)->where('tipo','saude')->where('status','aprovado')->orderByDesc('id')->first();

			//se não tem atestado valido
			if($atestado == null){
				$inscricao->alterarStatus('pendente');
				//\App\PessoaDadosAdministrativos::cadastrarUnico($inscricao->pessoa,'pendencia','Atestado médico vencido.');
				$inscricao->save();
				if(in_array($inscricao->pessoa,$itens) == false)
					$itens[] = $inscricao->pessoa->id;
				
				continue;
			}
			
			//verifica se o atestado está vencido para a turma
			if($atestando->verificaPorTurma($inscricao->turma)==false){			
				$inscricao->alterarStatus('pendente');
				//\App\PessoaDadosAdministrativos::cadastrarUnico($inscricao->pessoa,'pendencia','Atestado médico vencido.');
				$inscricao->save();
				if(in_array($inscricao->pessoa,$itens) == false)
					$itens[] = $inscricao->pessoa->id;

			}
			//verifica se o atestado está vencido (1 ano)
			if($atestado->validar() == false){
				$atestado->status = 'vencido';
				$atestado->save();
				if(in_array($inscricao->pessoa,$itens) == false)
					$itens[] = $inscricao->pessoa->id;
				
			}

		}
		
		return $itens;

		

	}

	
}
