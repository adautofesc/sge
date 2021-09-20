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
use Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class InscricaoController extends Controller
{
    

    /**
     * Edição de Inscrição (view)
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
        $incricoes_atuais=Inscricao::where('pessoa',$id_pessoa)->whereIn('status', ['regular','pendente'])->get();
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
    public static function verificaSeInscrito($pessoa,$turma){
        $existe=Inscricao::where('turma',$turma)->where('pessoa',$pessoa)->whereIn('status', ['regular','pendente'])->get();
        if($existe->count())
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
    public function verTurmasAtuais($pessoa){
        $turmas=collect();
        $Inscricaos_atuais=Inscricao::where('pessoa', $pessoa )->whereIn('status', ['regular','pendente'])->get();
        foreach($Inscricaos_atuais as $Inscricao){
            $turma=Turma::find($Inscricao->turma);
            $turmas->push($turma);
        }
        return $turmas;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request){   
        $inscricao = $request->inscricao;
        $inscricao = Inscricao::find($inscricao);
        if($inscricao != null){
            $inscricao->matricula = $request->matricula;
            $inscricao->save();
            AtendimentoController::novoAtendimento("Inscrição ".$inscricao->id." modificada para matrícula ".$inscricao->matricula.".", $inscricao->pessoa->id, Auth::user()->pessoa);
            return redirect(asset('/secretaria/atender/'));
        }
        else
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Matricula inválida.']);
    }

    /**
     * Confimação de atividades no processo de matrícula
     */
    public function confirmacaoAtividades(Request $request){
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/inicio-atendimento'));
        $pessoa=Pessoa::find($request->pessoa);
        $valor=0; 
        $todas_turmas=TurmaController::csvTurmas($request->atividades.$request->turmas_anteriores);
        $turmas=TurmaController::csvTurmas($request->atividades);
        //dd($turmas);
        $newturmas=$request->atividades;
        $cursos=collect();
        $uati=0;
        foreach($turmas as $turma){
            if($turma->vagas<=$turma->matriculados)
                $newturmas = str_replace(','.$turma->id,'',$newturmas);
            if($turma->disciplina==null)
                $cursos->push($turma->curso);
            else{
                if(!$cursos->contains($turma->curso)){
                    $cursos->push($turma->curso);
                }       
            }
            $turma->requisitos = \App\CursoRequisito::where('para_tipo','turma')->where('curso',$turma->id)->get();
        }
        foreach($cursos as $curso){  
            $curso->turmas=collect();
            foreach($turmas as $turma){
                if($turma->curso->id==$curso->id)
                    $curso->turmas->push($turma);
            }
        }
        $descontos=Desconto::all();
        return view('secretaria.inscricao.confirma-atividades')
            ->with('cursos',$cursos)
            ->with('turmas',$turmas)
            ->with('descontos',$descontos)
            ->with('pessoa',$pessoa)
            ->with('todas_turmas',$todas_turmas)
            ->with('turmas_str',$newturmas);

    }

    /**
     * [inscreverAluno description]
     * @param  [type]  $aluno     [description]
     * @param  [type]  $turma     [description]
     * @param  integer $matricula [description]
     * @return [type]             [description]
     */
    public static function inscreverAluno($aluno,$turma,$matricula=0,$atendente=0){
     
       

        $turma=Turma::find($turma);
        //dd($turma);
        if(substr($turma->data_inicio,-4,4) < date('Y')){
            redirect()->back()->withErrors(['Não é possível inscrever alunos em turmas de anos anteriores: Turma:'.substr($turma->data_inicio,-4,4).', data: '.date('Y')]);
            return false;
        }

        //segurança para evitar espertinhos que alteram o html
        if($atendente>0 && $turma->vagas<=$turma->matriculados){
            redirect()->back()->withErrors(['Não há vagas para a turma'.$turma->id]); 
            return false; 

                 
        }


        if(!$turma->verificaRequisitos($aluno)){
            redirect()->back()->withErrors(['Problemas com os pré-requisitos da turma '.$turma->id]); 
            return false;  
                 
        }



        if(InscricaoController::verificaSeInscrito($aluno,$turma->id))
                return Inscricao::find(InscricaoController::verificaSeInscrito($aluno,$turma->id));
        if($matricula==0){
            if(MatriculaController::verificaSeMatriculado($aluno,$turma->curso->id,$turma->data_inicio)==false){
                if($turma->status == 'andamento' || $turma->status == 'iniciada')
                    $status="ativa";    
                else
                    $status="espera";
                $matricula_obj=MatriculaController::gerarMatricula($aluno,$turma->id,$status,$atendente);
                $matricula=$matricula_obj->id;
            }
            else{
                $matricula_obj=MatriculaController::verificaSeMatriculado($aluno,$turma->curso->id,$turma->data_inicio);
                $matricula=$matricula_obj;

            }
        }
        $atendimento = AtendimentoController::novoAtendimento(' ', $aluno, $atendente);
        

        $inscricao=new Inscricao();
        $inscricao->atendimento = $atendimento->id;
        $inscricao->pessoa=$aluno;
        $inscricao->turma=$turma->id;
        $inscricao->status='regular';
        $inscricao->matricula=$matricula;
        $inscricao->save();
        $atendimento->descricao = "Inscrição na turma ".$turma->id.' ID'.$inscricao->id;
        $atendimento->save();
        TurmaController::modInscritos($turma->id);
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
        $atendimento = AtendimentoController::novoAtendimento("Inscrição na turma ".$turma->id , $aluno, Auth::user()->pessoa);
        $inscricao->atendimento = $atendimento->id;
        $inscricao->save();
        TurmaController::modInscritos($turma->id);
        return $inscricao;
    }

    public static function inscreverAlunoRematricula($aluno,$turma){
        $turma=Turma::find($turma);
        if($turma == null)
            return false;
        if(InscricaoController::verificaSeInscrito($aluno,$turma->id))
                return Inscricao::find(InscricaoController::verificaSeInscrito($aluno,$turma->id));
        $inscricao=new Inscricao();
        $inscricao->pessoa=$aluno;
        $inscricao->turma=$turma->id;
        $inscricao->status='regular';
        
        $inscricao->atendimento = 1111;
        $inscricao->save();
        TurmaController::modInscritos($turma->id);
        return $inscricao;
    }

    /**
     * [inscreverAlunoLote description]
     * @param  [type]  $turma [description]
     * @param  Request $r     [description]
     * @return [type]         [description]
     */
    public function inscreverAlunoLote($turma,Request $r){
        $inscricao=InscricaoController::inscreverAluno($r->id_pessoa,$turma);
        return redirect()->back()->withErrors(['Inscrição efetuada.']);

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
        
        LogController::registrar('inscricao',$r->inscricao,'Cancelamento da inscrição, motivo: '.implode(', ',$r->cancelamento));    
        InscricaoController::alterarStatus($r->inscricao,'cancelada');

        $inscricoes = Inscricao::where('matricula',$r->matricula)->whereIn('status',['regular','pendente'])->count();
        $pessoa = Pessoa::find($r->pessoa);
        if($inscricoes>0){
            if(!empty($r->cancelamento))
                AtendimentoController::novoAtendimento("Cancelamento da inscrição ".$r->inscricao. " motivo: ".implode(', ',$r->cancelamento), $r->pessoa, Auth::user()->pessoa);
            else
                AtendimentoController::novoAtendimento("Cancelamento da inscrição ".$r->inscricao, $r->pessoa, Auth::user()->pessoa);
            return redirect('/secretaria/matricula/inscricao/imprimir/cancelamento/'.$r->inscricao);
        }
        else{
            if(!empty($r->cancelamento))
                AtendimentoController::novoAtendimento("Cancelamento da matricula ".$r->matricula. " motivo: ".implode(', ',$r->cancelamento), $r->pessoa, Auth::user()->pessoa);
            else
                AtendimentoController::novoAtendimento("Cancelamento da matricula ".$r->matricula, $matricula->pessoa, Auth::user()->pessoa);
            return redirect('/secretaria/matricula/imprimir-cancelamento/'.$r->matricula);
        }

    }

    /**
     * Metodo de alteração de status das inscrições
     */
    public static function alterarStatus($itens,$status){
        $arr_itens = explode(',',$itens);
        foreach($arr_itens as $item){
            if(is_numeric($item)){
                $inscricao = Inscricao::find($item);
                //dd($inscricao);
                if(isset($inscricao->status) && $inscricao->status != $status){
                    $inscricao->status = $status;
                    $inscricao->save();
                    switch($status){
                        case "pendente" :
                            MatriculaController::atualizar($inscricao->matricula);
                            break;
                        case "regular": 
                            TurmaController::modInscritos($inscricao->turma->id);
                            MatriculaController::atualizar($inscricao->matricula);
                            break;
                        case "finalizada": 
                            MatriculaController::atualizar($inscricao->matricula);
                            break;
                        case "cancelada":
                            TurmaController::modInscritos($inscricao->turma->id);
                            MatriculaController::atualizar($inscricao->matricula);
                            break;
                        case "transferida": 
                            TurmaController::modInscritos($inscricao->turma->id);
                            MatriculaController::atualizar($inscricao->matricula);
                            break;
                    }
                    
                }
            }
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
            LogController::registrar('inscricao',$inscricao->id,'Cancelamento');
            TurmaController::modInscritos($inscricao->turma->id);
        }
        return $inscricoes;
    }

    /**
     * Atualização de status em inscrições devido alterações no status da matrícula
     */
    public static function atualizarPorMatricula($matricula,$status){
        $inscricoes = Inscricao::where('matricula',$matricula)->get();
        switch($status){
            case 'ativa': 
                $inscricoes_ = $inscricoes->whereIn('status',['pendente','finalizada']);
                foreach($inscricoes_ as $inscricao){
                    $inscricao->status = 'regular';
                    $inscricao->save();
                }
            break;
            case 'pendente': 
                $inscricoes_ = $inscricoes->where('status','regular');
                foreach($inscricoes_ as $inscricao){
                    $inscricao->status = 'pendente';
                    $inscricao->save();
                }
            break;
            case 'cancelada': 
                $inscricoes_ = $inscricoes->whereIn('status',['regular','pendente']);
                foreach($inscricoes_ as $inscricao){
                    $inscricao->status = 'cancelada';
                    $inscricao->save();
                    TurmaController::modInscritos($inscricao->turma->id);
                }
            break;
            case 'finalizada': 
                $inscricoes_ = $inscricoes->whereIn('status',['regular','pendente']);
                foreach($inscricoes_ as $inscricao){
                    $inscricao->status = 'expirada';
                    $inscricao->save();
                }
            break;

        }
    }

    /**
     * Finaliza inscrição
     * @param  [Inscricao] $inscricao [Objeto Inscricao]
     * @return [type]            [description]
     */
    public static function finaliza($inscricao){
        if($inscricao->status == 'regular' || $inscricao->status == 'pendente' ){
            $inscricao->status = 'finalizada';
            $inscricao->save();
            LogController::registrar('inscricao',$inscricao->id,'Finalização');
            AtendimentoController::novoAtendimento("Inscrição ".$inscricao->id.' finalizada.', $inscricao->pessoa->id, Auth::user()->pessoa);
             //atualiza a matricula. caso não houver matriculas ativas, finalizar.
            MatriculaController::atualizar($inscricao->matricula);
        }
        return true;
    }

    
    
    /**
     * [verInscricoes description]
     * @param  [type] $turma [description]
     * @return [type]        [description]
     */
    public function verInscricoes($turma){
        $turma=Turma::find($turma);
        if (empty($turma))
            return redirect(asset('/turmas'));
        $inscricoes=Inscricao::where('turma','=', $turma->id)->whereIn('status',['regular','pendente','finalizada'])->get();
        if($inscricoes->count() != $turma->matriculados)
            $turma->atualizarInscritos($inscricoes->count());

        $inscricoes = $inscricoes->sortBy('pessoa.nome');
        foreach ($inscricoes as $inscricao) {
            $inscricao->telefone = \App\PessoaDadosContato::getTelefone($inscricao->pessoa->id);

            $inscricao->atestado = $inscricao->getAtestado();
            if($inscricao->atestado){
                $inscricao->atestado->validade =  $inscricao->atestado->calcularVencimento($turma->programa->id);
                //dd($inscricao->atestado);
            }
           
        }
        //return $inscricoes;
        return view('turmas.dados-secretaria',compact('turma'))->with('inscricoes',$inscricoes);


    }

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
                LogController::registrar('inscricao',$inscricao->id,'Reativação');
                AtendimentoController::novoAtendimento("Inscrição ".$inscricao->id." reativada.", $inscricao->pessoa->id, Auth::user()->pessoa);
                TurmaController::modInscritos($inscricao->turma->id);
                return redirect($_SERVER['HTTP_REFERER']);
            }
            else
                return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Inscrição na turma '.$turma->id.' - '.$curso.' não está cancelada :'.$inscricao->status]);
        } else
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Turma '.$turma->id.' - '.$curso.' não possui vagas.']);
    }

    /**
     * View de Transferência de turma (lista turmas compatíveis)
     */
    public function trocarView($id){
        $inscricao = Inscricao::find($id);
        if(!$inscricao)
            return redirect()->back()->withErrors('Inscrição não encontrada.');
        //pegar idade da pessoa
        $pessoa = \App\Pessoa::find($inscricao->pessoa->id);
       // se não for hidro
       // 898 = hidro
       // 1493 = hidro 18+
        if($inscricao->turma->curso->id ==898)//se for hidro, listar os as turmas hidro e hidro+18
            $turmas_compativeis = Turma::whereIn('curso',[898,1493])->whereIn('status',['inscricao','iniciada'])->whereColumn('matriculados','<',"vagas")->orderBy('dias_semana')->orderBy('hora_inicio')->get();
        elseif($inscricao->turma->curso->id ==1493){ //se for hidro 18+
            if($pessoa->getIdade()>39) //se for >=40 anos mostrar todas hidros
                $turmas_compativeis = Turma::whereIn('curso',[898,1493])->whereIn('status',['inscricao','iniciada'])->whereColumn('matriculados','<',"vagas")->orderBy('dias_semana')->orderBy('hora_inicio')->get();
            else //mostrar só as hidros 18+
                $turmas_compativeis = Turma::where('curso',1493)->whereIn('status',['inscricao','iniciada'])->whereColumn('matriculados','<',"vagas")->orderBy('dias_semana')->orderBy('hora_inicio')->get();

        }     
        else //senão mostrar turmas do curso correspondente.
          $turmas_compativeis = Turma::where('curso',$inscricao->turma->curso->id)->whereIn('status',['inscricao','iniciada'])->whereColumn('matriculados','<',"vagas")->orderBy('dias_semana')->orderBy('hora_inicio')->get();

        return view('secretaria.inscricao.trocar',compact('inscricao'))->with('turmas',$turmas_compativeis);

    }

    /**
     * Executa transferencia de turma
     */
    public function trocarExec(Request $r){

        //verifica se escolheu turma
        if($r->turma >0)
            $turma = $r->turma;
        else // não escolheu verifica se digitou turma alternativa
            $turma = $r->turma_alternativa;
        $turma_obj = \App\Turma::find($turma);
        if($turma_obj == null) // não existe essa turma alternativa?
            return redirect()->back()->withErrors(['Turma inválida.']);
        $inscricao = Inscricao::find($r->inscricao);
        $inscricao_nova = $this->inscreverAluno($inscricao->pessoa->id,$turma,$inscricao->matricula);
        if($inscricao_nova == false)
         return redirect()->back();
        $turma_obj->matriculados++;
        $turma_obj->save();
        $inscricao->status = 'transferida';
        $inscricao->save();
        $turma_anterior = Turma::find($inscricao->turma->id);
        $turma_anterior->matriculados--;
        $turma_anterior->save();
        //dd($inscricao_nova);

        $transferencia = TransferenciaController::gravarRegistro($inscricao->matricula,$inscricao->id,$inscricao_nova->id,$r->motivo); 
        LogController::registrar('inscricao',$inscricao->id,'Transferência de turma');
        AtendimentoController::novoAtendimento('Transferencia da turma '.$inscricao->turma->id.' para turma '.$turma, $inscricao->pessoa->id, Auth::user()->pessoa);
        return redirect('/secretaria/matricula/inscricao/imprimir/transferencia/'.$transferencia->id);

    }

    /**
     * View de impressão de cancelamento.
     */
    public function imprimirCancelamento($inscricao){
        $insc=Inscricao::find($inscricao);
        if(!isset($insc->id))
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(["Inscrição não encontrada"]);
        $pessoa = Pessoa::find($insc->pessoa->id);
        return view('juridico.documentos.cancelamento-inscricao')->with('pessoa',$pessoa)->with('inscricao',$insc);
    }



}
