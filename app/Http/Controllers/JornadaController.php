<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jornada;
use Auth;

class JornadaController extends Controller
{
    public function cadastrar(Request $r)
    {
        $r->validate([
            'pessoa => required|number'
        ]);
        $jornada = new Jornada;
        $jornada->pessoa = $r->pessoa;
        $jornada->sala = $r->sala;
        $jornada->dias_semana = $r->dias;
        $jornada->hora_inicio = $r->hr_inicio;
        $jornada->hora_termino = $r->hr_termino;
        $jornada->inicio = $r->dt_inicio;
        $jornada->tipo = $r->tipo;
        $jornada->status = 'solicitada';
        if(in_array('17', Auth::user()->recursos))
            $jornada->status = 'ativa';

        $jornada->save();


        return redirect()->back()->with('success','Jornada cadastrada com sucesso.');

    }
}
