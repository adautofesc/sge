<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscricao;
use App\Turma;

class WebServicesController extends Controller
{


    public function apiChamada($id){
	    $inscritos=\App\Inscricao::where('turma',$id)->where('status','<>','cancelado')->get();
	    $inscritos= $inscritos->sortBy('pessoa.nome');
	    return $inscritos;
    }


    public function apiTurmas(){
        $turmas = Turma::where('status','>',0)->get();
        return $turmas;
    }
}
