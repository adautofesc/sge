<?php

namespace App\Http\Controllers;

use App\Bolsa;
use Illuminate\Http\Request;

class BolsaController extends Controller
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
     * @param  \App\Bolsa  $bolsa
     * @return \Illuminate\Http\Response
     */
    public function show(Bolsa $bolsa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bolsa  $bolsa
     * @return \Illuminate\Http\Response
     */
    public function edit(Bolsa $bolsa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bolsa  $bolsa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bolsa $bolsa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bolsa  $bolsa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bolsa $bolsa)
    {
        //
    }
    /**
     * Gerador de Bolsas, para migração do sistema de bolsas em matriculas para bolsas independentes
     * @return [type] [description]
     */
    public function gerador(){
        //pegar todas matriculas com bolsa
        $matriculas = \App\Matricula::select(['id','desconto','curso','pessoa'])->whereIn('status',['ativa','pendente'])->where('desconto','>',0)->get();

        //Contador
       $bolsas_criadas = 0;

        foreach($matriculas as $matricula){

            //verifica se já tem bolsa para essa pessoa nesse curso
            $bolsa = Bolsa::select(['id'])->where('pessoa',$matricula->pessoa)->where('curso',$matricula->curso)->get();
            $inscricao = \App\Inscricao::select(['id','turma'])->where('matricula',$matricula->id)->first();
            //dd($inscricao);



            //se não tiver, criar uma nova
            if(count($bolsa)==0)
            {

                $bolsa = new Bolsa;
                $bolsa->pessoa = $matricula->pessoa;
                $bolsa->curso = $matricula->curso;
                $bolsa->desconto = $matricula->desconto;
                
                $bolsa->curso = $inscricao->turma->curso->id;
                $bolsa->programa = $inscricao->turma->programa->id;

                $bolsa->validade = '2018-12-31';
                $bolsa->obs = 'Bolsa gerada a partir das matrículas do 1º semestre';
                $bolsa->status = 'ativa';
                $bolsa->save();
                $bolsas_criadas++;

            }
        }
        return "Foram geradas ".$bolsas_criadas. " bolsas a partir de matrículas do 1º semestre";
        
    }
    public static function verificaBolsa($pessoa,$curso){
        $bolsa = Bolsa::where('pessoa',$pessoa)->where('curso',$curso)->where('status','ativa')->first();
        //die('teste');
        //
        //dd($bolsa);
        if($bolsa)
            return $bolsa->desconto;
        else
            return null;


    }
}
