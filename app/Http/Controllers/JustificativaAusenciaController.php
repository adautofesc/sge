<?php

namespace App\Http\Controllers;
use App\Pessoa;
use App\JustificativaAusencia;
use Illuminate\Http\Request;

class JustificativaAusenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pessoa = 0)
    {
        if($pessoa>0){
            $justificativas = JustificativaAusencia::where('pessoa',$pessoa)->orderByDesc('inicio')->paginate(50);
            $pessoa = Pessoa::find($pessoa);
         
        }else {
            $justificativas = JustificativaAusencia::orderByDesc('inicio')->paginate(50);
            $pessoa = null;
        }

        return view('justificativa-ausencias.index')->with('justificativas',$justificativas)->with('pessoa',$pessoa);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JustificativaAusencia  $justificativaAusencia
     * @return \Illuminate\Http\Response
     */
    public function show(JustificativaAusencia $justificativaAusencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JustificativaAusencia  $justificativaAusencia
     * @return \Illuminate\Http\Response
     */
    public function edit(JustificativaAusencia $justificativaAusencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JustificativaAusencia  $justificativaAusencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JustificativaAusencia $justificativaAusencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JustificativaAusencia  $justificativaAusencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(JustificativaAusencia $justificativaAusencia)
    {
        //
    }
}
