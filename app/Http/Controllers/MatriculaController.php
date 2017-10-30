<?php

namespace App\Http\Controllers;

use App\Matricula;
use App\Turma;
use App\Programa;
use App\Desconto;
use App\Pessoa;
use Illuminate\Http\Request;
use App\Atendimento;

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
        if(isset($_COOKIE['pessoa_atendimento']))
            $id_pessoa=$_COOKIE['pessoa_atendimento'];
        else
            return redirect(asset('/secretaria/pre-atendimento'));
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
        if(!isset($_COOKIE['pessoa_atendimento']))
            return redirect(asset('/secretaria/pre-atendimento'));
        $matriculas=collect();
        foreach($request->turmas as $turma){
            $matricula=new Matricula();
            $matricula->pessoa=$_COOKIE['pessoa_atendimento'];
            $matricula->atendimento=$_COOKIE['atendimento'];
            $matricula->forma_pgto="b";
            $parcelas="nparcelas".$turma;
            $matricula->parcelas=$request->$parcelas;
            $venc="dvencimento".$turma;
            $matricula->dia_venc=$request->$venc;
            $matricula->save();
            $matriculas->push($matricula);

        }

        $atendimento=Atendimento::find($_COOKIE['atendimento']);
        $atendimento->descricao="Matricula(s)";
        $atendimento->save();

        if(isset($_COOKIE['atendimento'])){
            
            setcookie('atendimento',null,time()-3600,"/atendimento");
            unset($_COOKIE['atendimento']);
        }



        return $matriculas;

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
        if(!isset($_COOKIE['pessoa_atendimento'])){
            return redirect(asset('/secretaria/pre-atendimento'));

        }
        $pessoa=Pessoa::find($_COOKIE['pessoa_atendimento']);
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
