<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaDadosAdministrativos;

class PessoaDadosAdmin extends Controller
{
    //
    public function excluir($ri){
    	PessoaDadosAdministrativos::destroy($ri);
    	return redirect()->back()->withErrors(['Relação removida com sucesso.']);

    }
}
