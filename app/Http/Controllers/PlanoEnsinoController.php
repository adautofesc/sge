<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaDadosAdministrativos;
use App\PlanoEnsino;
use App\PlanoEnsinoDados;
use App\Programa;

class PlanoEnsinoController extends Controller
{
    public function index(Request $r){

        return view('plano-ensino.home');
    }

    public function create(){
        $semestres = \App\classes\Data::semestres();
        $professores = PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
        $programas = Programa::all()->sortBy('nome');
        return view('plano-ensino.cadastrar')
            ->with('professores',$professores)
            ->with('semestres',$semestres)
            ->with('programas',$programas);
    }

    public function store(Request $r){
        $plano = new PlanoEnsino;
        $plano->docente = $r->professor;
        $plano->curso = $r->curso;
        $plano->carga = $r->carga;
        $plano->periodo = substr($r->periodo,0,1);
        $plano->ano = substr($r->periodo,1,4);
        $plano->status = 'analise';
        $plano->save();

        if(isset($r->habilidades_gerais) && $plano->id){
            foreach($r->habilidades_gerais as $habilidade){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'habilidade_geral';
                $dado->conteudo = $habilidade;
                $dado->save();
            }
        }

        if(isset($r->habilidades_especificas) && $plano->id){
            foreach($r->habilidades_especificas as $habilidade){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'habilidade_especifica';
                $dado->conteudo = $habilidade;
                $dado->save();
            }
        }

        if(isset($r->objetivos) && $plano->id){
            foreach($r->objetivos as $objetivo){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'objetivo';
                $dado->conteudo = $objetivo;
                $dado->save();
            }
        }

        if(isset($r->conteudos_programaticos) && $plano->id){
            foreach($r->conteudos_programaticos as $conteudo_programatico){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'conteudo_programatico';
                $dado->conteudo = $conteudo_programatico;
                $dado->save();
            }
        }

        if(isset($r->procedimentos_ensino) && $plano->id){
            foreach($r->procedimentos_ensino as $procedimento_ensino){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'procedimento_ensino';
                $dado->conteudo = $procedimento_ensino;
                $dado->save();
            }
        }

        if(isset($r->instrumentos_avaliacao) && $plano->id){
            foreach($r->instrumentos_avaliacao as $instrumento_avaliacao){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'instrumento_avaliacao';
                $dado->conteudo = $instrumento_avaliacao;
                $dado->save();
            }
        }

        if(isset($r->bibliografia) && $plano->id){
            foreach($r->bibliografia as $bibliografia){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'bibliografia';
                $dado->conteudo = $bibliografia;
                $dado->save();
            }
        }

        if(isset($r->atividades) && $plano->id){
            foreach($r->atividades as $atividade){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'bibliografia';
                $dado->conteudo = $atividade;
                $dado->save();
            }
        }



        
    }
}
