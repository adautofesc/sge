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

}
