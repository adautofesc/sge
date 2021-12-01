<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atestado;
use Auth;

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

		return view('pessoa.dados-clinicos.cadastrar-atestado',compact('pessoa'));
	}
	public function create(Request $r){
		if(substr($r->emissao,0,4)<(date('Y')-1))
			return redirect()->back()->withErrors(['Digite o ano com 4 algarismos']);
		
		if(isset($r->validade) && substr($r->validade,0,4)<(date('Y')-1))
			return redirect()->back()->withErrors(['Digite o ano com 4 algarismos']);    


		$arquivo = $r->file('arquivo');
		$atestado = new Atestado;
				$atestado->pessoa = $r->pessoa;
				$atestado->tipo = $r->tipo;
				$atestado->emissao = $r->emissao;
				$atestado->validade = $r->validade;
				$atestado->atendente = Auth::user()->pessoa;
				$atestado->status = 'aprovado';
				$atestado->save();
        if (!empty($arquivo)) {	
                $arquivo->move('documentos/atestados/', $atestado->id.'.pdf');
        }
      
        

        return redirect('/secretaria/atender/'.$r->pessoa)->withErrors(['Atestado '.$atestado->id.' cadastrado com sucesso.']);


	}
	public function listar(){
		$atestados = Atestado::where('status','analisando')->orderByDesc('id')->paginate(50);
		foreach($atestados as $atestado){
			$atestado->pessoa = \App\Pessoa::getNome($atestado->pessoa);
			$atestado->emissao = \Carbon\Carbon::parse($atestado->emissao)->format('d/m/Y');
			$atestado->validade = \Carbon\Carbon::parse($atestado->validade)->format('d/m/Y');
			$atestado->cadastro = \Carbon\Carbon::parse($atestado->created_at)->format('d/m/Y H:i');
		}
		//dd($atestados);
		return view('pessoa.dados-clinicos.listar',compact('atestados'));
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

			return view('pessoa.dados-clinicos.editar-atestado')->with('atestado',$atestado)->with('pessoa',$pessoa);
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
				 
			$atestado->emissao = $r->emissao;
			$atestado->tipo = $r->tipo;
			$atestado->save();
			$arquivo = $r->file('arquivo');
       		if (!empty($arquivo)) {
       			$arquivo->move('documentos/atestados/', $atestado->id.'.pdf');
       		}
       		return redirect()->back()->withErrors(['Atestado atualizado.']);
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
			//$atestado->validade = \Carbon\Carbon::parse($atestado->validade)->format('d/m/Y');
			$pessoa=\App\Pessoa::find($atestado->pessoa);
			$pessoa=PessoaController::formataParaMostrar($pessoa);
			if(isset($pessoa->telefone))
				$pessoa->telefone=\App\classes\Strings::formataTelefone($pessoa->telefone);
			if(isset($pessoa->telefone_alternativo))
				$pessoa->telefone_alternativo=\App\classes\Strings::formataTelefone($pessoa->telefone_alternativo);
			if(isset($pessoa->telefone_contato))
				$pessoa->telefone_contato=\App\classes\Strings::formataTelefone($pessoa->telefone_contato);
			$atestado->emissao = \Carbon\Carbon::parse($atestado->emissao)->format('d/m/Y');

			return view('pessoa.dados-clinicos.analisar-atestado')->with('atestado',$atestado)->with('pessoa',$pessoa);
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
				LogController::registrar('atestado',$id,'Atestado aprovado.', Auth::user()->pessoa);
				if($atestado->tipo == 'vacinacao')					
					PessoaDadosAdminController::liberarPendencia($atestado->pessoa,'Atestado de vacinação aprovado.');
				if($atestado->tipo == 'saude')					
					PessoaDadosAdminController::liberarPendencia($atestado->pessoa,'Atestado de saúde aprovado.');
				
			}
			if($r->status == 'recusado'){
				LogController::registrar('atestado',$id,'Atestado RECUSADO: '."\n".$r->obs, Auth::user()->pessoa);
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
		return redirect("/pessoa/atestado/listar")->withErrors(['Atestado '.$atestado->id.' avaliado.']);
		}
		else
		 return redirect()->back()->withErrors(['Atestado não encontrado.']);

	}

	public static function verificaParaInscricao(int $pessoa, \App\Turma $turma){
		$vacinacao = Atestado::where('pessoa',$pessoa)->where('tipo','vacinacao')->where('status','aprovado')->first();
		if(!$vacinacao){
			
			\App\PessoaDadosAdministrativos::cadastrarUnico($pessoa,'pendencia','Falta atestado de vacinação aprovado.');
			
			
			return false;
		}
		

		$requisito_curso = \App\CursoRequisito::where('para_tipo','curso')->where('curso',$turma->curso)->where('requisito',18)->first();
		$requisito_turma = \App\CursoRequisito::where('para_tipo','turma')->where('curso',$turma->id)->where('requisito',18)->first();
		if($requisito_curso || $requisito_turma){
			$saude =  Atestado::where('pessoa',$pessoa)->where('tipo','saude')->where('status','aprovado')->first();
			if(!$saude){
				\App\PessoaDadosAdministrativos::cadastrarUnico($pessoa,'pendencia','Falta atestado de saúde aprovado.');	
				return false;
			}

		}

		return true;		

	}
}
