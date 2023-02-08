<?php

namespace App\Http\Controllers;

use App\Matricula;
use App\Turma;
use App\Desconto;
use App\Pessoa;
use Illuminate\Http\Request;
use App\Inscricao;
use Session;
use Auth;


ini_set('upload_max_filesize', '4194304');

class MatriculaController extends Controller
{
    /**
     * Listar disponíveis
     * 
     */
    public function novaMatricula(int $pessoa, Request $r){
        
        $str_turmas = '';
        $pessoa = Pessoa::findOrFail($pessoa);
        $turmas_atuais=collect();
        $lista=array();
        $lst=array();

        $incricoes_atuais=Inscricao::where('pessoa',$pessoa->id)->whereIn('status', ['regular','pendente'])->get();
        foreach($incricoes_atuais as $inscricao){
            $str_turmas=$str_turmas.','.$inscricao->turma->id;
            $turma=Turma::find($inscricao->turma->id);
            $turmas_atuais->push($turma);
        }

        /*
        //transforma a string de turmas atuais em collection de turmas
        $turmas_atuais=explode(',',$turmas_atuais);
        foreach($turmas_atuais as $turma){
            if(is_numeric($turma)){
                if(Turma::find($turma))
                    $turmas_atuais->push(Turma::find($turma));
            }
        }*/


        //se não tiver nenhuma turma atual
        if(count($turmas_atuais)==0){ 
            $turmas = Turma::whereIn('turmas.status', ['inscricao','iniciada'])
                            ->get();
                            
            foreach($turmas as $turma){
                $turma->parcelas = $turma->getParcelas();
            }
            $turmas = $turmas->SortBy('cursos.nome')->SortBy('disciplinas.nome');
            
           
           
        }
        //cria limitação nos horários das turmas
        else{
            foreach($turmas_atuais as $turma){
                    $hora_fim=date("H:i",strtotime($turma->hora_termino." - 1 minutes"));
                    foreach($turma->dias_semana as $turm){
                        $data = \Carbon\Carbon::createFromFormat('d/m/Y', $turma->data_termino)->format('Y-m-d');
                        $lista[]=Turma::where('dias_semana', 'like', '%'.$turm.'%')->whereBetween('hora_inicio', [$turma->hora_inicio,$hora_fim])->where('data_inicio','<=',$data)->get(['id']);
                    }
                    
                }
            foreach($lista as $col_turma){
                foreach($col_turma as $obj_turma)
                    $lst[]=$obj_turma->id;

            }

            $turmas = Turma::whereIn('turmas.status', ['inscricao','iniciada'])
                            ->whereNotIn('turmas.id', $lst)
                            ->get();
            foreach($turmas as $turma){
                $turma->parcelas = $turma->getParcelas();
                $turma->nome_curso = $turma->getNomeCurso();
            }
            $turmas = $turmas->SortBy('nome_curso');
            


        }

        
        return view('secretaria.matricula.nova_matricula')->with('pessoa',$pessoa)->with('turmas',$turmas)->with('str_turmas',$str_turmas)->with('turmas_atuais',$turmas_atuais);
    }



    /**
     * Grava a Matricula e gera as inscrições
     * @param  Request $r Proveniente de formulário
     * @return View     secretaria.inscricao.gravar
     */
    public function gravar(Request $r){
        
        //dd($r->emg);
        
        //throw new \Exception("Matricula temporariamente suspensa. Tente novamente em instantes.", 1);
        
        //criar colections de objetos
        $matriculas=collect();
        $cursos=collect();


        //Recebe lista de turmas csv
        $turmas=TurmaController::csvTurmas($r->turmas); 
        foreach($turmas as $turma){
            $insc=InscricaoController::inscreverAluno($r->pessoa,$turma->id);
        }
        
        $CC = new CarneController;
        $CC->gerarCarneIndividual($r->pessoa);
        //$boletos = \App\Boleto::where('pessoa',$r->pessoa)->where('status','gravado')->get();
        
        
        
        return redirect(asset("secretaria/atender").'/'.$r->pessoa);
 
        

    }



    /**
     * Grava alterações feitas na edição de matricula
     * @param  Request $r [description]
     * @return [type]     [description]
     */
    public function update(Request $r){
        $matricula=Matricula::find($r->id);
        $matricula->desconto=$r->fdesconto;
        $matricula->valor_desconto=$r->valordesconto;
        $matricula->obs=$r->obs;
        $matricula->pacote = $r->pacote;
        $matricula->parcelas = $r->parcelas;
        $bolsa = \App\Bolsa::select(['bolsas.id', 'bolsas.status'])
                        ->join('bolsa_matriculas','bolsa_matriculas.bolsa','bolsas.id')
                        ->where('bolsa_matriculas.matricula',$matricula->id)
                        ->first();
        if(isset($bolsa) && $bolsa->status == 'analisando')
            return redirect()->back()->withErrors(['Bolsa pendente para esta matrícula. Resolva a pendência antes']); 
        $matricula->save();
        MatriculaController::alterarStatus($matricula->id,$r->status);

        AtendimentoController::novoAtendimento("Matrícula atualizada.", $matricula->pessoa);
        //LancamentoController::atualizaMatricula($matricula->id);
        return redirect(asset('secretaria/atender'));
    }

    /**
     * [Grador do termo de Matrícula]
     * @param  [type] $matricula [description]
     * @return [type]            [description]
     */
    public function termo($matricula,Request $r){
        //dd($r->keycode);
        $matricula=Matricula::find($matricula);
        if(!$matricula)
            return view("error-404");

        if(!isset(Auth::user()->pessoa))
            if(isset($r->pessoa->id)){
                if($r->pessoa->id != $matricula->pessoa)
                    return redirect("https://www.youtube.com/watch?v=fXLicO0CRvk");
            }
            else
                return redirect("https://makeameme.org/meme/no-tem-nada-2e82409728");

        
        /*
        if($matricula->status == 'pendente'){
            return redirect()->back()->withErrors(['Matrículas pendentes não podem ser impressas. Altere o status em opções/editar']);
        }
        */
        $pessoa=Pessoa::find($matricula->pessoa);
        $pessoa=PessoaController::formataParaMostrar($pessoa);

        
        switch($matricula->status){
            case 'cancelada':
                $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->where('status','cancelada')->get();
                break;
            case 'ativa': 
            case 'pendente':
                $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->whereIn('status',['regular','pendente'])->get();
                break;
            case 'expirada':
                $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->where('status','finalizada')->get();
                break;
            default:
                $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->whereIn('status',['regular','pendente'])->get();
                break;

        }
            
        foreach($inscricoes as $inscricao){
            $inscricao->turmac=Turma::find($inscricao->turma->id);
            $inscricao->turmac->getSala();

        }


        //return $pessoa;
        if($inscricoes->first()->turma->local->id == 118)
            return view("juridico.documentos.termo-ead",compact('matricula'))->with('pessoa',$pessoa)->with('inscricoes',$inscricoes);
        else
            return view("juridico.documentos.termo",compact('matricula'))->with('pessoa',$pessoa)->with('inscricoes',$inscricoes);

    }
    public function declaracao($matricula){
        $matricula=Matricula::find($matricula);
        if(!$matricula)
            return view("error-404");
        $pessoa=Pessoa::find($matricula->pessoa);
        $pessoa=PessoaController::formataParaMostrar($pessoa);
        
        $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->where('status','<>','cancelada')->get();
        foreach($inscricoes as $inscricao){
            $inscricao->turmac=Turma::find($inscricao->turma->id);
        }

        return view("juridico.documentos.declaracao",compact('matricula'))->with('pessoa',$pessoa)->with('inscricoes',$inscricoes);
        
    }
    
   

    /**
     * Listar Matriculas por pessoa
     * @return [type] [description]
     **/
     
    public function listarPorPessoa(){
        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        $matriculas=Matricula::where('pessoa', Session::get('pessoa_atendimento'))->where('status','<>','expirada')->orderBy('id','desc')->get();
        //return $matriculas;
        $nome=Pessoa::getNome(Session::get('pessoa_atendimento'));

        return view('secretaria.matricula.lista-por-pessoa',compact('matriculas'))->with('nome',$nome)->with('pessoa_id',Session::get('pessoa_atendimento'));

    }



    /**
     * [verificaSeMatriculado description]
     * @param  [type] $pessoa [description]
     * @param  [type] $curso  [description]
     * @param  [type] $data   [description]
     * @return [type]         [description]
     */
    public static function verificaSeMatriculado($pessoa,$curso,$data,$pacote=null)
    {
        //$data = \Carbon\Carbon::createFromFormat('d/m/Y', $data);
        $inicio_turma = \Carbon\Carbon::createFromFormat('d/m/Y', $data);
        $hoje = \Carbon\Carbon::createFromFormat('d/m/Y', date('d/m/Y'));

        
        if($pacote > 0){
            
            if($hoje->gte($inicio_turma))
                $matricula = Matricula::where('pessoa',$pessoa)
                    ->where('pacote',$pacote)   
                    ->Where('status','ativa')
                    ->first();
            else
                $matricula = Matricula::where('pessoa',$pessoa)
                    ->where('pacote',$pacote)   
                    ->WhereIn('status',['espera','pendente'])
                    ->first();

            if($matricula)
                return $matricula;
            else
                return false;

        }
        else{
            return false;
        }
           
    }




    public static function gerarMatricula($pessoa,$turma_id,$status_inicial,$atendente=0,$pacote){

        $turma=Turma::find($turma_id);
        if($turma==null)
            redirect($_SERVER['HTTP_REFERER']);
        $atendimento = AtendimentoController::novoAtendimento("Matrícula gerada por adição direta na turma, lote, rematrícula ou matrícula online", $pessoa,$atendente);
        $matricula=new Matricula();
        $matricula->pessoa=$pessoa;
        $matricula->atendimento=$atendimento->id;
        $matricula->data=date('Y-m-d');
        $matricula->dia_venc=10;
        $matricula->status=$status_inicial;
        $matricula->valor=str_replace(',','.',$turma->valor);
        $matricula->curso = $turma->curso->id;
        $matricula->pacote = $pacote;
        $matricula->save();
        $matricula->parcelas = $matricula->getParcelas();
        $matricula->save();


        return $matricula;




    }


    public static function gerarMatriculaRematricula($pessoa,$turma_id,$status_inicial){
        $turma=Turma::find($turma_id);
        if($turma==null)
            redirect($_SERVER['HTTP_REFERER']);
        $matricula=new Matricula();
        $matricula->pessoa=$pessoa;
        $matricula->atendimento=1111;
        $matricula->data=date('Y-m-d');
        $matricula->dia_venc=10;
        $matricula->status=$status_inicial;
        $matricula->valor=str_replace(',','.',$turma->valor);
        $matricula->curso = $turma->curso->id;
        $matricula->save();


        return $matricula;




    }

    public static function viewCancelarMatricula($id){
        
        $matricula=Matricula::find($id);
        $pessoa = Pessoa::find($matricula->pessoa);

        return view('secretaria.matricula.cancelamento')->with('pessoa',$pessoa)->with('matricula',$matricula);
  
    }
    public function cancelarMatricula(Request $r){
        self::cancelar($r->matricula); 
         //cacelar os boletos automaticamente
         if($r->cancelar_boletos == true)
             BoletoController::cancelarPorMatricula($r->matricula);

        //LancamentoController::cancelamentoMatricula($id);
        if(!empty($r->cancelamento))
            AtendimentoController::novoAtendimento("Cancelamento da matricula ".$r->matricula. " motivo: ".implode(', ',$r->cancelamento), $r->pessoa,Auth::user()->pessoa);
        else
            AtendimentoController::novoAtendimento("Cancelamento da matricula ".$r->matricula, $r->pessoa,Auth::user()->pessoa);
        //return view('juridico.documentos.cancelamento-matricula')->with('pessoa',$pessoa)->with('matricula',$matricula)->with('inscricoes',$insc)->with('boletos',count($boletos));
        return redirect('/secretaria/matricula/imprimir-cancelamento/'.$r->matricula);
    }

    public static function cancelar(int $matricula,$responsavel=0){

        $matricula=Matricula::find($matricula);
        $matricula->status='cancelada';
        $pessoa = Pessoa::find($matricula->pessoa);
        $matricula->save();
        $insc=InscricaoController::cancelarPorMatricula($matricula->id);
        
        

        //cancelar a bolsa se houver
        $bolsa = $matricula->getBolsas();
        if($bolsa){
            $bmc = new BolsaController;
            $bmc->unLinkMe($matricula->id,$bolsa->id);
        }

        PessoaDadosAdminController::removePendenciasSemMatriculas($matricula->pessoa);
        return true;


    }



    /**
     * Atualizar Matrícula.
     * Chamado após alterações nas inscrições 
     *  - Finaliza caso tiver todas inscrições estiverem finalizadas
     *  - Cancela matricula se não houver inscrições regulares
     * @param  [integer] $id [id da matricula a ser atualizada]
     * @return [Matricula]     [retorna objeto matrícula.]
     */
    public static function atualizar($id){
        $matricula = Matricula::find($id);
        if(isset($matricula->id)){
           
            $inscricoes = InscricaoController::inscricoesPorMatricula($id,'todas');
            if($inscricoes->count()==0){
                $matricula->status = 'cancelada';
                $matricula->save();
                \App\BolsaMatricula::atualizarPorMatricula($matricula->id);
                return $matricula;
            }
            $regulares = $inscricoes->where('status','regular');
            if($regulares->count()>0){
                $matricula->status = 'ativa';
                $matricula->save();
                \App\BolsaMatricula::atualizarPorMatricula($matricula->id);
                return $matricula;
            }              
            else{
                $pendentes = $inscricoes->where('status','pendente');
                if($pendentes->count()>0){
                    $matricula->status = 'pendente';
                    $matricula->save();
                    \App\BolsaMatricula::atualizarPorMatricula($matricula->id);
                    return $matricula;
                }
                else{
                    $finalizadas = $inscricoes->where('status','finalizada');
                    if($finalizadas->count()>0){
                        $matricula->status = 'expirada';
                        $matricula->save();
                        \App\BolsaMatricula::atualizarPorMatricula($matricula->id);
                        return $matricula;
                    }
                    else{
                        $matricula->status = 'cancelada';
                        $matricula->save();
                        \App\BolsaMatricula::atualizarPorMatricula($matricula->id);
                        return $matricula;
                    }
                }
            }
            
            
        }  
        else
            dd('Erro em MatriculaController::atualizar -> Matrícula'.$id.' não encontrada');  

        return false;   
    }

    /**
     * Editar Matrícula
     * Carrega os dados da matrícula e abre a view com formulário de edição
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editar($id){
        $matricula=Matricula::find($id);
        $nome=Pessoa::getNome($matricula->pessoa);
        $descontos=Desconto::all();
        //dd($matricula);

        return view('secretaria.matricula.editar',compact('matricula'))->with('nome',$nome)->with('descontos',$descontos);

    }
    

    /**
     * Modificador de Matrículas
     * Atribui código do curso nas matrículas ativas ou pendentes sem esse código.
     * @return [type] [description]
     */
    public function modMatriculas(){
        $contador =0;
         $matriculas = Matricula::whereIn('status',['ativa','pendente'])->where('curso',null)->get();
         //dd($matriculas);

         foreach($matriculas as $matricula){
            $inscricao = Inscricao::where('matricula',$matricula->id)->first();
            $matricula->curso = $inscricao->turma->curso->id;
            $matricula->save();
            $contador++;
         }
         return $contador." Matriculas alteradas";

    }

    public function atualizaTodasMatriculas(){
        $matriculas=Matricula::all();
        foreach($matriculas as $matricula){
            $this->modificaMatricula($matricula->id);
            LancamentoController::atualizaMatricula($matricula->id);
        }
    }

    public function reativarMatricula($id){
        $matricula = Matricula::find($id);
        $matricula->status = 'ativa';
        $inscricoes = Inscricao::where('matricula',$id)->get();
        foreach($inscricoes as $inscricao){
            InscricaoController::reativar($inscricao->id);  
        }
        $insc = Inscricao::where('matricula',$id)->where('status','regular')->get();
        if($insc->count()>0){
            $matricula->save();
            AtendimentoController::novoAtendimento("Reativação de matrícula ".$matricula->id, $matricula->pessoa);
            return redirect($_SERVER['HTTP_REFERER']);
        }
        else
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhuma inscrição REGULAR para a matrícula']);
    }


    /**
     * view de upload de termo
     */
    public function uploadTermo_vw($matricula){
        return view('secretaria.matricula.upload-termo')->with('matricula',$matricula);
    }

    /**
     * Execução de upload de termo
     */
    public function uploadTermo(Request $r){
        $arquivo = $r->file('arquivo');                  
            if (!empty($arquivo)) 
                $arquivo->move('documentos/matriculas/termos',$r->matricula.'.pdf');         

            return redirect(asset('secretaria/atender'));
    }

    /**
     * Execução de upload em lote
     */
    public function uploadTermosLote(Request $r){
        $arquivos = $r->file('arquivos');
        foreach($arquivos as $arquivo){
            //dd($arquivo);
            if (!empty($arquivo)) 
                $arquivo->move('documentos/matriculas/termos', preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName()).'.pdf');
        }
        return redirect(asset('secretaria/matricula/upload-termo-lote'))->withErrors(['Enviados'.count($arquivos).' arquivos.']);
    }

    /**
     * view de upload de cancelamento de matricula
     */
    public function uploadCancelamentoMatricula_vw($matricula){
        return view('secretaria.matricula.upload-termo')->with('matricula',$matricula);
    }

    /**
     * Execução de upload de cancelamento
     */
    public function uploadCancelamentoMatricula(Request $r){
        $arquivos = $r->file('arquivos');
            foreach($arquivos as $arquivo){
                if (!empty($arquivo)) 
                    $arquivo->move('documentos/matriculas/cancelamentos', preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName()).'.pdf');    
            }
        return redirect(asset('secretaria/atender'))->withErrors(['Enviados'.count($arquivos).' arquivos.']);
        
    }

    /**
     * [uploadGlobal_vw description]
     * @param  [type] $tipo  [ 0 = inscricao, 1 = matricula, 2 atestado]
     * @param  [type] $operacao  [ 0 = cancelamento, 1 = Inserir, 2 = Remover ]
     * @param  [type] $qnde [1 = unico, 0 = varios]
     * @param  [type] $valor [Numero da matricula/inscricao ou atestado]
     * @return [type]        [View dinâmica]
     */
    public function uploadGlobal_vw($tipo,$operacao,$qnde,$valor){
        switch($tipo){
            case 0 : 
                $objeto = " de inscrição";
                break;
            case 1:
                $objeto = " de matrícula";
                break;
            case 2:
                $objeto = "atestado";
                break;
        }
        if($qnde==0)
            $objeto = $objeto.'s em lote.';
        if($operacao ==0)
            $objeto = ' de cancelamento'.$objeto;

        return view('secretaria.matricula.upload-global')->with('valor',$valor)->with('tipo',$tipo)->with('operacao',$operacao)->with('qnde',$qnde)->with('objeto',$objeto);
    }


    /**
     * [uploadGlobal description]
     * @param  Request $r [description]
     * @return [type]     [description]
     */
    public function uploadGlobal(Request $r){

        switch($r->tipo){
            case 0:
                $pasta = 'inscricoes/';
                break;
            case 1:
                $pasta = 'matriculas/';
                break;
            case 2:
                $pasta = 'atestados/';
                break;        
        }

        switch ($r->operacao) {
            case 0 :
                $pasta = $pasta.'cancelamentos/';
                break;
            case 1:
                switch($r->tipo){
                    case 0:
                        $pasta = $pasta.'inclusao/';
                        break;
                    case 1:
                        $pasta = $pasta.'termos/';
                        break;
                    case 2:
                        $pasta = $pasta.'';
                        break;        
                }
                break;
        }
        if($r->qnde == 0){
            $arquivos = $r->file('arquivos');
            foreach($arquivos as $arquivo){
                if (!empty($arquivo)) 
                   $arquivo->move('documentos/'.$pasta, preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName()).'.pdf');            
            }
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Enviados'.count($arquivos).' arquivos.']);
        }
        else{
            $arquivo = $r->file('arquivos');
            if (!empty($arquivo)) 
                    $arquivo->move('documentos/'.$pasta, $r->valor.'.pdf');       
            return redirect(asset('secretaria/atender'))->withErrors(['Arquivo enviado.']);
        }   
    }

    /**
     * Função para mostrar view de renovação de matrícula
     * @param  [Integer] pessoa 
     * @return [View]      
     */
    public function renovar_vw($pessoa){
       $pessoa = \App\Pessoa::cabecalho($pessoa);
       $matriculas = Matricula::where('pessoa', $pessoa->id)
                ->whereIn('status',['expirada','ativa'])
                ->whereDate('data','>','2021-11-01')
                ->orderBy('id','desc')->get();

                //dd($matriculas);
                
             //listar inscrições de cada matricula; 
             foreach($matriculas as $matricula){
                $matricula->inscricoes = \App\Inscricao::where('matricula',$matricula->id)->whereIn('status',['regular','finalizada'])->get();
                foreach($matricula->inscricoes as $inscricao){ 
                    
                    $inscricao->proxima_turma = \App\Turma::where('professor',$inscricao->turma->professor->id)
                                                            ->where('dias_semana',implode(',', $inscricao->turma->dias_semana))
                                                            ->where('hora_inicio',$inscricao->turma->hora_inicio)
                                                            ->where('data_inicio','>',\Carbon\Carbon::createFromFormat('d/m/Y', $inscricao->turma->data_termino)->format('Y-m-d'))                                                          
                                                            ->where('status_matriculas','rematricula')
                                                            ->get();
              


                    $alternativas = \App\TurmaDados::where('turma',$inscricao->turma->id)->where('dado','proxima_turma')->first();
                    if($alternativas){
                        $array_alternativas = explode(',',$alternativas->valor);
                        foreach($array_alternativas as $alternativa){
                            $turma =\App\Turma::find($alternativa);
                            if($turma)
                                $inscricao->proxima_turma->push($turma);

                        }
                    }
                    //dd($inscricao->turma->vagas);->where('vagas', $inscricao->turma->vagas)
                }
             }
        return view('secretaria.matricula.renovacao',compact('pessoa'))->with('matriculas',$matriculas);

    }


    

    /**
     * Usando em valorController para setar o curso da matrícula
     */
    static public function matriculaSemCurso($matricula){
        $inscricao = Inscricao::where('matricula',$matricula->id)->first();
        if(!$inscricao){
            $matricula->status = 'cancelada';
            $matricula->obs = 'Cancelada automaticamente por falta de inscrições.';
            $matricula->save();
        }
        else{
            $matricula->curso = $inscricao->turma->curso->id;
            $matricula->save();
        }
    }





    /**
     * Renovação de matrícula online
     * Verifica
     * @param  Request $r [description]
     * @return [type]     [description]
     */
    public function renovar(Request $r)
    {
        
        if(!isset($r->turmas) || count($r->turmas)==0)
            return redirect()->back()->withErrors(['Nenhuma turma selecionada']);

       
        foreach($r->turmas as $turma){
                $inscricao = InscricaoController::inscreverAluno($r->pessoa,$turma,0,Auth::user()->pessoa);
            }
        
    
        $CC = new CarneController;
        $CC->gerarCarneIndividual($r->pessoa);
        
           
        if(isset($inscricao->id))    
            return redirect("/secretaria/atender/".$r->pessoa."?mostrar=todos")->with('dados["alert_sucess"]',['Turmas rematriculadas com sucesso']);
        else
            return redirect("/secretaria/atender/");
    }


    /*public function gravarRematricula(Request $r){
        if(!isset($r->agree) || $r->agree==false)
            return redirect()->back()->withErrors(['Só é possivel fazer a rematrícula concordando com o Termo de Matrícula, clicando na caixa correspondente.']);

        if(!isset($r->turmas))
            return redirect()->back()->withErrors(['Nenhuma turma selecionada']);
        
        $ip='';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip .='|'. $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip .='|'. $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip .='|'. $_SERVER['REMOTE_ADDR'];

        }
        $matriculas = array();
        foreach($r->turmas as $turma){
            //verifica se existe turma de continuação
            
                $inscricao = InscricaoController::inscreverAlunoRematricula($r->pessoa,$turma);
                $matricula = Matricula::where('pessoa',$r->pessoa)->where('status','espera')->where('curso', $inscricao->turma->curso->id)->first();
                if($matricula == null){
                    $matricula = MatriculaController::gerarMatriculaRematricula($r->pessoa,$turma,'espera');     
                }
                if(!in_array($matricula->id,$matriculas))
                    $matriculas[] = $matricula->id;
                $inscricao->matricula = $matricula->id;
                $inscricao->status = 'regular';
                $inscricao->save();
                $matricula->obs = 'Rematricula online. IP: '.$ip;
                $matricula->parcelas = $matricula->getParcelas();
                $matricula->save();
            
        }
        return view('rematricula.confirma')->with('matriculas',$matriculas)->with('pessoa',$r->pessoa);
        
    }*/





    /**
     * Cria uma cópia da matricula para regularização de situações.
     * @param  [type] $matricula [description]
     * @return [type]            [description]
     */
    public function duplicar($matricula)
    {
        $original = Matricula::find($matricula);
        $nova = new Matricula;
        $nova->pessoa = $original->pessoa;
        $nova->data = $original->data;
        $nova->forma_pg = $original->forma_pg;
        $nova->dia_venc = $original->dia_venc;
        $nova->parcelas = $original->parcelas;
        $nova->status = 'espera';
        $nova->resp_financeiro = $original->resp_financeiro;
        $nova->obs = '';
        $nova->pacote = $original->pacote;
        $nova->save();
        $nova->atendimento = AtendimentoController::novoAtendimento("Matrícula ".$nova->id." copiada da matricula ".$original->id, $nova->pessoa);

        return redirect('/secretaria/atender/'.$nova->pessoa)->withErrors(['Matricula duplicada.']);
    }




    /**
     * Muda o status das matriculas em espera para ativas.
     * Recurso só pode ser efetuado por quem for autorizado.
     * @return [type] [description]
     */
    public function ativarEmEspera(){
       
        $contador=0;
        $matriculas = Matricula::where('status','espera')->get();
        foreach($matriculas as $matricula){
            $matricula->status = 'ativa';
            $matricula->save();
            $contador++;
        }

        return redirect()->back()->withErrors([$contador.'Matriculas ativadas com sucesso.']);
    }

    public function imprimirCancelamento($matricula){
        
        $matricula = Matricula::find($matricula);
        if(!$matricula)
            return redirect()->back()->withErrors('Matrícula não encontrada para gerar a impressão.');
        $pessoa = Pessoa::find($matricula->pessoa);
        $inscricoes = Inscricao::where('matricula',$matricula->id)->where('updated_at', $matricula->updated_at)->get();
        $vencimento = \Carbon\Carbon::today()->addDays(-5);    
        $boletos = \App\Boleto::where('pessoa',$pessoa->id)
            ->whereIn('status',['emitido','divida','ABERTO EXECUTADO'])
            ->where('vencimento','<',$vencimento->toDateString())
            ->orderBy('id','desc')
            ->get();

        return view('juridico.documentos.cancelamento-matricula')->with('pessoa',$pessoa)->with('matricula',$matricula)->with('inscricoes',$inscricoes)->with('boletos',count($boletos));
    }



    public static function alterarStatus($itens,$status){
        $matriculas_array=explode(',',$itens);
        foreach($matriculas_array as $matricula_id){
            if(is_numeric($matricula_id)){
                if($status == 'cancelada'){
                    MatriculaController::cancelar($matricula_id);
                }
                else{
                    $matricula = Matricula::find($matricula_id);
                    if(isset($matricula->id)){
                        LogController::registrar('matricula',$matricula->id,'Alteração de status na matricula de '.strtoupper($matricula->status).' para '.strtoupper($status));
                        $matricula->status = $status;
                        $matricula->save();
                        InscricaoController::atualizarPorMatricula($matricula->id,$matricula->status); 
                    }
                }
                \App\BolsaMatricula::atualizarPorMatricula($matricula->id);                 
            }
        }
    }

    public function arquivo($tipo,$id){
        //Tipo
        //inscricao
        //cancelamento de matricula
        //cancelamento de inscricao

    }

    public function analiseFinanceira($id = null){
        $matriculas_alvo = Array();
        
        if($id)
            $matriculas_ativas = Matricula::select(['*','matriculas.id as matricula_id','inscricoes.id as inscricao_id', 'turmas.id as turma_id'])
                                ->whereIn('matriculas.status',['ativa','pendente'])
                                ->leftjoin('inscricoes','matriculas.id','=','inscricoes.matricula')//inscricao
                                ->leftjoin('turmas','inscricoes.turma','=','turmas.id')//turmas
                                ->where('matriculas.id',$id)
                                ->get();
        else
            $matriculas_ativas = Matricula::select(['*','matriculas.id as matricula_id','inscricoes.id as inscricao_id', 'turmas.id as turma_id'])
                                ->whereIn('matriculas.status',['ativa','pendente'])
                                ->leftjoin('inscricoes','matriculas.id','=','inscricoes.matricula')//inscricao
                                ->leftjoin('turmas','inscricoes.turma','=','turmas.id')//turmas
                                ->whereIn('turmas.local',[84,85,86])
                                ->get();
        foreach($matriculas_ativas as $matricula){

            $bolsa = \App\BolsaMatricula::where('matricula',$matricula->matricula_id)->first();

            if(!$bolsa){

                $lancamentos = \App\Lancamento::where('matricula',$matricula->matricula_id)->where('status',null)->where('boleto','>',0)->count();
                $mat_parcela = Matricula::find($matricula->matricula_id);
                //dd($mat_parcela->getParcelas());

                if($lancamentos != $mat_parcela->getParcelas())
                    $matriculas_alvo[] = $matricula->matricula_id;
            }
            



        }

        
        return  redirect('/secretaria/matricula/'.implode(',',$matriculas_alvo))->with(['info'=>'Listando matrículas com número de parcelas divergentes.']);
    }

    



        


}
