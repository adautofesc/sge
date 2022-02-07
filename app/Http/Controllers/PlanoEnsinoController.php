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
        $plano->carga = $r->carga;;
        $plano->periodo = substr($r->periodo,0,1);
        $plano->ano = substr($r->periodo,1,4);
        $plano->save();

        if(isset($r->habilidades_gerais) && $plano->id){
            foreach($r->habilidades_gerais as $habilidade){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'habilidades_gerais';
                $dado->conteudo = $habilidade;
                $dado->save();
            }
        }

        if(isset($r->habilidades_especificas) && $plano->id){
            foreach($r->habilidades_especificas as $habilidade){
                $dado = new PlanoEnsinoDados;
                $dado->plano = $plano->id;
                $dado->dado = 'habilidades_especificas';
                $dado->conteudo = $habilidade;
                $dado->save();
            }
        }

        
    }
}
