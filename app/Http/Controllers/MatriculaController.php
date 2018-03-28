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
    /**
     * Grava a Matricula e gera as inscrições
     * @param  Request $r Proveniente de formulário
     * @return View     secretaria.inscricao.gravar
     */
    public function gravar(Request $r){
        //throw new \Exception("Matricula temporariamente suspensa. Tente novamente em instantes.", 1);
        
        $matriculas=collect();
        $cursos=collect();
        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));

        $turmas=TurmaController::csvTurmas($r->turmas); // recebe lista de turmas csv
        foreach($turmas as $turma){
            if($turma->disciplina==null) // verifica se é curso ou disciplina
                $cursos->push($turma->curso);//adiciona na lista de cursos escolhidos
            else{
                if(!$cursos->contains($turma->curso))
                    $cursos->push($turma->curso); //adiciona Curso da disciplina na lista de cursos escolhidos
            }
            
        }
        foreach($cursos as $curso){ 
            $matriculado=MatriculaController::verificaSeMatriculado(Session::get('pessoa_atendimento'),$curso->id);
            $curso->turmas=collect();//cria lista de turmas de cada curso
            foreach($turmas as $turma){
                if($turma->curso->id==$curso->id)
                    $curso->turmas->push($turma);// adiciona turma ao curso
            } 
            //verifica se já possui matricula no curso
            if($matriculado==false){
                $matricula=new Matricula();
                $matricula->pessoa=Session::get('pessoa_atendimento');
                $matricula->atendimento=Session::get('atendimento');
                $matricula->data=date('Y-m-d');
                $valor="valorcursointegral".$curso->id;
                $matricula->valor=str_replace(',', '.', $r->$valor);
                $parcelas="nparcelas".$curso->id;
                $matricula->parcelas=$r->$parcelas;
                $dia_vencimento="dvencimento".$curso->id;
                $matricula->dia_venc=$r->$dia_vencimento;
                $matricula->status="ativa";
                $desconto="fdesconto".$curso->id;
                $matricula->desconto=$r->$desconto;
                $valordesconto="valordesconto".$curso->id;
                $matricula->valor_desconto=$r->$valordesconto*1;
                $matricula->curso = $curso->id;
                $matricula->save();
                $matriculas->push($matricula);
            }
            else{ // ja esta matriculada
                $matricula=Matricula::find($matriculado);
            }

            foreach($curso->turmas as $cturma){
                //return $cturma;
                $insc=InscricaoController::inscreverAluno(Session::get('pessoa_atendimento'),$cturma->id,$matricula->id);
                MatriculaController::modificaMatricula($insc->matricula);
                $matriculas->push($matricula);
                
            }
   
        }
       

        $atendimento=Atendimento::find(Session::get('atendimento'));
        $atendimento->descricao="Matricula/Inscrição ";
        $atendimento->save();

        Session::forget('atendimento');
        $pessoa=Pessoa::find(session('pessoa_atendimento'));

        return redirect(asset("/pessoa/matriculas"));
        /*
        return view("secretaria.inscricao.gravar")->with('matriculas',$matriculas)->with('nome',$pessoa->nome_simples);
         */
        

    }
    public function update(Request $r){
        $matricula=Matricula::find($r->id);
        $matricula->desconto=$r->fdesconto;
        $matricula->valor_desconto=$r->valordesconto;
        $matricula->parcelas=$r->nparcelas;
        $matricula->dia_venc=$r->dvencimento;
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
        
        $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->where('status','<>','cancelado')->get();
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
        
        $inscricoes=Inscricao::where('matricula', '=', $matricula->id)->where('status','<>','cancelado')->get();
        foreach($inscricoes as $inscricao){
            $inscricao->turmac=Turma::find($inscricao->turma->id);
        }

        //return $pessoa;

        return view("juridico.documentos.declaracao",compact('matricula'))->with('pessoa',$pessoa)->with('inscricoes',$inscricoes);
        
    }
    /*
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
                    $matricula->status="pendente";
                    $matricula->obs="Falta assinar termo e eventual atestado.";
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
                $matricula->parcelas=$turma->tempo_curso;
                $matricula->dia_venc=20;
                $matricula->status="ativa";
                $matricula->valor=str_replace(',','.',$turma->valor)*1;
                $matricula->save();
                $inscricao->matricula=$matricula->id;
                $inscricao->save();
                $resultado[]= "Criada matricula ".$matricula->id." para a inscricao de cursos id ".$inscricao->id;
            }

        }

        return $resultado;



    }
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
    public function listarPorPessoa(){
        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        $matriculas=Matricula::where('pessoa', Session::get('pessoa_atendimento'))->where('status','<>','expirada')->orderBy('id','desc')->get();
        //return $matriculas;
        $nome=Pessoa::getNome(Session::get('pessoa_atendimento'));

        return view('secretaria.matricula.lista-por-pessoa',compact('matriculas'))->with('nome',$nome)->with('pessoa_id',Session::get('pessoa_atendimento'));

    }
    public static function verificaSeMatriculado($pessoa,$curso){
        $matriculas_ativas=Matricula::where('pessoa',Session::get('pessoa_atendimento'))
            ->where('curso',$curso)
            ->Where(function($query) {
                $query->where('status','ativa')->orWhere('status','pendente');
            })->get();
        if(count($matriculas_ativas) > 0)
            return $matriculas_ativas->first()->id;  
        else
            return false;
            

    }

    public static function gerarMatricula($pessoa,$turma_id){
        $turma=Turma::find($turma_id);
        if($turma==null)
            redirect($_SERVER['HTTP_REFERER']);
        AtendimentoController::novoAtendimento("Matrícula automática por inscrição direta.", $pessoa, Session::get('usuario'));
        $matricula=new Matricula();
        $matricula->pessoa=$pessoa;
        $matricula->atendimento=1;
        $matricula->data=date('Y-m-d');
        $matricula->parcelas=$turma->tempo_curso;
        $matricula->dia_venc=20;
        $matricula->status="pendente";
        $matricula->obs="Falta assinar termo e eventual atestado.";
        $matricula->valor=str_replace(',','.',$turma->valor);
        $matricula->curso = $turma->curso->id;
        $matricula->save();

        return $matricula;




    }
    /**
     * Modifica valor da matrícula em caso de alteração.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function modificaMatricula($id){
        $matricula=Matricula::find($id);
        //$inscricoes=Inscricao::where('matricula',$matricula->id)->where('status','regular')->count();
        if($matricula->curso == 307){
            $inscricoes=Inscricao::where('matricula',$matricula->id)->where('status','regular')->get();
            switch (count($inscricoes)) {
                        case 0:
                            $matricula->valor=0;
                            break;
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
                            break;
                    }
            $matricula->save();
            //LancamentoController::atualizaMatricula($matricula->id);
            return $matricula->valor;
        }
        
    }
    public static function cancelarMatricula($id){
        $matricula=Matricula::find($id);
        $matricula->status='cancelada';
        $matricula->save();
        $inscricoes=Inscricao::where('matricula',$matricula->id)->where('status','<>','cancelado')->get();
        foreach($inscricoes as $inscricao){
            $insc=InscricaoController::cancelar($inscricao->id);
        }
        //LancamentoController::cancelamentoMatricula($id);
        AtendimentoController::novoAtendimento("Cancelamento da matricula ".$id, $matricula->pessoa, Session::get('usuario'));

        //verifica numero de parcelas existentes  se <=2 e cancela os boletos atuais se for o caso


        return redirect($_SERVER['HTTP_REFERER']);
    }
    public function ativarMatricula($id){
        $matricula=Matricula::find($id);
        $matricula->status='ativa';
        $matricula->save();
        AtendimentoController::novoAtendimento("Ativação de matrícula com pendencia ou cancelada.", $pessoa, Session::get('usuario'));
    }
    public function editar($id){
        $matricula=Matricula::find($id);
        $nome=Pessoa::getNome($matricula->pessoa);
        $descontos=Desconto::all();

        return view('secretaria.matricula.editar',compact('matricula'))->with('nome',$nome)->with('descontos',$descontos);

    }
    /*
    public function revitaliza(){
        $turmas=[88,89,99,100];
        $inscricoes=Inscricao::select('*','inscricoes.id as id')
                                 ->join('turmas', 'inscricoes.turma','=','turmas.id')
                                 ->whereIn('inscricoes.turma',$turmas)
                                 ->get();
        foreach($inscricoes as $inscricao){
            if($this->numeroInscritos($inscricao->matricula)==1){
                $matricula=Matricula::find($inscricao->matricula);
                $matricula->valor=25;
                $matricula->status='pendente';
                $matricula->obs='Falta assinar termo.';
                $matricula->save();
            }
            else{
                $matricula=new Matricula();
                $matricula->pessoa=$inscricao->pessoa->id;
                $matricula->atendimento=1;
                $matricula->data=date('Y-m-d');
                $matricula->parcelas=5;
                $matricula->dia_venc=20;
                $matricula->status="pendente";
                $matricula->obs="Falta assinar termo e eventual atestado.";
                $matricula->valor=25;
                $matricula->save();
                $inscricao->matricula=$matricula->id;
                $inscricao->save();
            }

        }
        return "Procedimento executado.";

    }*/
    public static function numeroInscritos($matricula){
        $inscritos=Inscricao::where('matricula',$matricula)->count();
        return $inscritos;
    }
    public static function regularizarCancelamentos(){
        //pega todas matriculas com status de ativo sem inscricoes regulares
        $matriculas = Matricula::select( '*', 'matriculas.status as status', 'matriculas.id as id')
                    ->join('inscricoes','inscricoes.matricula','matriculas.id')
                    ->where('matriculas.status','ativa')
                    ->where('inscricoes.status','cancelado')
                    ->get();
        /*pega todas matriculas com valor de 100
        $matriculas = Matricula::select( '*', 'matriculas.status as status', 'matriculas.id as id')
                    ->join('inscricoes','inscricoes.matricula','matriculas.id')
                    ->where('matriculas.status','ativa')
                    ->where('matriculas.valor', 100)
                    ->get();*/

    return view('secretaria.matricula.lista-geral', compact('matriculas'));


    }
    // primeiro passo para corrigir mas matriculas erradas é atribuir curso as matriculas
    public function modMatriculas(){
         $matriculas = Matricula::select( '*', 'matriculas.status as status', 'matriculas.id as id', 'inscricoes.id as inscId', 'turmas.id as turmaId','matriculas.curso as curso', 'turmas.curso as tcurso')
                    ->join('inscricoes','inscricoes.matricula','matriculas.id')
                    ->join('turmas','inscricoes.turma','turmas.id')
                    ->where('matriculas.status','ativa')
                    ->where('matriculas.curso',null)
                    ->get();
         foreach($matriculas as $matricula){
            $matricula_origin = Matricula::find($matricula->id);
            $matricula_origin->curso = $matricula->tcurso;
            $matricula_origin->save();
         }
         return $matriculas;

    }
    //seleciona pessoas que tem mais de uma matricula no curso da uati
    public function arrumarMultiplasUati(){
        $pessoas=\DB::select('select pessoa, matricula from (
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
            return redirect($_SERVER['HTTP_REFERER']);
        }
        else
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhuma inscrição REGULAR para a matrícula']);
    }


        


}
