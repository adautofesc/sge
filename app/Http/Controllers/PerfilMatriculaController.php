<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Turma;
use App\Inscricao;

class PerfilMatriculaController extends Controller
{
    //
    public function matriculasAtivas(Request $r){
        $matriculas = \App\Matricula::where('pessoa',$r->pessoa->id)->whereIn('status',['ativa','pendente','espera'])->get();
        foreach($matriculas as $matricula){
            $matricula->getInscricoes();
        }
        //dd($matriculas);
        return view('perfil.matriculas.matriculas')->with('pessoa',$r->pessoa)->with('matriculas',$matriculas);
    }
    public function turmasDisponiveis(Request $r){

        $turmas = Turma::where('status','inscricao')->get();
        foreach($turmas as $turma){
            $turma->nomeCurso = $turma->getNomeCurso();
        }
        $turmas = $turmas->sortBy('nomeCurso');
        
        //dd($turmas);
        return view('perfil.matriculas.turmas-disponiveis')->with('turmas',$turmas)->with('pessoa',$r->pessoa);

    }
    public function confirmacao(Request $r){
        if($r->turma == null)
            return redirect()->back()->withErrors(['Escolha pelo menos uma turma']);

        $turmas = Turma::whereIn('id',$r->turma)->get();
        return view('perfil.matriculas.turmas-confirma')->with('turmas',$turmas)->with('pessoa',$r->pessoa);
        
    }

    public function inscricao(Request $r){
        if($r->turma == null)
            return redirect()->back()->withErrors(['Escolha pelo menos uma turma']);

        $ip='';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip .='|'. $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip .='|'. $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip .='|'. $_SERVER['REMOTE_ADDR'];

        }

        foreach($r->turma as $turma){
            echo 'inscrito em '.$turma.'<br>'."\n";
            $inscricao=InscricaoController::inscreverAluno($r->pessoa->id,$turma,0,$r->pessoa->id);
            if($inscricao){
                        
                $matricula = \App\Matricula::find($inscricao->matricula);
                $matricula->obs = 'Matricula online. IP: '.$ip;
                $matricula->save();
            }

        }

        //gerar carnê

        // devo cancelar todos boletos anteriores?
        $CC = new CarneController;
        $CC->gerarCarneIndividual($r->pessoa->id);
        $boletos = \App\Boleto::where('pessoa',$pessoa->id)->where('status','gravado')->get();
        foreach($boletos as $boleto){
            $boleto->status = 'impresso';
            $boleto->save();
        }

        return redirect('/perfil/matricula');
        
        //confirmar que são essas turmas e aceitar o termo
        //inscrever pessoa (verificar se já não inscrita antes)
        //gerar boleto
        //cadastrar pessoa no Outlook
        //Inscrever pessoa nas turmas do Teams
        //inscrever pessoa nas turmas do Moodle
    }

    public function cancelar(Request $r, $matricula){
        $insc = \App\Matricula::find($matricula);
        if($insc==null)
            return redirect()->back()->withErrors(['Inscrição não encontrada']);
        else{
            if($insc->pessoa == $r->pessoa->id){
                MatriculaController::cancelar($matricula,$insc->pessoa);
                AtendimentoController::novoAtendimento("Auto cancelamento online da matrícula ".$insc->id, $insc->pessoa,$insc->pessoa);
                return redirect('/perfil/matricula');

            }
                
            else 
                return redirect()->back()->withErrors(['Inscrição não vinculada a este usuário.']);  
        }

    }

    //
}
