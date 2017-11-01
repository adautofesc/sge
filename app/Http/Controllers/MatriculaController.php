<?php

namespace App\Http\Controllers;

use App\Matricula;
use App\Turma;
use App\Programa;
use App\Desconto;
use App\Pessoa;
use Illuminate\Http\Request;
use App\Atendimento;
use App\Classe;
use Session;

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
    public function novaMatricula(){
        if(Session::get('pessoa_atendimento'))
            $id_pessoa=Session::get('pessoa_atendimento');
        else
            return redirect(asset('/secretaria/pre-atendimento'));
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));
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
    public function gravar(Request $request)
    {
        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));
        $matriculas=collect();
        foreach($request->turmas as $turma_id){
            $matricula=new Matricula();
            $matricula->pessoa=Session::get('pessoa_atendimento');
            $matricula->atendimento=Session::get('atendimento');
            $matricula->forma_pgto="b";
            $parcelas="nparcelas".$turma_id;
            $matricula->parcelas=$request->$parcelas;
            $venc="dvencimento".$turma_id;
            $matricula->dia_venc=$request->$venc;
            $matricula->save();
            $matriculas->push($matricula);

            /*foreach($parcelas as $parcela){
                // grava cada parcela em lançamentos
                //grava dados financeiros
            }-*/

            // Coloca nome do aluno na lista de chamada
            $classe= new Classe();
            $classe->matricula=$matricula->id;
            $classe->turma=$turma_id;
            $classe->save();

            // Reduz o numero de vagas
            $turma=Turma::find($turma_id);
            $turma->vagas=$turma->vagas-1;
            $turma->save();





           



        }// fim foreach turmas

        $atendimento=Atendimento::find(Session::get('atendimento'));
        $atendimento->descricao="Matricula(s)";
        $atendimento->save();

        Session::forget('atendimento');
        $pessoa=Pessoa::find(session('pessoa_atendimento'));



        return $matriculas;
        return view("secretaria.matricula.gravar")->with('matriculas',$matriculas)->with('nome',$pessoa->nome_simples);

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

        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));
        
        $pessoa=Pessoa::find(Session::get('pessoa_atendimento'));
        $valor=0; 

        $turmas=TurmaController::csvTurmas($request->atividades);
        foreach($turmas as $turma){
            $valor=$valor+str_replace(',', '.',$turma->valor);
        }
        $descontos=Desconto::all();



        //return $turmas;

        return view('secretaria.matricula.confirma-atividades')->with('turmas',$turmas)->with('valor',$valor)->with('descontos',$descontos)->with('nome',$pessoa->nome_simples);

    }
}
