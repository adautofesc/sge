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
use App\Lancamento;
use App\PessoaDadosGerais;
use App\PessoaDadosContato;
use App\Endereco;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
                //criar matricula nova
                $atendimento = AtendimentoController::novoAtendimento("Nova matrícula, código ", $r->pessoa, Session::get('usuario'));
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
                $matricula->curso = $curso->id;
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
        $matricula->status = $r->status;
        $matricula->obs=$r->obs;
        $matricula->save();

        AtendimentoController::novoAtendimento("Matrícula atualizada.", $matricula->pessoa, Session::get('usuario'));
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
        $pessoa=Pessoa::find($matricula->pessoa);
        $pessoa=PessoaController::formataParaMostrar($pessoa);
        
        $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->where('status','<>','cancelada')->get();
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
        
        $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->where('status','<>','cancelada')->get();
        foreach($inscricoes as $inscricao){
            $inscricao->turmac=Turma::find($inscricao->turma->id);
        }

        return view("juridico.documentos.declaracao",compact('matricula'))->with('pessoa',$pessoa)->with('inscricoes',$inscricoes);
        
    }
    
   
   /**
    * Importa inscrições feitas através de planilha externa
    * @return [type] [description]
    */
    public function importarMatriculas(){
        //importava matriculas de um aquuivo XLSX
        $registros=collect();
        

        $input='./matriculas.xlsx';
        //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($input);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($input);
        for($i=2;$i<=919;$i++){
            $insc= (object)[];
            $insc->cpfAlu=$spreadsheet->getActiveSheet()->getCell('G'.$i)->getValue();
            $pessoa_db=PessoaDadosGerais::where('valor', $insc->cpfAlu)->first();
            if(count($pessoa_db)==0){
                $pessoa=new Pessoa();
                $pessoa->nome=$spreadsheet->getActiveSheet()->getCell('D'.$i)->getValue();
                $pessoa->genero=$spreadsheet->getActiveSheet()->getCell('E'.$i)->getValue();
                $pessoa->nascimento=$spreadsheet->getActiveSheet()->getCell('J'.$i)->getFormattedValue();
                $pessoa->por=0;
                $pessoa->save();
                $dados_gerais= new PessoaDadosGerais;
                $dados_gerais->pessoa=$pessoa->id;
                $dados_gerais->dado=3; //cpf
                $dados_gerais->valor=$insc->cpfAlu;
                $dados_gerais->save();
                $pessoa_db=$dados_gerais;
                $dados_gerais= new PessoaDadosGerais;
                $dados_gerais->pessoa=$pessoa->id;
                $dados_gerais->dado=4; //rg
                $dados_gerais->valor=$spreadsheet->getActiveSheet()->getCell('F'.$i)->getValue();
                $dados_gerais->save();
                $endereco=new Endereco;
                $endereco->logradouro=$spreadsheet->getActiveSheet()->getCell('K'.$i)->getValue();
                $endereco->cidade="São Carlos";
                $endereco->estado="SP";
                $endereco->bairro=0;
                $endereco->cep=$spreadsheet->getActiveSheet()->getCell('L'.$i)->getValue();
                $endereco->save();
                $dados_contato= new PessoaDadosContato;
                $dados_contato->pessoa=$pessoa->id;
                $dados_contato->dado=6;
                $dados_contato->valor=$endereco->id;
                $dados_contato->save();
                $dados_contato= new PessoaDadosContato;
                $dados_contato->pessoa=$pessoa->id;
                $dados_contato->dado=2;
                $dados_contato->valor=$spreadsheet->getActiveSheet()->getCell('H'.$i)->getValue().$spreadsheet->getActiveSheet()->getCell('I'.$i)->getValue();
                $dados_contato->save();
            }
            if(InscricaoController::inscreverAluno($pessoa_db->pessoa,$spreadsheet->getActiveSheet()->getCell('S'.$i)->getValue())==null)
                $registros->push($insc);   
        }
        return  $registros;

    }



    /**
     * Listar Matriculas por pessoa
     * @return [type] [description]
     
    public function listarPorPessoa(){
        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        $matriculas=Matricula::where('pessoa', Session::get('pessoa_atendimento'))->where('status','<>','expirada')->orderBy('id','desc')->get();
        //return $matriculas;
        $nome=Pessoa::getNome(Session::get('pessoa_atendimento'));

        return view('secretaria.matricula.lista-por-pessoa',compact('matriculas'))->with('nome',$nome)->with('pessoa_id',Session::get('pessoa_atendimento'));

    }
    */




    /**
     * [verificaSeMatriculado description]
     * @param  [type] $pessoa [description]
     * @param  [type] $curso  [description]
     * @param  [type] $data   [description]
     * @return [type]         [description]
     */
    public static function verificaSeMatriculado($pessoa,$curso,$data)
    {
        /*
        $matriculas_ativas=Matricula::where('pessoa',Session::get('pessoa_atendimento'))
            ->where('curso',$curso)
            ->Where(function($query) {
                $query->where('status','ativa')->orWhere('status','pendente');
            })->get();
        if(count($matriculas_ativas) > 0)
            return $matriculas_ativas->first()->id;  
        else
            return false;

            */
        $data = \Carbon\Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
        if($data > date("Y-m-d")){
            if($curso == 307)
            {
                $matriculas_ativas=Matricula::where('pessoa',$pessoa)
                ->where('curso',$curso)
                ->Where('status','espera')
                ->get();

                if(count($matriculas_ativas)>0)
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

                if(count($matriculas_ativas)>0)
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
        if(count($matriculas_ativas) > 0)
            return $matriculas_ativas->first()->id;  
        else
            return false;
            

    }

    public static function gerarMatricula($pessoa,$turma_id,$status_inicial){
        $turma=Turma::find($turma_id);
        if($turma==null)
            redirect($_SERVER['HTTP_REFERER']);
        $atendimento = AtendimentoController::novoAtendimento("Matrícula gerada por adição direta na turma, lote ou rematrícula.", $pessoa, Session::get('usuario'));
        $matricula=new Matricula();
        $matricula->pessoa=$pessoa;
        $matricula->atendimento=$atendimento->id;
        $matricula->data=date('Y-m-d');
        $matricula->parcelas=$turma->tempo_curso;
        $matricula->dia_venc=20;
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
        
        $matricula=Matricula::find($r->matricula);
        $matricula->status='cancelada';
        $pessoa = Pessoa::find($matricula->pessoa);
        $matricula->save();
        $insc=InscricaoController::cancelarPorMatricula($matricula->id);
        
        //LancamentoController::cancelamentoMatricula($id);
        if(count($r->cancelamento))
        AtendimentoController::novoAtendimento("Cancelamento da matricula ".$matricula->id. " motivo: ".implode(', ',$r->cancelamento), $matricula->pessoa, Session::get('usuario'));
        else
            AtendimentoController::novoAtendimento("Cancelamento da matricula ".$matricula->id, $matricula->pessoa, Session::get('usuario'));

        //verifica numero de parcelas existentes  se <=2 e cancela os boletos atuais se for o caso
      
       
        return view('juridico.documentos.cancelamento-matricula')->with('pessoa',$pessoa)->with('matricula',$matricula)->with('inscricoes',$insc);
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
        if($matricula){
            $inscricoes = InscricaoController::inscricoesPorMatricula($id,'todas');
            if($inscricoes){
                //verifica se tem matricula regular      
                foreach($inscricoes as $inscricao){
                    if ($inscricao->status =='regular')
                        return $matricula;
                }



                //verifica se tem alguma finalizada
                foreach($inscricoes as $inscricao){
                    if ($inscricao->status =='finalizada'){
                        $matricula->status = 'expirada';
                        $matricula->save();
                        return $matricula;
                    }
                }

                //senão cancelar
                $matricula->status = 'cancelada';
                $matricula->save();
                
                return $matricula;
            }

        }
    }





    /**
     * Ativador de Matrícula
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function ativarMatricula($id){
        $matricula=Matricula::find($id);
        $matricula->status='ativa';
        $matricula->save();
        AtendimentoController::novoAtendimento("Ativação de matrícula com pendencia ou cancelada.", $pessoa, Session::get('usuario'));
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
     * Numero de inscrições
     * @param  [type] $matricula [description]
     * @return [type]            [description]
     */
    public static function numeroInscritos($matricula){
        $inscritos=Inscricao::where('matricula',$matricula)->count();
        return $inscritos;
    }




    public static function regularizarCancelamentos(){
        //pega todas matriculas com status de ativo sem inscricoes regulares
        $matriculas = Matricula::select( '*', 'matriculas.status as status', 'matriculas.id as id')
                    ->join('inscricoes','inscricoes.matricula','matriculas.id')
                    ->where('matriculas.status','ativa')
                    ->where('inscricoes.status','cancelada')
                    ->get();
        /*pega todas matriculas com valor de 100
        $matriculas = Matricula::select( '*', 'matriculas.status as status', 'matriculas.id as id')
                    ->join('inscricoes','inscricoes.matricula','matriculas.id')
                    ->where('matriculas.status','ativa')
                    ->where('matriculas.valor', 100)
                    ->get();*/

    return view('secretaria.matricula.lista-geral', compact('matriculas'));


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




    /**
     * Modificador de Matrícula individual
     * Atribui código do curso na matrícula ativas ou pendentes sem esse código. Cancela caso não tiver incrição
     * @param  [Matricula] $matricula [objeto matrícula]
     * @return [type]            [description]
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





    //seleciona pessoas que tem mais de uma matricula no curso da uati
    public function arrumarMultiplasUati(){
        $pessoas=\DB::select('select pessoa, matricula from (
        }
select distinct(pessoa),count(id)as matricula from matriculas where curso = 307 group by pessoa)as nt
where nt.matricula>1');

        foreach($pessoas as $pessoa ){
            $matriculap = '';
            $matriculas = Matricula::where('pessoa',$pessoa->pessoa)->where('curso',307)->get();
            foreach($matriculas as $matricula){
                if($matricula->status != 'cancelada'){
                    if($matriculap == ''){
                        $matriculap = $matricula->id;
                    }
                    else{
                        $matricula->status = 'cancelada';
                        $matricula->save();
                        $inscricoes = Inscricao::where('matricula',$matricula->id)->get();
                        foreach($inscricoes as $inscricao){
                            $inscricao->matricula = $matriculap;
                            $inscricao->save();
                        }


                    }

                }

            }

        }
        return "metodo executado";



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
        if(count($insc)>0){
            $matricula->save();
            AtendimentoController::novoAtendimento("Reativação de matrícula ".$matricula->id, $matricula->pessoa, Session::get('usuario'));
            return redirect($_SERVER['HTTP_REFERER']);
        }
        else
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhuma inscrição REGULAR para a matrícula']);
    }

    public function uploadTermo_vw($matricula){
        return view('secretaria.matricula.upload-termo')->with('matricula',$matricula);
    }
    public function uploadTermo(Request $r){
        $arquivo = $r->file('arquivo');
            
                if (!empty($arquivo)) {
                    $arquivo->move('documentos/matriculas/termos',$r->matricula.'.pdf');
                }

            return redirect(asset('secretaria/atender'));
    }
    public function uploadTermosLote(Request $r){
        $arquivos = $r->file('arquivos');
            foreach($arquivos as $arquivo){
                //dd($arquivo);
                if (!empty($arquivo)) {
                    $arquivo->move('documentos/matriculas/termos', preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName()).'.pdf');
                }

            }
        return redirect(asset('secretaria/matricula/upload-termo-lote'))->withErrors(['Enviados'.count($arquivos).' arquivos.']);
    }
    public function uploadCancelamentoMatricula_vw($matricula){
        return view('secretaria.matricula.upload-termo')->with('matricula',$matricula);
    }
    public function uploadCancelamentoMatricula(Request $r){
        $arquivos = $r->file('arquivos');
            foreach($arquivos as $arquivo){
                //dd($arquivo);
                if (!empty($arquivo)) {
                    $arquivo->move('documentos/matriculas/cancelamentos', preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName()).'.pdf');
                }

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
        //dd($r);

        if($r->qnde == 0){

            $arquivos = $r->file('arquivos');
            foreach($arquivos as $arquivo){
                //dd($arquivo);
                if (!empty($arquivo)) {
                    $arquivo->move('documentos/'.$pasta, preg_replace( '/[^0-9]/is', '', $arquivo->getClientOriginalName()).'.pdf');
                }
            }
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Enviados'.count($arquivos).' arquivos.']);
        }
        else{
            $arquivo = $r->file('arquivos');
            if (!empty($arquivo)) {
                    $arquivo->move('documentos/'.$pasta, $r->valor.'.pdf');
            }
            return redirect(asset('secretaria/atender'))->withErrors(['Arquivo enviado.']);

        }   
    }

    /**
     * Função para mostrar view de renovação de matrícula
     * @param  [Integer] pessoa 
     * @return [View]      
     */
    public function renovar_vw($pessoa)
    {
       $pessoa = \App\Pessoa::cabecalho($pessoa);
       $matriculas = Matricula::where('pessoa', $pessoa->id)
                ->where(function($query){ $query
                            ->where('status','ativa')
                            ->orwhere('status', 'pendente');
                    })
                ->orderBy('id','desc')->get();
                
             //listar inscrições de cada matricula;
             foreach($matriculas as $matricula){
                $matricula->getInscricoes();
                //dd($matricula);
                foreach($matricula->inscricoes as $inscricao){
                    
                    $inscricao->proxima_turma = \App\Turma::where('professor',$inscricao->turma->professor->id)
                                        ->where('dias_semana',implode(',', $inscricao->turma->dias_semana))
                                        ->where('hora_inicio',$inscricao->turma->hora_inicio)
                                        ->where('data_inicio','>',\Carbon\Carbon::createFromFormat('d/m/Y', $inscricao->turma->data_termino)->format('Y-m-d'))
                                        ->get();
                }
             }
        //dd($matriculas);

       return view('secretaria.matricula.renovacao',compact('pessoa'))->with('matriculas',$matriculas);

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

                //inscreve pessoa na nova turma
                $inscricao = InscricaoController::inscreverAlunoSemMatricula($r->pessoa,$r->novaturma[$turma]);

                //procurar matricula em espera ja existente do mesmo curso
                $matricula = Matricula::where('pessoa',$r->pessoa)->where('status','espera')->where('curso', $inscricao->turma->curso->id)->first();
                
                if($matricula == null){


                    //senao cria uma nova
                    $matricula = MatriculaController::gerarMatricula($r->pessoa,$r->novaturma[$turma],'espera');

                }

                //atribui matricula a inscricao
                $inscricao->matricula = $matricula->id;
                $inscricao->save();
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

        $nova->atendimento = AtendimentoController::novoAtendimento("Matrícula ".$nova->id." copiada da matricula ".$original->id, $nova->pessoa, Session::get('usuario'));
        
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

        //return $inscricoes;
        return view('juridico.documentos.cancelamento-matricula')->with('pessoa',$pessoa)->with('matricula',$matricula)->with('inscricoes',$inscricoes);
    }


        


}
