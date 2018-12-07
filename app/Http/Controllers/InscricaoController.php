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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class InscricaoController extends Controller
{
    /**
     * Edição de Inscrição
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editar($id){
         $inscricao = Inscricao::find($id);
        $matriculas = \App\Matricula::where('pessoa',$inscricao->pessoa->id)->whereIn('status',['ativa','pendente','espera'])->get();
        return view('secretaria.inscricao.editar',compact('inscricao'))->with('matriculas',$matriculas);
    }



    /**
     * Criar nova inscrição
     * @param  [type] $id_pessoa [description]
     * @return [type]            [description]
     */
    public function novaInscricao($id_pessoa){

        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));
        $str_turmas='';
        $turmas=collect();
        $incricoes_atuais=Inscricao::where('pessoa',$id_pessoa)->where('status', '<>','cancelada')->get();
        foreach($incricoes_atuais as $inscricao){
            $str_turmas=$str_turmas.','.$inscricao->turma->id;
            $turma=Turma::find($inscricao->turma->id);
            $turmas->push($turma);
        }
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
        $existe=Inscricao::where('turma',$turma)->where('pessoa',$pessoa)->where('status','<>','cancelada')->get();
        if(count($existe))
            return $existe->first()->id;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inscricao  $Inscricao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $inscricao = $request->inscricao;
        $inscricao = Inscricao::find($inscricao);
        if($inscricao != null){
            $inscricao->matricula = $request->matricula;
            $inscricao->save();
            AtendimentoController::novoAtendimento("Inscrição ".$inscricao->id." modificada para matrícula ".$inscricao->matricula.".", $inscricao->pessoa->id, Session::get('usuario'));

            return redirect(asset('/secretaria/atender/'));
        }
        else
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Matricula inválida.']);

    }

    public function confirmacaoAtividades(Request $request){

       
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/inicio-atendimento'));
        
        $pessoa=Pessoa::find($request->pessoa);
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
                }       
            }
            $turma->requisitos = \App\CursoRequisito::where('para_tipo','turma')->where('curso',$turma->id)->get();
        }

        //coloca turma dento da lista de curso atribui valor de cada curso
        foreach($cursos as $curso){
            
            $curso->turmas=collect();
            foreach($turmas as $turma){
                if($turma->curso->id==$curso->id)
                    $curso->turmas->push($turma);

            }
            
           // $curso->valor=$curso->turma->valor;
        }
        $descontos=Desconto::all();

        //dd($turmas);


        //return $cursos;

        return view('secretaria.inscricao.confirma-atividades')->with('cursos',$cursos)->with('turmas',$turmas)->with('descontos',$descontos)->with('pessoa',$pessoa)->with('todas_turmas',$todas_turmas)->with('turmas_str',$request->atividades);

    }



    /**
     * [inscreverAluno description]
     * @param  [type]  $aluno     [description]
     * @param  [type]  $turma     [description]
     * @param  integer $matricula [description]
     * @return [type]             [description]
     */
    public static function inscreverAluno($aluno,$turma,$matricula=0){
        $atendimento = AtendimentoController::novoAtendimento(' ', $aluno, Session::get('usuario'));
        $turma=Turma::find($turma);
        if(InscricaoController::verificaSeInscrito($aluno,$turma->id))
                return Inscricao::find(InscricaoController::verificaSeInscrito($aluno,$turma->id));
        if($matricula==0){
            if(MatriculaController::verificaSeMatriculado($aluno,$turma->curso->id,$turma->data_inicio)==false){
                $matricula_obj=MatriculaController::gerarMatricula($aluno,$turma->id,'pendente');
                $matricula=$matricula_obj->id;
            }
            else{
                $matricula_obj=MatriculaController::verificaSeMatriculado($aluno,$turma->curso->id,$turma->data_inicio);
                $matricula=$matricula_obj;

            }
        }
        $inscricao=new Inscricao();
        $inscricao->atendimento = $atendimento->id;
        $inscricao->pessoa=$aluno;
        $inscricao->turma=$turma->id;
        $inscricao->status='regular';
        $inscricao->matricula=$matricula;
        $inscricao->save();

        //adiciona no log de atendimentos
        $atendimento->descricao = "Inscrição na turma ".$turma->id.' ID'.$inscricao->id;
        $atendimento->save();

        //modifica o numero de inscritos na turma
        InscricaoController::modInscritos($turma->id,1,1);

        return $inscricao;

    }



    /**
     * [inscreverAlunoSemMatricula description]
     * @param  [type] $aluno [description]
     * @param  [type] $turma [description]
     * @return [type]        [description]
     */
    public static function inscreverAlunoSemMatricula($aluno,$turma){
    $turma=Turma::find($turma);
    if($turma == null)
        return false;
    if(InscricaoController::verificaSeInscrito($aluno,$turma->id))
            return Inscricao::find(InscricaoController::verificaSeInscrito($aluno,$turma->id));
    $inscricao=new Inscricao();
    $inscricao->pessoa=$aluno;
    $inscricao->turma=$turma->id;
    $inscricao->status='regular';
    $atendimento = AtendimentoController::novoAtendimento("Inscrição na turma ".$turma->id , $aluno, Session::get('usuario'));
    $inscricao->atendimento = $atendimento->id;
    $inscricao->save();


    // aumenta Inscricaodos
    InscricaoController::modInscritos($turma->id,1,1);

    return $inscricao;

    }




    /**
     * [inscreverAlunoLote description]
     * @param  [type]  $turma [description]
     * @param  Request $r     [description]
     * @return [type]         [description]
     */
    public function inscreverAlunoLote($turma,Request $r){
        
        //return "função temporareamente bloqueada";
        $inscricao=InscricaoController::inscreverAluno($r->id_pessoa,$turma);
        return redirect(asset('/secretaria/turma/'.$turma));

    }

    public function viewCancelar($id){

        $inscricao = Inscricao::find($id);
        $pessoa = Pessoa::find($inscricao->pessoa->id);
        return view('secretaria.inscricao.cancelamento')->with('pessoa',$pessoa)->with('inscricao',$inscricao);
  



    }




    /**
     * Cancelamento de Inscrição individual - chamado pela route (view)
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function cancelar(Request $r){
        $insc=Inscricao::find($r->inscricao);

        //existe mesmo essa inscrição?
        if($insc==null)
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(["Inscrição não encontrada"]);
        //return $insc->turma->id."teste";
        if($insc->status == 'cancelada')
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(["Inscrição já está cancelada"]);

        //diminui uma pessoa da turma
        InscricaoController::modInscritos($insc->turma->id,0,1);

        //grava canelamento
        $insc->status='cancelada';
        $insc->save();

        //atualiza matricula para caso não tiver mais inscrições
        $matricula = MatriculaController::atualizar($insc->matricula);

        $inscricoes = Inscricao::where('matricula',$matricula->id)->whereIn('status',['regular','pendente'])->count();

        $pessoa = Pessoa::find($insc->pessoa->id);

        if($inscricoes>0){
            if(count($r->cancelamento))
            AtendimentoController::novoAtendimento("Cancelamento da inscrição ".$insc->id. " motivo: ".implode(', ',$r->cancelamento), $matricula->pessoa, Session::get('usuario'));
            else
                AtendimentoController::novoAtendimento("Cancelamento da inscrição ".$insc->id, $matricula->pessoa, Session::get('usuario'));

            return view('juridico.documentos.cancelamento-inscricao')->with('pessoa',$pessoa)->with('inscricao',$insc);
        }

        else{
            if(count($r->cancelamento))
            AtendimentoController::novoAtendimento("Cancelamento da matricula ".$matricula->id. " motivo: ".implode(', ',$r->cancelamento), $matricula->pessoa, Session::get('usuario'));
            else
                AtendimentoController::novoAtendimento("Cancelamento da matricula ".$matricula->id, $matricula->pessoa, Session::get('usuario'));
            return redirect('/secretaria/matricula/imprimir-cancelamento/'.$matricula->id);
        }

    }

    /**
     * Cancelamento de inscrições de uma matrícula. - chamado pelo metodo de cancelar matricula
     * @param [Integer] $matricula [número da matricula]
     */
    public static function cancelarPorMatricula($matricula){
        $inscricoes=Inscricao::where('matricula',$matricula)->whereIn('status',['regular','pendente'])->get();
        foreach($inscricoes as $inscricao){
            $inscricao->status = 'cancelada';
            $inscricao->save();
        }
        return $inscricoes;

    }

    

    /**
     * Finaliza inscrição
     * @param  [Inscricao] $inscricao [Objeto Inscricao]
     * @return [type]            [description]
     */
    public static function finaliza($inscricao){

        //finaliza turma
        if($inscricao->status == 'regular' || $inscricao->status == 'pendente' ){
            $inscricao->status = 'finalizada';
            $inscricao->save();
            AtendimentoController::novoAtendimento("Inscrição ".$inscricao->id.' finalizada.', $inscricao->pessoa->id, Session::get('usuario'));
             //atualiza a matricula. caso não houver matriculas ativas, finalizar.
            MatriculaController::atualizar($inscricao->matricula);
        }

       
        return true;



    }




    /**
     * Modifica a quantidade de pessoas inscritas na turma
     *
     * @param  \App\Turma  $turma
     * @param  $operaçao - 0 reduz, 1 aumenta
     * @param  $qnde - numero para adicionar ou reduzir
     * @return \Illuminate\Http\Response
     */
    public static function modInscritos($turma,$operacao,$qnde){
        $turma=Turma::find($turma);
        if($turma){
            switch ($operacao) {
                case '1':
                    $turma->matriculados=$turma->matriculados+$qnde;
                    break;
                case '0':
                    $turma->matriculados=$turma->matriculados-$qnde;
                    break;
                default:
                    $turma->matriculados=$turma->matriculados+$qnde;
                    break;
            }
            $turma->save();
        }
    }
    



    /**
     * [verInscricoes description]
     * @param  [type] $turma [description]
     * @return [type]        [description]
     */
    public function verInscricoes($turma){
        $turma=Turma::find($turma);
        if (empty($turma))
            return redirect(asset('/secretaria/turmas'));
        $inscricoes=Inscricao::where('turma','=', $turma->id)->whereIn('status',['regular','pendente','finalizada'])->get();

        $inscricoes = $inscricoes->sortBy('pessoa.nome');
        foreach ($inscricoes as $inscricao) {
            $inscricao->telefone = \App\PessoaDadosContato::getTelefone($inscricao->pessoa->id);
            
        }
        //return $inscricoes;
        return view('pedagogico.turma.dados',compact('turma'))->with('inscricoes',$inscricoes);


    }



    /**
     * [cancelarInscricao description]
     * @param  [type] $inscricao [description]
     * @return [type]            [description]
     
    public static function cancelarInscricao($inscricao){
        $inscricao->status='cancelado';
        $inscricao->save();
        InscricaoController::modInscritos($inscricao->turma->id,0,1);
        MatriculaController::modificaMatricula($inscricao->matricula);
        if(count(InscricaoController::inscricoesPorMatricula($inscricao->matricula))==0)
            MatriculaController::cancelarMatricula($inscricao->matricula);
        return $inscricao;
    }*/




    /**
     * [inscricoesPorMatricula description]
     * @param  [type] $matricula [description]
     * @return [type]            [description]
     */
    public static function inscricoesPorMatricula($matricula, $tipo){
        switch($tipo){
            case 'todas' :
                $inscricoes=Inscricao::where('matricula', $matricula)->get();
                break;
            case 'regulares':
                $inscricoes=Inscricao::where('matricula', $matricula)->where('status','regular')->get();
                break;
            case 'finalizadas':
                $inscricoes=Inscricao::where('matricula', $matricula)->where('status','finalizada')->get();
                break;
            case 'canceladas':
                $inscricoes=Inscricao::where('matricula', $matricula)->where('status','cancelada')->get();
                break;
            case 'pendente':
                $inscricoes=Inscricao::where('matricula', $matricula)->where('status','pendente')->get();
                break;
            default:
                $inscricoes=Inscricao::where('matricula', $matricula)->where('status','regular')->get();
                break;


        }
       
        return $inscricoes;
    }




    /**
     * [incricoesPorPosto description]
     * @return [type] [description]
     */
    public function incricoesPorPosto(){
        $vagas=['Fesc 1'=>0,'Fesc 2'=>0,'Fesc 3'=>0];
        $locais= array(84 =>'Fesc 1',
                       85 =>'Fesc 2',
                       86 =>'Fesc 3');
        foreach($locais as $local_id => $local_nome){
            $qnde=Inscricao::join('turmas', 'inscricoes.turma','=','turmas.id')
                            ->where('local',$local_id)
                            ->where('inscricoes.status','<>','cancelada')
                            ->groupBy('inscricoes.pessoa')
                            ->count('inscricoes.pessoa');
            return $qnde;//
        // select count(i.pessoa) from inscricoes i join turmas t on i.turma = t.id where t.`local`=86 group by pessoa                    
            $vagas[$local_nome]=$qnde;

        }

        return $vagas;
    }




    /**
     * [reativar description]
     * @param  [type] $insc [description]
     * @return [type]       [description]
     */
    public static function reativar($insc){
        $curso = '';
        $inscricao = Inscricao::find($insc);
        $turma = Turma::find($inscricao->turma->id);
        if(isset($turma->disciplina->nome))
            $curso = $turma->disciplina->nome;
        else
            $curso = $turma->curso->nome;

        if($turma->vagas >= $turma->matriculados){
            if($inscricao->status == 'cancelada'){
                $inscricao->status = 'regular';
                $inscricao->save();
                AtendimentoController::novoAtendimento("Inscrição ".$inscricao->id." reativada.", $inscricao->pessoa->id, Session::get('usuario'));
                InscricaoController::modInscritos($inscricao->turma->id,1,1);
                return redirect($_SERVER['HTTP_REFERER']);
            }
            else
                return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Inscrição na turma '.$turma->id.' - '.$curso.' não está cancelada :'.$inscricao->status]);
        } else
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Turma '.$turma->id.' - '.$curso.' não possui vagas.']);
        
        


    }





    /**
     * [relatorioConcluintes description]
     * @param  integer $turma [description]
     * @return [type]         [description]
     */
    public function relatorioConcluintes($turma=0){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. 'relatorio' .'.xls"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');

        $tabela =  new Spreadsheet();
        $arquivo = new Xls($tabela);

        $planilha = $tabela->getActiveSheet();
        $planilha->setCellValue('A1', 'ALUNOS PENDENTES - Gerado em '.date('d/m/Y'));
        $planilha->setCellValue('A2', 'Nome');
        $planilha->setCellValue('B2', 'Programa');
        $planilha->setCellValue('C2', 'Curso');
        $planilha->setCellValue('D2', 'Professor');
        $planilha->setCellValue('E2', 'Local');
        $planilha->setCellValue('F2', 'Carga Horária');
        $planilha->setCellValue('G2', 'Início');
        $planilha->setCellValue('H2', 'Termino');
        $linha = 3;

        if($turma ==0){
            $concluintes = Inscricao::join('turmas', 'inscricoes.turma','=','turmas.id')
            ->where('inscricoes.status','pendente')
            ->whereIn('turmas.programa',[1,2])
            ->get();

                //->toSql();
                
           // dd($concluintes);
           
           
        }
            
        foreach($concluintes as $concluinte){ 

                $planilha->setCellValue('A'.$linha, $concluinte->pessoa->nome);
                $planilha->setCellValue('B'.$linha, $concluinte->turma->programa->sigla);
                $planilha->setCellValue('C'.$linha, $concluinte->turma->curso->nome);
                $planilha->setCellValue('D'.$linha, $concluinte->turma->professor->nome);
                $planilha->setCellValue('E'.$linha, $concluinte->turma->local->nome);
                $planilha->setCellValue('F'.$linha, $concluinte->turma->carga);
                $planilha->setCellValue('G'.$linha, $concluinte->turma->data_inicio);
                $planilha->setCellValue('H'.$linha, $concluinte->turma->data_termino);

                $linha++;
                /*
                $aluno->turma = $concluinte->turma->id;
                $aluno->nome = $concluinte->pessoa->nome;
                $aluno->programa = $concluinte->turma->programa->sigla;
                $aluno->curso = $concluinte->turma->curso->nome;
                $aluno->professor = $concluinte->turma->professor->nome;
                $aluno->unidade = $concluinte->turma->local->nome;
                $aluno->carga= $concluinte->turma->carga;
                $aluno->inicio =  $concluinte->turma->data_inicio;
                $aluno->termino =  $concluinte->turma->data_termino;*/   
        }
        
        return $arquivo->save('php://output', 'xls');
        //return $formandos;
    }


    public function trocarView($id){
        $inscricao = Inscricao::find($id);
        if(!$inscricao)
            return redirect()->back()->withErrors('Inscrição não encontrada.');

       // return $inscricao;

        $turmas_compativeis = Turma::where('curso',$inscricao->turma->curso->id)->whereIn('status',['inscricao','iniciada','espera'])->whereColumn('matriculados','<',"vagas")->get();


        //dd($inscricao->turma->curso->id);

        //return $turmas_compativeis;

        return view('secretaria.inscricao.trocar',compact('inscricao'))->with('turmas',$turmas_compativeis);

    }
    public function trocarExec(Request $r){
        $inscricao = Inscricao::find($r->inscricao);
        $inscricao_nova = $this->inscreverAluno($inscricao->pessoa->id,$r->turma,$inscricao->matricula);
        $inscricao->status = 'transferida';
        $inscricao->save();
        AtendimentoController::novoAtendimento('Transferencia da turma '.$inscricao->turma->id.' para turma '.$r->turma, $inscricao->pessoa->id, Session::get('usuario'));


        
        return redirect('/secretaria/atender/'.$inscricao->pessoa->id)->withErrors(['Transferência efetuada.']);

    }

    public function imprimirCancelamento($inscricao){
        //dd('oi');


        $insc=Inscricao::find($inscricao);

        //existe mesmo essa inscrição?
        if($insc==null)
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(["Inscrição não encontrada"]);

        $pessoa = Pessoa::find($insc->pessoa->id);


        return view('juridico.documentos.cancelamento-inscricao')->with('pessoa',$pessoa)->with('inscricao',$insc);
    }
    public function imprimirTransferencia($inscricao){


        $insc=Inscricao::find($inscricao);

        //existe mesmo essa inscrição?
        if($insc==null)
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(["Inscrição não encontrada"]);

        $pessoa = Pessoa::find($insc->pessoa->id);


        return view('juridico.documentos.troca-turma')->with('pessoa',$pessoa)->with('inscricao',$insc);
    }


}
