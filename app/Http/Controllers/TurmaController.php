<?php

namespace App\Http\Controllers;

use App\Turma;
use App\Local;
use App\Programa;
use App\classes\Data;
use App\PessoaDadosAdministrativos;
use App\Parceria;
use App\Pessoa;
use App\Inscricao;
//use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($dados='')
    {
        $turmas=Turma::orderBy('curso')->get();
       
        $programas=Programa::all();


        //return $turmas;
        //$dados=['alert_sucess'=>['hello world']];
        return view('pedagogico.turma.listar', compact('turmas'))->with('programas',$programas)->with('dados',$dados);
    }

    public function listarSecretaria($dados='')
    {
        $turmas=Turma::select('*', 'turmas.id as id' ,'turmas.vagas as vagas','disciplinas.id as disciplinaid','cursos.id as cursoid','turmas.programa as programaid')
                ->join('cursos', 'turmas.curso','=','cursos.id')
                ->leftjoin('disciplinas', 'turmas.disciplina','=','disciplinas.id')
                ->orderBy('cursos.nome')
                ->orderBy('disciplinas.nome')
                ->get();

        //return $turmas;
       
        $programas=Programa::all();


        //return $dados;
        //$dados=['alert_sucess'=>['hello world']];
        //return $turmas;
        return view('secretaria.listar-turmas', compact('turmas'))->with('programas',$programas)->with('dados',$dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $programas=Programa::get();
        //$cursos=Curso::getCursosPrograma(); ok
        $professores=PessoaDadosAdministrativos::getFuncionarios('Educador');
        $unidades=Local::get(['id' ,'nome']);
        $parcerias=Parceria::orderBy('nome')->get();
        //Locais=Local::getLocaisPorUnidade($unidade);
        $dados=collect();
        $dados->put('programas',$programas);
        $dados->put('professores',$professores);
        $dados->put('unidades',$unidades);
        $dados->put('parcerias',$parcerias);

        //return $dados;

        return view('pedagogico.turma.cadastrar',compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "programa"=>"required|numeric",
            "curso"=>"required|numeric",
            "professor"=>"required|numeric",
            "unidade"=>"required|numeric",
            "dias"=>"required",
            "dt_inicio"=>"required",
            "hr_inicio"=>"required",
            "vagas"=>"required",
            "valor"=>"required"


        ]);



        $turma=new Turma;
        $turma->programa=$request->programa;
        $turma->curso=$request->curso;
        $turma->disciplina=$request->disciplina;
        $turma->professor=$request->professor;
        $turma->local=$request->unidade;
        $turma->dias_semana=$request->dias;
        $turma->data_inicio=$request->dt_inicio;
        $turma->data_termino=$request->dt_termino;
        $turma->hora_inicio=$request->hr_inicio;
        $turma->hora_termino=$request->hr_termino;
        $turma->parceria=$request->parceria;
        $turma->periodicidade=$request->periodicidade;
        $turma->valor=$request->valor;
        $turma->vagas=$request->vagas;
        $turma->atributos=$request->atributo;
        $turma->status=1;
        //return $turma->dias_semana;

        $turma->save();
        if($request->btn==1)
            return redirect(asset('/pedagogico/turmas'));
        else
            return redirect(asset('/pedagogico/turmas/cadastrar'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function show(Turma $turma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $turma=Turma::find($id);
        if($turma){
            $programas=Programa::get();
            $parcerias=Parceria::orderBy('nome')->get();
            //$cursos=Curso::getCursosPrograma(); ok
            $professores=PessoaDadosAdministrativos::getFuncionarios('Educador');
            $unidades=Local::get();
            //Locais=Local::getLocaisPorUnidade($unidade);
            $dados=collect();
            $dados->put('programas',$programas);
            $dados->put('professores',$professores);
            $dados->put('unidades',$unidades);
            $dados->put('parcerias', $parcerias);
            $turma->data_iniciov=Data::converteParaBd($turma->data_inicio);
            $turma->data_terminov=Data::converteParaBd($turma->data_termino);

            //return $turma;

            return view('pedagogico.turma.editar',compact('dados'))->with('turma',$turma);
        }
        else
            return $this->index();
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Turma $turma)
    {
        $this->validate($request, [
            "turmaid"=>"required|numeric",
            "programa"=>"required|numeric",
            "curso"=>"required|numeric",
            "professor"=>"required|numeric",
            "unidade"=>"required|numeric",
            "dias"=>"required",
            "dt_inicio"=>"required",
            "hr_inicio"=>"required",
            "vagas"=>"required",
            "valor"=>"required",
            "periodicidade"=>"required"


        ]);
        $turma=Turma::find($request->turmaid);
        $turma->programa=$request->programa;
        $turma->curso=$request->curso;
        $turma->disciplina=$request->disciplina;
        $turma->professor=$request->professor;
        $turma->local=$request->unidade;
        $turma->dias_semana=$request->dias;
        $turma->data_inicio=$request->dt_inicio;
        $turma->data_termino=$request->dt_termino;
        $turma->hora_inicio=$request->hr_inicio;
        $turma->hora_termino=$request->hr_termino;
        $turma->valor=$request->valor;
        $turma->vagas=$request->vagas;
        $turma->atributos=$request->atributo;
        $turma->periodicidade=$request->periodicidade;
        $turma->update();
        return $this->index();
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function destroy($itens_url)
    {
        $msgs=Array();
        $turmas=explode(',',$itens_url);
        foreach($turmas as $turma){
            if(is_numeric($turma)){
                $turma=Turma::find($turma);
                if($turma){
                    // Aqui virá uma verificação que se há matrículas antes de excluir
                    $msgs=array('alert_sucess'=>["Turma ".$turma->id." excluída com sucesso."]);
                    $turma->delete();
                    
                }
            }
        }
        return $this->index($msgs);
    }
    public function status($status,$itens_url)
    {
        $turmas=explode(',',$itens_url);
        foreach($turmas as $turma){
            if(is_numeric($turma)){
                $turma=Turma::find($turma);
                if($turma){
                    // Aqui virá uma verificação que se há matrículas antes de excluir
                    $msgs['alert_sucess'][]="Turma ".$turma->id." modificada com sucesso.";
                    $turma->status=$status;
                    $turma->save();
                    
                }
            }
        }
        //return $msgs;
        return $this->listarSecretaria($msgs);
    }
    public function turmasDisponiveis($turmas_atuais='0',$ordered_by='')
    {
        $turmas_af=collect();
        $lista=array();
        $lst=array();
        $turmas_atuais=explode(',',$turmas_atuais);
        foreach($turmas_atuais as $turma){
            if(is_numeric($turma)){
                if(Turma::find($turma))
                    $turmas_af->push(Turma::find($turma));
            }
        }
        //return $turmas_af;
        if(count($turmas_af)==0){
            $turmas=Turma::select('*', 'turmas.id as id' ,'turmas.programa as programa','turmas.vagas as vagas' ,'disciplinas.id as disciplinaid','cursos.id as cursoid')
                -> where('status', '>', 2)
                ->join('cursos', 'turmas.curso','=','cursos.id')
                ->leftjoin('disciplinas', 'turmas.disciplina','=','disciplinas.id')
                ->whereNotIn('turmas.id', $lst)
                ->orderBy('cursos.nome')
                ->orderBy('disciplinas.nome')
                ->get();

            
            //return $turmas;
            $programas=Programa::get();
            //return $turmas;
            return view('secretaria.inscricao.lista-formatada', compact('turmas'))->with('programas',$programas);
        }
        else{

            foreach($turmas_af as $turma){
                    $hora_fim=date("H:i",strtotime($turma->hora_termino." - 1 minutes"));
                    foreach($turma->dias_semana as $turm){
                        $lista[]=Turma::where('dias_semana', 'like', '%'.$turm.'%')->whereBetween('hora_inicio', [$turma->hora_inicio,$hora_fim])->get(['id']);
                    }
                    
                }
            //transforma resultados em array
            foreach($lista as $x){
                foreach($x as $y)
                    $lst[]=$y->id;

            }

            //return $lst;

            
            $turmas=Turma::select('*', 'turmas.id as id', 'turmas.programa as programa','turmas.vagas as vagas' ,'disciplinas.id as disciplinaid','cursos.id as cursoid')
                ->where('turmas.status', '>', 2)
                ->join('cursos', 'turmas.curso','=','cursos.id')
                ->leftjoin('disciplinas', 'turmas.disciplina','=','disciplinas.id')
                ->whereNotIn('turmas.id', $lst)
                ->orderBy('cursos.nome')
                ->orderBy('disciplinas.nome')
                ->get();


        }
        $programas=Programa::get();

        //return $turmas;
        return view('secretaria.inscricao.lista-formatada', compact('turmas'))->with('programas',$programas);
        
    }
    public function turmasEscolhidas($lista='0'){
        $turmas=collect();
        $valor=0;
        $uati=0;
        $parcelas=4;
        $lista=explode(',',$lista);
        foreach($lista as $turma){
            if(is_numeric($turma)){
                $db_turma=Turma::find($turma);
                if(count($db_turma)>0)
                    $turmas->push($db_turma);
            }

        }

        foreach($turmas as $turma){
            if($turma->curso->id==307)
                $uati++;
            else
            $valor=$valor+str_replace(',', '.',$turma->valor);
        }
        switch ($uati) {
            case '1':
                $valor=$valor+100;
                break;
            case '2':
            case '3':
            case '4':
                $valor=$valor+250;
                break;
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
                $valor=$valor+400;
                break;
            
        }

        return view('secretaria.inscricao.turmas-escolhidas', compact('turmas'))->with('valor',$valor)->with('parcelas',$parcelas);

    }
    public static function csvTurmas($lista='0'){
        $turmas=collect();
        $valor=0;
        $parcelas=4;
        $lista=explode(',',$lista);
        foreach($lista as $turma){
            if(is_numeric($turma)){
                if(Turma::find($turma))
                    $turmas->push(Turma::find($turma));
            }
        }
        return $turmas->sortBy('hora_inicio');

    }

    public function turmasJSON(){
        $programas=Programa::get();
        foreach($programas as $programa){
            $turmas=Turma::where('turmas.programa',$programa->id)
                                        ->join('cursos','turmas.curso','=','cursos.id')
                                        ->leftjoin('disciplinas','turmas.disciplina','=','disciplinas.id')
                                        ->get();
            foreach($turmas as $turma){
                $dados[$programa->sigla][$turma->id]=$turmas;
            }
        }
        return $dados;
    }

    public function turmasSite(){

        $turmas=Turma::select('*', 'turmas.vagas as vagas','turmas.id as id')
                ->where('turmas.status','>',0)
                ->join('cursos', 'turmas.curso','=','cursos.id')
                ->leftjoin('disciplinas', 'turmas.disciplina','=','disciplinas.id')
                ->orderBy('cursos.nome')
                ->orderBy('disciplinas.nome')
                ->get();
        //return $turmas;
        return view('pedagogico.turma.turmas-site',compact('turmas'));
    }

    public function listarProfessores(){

        $professores=PessoaDadosAdministrativos::getFuncionarios('Educador');
        return view('docentes.lista-professores',compact('professores'));

    }
    public function turmasProfessor(Request $r){
        $turmas=Turma::select('*', 'turmas.id as id')
                ->where('turmas.status','>',0)
                ->where('professor',$r->professor)
                ->join('cursos', 'turmas.curso','=','cursos.id')
                ->leftjoin('disciplinas', 'turmas.disciplina','=','disciplinas.id')
                ->orderBy('cursos.nome')
                ->orderBy('disciplinas.nome')
                ->get();
        $professor=Pessoa::find($r->professor);

        return view('pedagogico.turma.turmas-site',compact('turmas'))->with('professor',$professor->nomeSimples);

    }
    //secretaria
    public function verInscricoes($turma){
        $turma=Turma::find($turma);
        if (empty($turma))
            return redirect(asset('/secretaria/turmas'));
        $inscricoes=Inscricao::where('turma','=', $turma->id)->where('status','<>','cancelado')->get();
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








    }

}
