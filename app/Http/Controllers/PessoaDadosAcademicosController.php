<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaDadosAcademicos;

class PessoaDadosAcademicosController extends Controller
{
    public function registrarEmailFesc($pessoa,$email){
        $reg = new PessoaDadosAcademicos;
        $reg->pessoa = $pessoa;
        $reg->dado = 'email_fesc';
        $reg->valor = $email;
        $reg->save();
        return response('ok',200);
    }

    public function apagarEmailFesc($id){
        $reg = PessoaDadosAcademicos::destroy($id);
        return response('ok',200);
    }

    public function inscreverTeams($pessoa,$turma){
        $reg = new PessoaDadosAcademicos;
        $reg->pessoa = $pessoa;
        $reg->dado = 'equipe_teams';
        $reg->valor = $turma;
        $reg->save();
        return response('ok',200);
    }

    public function removerTeams($id){
        $reg = PessoaDadosAcademicos::destroy($id);
        return response('ok',200);
    }
}
