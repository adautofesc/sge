<?php

namespace App\Http\Controllers;

use App\Matricula;
use App\Turma;
use App\Programa;
use App\Desconto;
use App\Pessoa;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function novaMatricula($id_pessoa){
        $turmas=Turma::orderBy('curso')->get();
        $pessoa=Pessoa::find($id_pessoa);
       
        $programas=Programa::all();
        return view('secretaria.matricula.turmas',compact('turmas'))->with('programas',$programas)->with('pessoa',$pessoa);

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
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function show(Matricula $matricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function edit(Matricula $matricula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matricula $matricula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Matricula  $matricula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matricula $matricula)
    {
        //
    }

    public function confirmacaoAtividades(Request $request){
        $valor=0;
        $turmas=TurmaController::csvTurmas($request->atividades);
        foreach($turmas as $turma){
            $valor=$valor+str_replace(',', '.',$turma->valor);
        }
        $descontos=Desconto::all();

        //return $turmas;

        return view('secretaria.matricula.confirma-atividades')->with('turmas',$turmas)->with('valor',$valor)->with('descontos',$descontos);

    }
}
