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

class InscricaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function editar($id){
        $inscricao = Inscricao::find($id);
        return view('secretaria.inscricao.editar',compact('inscricao'));
    }
    public function novaInscricao($id_pessoa){

        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));
        $str_turmas='';
        $turmas=collect();
        $incricoes_atuais=Inscricao::where('pessoa',$id_pessoa)->where('status', '<>','cancelado')->get();
        //return $incricoes_atuais;
        //->where('status','<>','cancelado')

        foreach($incricoes_atuais as $inscricao){
            $str_turmas=$str_turmas.','.$inscricao->turma->id;
            $turma=Turma::find($inscricao->turma->id);
            $turmas->push($turma);

        }

        

        //return $turmas;

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
        $existe=Inscricao::where('turma',$turma)->where('pessoa',$pessoa)->where('status','<>','cancelado')->get();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     
    public function gravar(Request $request)
    {
        //return $request->pendente;
        if(!Session::get('pessoa_atendimento'))
            return redirect(asset('/secretaria/pre-atendimento'));
        if(!Session::get('atendimento'))
            return redirect(asset('/secretaria/atender'));
        $inscricoes=collect();
        if($request->pendente=='true'){
            $status='pendente';
        }
        else
            $status='regular';
        //return $status.'-'.$request->pendente;

        return $request;
        
        foreach($request->turmas as $turma_id){
            
            $inscricao=$this->inscreverAluno(Session::get('pessoa_atendimento'),$turma_id);
            $inscricoes->push($inscricao);

        }// fim foreach turmas

       $atendimento=Atendimento::find(Session::get('atendimento'));
        $atendimento->descricao="Inscricao(s)";
        $atendimento->save();

        Session::forget('atendimento');
        $pessoa=Pessoa::find(session('pessoa_atendimento'));



        //return $Inscricaos;
        return view("secretaria.inscricao.gravar")->with('inscricoes',$inscricoes)->with('nome',$pessoa->nome_simples);

    }*/

    /**
     * Display the specified resource.
     *
     * @param  \App\Inscricao  $Inscricao
     * @return \Illuminate\Http\Response
     */
    public function show(Inscricao $Inscricao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inscricao  $Inscricao
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscricao $Inscricao)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inscricao  $Inscricao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscricao $Inscricao)
    {
        //
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
    public function inscreverAlunoLote($turma,Request $r){
        //return "função temporareamente bloqueada";
        $inscricao=InscricaoController::inscreverAluno($r->id_pessoa,$turma);
        MatriculaController::modificaMatricula($inscricao->matricula);

        return redirect(asset('/secretaria/turma/'.$turma));
    }
    /**
     * Cancelamento de Inscrição
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function cancelar($id){
        $insc=Inscricao::find($id);
        if($insc==null)
            return die("Inscrição não encontrada");
        //return $insc->turma->id."teste";
        if($insc->status == 'cancelado')
            return redirect($_SERVER['HTTP_REFERER']);
        InscricaoController::modInscritos($insc->turma->id,0,1);
        $insc->status='cancelado';
        $insc->save();

        MatriculaController::modificaMatricula($insc->matricula);
        $num_inscricoes=count(InscricaoController::inscricoesPorMatricula($insc->matricula));
        if($num_inscricoes==0)
            MatriculaController::cancelarMatricula($insc->matricula);
        AtendimentoController::novoAtendimento("Inscrição ".$insc->id." da matrícula ".$insc->matricula." cancelada.", $insc->pessoa->id, Session::get('usuario'));
        return redirect($_SERVER['HTTP_REFERER']); //volta pra pagina anterior, atualizando ela.

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
    /* Metodo para atualizar numero de vagas das turmas de acordo com as inscrições efetuadas
    public function atualizarInscritos(){
        $linha="";
        $turmas=Turma::all();
        foreach($turmas as $turma){
            $inscricoes=Inscricao::where('turma',$turma->id)->where('status','<>','cancelado')->get();
            $turma->matriculados=count($inscricoes);
            $turma->save();
            $linha.=  " <br> turma ".$turma->id. "inscritos: ".count($inscricoes);
        }
       
    return $linha;
    } */
        //secretaria
    public function verInscricoes($turma){
        $turma=Turma::find($turma);
        if (empty($turma))
            return redirect(asset('/secretaria/turmas'));
        $inscricoes=Inscricao::where('turma','=', $turma->id)->where('status','<>','cancelado')->get();
        foreach ($inscricoes as $inscricao) {
            $inscricao->telefone = \App\PessoaDadosContato::getTelefone($inscricao->pessoa->id);
            
        }
        //return $inscricoes;
        return view('pedagogico.turma.dados',compact('turma'))->with('inscricoes',$inscricoes);


    }
    //pedagogico
    public function verInscritos($turma){
        $turma=Turma::find($turma);
        if (empty($turma))
            return redirect(asset('/secretaria/turmas'));
        $inscricoes=Inscricao::where('turma','=', $turma->id)->where('status','<>','cancelado')->get();
        //return $inscricoes;
        return view('pedagogico.turma.inscritos',compact('turma'))->with('inscricoes',$inscricoes);


    }
    /*
    public static function cancelarInscricao($inscricao){
        $inscricao->status='cancelado';
        $inscricao->save();
        InscricaoController::modInscritos($inscricao->turma->id,0,1);
        MatriculaController::modificaMatricula($inscricao->matricula);
        if(count(InscricaoController::inscricoesPorMatricula($inscricao->matricula))==0)
            MatriculaController::cancelarMatricula($inscricao->matricula);
        return $inscricao;
    }*/
    public static function inscricoesPorMatricula($matricula){
        $inscricoes=Inscricao::where('matricula', $matricula)->where('status','regular')->get();
        return $inscricoes;
    }
    public function incricoesPorPosto(){
        $vagas=['Fesc 1'=>0,'Fesc 2'=>0,'Fesc 3'=>0];
        $locais= array(84 =>'Fesc 1',
                       85 =>'Fesc 2',
                       86 =>'Fesc 3');
        foreach($locais as $local_id => $local_nome){
            $qnde=Inscricao::join('turmas', 'inscricoes.turma','=','turmas.id')
                            ->where('local',$local_id)
                            ->where('inscricoes.status','<>','cancelado')
                            ->groupBy('inscricoes.pessoa')
                            ->count('inscricoes.pessoa');
            return $qnde;//
        // select count(i.pessoa) from inscricoes i join turmas t on i.turma = t.id where t.`local`=86 group by pessoa                    
            $vagas[$local_nome]=$qnde;

        }

        return $vagas;
    }
    public static function reativar($insc){
        $curso = '';
        $inscricao = Inscricao::find($insc);
        $turma = Turma::find($inscricao->turma->id);
        if(isset($turma->disciplina->nome))
            $curso = $turma->disciplina->nome;
        else
            $curso = $turma->curso->nome;

        if($turma->vagas >= $turma->matriculados){
            if($inscricao->status == 'cancelado'){
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


}
