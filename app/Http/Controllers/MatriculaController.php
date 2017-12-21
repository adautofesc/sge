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
        $str_turmas='';
        $turmas=collect();
        $matriculas_atuais=Matricula::where('pessoa',Session::get('pessoa_atendimento'))->where('status', '<>','finalizado')->get();
        foreach($matriculas_atuais as $matricula){
            $str_turmas=$str_turmas.','.$matricula->turma;
            $turma=Turma::find($matricula->turma);
            $turmas->push($turma);

        }

        

        //return $turmas;

        $pessoa=Pessoa::find($id_pessoa);
       
        $programas=Programa::all();
        return view('secretaria.matricula.turmas',compact('turmas'))->with('programas',$programas)->with('pessoa',$pessoa)->with('str_turmas',$str_turmas);

    }

    /**
     * Verifica se a pessoa está matriculada em um curso
     *
     * @param App\Pessoa $pessoa
     * @param App\Turma $turma
     * @return \Illuminate\Http\Response
     */
    public function verificaSeMatriculado($pessoa,$turma)
    {
        $existe=Matricula::where('turma',$turma)->where('pessoa',$pessoa)->get();
        if(count($existe)>0)
            return True;
        else
            return False;

    }
    /**
     * Mostra Turmas em que a pessoa está matriculada
     *
     * @param App\Pessoa $pessoa
     * @param App\Turma $turma
     * @return \App\Turma
     */
    public function verTurmasAtuais($pessoa)
    {
        $turmas=collect();
        $matriculas_atuais=Matricula::where('pessoa', $pessoa )->where('status', '<>','finalizado')->get();
        foreach($matriculas_atuais as $matricula){
            $turma=Turma::find($matricula->turma);
            $turmas->push($turma);

        }
        return $turmas;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gravar(Request $request)
    {
        //return $request->pendente;
        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));
        $matriculas=collect();
        if($request->pendente=='true'){
            $status='pendente';
        }
        else
            $status='regular';
        //return $status.'-'.$request->pendente;
        
        foreach($request->turmas as $turma_id){
            if($this->verificaSeMatriculado(Session::get('pessoa_atendimento'),$turma_id))
                continue;

            $matricula=new Matricula();
            $matricula->pessoa=Session::get('pessoa_atendimento');
            $matricula->atendimento=Session::get('atendimento');
            $parcelas="nparcelas".$turma_id;
            $matricula->parcelas=$request->$parcelas;
            $venc="dvencimento".$turma_id;
            $matricula->dia_venc=$request->$venc;
            $matricula->turma=$turma_id;
            $matricula->status=$status;
            $matricula->save();
            $matriculas->push($matricula);

            /*foreach($parcelas as $parcela){
                // grava cada parcela em lançamentos
                //grava dados financeiros
            }-*/

            // aumenta matriculados

            $turma=Turma::find($turma_id);
            $turma->matriculados=$turma->matriculados+1;
            $turma->save();


        }// fim foreach turmas

       $atendimento=Atendimento::find(Session::get('atendimento'));
        $atendimento->descricao="Matricula(s)";
        $atendimento->save();

        Session::forget('atendimento');
        $pessoa=Pessoa::find(session('pessoa_atendimento'));



        //return $matriculas;
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
        $todas_turmas=TurmaController::csvTurmas($request->atividades.$request->turmas_anteriores);
        $turmas=TurmaController::csvTurmas($request->atividades);
        foreach($turmas as $turma){
            $valor=$valor+str_replace(',', '.',$turma->valor);
        }
        $descontos=Desconto::all();



        //return $turmas;

        return view('secretaria.matricula.confirma-atividades')->with('turmas',$turmas)->with('valor',$valor)->with('descontos',$descontos)->with('nome',$pessoa->nome_simples)->with('todas_turmas',$todas_turmas);

    }
}
