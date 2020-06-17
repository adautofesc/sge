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
     * Grava a Matricula e gera as inscrições
     * @param  Request $r Proveniente de formulário
     * @return View     secretaria.inscricao.gravar
     */
    public function gravar(Request $r){
        //throw new \Exception("Matricula temporariamente suspensa. Tente novamente em instantes.", 1);
        
        //criar colections de objetos
        $matriculas=collect();
        $cursos=collect();


        // recebe lista de turmas csv
        $turmas=TurmaController::csvTurmas($r->turmas); 
        foreach($turmas as $turma){
            // verifica se é curso ou disciplina
            if($turma->disciplina==null) 
                $cursos->push($turma->curso);//adiciona na lista de cursos escolhidos
            else{
                if(!$cursos->contains($turma->curso))
                    $cursos->push($turma->curso); //adiciona Curso da disciplina na lista de cursos escolhidos
            }
            
        }

        $turmas = $turmas->sortByDesc('data_inicio');
    
        //para cada um dos cursos listados na lista de turmas escolhidas
        foreach($cursos as $curso){ 
            //verifica se já matriculado no curso
            

            $curso->turmas=collect();//cria lista de turmas de cada curso
            foreach($turmas as $turma){
                if($turma->curso->id==$curso->id)
                    $curso->turmas->push($turma);// adiciona turma ao curso
            } 
            //verifica se já possui matricula no curso
            $matriculado=MatriculaController::verificaSeMatriculado($r->pessoa,$curso->id,$turmas->first()->data_inicio);
            if($matriculado==false){
                $atendimento = AtendimentoController::novoAtendimento("Nova matrícula, código ", $r->pessoa, Auth::user()->pessoa);
                //dd($atendimento->id);
                $matricula=new Matricula();
                $matricula->pessoa=$r->pessoa;
                $matricula->atendimento=$atendimento->id;
                $matricula->data=date('Y-m-d');
                $valor="valorcursointegral".$curso->id;
                $matricula->valor=str_replace(',', '.', $r->$valor);
                //verifica se a pessoa está fazendo inscrição com a turma já em andamento ou não.
                if($turmas->first()->status == 'andamento' || $turmas->first()->status == 'iniciada')
                    $matricula->status="ativa";    
                else
                    $matricula->status="espera";
                $matricula->save();
                $atendimento->descricao .= $matricula->id;
                $atendimento->save();
                $matriculas->push($matricula);
            }
            else{ // ja esta matriculada
                $matricula=Matricula::find($matriculado);
            }

            foreach($curso->turmas as $cturma){
                // Increver aluno na turma
                $insc=InscricaoController::inscreverAluno($r->pessoa,$cturma->id,$matricula->id);
                $matriculas->push($matricula);
                
            }

            // define numero de parcelas

           
            $matricula->parcelas = $matricula->getParcelas();
            $matricula->save();
            
        }
        
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
        $matricula->parcelas = $r->parcelas;
        $bolsa = \App\Bolsa::select(['bolsas.id', 'bolsas.status'])
                        ->join('bolsa_matriculas','bolsa_matriculas.bolsa','bolsas.id')
                        ->where('bolsa_matriculas.matricula',$matricula->id)
                        ->first();
        if(isset($bolsa) && $bolsa->status == 'analisando')
            return redirect()->back()->withErrors(['Bolsa pendente para esta matrícula. Resolva a pendência antes']); 
        $matricula->save();
        MatriculaController::alterarStatus($matricula->id,$r->status);

        AtendimentoController::novoAtendimento("Matrícula atualizada.", $matricula->pessoa, Auth::user()->pessoa);
        //LancamentoController::atualizaMatricula($matricula->id);
        return redirect(asset('secretaria/atender'));
    }

    /**
     * [Grador do termo de Matrícula]
     * @param  [type] $matricula [description]
     * @return [type]            [description]
     */
    public function termo($matricula){
        $matricula=Matricula::find($matricula);
        if(!$matricula)
            return view("error-404");
        
        if($matricula->status == 'pendente'){
            return redirect()->back()->withErrors(['Matrículas pendentes não podem ser impressas. Altere o status em opções/editar']);
        }
        $pessoa=Pessoa::find($matricula->pessoa);
        $pessoa=PessoaController::formataParaMostrar($pessoa);
        
        $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->whereIn('status',['regular','pendente','finalizada'])->get();
        foreach($inscricoes as $inscricao){
            $inscricao->turmac=Turma::find($inscricao->turma->id);
            $inscricao->turmac->getSala();

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
    public static function verificaSeMatriculado($pessoa,$curso,$data)
    {
        $data = \Carbon\Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
        if($data > date("Y-m-d")){
            if($curso == 307)
            {
                $matriculas_ativas=Matricula::where('pessoa',$pessoa)
                ->where('curso',$curso)
                ->Where('status','espera')
                ->get();

                if($matriculas_ativas->count()>0)
                    return $matriculas_ativas->first()->id;
                else
                    return false;
            }
            else
                return false;
        }
        else{
            if($curso == 307)
            {
                $matriculas_ativas=Matricula::where('pessoa',$pessoa)
                ->where('curso',$curso)
                ->WhereIn('status',['ativa','pendente'])
                ->get();

                if($matriculas_ativas->count()>0)
                    return $matriculas_ativas->first()->id;
                else
                    return false;
            }
            else
                return false;

        }
           
    }



    /**
     * Função que verifica se já existe rematricula para esta pessoa
     * @param  [type] $pessoa [description]
     * @param  [type] $curso  [description]
     * @return [type]         [description]
     */
    public static function verificaSeRematriculado($pessoa,$curso){
        $matriculas_ativas=Matricula::where('pessoa',Session::get('pessoa_atendimento'))
            ->where('curso',$curso)
            ->where('status','espera')
            ->get();
        if($matriculas_ativas->count() > 0)
            return $matriculas_ativas->first()->id;  
        else
            return false;
            

    }

    public static function gerarMatricula($pessoa,$turma_id,$status_inicial){
        $turma=Turma::find($turma_id);
        if($turma==null)
            redirect($_SERVER['HTTP_REFERER']);
        $atendimento = AtendimentoController::novoAtendimento("Matrícula gerada por adição direta na turma, lote ou rematrícula.", $pessoa, Auth::user()->pessoa);
        $matricula=new Matricula();
        $matricula->pessoa=$pessoa;
        $matricula->atendimento=$atendimento->id;
        $matricula->data=date('Y-m-d');
        $matricula->dia_venc=10;
        $matricula->status=$status_inicial;
        $matricula->valor=str_replace(',','.',$turma->valor);
        $matricula->curso = $turma->curso->id;
        $matricula->save();

        $matricula->getParcelas();
        $matricula->save();


        return $matricula;




    }

    public static function viewCancelarMatricula($id){
        
        $matricula=Matricula::find($id);
        $pessoa = Pessoa::find($matricula->pessoa);

        return view('secretaria.matricula.cancelamento')->with('pessoa',$pessoa)->with('matricula',$matricula);
  
    }
    public function cancelarMatricula(Request $r){
        
        $matricula=Matricula::find($r->matricula);
        $matricula->status='cancelada';
        $pessoa = Pessoa::find($matricula->pessoa);
        $matricula->save();
        $insc=InscricaoController::cancelarPorMatricula($matricula->id);
        
        //cacelar os boletos automaticamente
        if($r->cancelar_boletos == true){
            //cancela os boletos
            $boleto_controller = new BoletoController;
            $boletos = \App\Boleto::where('pessoa',$matricula->pessoa)->where('vencimento', '>', date('Y-m-d H:i:s'))->get();
            //dd($boletos);
            foreach($boletos as $boleto){
                $boleto_controller->cancelamentoDireto($boleto->id,'Cancelamento de matrícula.');

            }
            //apagar lançamentos
            $LC = new LancamentoController;
            $LC->excluirSemBoletosPorMatricula($matricula->id);
        }
        //LancamentoController::cancelamentoMatricula($id);
        if(!empty($r->cancelamento))
        AtendimentoController::novoAtendimento("Cancelamento da matricula ".$matricula->id. " motivo: ".implode(', ',$r->cancelamento), $matricula->pessoa, Auth::user()->pessoa);
        else
            AtendimentoController::novoAtendimento("Cancelamento da matricula ".$matricula->id, $matricula->pessoa, Auth::user()->pessoa);

        //cancelar a bolsa se houver
        $bolsa = $matricula->getBolsas();
        if($bolsa){
        $bmc = new BolsaController;
        $bmc->unLinkMe($matricula->id,$bolsa->id);
        }

        
        //return view('juridico.documentos.cancelamento-matricula')->with('pessoa',$pessoa)->with('matricula',$matricula)->with('inscricoes',$insc)->with('boletos',count($boletos));
        return redirect('/secretaria/matricula/imprimir-cancelamento/'.$matricula->id);
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
            $regulares = $inscricoes->where('status','regular');
            if($regulares->count()>0){
                $matricula->status = 'ativa';
                $matricula->save();
                return $matricula;
            }              
            else{
                $pendentes = $inscricoes->where('status','pendente');
                if($pendentes->count()>0){
                    $matricula->status = 'pendente';
                    $matricula->save();
                    return $matricula;
                }
                else{
                    $finalizadas = $inscricoes->where('status','finalizada');
                    if($finalizadas->count()>0){
                        $matricula->status = 'expirada';
                        $matricula->save();
                        return $matricula;
                    }
                    else{
                        $matricula->status = 'cancelada';
                        $matricula->save();
                        return $matricula;
                    }
                }
            }  
        }  
        else
            dd('Erro em MatriculaController::atualizar -> Matrícula não encontrada');  

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
            AtendimentoController::novoAtendimento("Reativação de matrícula ".$matricula->id, $matricula->pessoa, Auth::user()->pessoa);
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
                ->whereIn('status',['ativa','pendente'])
                ->orderBy('id','desc')->get();
                
             //listar inscrições de cada matricula;
             foreach($matriculas as $matricula){
                $matricula->inscricoes = \App\Inscricao::where('matricula',$matricula->id)->where('status','regular')->get();
                foreach($matricula->inscricoes as $inscricao){  
                    $inscricao->proxima_turma = \App\Turma::where('professor',$inscricao->turma->professor->id)
                                                            ->where('dias_semana',implode(',', $inscricao->turma->dias_semana))
                                                            ->where('hora_inicio',$inscricao->turma->hora_inicio)
                                                            ->where('data_inicio','>',\Carbon\Carbon::createFromFormat('d/m/Y', $inscricao->turma->data_termino)->format('Y-m-d'))
                                                            ->where('vagas', $inscricao->turma->vagas)
                                                            ->where('status','inscricao')
                                                            ->get();
                    //dd($inscricao->turma->vagas);
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
     * Renovação de matrícula
     * Verifica
     * @param  Request $r [description]
     * @return [type]     [description]
     */
    public function renovar(Request $r)
    {
        if(!isset($r->turmas))
            return redirect()->back()->withErrors(['Nenhuma turma selecionada']);
        foreach($r->turmas as $turma){
            //verifica se existe turma de continuação
            if(isset($r->novaturma[$turma])){
                $inscricao = InscricaoController::inscreverAlunoSemMatricula($r->pessoa,$r->novaturma[$turma]);
                $matricula = Matricula::where('pessoa',$r->pessoa)->where('status','espera')->where('curso', $inscricao->turma->curso->id)->first();
                if($matricula == null)
                    $matricula = MatriculaController::gerarMatricula($r->pessoa,$r->novaturma[$turma],'espera'); 
                $inscricao->matricula = $matricula->id;
                $inscricao->save();
                $matricula->parcelas = $matricula->getParcelas();
                $matricula->save();
            }
        }
        return redirect("/secretaria/atender/".$r->pessoa."?mostrar=todos")->with('dados["alert_sucess"]',['Turmas rematriculadas com sucesso']);
    }





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
        $nova->save();
        $nova->atendimento = AtendimentoController::novoAtendimento("Matrícula ".$nova->id." copiada da matricula ".$original->id, $nova->pessoa, Auth::user()->pessoa);

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

        return redirect($_SERVER['HTTP_REFERER'])->withErrors([$contador.'Matriculas ativadas com sucesso.']);
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
                $matricula = Matricula::find($matricula_id);
                if(isset($matricula->id)){
                    LogController::registrar('matricula',$matricula->id,'Alteração de status na matricula de '.strtoupper($matricula->status).' para '.strtoupper($status));
                    $matricula->status = $status;
                    $matricula->save();
                    InscricaoController::atualizarPorMatricula($matricula->id,$matricula->status); 
                }
                    
            }
        }
    }

    public function arquivo($tipo,$id){
        //Tipo
        //inscricao
        //cancelamento de matricula
        //cancelamento de inscricao

    }

    



        


}
