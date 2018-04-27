<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atestado;

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

		return view('pessoa.cadastrar-atestado',compact('pessoa'));
	}
	public function create(Request $r){
		$arquivo = $r->file('arquivo');
        if (!empty($arquivo)) {
        		$atestado = new Atestado;
				$atestado->pessoa = $r->pessoa;
				$atestado->validade = $r->validade;
				$atestado->save();
                $arquivo->move('documentos/atestados/', $atestado->id.'.pdf');
        }
        else
        	return redirect()->back()->withErrors(['Atestado não gravado: arquivo nulo/vazio.']);
        

        return redirect('/secretaria/atender/'.$r->pessoa)->withErrors(['Atestado cadastrado com sucesso.']);


	}
    //
}
