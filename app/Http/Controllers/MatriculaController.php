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
    // Pega todas inscrições sem matricula e atribui matriculas pra elas
    public function autoMatriculas(){
        $resultado=array();
        $inscricoes=Inscricao::where('status','<>','cancelado')->where('matricula', null)->orWhere('matricula','=','0')->get();
        foreach($inscricoes as $inscricao){
            if($inscricao->turma->curso->id == 307){
                $insc_com_mat=Inscricao::select('*', 'inscricoes.id as id', 'turmas.id as turmaid')
                    ->leftjoin('turmas', 'inscricoes.turma','=','turmas.id')
                    ->where('inscricoes.pessoa',$inscricao->pessoa->id)
                    ->where('turmas.curso','307')
                    ->where('inscricoes.matricula','>',0)
                    ->get();
                if(count($insc_com_mat)==0){
                    
                    $matricula=new Matricula();
                    $matricula->pessoa=$inscricao->pessoa->id;
                    $matricula->atendimento=1;
                    $matricula->data=date('Y-m-d');
                    $matricula->parcelas=5;
                    $matricula->dia_venc=20;
                    $matricula->status="ativa";
                    $matricula->valor=100;
                    $matricula->save();

                    //adiciona ela na inscrição
                    $inscricao->matricula=$matricula->id;
                    $inscricao->save();
                    //
                    $resultado[]= "Criada nova matrúcula: ". $matricula->id;
                }
                else{
                    //atualiza valor da matricula
                    $matricula=Matricula::find($insc_com_mat->first()->matricula);
                    switch (count($insc_com_mat)) {
                        case 1:
                            $matricula->valor=100;
                            break;
                        case 2:
                        case 3:
                        case 4:
                            $matricula->valor=250;
                            break;
                        case 5:
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                        case 10:
                            $matricula->valor=400;
                            break;;
                    }
                    $matricula->save();

                    //adiciona ela na inscrição
                    $inscricao->matricula=$matricula->id;
                    $inscricao->save();
                    //
                     $resultado[]= "Matricula ".$matricula->id." atualizada";
                }


            }
            else{
                $turma=Turma::find($inscricao->turma->id);
                $matricula=new Matricula();
                $matricula->pessoa=$inscricao->pessoa->id;
                $matricula->atendimento=1;
                $matricula->data=date('Y-m-d');
                $matricula->parcelas=5;
                $matricula->dia_venc=20;
                $matricula->status="ativa";
                $matricula->valor=$turma->valor;
                $matricula->save();
                $inscricao->matricula=$matricula->id;
                $resultado[]= "Criada matricula ".$matricula." para a inscricao de cursos id ".$inscricao->id;
            }

        }

        return $resultado;



    }
}
