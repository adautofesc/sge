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
            MatriculaController::modificaMatricula($inscricao->matricula);
            MatriculaController::modificaMatricula($request->matricula);
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
                    if($turma->curso->id==307)
                        $uati++;
                    else
                        $valor=$valor+str_replace(',', '.',$turma->valor);

                    switch ($uati) {
                        case '0':
                            $valor=$valor+0;
                        case '1':
                            $valor=$valor+100;
                            break;
                        case '2':
                        case '3':
                        case '4':
                            $valor=$valor+250;
                            break;
                        case 4:
                        case 5:
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                        case 10:
                            $valor=$valor+400;
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

        return view('secretaria.inscricao.confirma-atividades')->with('cursos',$cursos)->with('turmas',$turmas)->with('valor',$valor)->with('descontos',$descontos)->with('pessoa',$pessoa)->with('todas_turmas',$todas_turmas)->with('turmas_str',$request->atividades);

    }



    /**
     * [inscreverAluno description]
     * @param  [type]  $aluno     [description]
     * @param  [type]  $turma     [description]
     * @param  integer $matricula [description]
     * @return [type]             [description]
     */
    public static function inscreverAluno($aluno,$turma,$matricula=0){
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
        $inscricao->pessoa=$aluno;
        if (Session::get('atendimento')>0)
            $inscricao->atendimento=Session::get('atendimento');
        else
            $inscricao->atendimento=1;
        $inscricao->turma=$turma->id;
        $inscricao->status='regular';
        $inscricao->matricula=$matricula;
        $inscricao->save();

        // aumenta Inscricaodos

        //$turma=Turma::find($turma);
        InscricaoController::modInscritos($turma->id,1,1);
        MatriculaController::modificaMatricula($matricula);

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
    if (Session::get('atendimento')>0)
        $inscricao->atendimento=Session::get('atendimento');
    else
        $inscricao->atendimento=1;
    $inscricao->turma=$turma->id;
    $inscricao->status='regular';
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
        MatriculaController::modificaMatricula($inscricao->matricula);

        return redirect(asset('/secretaria/turma/'.$turma));
    }




    /**
     * Cancelamento de Inscrição individual - chamado pela route (view)
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function cancelar($id){
        $insc=Inscricao::find($id);

        //existe mesmo essa inscrição?
        if($insc==null)
            return die("Inscrição não encontrada");
        //return $insc->turma->id."teste";
        if($insc->status == 'cancelada')
            return redirect($_SERVER['HTTP_REFERER']);

        //diminui uma pessoa da turma
        InscricaoController::modInscritos($insc->turma->id,0,1);

        //grava canelamento
        $insc->status='cancelada';
        $insc->save();

        //atualiza matricula para caso não tiver mais inscrições
        $matricula = MatriculaController::atualizar($insc->matricula);
        
        /*
        $num_inscricoes=count(InscricaoController::inscricoesPorMatricula(,'regulares'));
        if($num_inscricoes==0)
            MatriculaController::cancelarMatricula($insc->matricula);
        */

        AtendimentoController::novoAtendimento("Cancelamento da inscrição ".$insc->id." da matrícula ".$insc->matricula.".", $insc->pessoa->id, Session::get('usuario'));

        return redirect($_SERVER['HTTP_REFERER']); //volta pra pagina anterior, atualizando ela.

    }

    /**
     * Cancelamento de inscrições de uma matrícula. - chamado pelo metodo de cancelar matricula
     * @param [Integer] $matricula [número da matricula]
     */
    public static function cancelarPorMatricula($matricula){
        $inscricoes=Inscricao::where('matricula',$matricula)->where('status','<>','cancelada')->get();
        foreach($inscricoes as $inscricao){
            $inscricao->status = 'cancelada';
            $inscricao->save();
        }
        return true;

    }

    

    /**
     * Fianliza inscrição
     * @param  [Inscricao] $inscricao [Objeto Inscricao]
     * @return [type]            [description]
     */
    public static function finaliza($inscricao){

        //finaliza turma
        $inscricao->status = 'finalizada';
        $inscricao->save();

        //atualiza a matricula. caso não houver matriculas ativas, finalizar.
        MatriculaController::atualizar($inscricao->matricula);

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
        $inscricoes=Inscricao::where('turma','=', $turma->id)->whereIn('status',['regular','pendente'])->get();

        $inscricoes = $inscricoes->sortBy('pessoa.nome');
        foreach ($inscricoes as $inscricao) {
            $inscricao->telefone = \App\PessoaDadosContato::getTelefone($inscricao->pessoa->id);
            
        }
        //return $inscricoes;
        return view('pedagogico.turma.dados',compact('turma'))->with('inscricoes',$inscricoes);


    }




    /**
     * Pedagogico ver inscrições
     * @param  [type] $turma [description]
     * @return [type]        [description]
     */
    public function verInscritos($turma){
        $turma=Turma::find($turma);
        if (empty($turma))
            return redirect(asset('/secretaria/turmas'));
        $inscricoes=Inscricao::where('turma','=', $turma->id)->whereIn('status',['regular','pendente'])->get();
        $inscricoes->sortBy('pessoa.nome');
        //return $inscricoes;
        return view('pedagogico.turma.inscritos',compact('turma'))->with('inscricoes',$inscricoes);


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
                InscricaoController::modInscritos($inscricao->turma->id,1,1);
                MatriculaController::modificaMatricula($inscricao->matricula);
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


}
