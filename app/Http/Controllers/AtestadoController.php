<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atestado;
use Session;

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
		$arquivo = $r->file('arquivo');
        if (!empty($arquivo)) {
        		$atestado = new Atestado;
				$atestado->pessoa = $r->pessoa;
				$atestado->validade = $r->validade;
				$atestado->atendente = session('usuario');
				$atestado->save();
                $arquivo->move('documentos/atestados/', $atestado->id.'.pdf');
        }
        else
        	return redirect()->back()->withErrors(['Atestado não gravado: arquivo nulo/vazio.']);
        

        return redirect('/secretaria/atender/'.$r->pessoa)->withErrors(['Atestado cadastrado com sucesso.']);


	}
	public function listar(){
		$atestados = Atestado::orderBy('validade','desc')->paginate(50);
		foreach($atestados as $atestado){
			$atestado->pessoa = \App\Pessoa::getNome($atestado->pessoa);
			$atestado->validade = \Carbon\Carbon::parse($atestado->validade)->format('d/m/Y');
			$atestado->cadastrado = \Carbon\Carbon::parse($atestado->created_at)->format('d/m/Y');
			$atestado->por = \App\Pessoa::getNome($atestado->atendente);
		}
		return view('pessoa.dados-clinicos.listar',compact('atestados'));
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
			$atestado->validade = $r->validade;
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
}
