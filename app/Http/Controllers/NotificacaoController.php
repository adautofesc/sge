<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    
    public function cadastrar(Request $r){
        $notificacao = $this->gerar($r->origem,$r->destino,$r->assunto,$r->tipo,$r->mensagem);
        return "notificação cadastrada com sucesso";

    }

    public function gerar($origem,$destino,$assunto,$tipo,$mensagem){
        $notificacao = new Notificacao;
        $notificacao->de = $origem;
        $notificacao->para = $destino;
        $notificacao->dado = $assunto;
        $notificacao->tipo = $tipo;
        $notificacao->valor = $mensagem;
        $notificacao->save();
        return $notificacao;

    }

    public static function notificarErro($pessoa,$erro){
		//Erros 1 = CPF, 2 = Endereço, 3 = Atestado vencido, 4 = telefone, 5 - gerar boleto, 6 - enviar remessa

		switch($erro){
			case 1:
				$dados = \App\PessoaDadosGerais::where('pessoa',$pessoa)
					->where('dado',20)
					->where('valor','CPF não foi aprovado pelo validador.')
					->get();
				$dado = 'CPF não foi aprovado pelo validador.';
			break;
			case 2:
				$dados = \App\PessoaDadosGerais::where('pessoa',$pessoa)
					->where('dado',20)
					->where('valor','Endereço inválido ou insuficiente.')
					->get();
				$dado = 'Endereço inválido ou insuficiente.';
			break;
			case 3:
				$dados = \App\PessoaDadosGerais::where('pessoa',$pessoa)
					->where('dado',20)
					->where('valor','Atestado médico vencido ou ausente.')
					->get();
				$dado = 'Atestado médico vencido ou ausente.';
			break;
			case 4:
				$dados = \App\PessoaDadosGerais::where('pessoa',$pessoa)
					->where('dado',20)
					->where('valor','Nenhum telefone válido.')
					->get();
				$dado = 'Nenhum telefone válido.';
			break;
			default:
				$dados = \App\PessoaDadosGerais::where('pessoa',$pessoa)
					->where('dado',20)
					->where('valor',$erro)
					->get();
				$dado = $erro;
			break;
		}
		
		if(count($dados) == 0){
			$erro = new \App\PessoaDadosGerais;
            $erro->pessoa = $pessoa;
            $erro->dado = 20;
            $erro->valor= $dado;
            $erro->save();
		}

	}

}
