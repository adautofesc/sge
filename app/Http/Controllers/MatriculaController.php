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
use App\Inscricao;
use Session;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *it
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function gravar(Request $r){
        $matriculas=collect();
        $cursos=collect();
        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));

        $turmas=TurmaController::csvTurmas($r->turmas);
        foreach($turmas as $turma){
            if($turma->disciplina==null)
                $cursos->push($turma->curso);
            else{
                if(!$cursos->contains($turma->curso))
                    $cursos->push($turma->curso);
            }
        }
        foreach($cursos as $curso){
            $curso->turmas=collect();
            foreach($turmas as $turma){
                if($turma->curso->id==$curso->id)
                    $curso->turmas->push($turma);
            } 
            $matricula=new Matricula();
            $matricula->pessoa=Session::get('pessoa_atendimento');
            $matricula->atendimento=Session::get('atendimento');
            $matricula->data=date('Y-m-d');
            $valor="valorcursointegral".$curso->id;
            $matricula->valor=$r->$valor*1;
            $parcelas="nparcelas".$curso->id;
            $matricula->parcelas=$r->$parcelas;
            $dia_vencimento="dvencimento".$curso->id;
            $matricula->dia_venc=$r->$dia_vencimento;
            $matricula->status="ativa";
            $desconto="fdesconto".$curso->id;
            $matricula->desconto=$r->$desconto;
            $valordesconto="valordesconto".$curso->id;
            $matricula->valor_desconto=$r->$valordesconto*1;
            $matricula->save();
            $matriculas->push($matricula);

            foreach($curso->turmas as $cturma){
                if(InscricaoController::inscreverAluno(Session::get('pessoa_atendimento'),$cturma->id,$matricula->id)==null)
                    die("Erro ao increver ".Session::get('pessoa_atendimento')." em ".$cturma->id);
               
            }
   
        }
       

        $atendimento=Atendimento::find(Session::get('atendimento'));
        $atendimento->descricao="Matricula ";
        $atendimento->save();

        Session::forget('atendimento');
        $pessoa=Pessoa::find(session('pessoa_atendimento'));

        //return $Inscricaos;
        return view("secretaria.inscricao.gravar")->with('matriculas',$matriculas)->with('nome',$pessoa->nome_simples);

    }
    public function termo($matricula){
        $matricula=Matricula::find($matricula);
        if(!$matricula)
            return view("error-404");
        $pessoa=Pessoa::find($matricula->pessoa);
        $pessoa=PessoaController::formataParaMostrar($pessoa);
        
        $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->get();
        foreach($inscricoes as $inscricao){
            $inscricao->turmac=Turma::find($inscricao->turma->id);
        }

        //return $pessoa;

        return view("juridico.documentos.termo",compact('matricula'))->with('pessoa',$pessoa)->with('inscricoes',$inscricoes);

    }
    public function declaracao($matricula){
        $matricula=Matricula::find($matricula);
        if(!$matricula)
            return view("error-404");
        $pessoa=Pessoa::find($matricula->pessoa);
        $pessoa=PessoaController::formataParaMostrar($pessoa);
        
        $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->get();
        foreach($inscricoes as $inscricao){
            $inscricao->turmac=Turma::find($inscricao->turma->id);
        }

        //return $pessoa;

        return view("juridico.documentos.declaracao",compact('matricula'))->with('pessoa',$pessoa)->with('inscricoes',$inscricoes);
        
    }
}
