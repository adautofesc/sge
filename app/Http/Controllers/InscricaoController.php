<?php

namespace App\Http\Controllers;

use App\Inscricao;
use App\Turma;
use App\Programa;
use App\Desconto;
use App\Pessoa;
use Illuminate\Http\Request;
use App\Atendimento;
use App\Classe;
use Session;

class InscricaoController extends Controller
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
    public function novaInscricao(){
        if(Session::get('pessoa_atendimento'))
            $id_pessoa=Session::get('pessoa_atendimento');
        else
            return redirect(asset('/secretaria/pre-atendimento'));
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));
        $str_turmas='';
        $turmas=collect();
        $incricoes_atuais=Inscricao::where('pessoa',Session::get('pessoa_atendimento'))->where('status', 'like','regular')->get();
        //->where('status','<>','cancelado')

        foreach($incricoes_atuais as $inscricao){
            $str_turmas=$str_turmas.','.$inscricao->turma->id;
            $turma=Turma::find($inscricao->turma->id);
            $turmas->push($turma);

        }

        

        //return $turmas;

        $pessoa=Pessoa::find($id_pessoa);
       
        $programas=Programa::all();
        return view('secretaria.inscricao.turmas',compact('turmas'))->with('programas',$programas)->with('pessoa',$pessoa)->with('str_turmas',$str_turmas);

    }

    /**
     * Verifica se a pessoa está Inscricaoda em um curso
     *
     * @param App\Pessoa $pessoa
     * @param App\Turma $turma
     * @return \Illuminate\Http\Response
     */
    public static function verificaSeInscrito($pessoa,$turma)
    {
        $existe=Inscricao::where('turma',$turma)->where('pessoa',$pessoa)->where('status','<>','cancelado')->get();
        if(count($existe)>0)
            return True;
        else
            return False;

    }
    /**
     * Mostra Turmas em que a pessoa está Inscricaoda
     *
     * @param App\Pessoa $pessoa
     * @param App\Turma $turma
     * @return \App\Turma
     */
    public function verTurmasAtuais($pessoa)
    {
        $turmas=collect();
        $Inscricaos_atuais=Inscricao::where('pessoa', $pessoa )->where('status', '<>','finalizado')->get();
        foreach($Inscricaos_atuais as $Inscricao){
            $turma=Turma::find($Inscricao->turma);
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
        $inscricoes=collect();
        if($request->pendente=='true'){
            $status='pendente';
        }
        else
            $status='regular';
        //return $status.'-'.$request->pendente;

        return $request;
        
        foreach($request->turmas as $turma_id){
            
            $inscricao=$this->inscreverAluno(Session::get('pessoa_atendimento'),$turma_id);
            $inscricoes->push($inscricao);

        }// fim foreach turmas

       $atendimento=Atendimento::find(Session::get('atendimento'));
        $atendimento->descricao="Inscricao(s)";
        $atendimento->save();

        Session::forget('atendimento');
        $pessoa=Pessoa::find(session('pessoa_atendimento'));



        //return $Inscricaos;
        return view("secretaria.inscricao.gravar")->with('inscricoes',$inscricoes)->with('nome',$pessoa->nome_simples);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inscricao  $Inscricao
     * @return \Illuminate\Http\Response
     */
    public function show(Inscricao $Inscricao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inscricao  $Inscricao
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscricao $Inscricao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inscricao  $Inscricao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscricao $Inscricao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inscricao  $Inscricao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscricao $Inscricao)
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
        $cursos=collect();
        $uati=0;

        //separa curso de disciplina, criando os lista de cursos e soma total
        foreach($turmas as $turma){
            if($turma->disciplina==null)
                $cursos->push($turma->curso);
            else{
                if(!$cursos->contains($turma->curso)){
                    $cursos->push($turma->curso);
                    if($turma->curso->id==307)
                        $uati++;
                    else
                        $valor=$valor+str_replace(',', '.',$turma->valor);

                    switch ($uati) {
                        case '1':
                            $valor=$valor+30;
                            break;
                        case '2':
                        case '3':
                            $valor=$valor+50;
                            break;
                        case 4:
                        case 5:
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                        case 10:
                            $valor=$valor+80;
                            break;

                    }
                    $valor=$valor+str_replace(',', '.',$turma->valor);

                }       
            }
        }

        //coloca turma dento da lista de curso atribui valor de cada curso
        foreach($cursos as $curso){
            $curso->turmas=collect();
            foreach($turmas as $turma){
                if($turma->curso->id==$curso->id)
                    $curso->turmas->push($turma);

            }
            if($curso->id==307){
                switch (count($curso->turmas)) {
                        case 1:
                            $curso->valor=100;
                            break;
                        case 2:
                        case 3:
                        case 4:
                            $curso->valor=250;
                            break;
                        case 5:
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                        case 10:
                            $curso->valor=400;
                            break;;

                    }

            }
            else{
                $curso->valor=$curso->turmas->first()->valor;
            }
            
           // $curso->valor=$curso->turma->valor;
        }
        $descontos=Desconto::all();



        //return $cursos;

        return view('secretaria.inscricao.confirma-atividades')->with('cursos',$cursos)->with('turmas',$turmas)->with('valor',$valor)->with('descontos',$descontos)->with('nome',$pessoa->nome_simples)->with('todas_turmas',$todas_turmas)->with('turmas_str',$request->atividades);

    }
    public static function inscreverAluno($aluno,$turma,$matricula=0){
        if(InscricaoController::verificaSeInscrito($aluno,$turma))
                return null;
        $inscricao=new Inscricao();
        $inscricao->pessoa=$aluno;
        if (Session::get('atendimento')>0)
            $inscricao->atendimento=Session::get('atendimento');
        else
            $inscricao->atendimento=1;
        $inscricao->turma=$turma;
        $inscricao->status='regular';
        $inscricao->matricula=$matricula;
        $inscricao->save();
        

        // aumenta Inscricaodos

        $turma=Turma::find($turma);
        TurmaController::modInscritos($turma->id,1,1);

        return $inscricao;

    }
    public function inscreverAlunoLote($turma,Request $r){
        $this->inscreverAluno($r->id_pessoa,$turma);
        return redirect(asset('/secretaria/turma/'.$turma));
    }
    public function apagar($id){
        $insc=Inscricao::find($id);
        if($insc==null)
            return die("Inscrição não encontrada");
        //return $insc->turma->id."teste";
        TurmaController::modInscritos($insc->turma->id,0,1);
        $insc->status='cancelado';
        $insc->save();
        return redirect(asset('/secretaria/turma/'.$insc->turma->id));

    }

}
