<?php

namespace App\Http\Controllers;

use App\Turma;
use App\TurmaDados;
use App\Local;
use App\Programa;
use App\classes\Data;
use App\PessoaDadosAdministrativos;
use App\Parceria;
use App\Pessoa;
use App\Inscricao;
use App\CursoRequisito;
use App\Endereco;
use App\PessoaDadosContato;
//use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TurmaController extends Controller
{
    /**
     * Listagem de turmas para o setor pedagógico.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $turmas = $this->listagemGlobal($request->filtro,$request->valor,$request->removefiltro,$request->remove);

        $programas=Programa::all();
        $professores=PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
        $professores = $professores->sortBy('nome_simples');
        $locais = Local::select(['id','sigla','nome'])->orderBy('sigla')->get();
        $periodos = \App\classes\Data::semestres();
        return view('turmas.listar-pedagogico', compact('turmas'))
            ->with('programas',$programas)
            ->with('professores', $professores)
            ->with('locais',$locais)
            ->with('filtros',$_SESSION['filtro_turmas'])
            ->with('periodos',$periodos);
    }





    /**
     * Pedagogico ver dados das turmas.
     * @param  [type] $turma [description]
     * @return [type]        [description]
     */
    public function mostrarTurma($turma){
        $turma=Turma::find($turma);
        if (empty($turma))
            return redirect(asset('/turmas'));
        $inscricoes=Inscricao::where('turma','=', $turma->id)->where('status','<>','cancelada')->get();
        $inscricoes->sortBy('pessoa.nome');
        
        foreach ($inscricoes as $inscricao) {
            $inscricao->telefone = \App\PessoaDadosContato::getTelefone($inscricao->pessoa->id);
            $inscricao->aluno = \App\Pessoa::find($inscricao->pessoa->id);

            $inscricao->atestado = $inscricao->getAtestado();
            if($inscricao->atestado){
                $inscricao->atestado->validade =  $inscricao->atestado->calcularVencimento($turma->programa->id);
                //dd($inscricao->atestado);
            }
           
        }
        $requisitos = CursoRequisito::where('para_tipo','turma')->where('curso',$turma->id)->get();
        $aulas = \App\Aula::where('turma',$turma->id)->orderBy('data')->get();
        foreach($aulas as $aula){
            //$aula->data = \DateTime::createFromFormat('Y-m-d H:i:s',$aula->data);
            switch($aula->status){
                case 'prevista': 
                    $aula->badge = 'secondary';
                    break;
                case 'planejada': 
                    $aula->badge = 'primary';
                    break;
                case 'executada': 
                    $aula->badge = 'success';
                    break;
                case 'cancelada': 
                    $aula->badge = 'danger';
                    break;
                case 'adiada': 
                    $aula->badge = 'warning';
                    break;
            }
           
        }
        
        //return $inscricoes;
        return view('turmas.dados-pedagogico',compact('turma'))->with('inscricoes',$inscricoes)->with('requisitos',$requisitos)->with('aulas',$aulas);


    }


    /**
     * Listador global de turmas
     * Suporta os seguintes tipos de filtros:
     *     -programa
     *     -professor
     *     -local
     *     -status
     * 
     * @param  [type]  $filtro [description]
     * @param  [type]  $valor  [description]
     * @param  integer $remove [description]
     * @param  integer $ipp    [Quantidade de itens por página]
     * @return [type]          [description]
     */
    public function listagemGlobal($filtro=null,$valor=null,$rem_filtro=null,$remove=0,$ipp=50){

        session_start();
 
        
        if(isset($_SESSION['filtro_turmas']))
            $filtros = $_SESSION['filtro_turmas'];
        
        else
            $filtros = array();
            
        if(isset($filtro) && isset($valor)){
           
            if(array_key_exists($filtro, $filtros)){
                $busca = array_search($valor, $filtros[$filtro]);
                if($busca === false){
                    $filtros[$filtro][] = $valor;
                }
                else
                {
                    if($remove > 0){
                        unset($filtros[$filtro][$busca]);
                    }
                }
            }
            else{
                $filtros[$filtro][] = $valor;
            }
            
        }
        if($rem_filtro != null){
            if(isset($filtros[$rem_filtro]))
                unset($filtros[$rem_filtro]);
        }
        

        $_SESSION['filtro_turmas'] = $filtros;

        $turmas=Turma::select('*', 'turmas.id as id' ,'turmas.vagas as vagas','turmas.carga as carga', 
            'turmas.programa as programa', 'turmas.periodicidade as periodicidade','disciplinas.id as disciplinaid','cursos.id as cursoid',
            'turmas.programa as programaid','turmas.valor as valor')
                ->join('cursos', 'turmas.curso','=','cursos.id')
                ->leftjoin('disciplinas', 'turmas.disciplina','=','disciplinas.id');

        if(isset($filtros['programa']) && count($filtros['programa'])){
            $turmas = $turmas->whereIn('turmas.programa', $filtros['programa']); 
        }

        if(isset($filtros['professor']) && count($filtros['professor'])){
            $turmas = $turmas->whereIn('turmas.professor', $filtros['professor']); 
        }
        if(isset($filtros['local']) && count($filtros['local'])){
            $turmas = $turmas->whereIn('turmas.local', $filtros['local']); 
        }

        if(isset($filtros['status']) && count($filtros['status'])){
            $turmas = $turmas->whereIn('turmas.status', $filtros['status']); 
        }

        if(isset($filtros['status_matriculas']) && count($filtros['status_matriculas'])){
            $turmas = $turmas->whereIn('turmas.status_matriculas', $filtros['status_matriculas']); 
        }

        if(isset($filtros['pordata']) && count($filtros['pordata'])){
            $str1 = substr($filtros['pordata'][0],1,10);
            if($str1 == 'undefinedt'){
                $str2 = substr($filtros['pordata'][0],11,10);
                try{
                    $data2 = \DateTime::createFromFormat('Y-m-d', $str2);
                    if($data2 && $data2->format('Y-m-d') === $str2){
                       $turmas = $turmas->where('data_termino','<=',$data2);
                    }
                }
                catch(\Exception $e){
                    unset($filtros['pordata']);
                }
            }
            else{
                try{
                    $data1 = \DateTime::createFromFormat('Y-m-d', $str1);
                    if($data1 && $data1->format('Y-m-d') === $str1){
                       $turmas = $turmas->where('data_inicio','>=',$data1);
                    }
                    

                }
                catch(\Exception $e){
                    unset($filtros['pordata']);
                }
                $str2 = substr($filtros['pordata'][0],12,10);
                try{
                    $data2 = \DateTime::createFromFormat('Y-m-d', $str2);
                    if($data2 && $data2->format('Y-m-d') === $str2){
                       $turmas = $turmas->where('data_termino','<=',$data2);
                    }
                }
                catch(\Exception $e){
                    unset($filtros['pordata']);
                }
            }

        }

        if(isset($filtros['periodo']) && count($filtros['periodo'])){
            if(count($filtros['periodo'])==1){
                $elemento = current($filtros['periodo']);
                $intervalo = \App\classes\Data::periodoSemestre($elemento);
                $turmas = $turmas->whereBetween('turmas.data_inicio', $intervalo);
            }      
            else{
                //Parameter Grouping
                $turmas = $turmas->where(function ($query) use ($filtros){
                    foreach($filtros['periodo'] as $periodo){
                        $intervalo = \App\classes\Data::periodoSemestre($periodo);
                        $query = $query->orWhereBetween('turmas.data_inicio', $intervalo);
                    }

                });
            }
               
        }
        if(!isset($filtros['periodo']) || !isset($filtros['status']) || !isset($filtros['status_matriculas'])){
            $turmas = $turmas->whereIn('turmas.status', ['iniciada','lancada']); 

        }
    

        $turmas = $turmas->orderBy('cursos.nome')->orderBy('disciplinas.nome');

        $turmas = $turmas->paginate($ipp);

        foreach($turmas as $turma){
            //$turma->parcelas = Turma::find($turma->id);
            $pacote = TurmaDados::where('dado','pacote')->where('turma',$turma->id)->first();
            $turma->pacote = $pacote;
            $turma->parcelas = $turma->getParcelas();
            $turma->getSala();
        }

        //dd($turmas);
        
        return $turmas;

    }




    /**
     * Listagem de turmas da secretaria
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function listarSecretaria(Request $request)
    {
        
        $turmas = $this->listagemGlobal($request->filtro,$request->valor,$request->removefiltro,$request->remove);
        $programas=Programa::all();
        $professores=PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
        $professores = $professores->sortBy('nome_simples');
        $locais = Local::select(['id','sigla','nome'])->orderBy('sigla')->get();

        return view('turmas.listar-secretaria', compact('turmas'))->with('programas',$programas)->with('professores', $professores)->with('locais',$locais)->with('filtros',$_SESSION['filtro_turmas'])->with('periodos',\App\classes\Data::semestres());
    }


       /**
    * Lista em Brnco
    * @param  [type] $id [description]
    * @return [type]     [description]
    */
    public function impressao($id){
        $inscritos=\App\Inscricao::where('turma',$id)->whereIn('status',['regular','espera','ativa','pendente'])->get();
        $inscritos= $inscritos->sortBy('pessoa.nome');
        if(count($inscritos))
            return view('pedagogico.frequencia.index',compact('inscritos'))->with('i',1);
        else
            return "Nenhum aluno cadastrado para esta turma.";
    }
    public function impressaoMultipla($ids){
        $turmas_arr = explode(',',$ids);
        $turmas = \App\Turma::whereIn('id',$turmas_arr)->get();
        
        foreach($turmas as $turma){
            $turma->inscritos =\App\Inscricao::where('turma',$turma->id)->whereIn('status',['regular','espera','ativa'])->get();
            $turma->inscritos = $turma->inscritos->sortBy('pessoa.nome');
        }
       // dd($turmas);
        return view('pedagogico.frequencia.multiplas',compact('turmas'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $programas=Programa::get();
        $requisitos=RequisitosController::listar();
        $professores=PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
        $unidades=Local::get(['id' ,'nome']);
        $parcerias=Parceria::orderBy('nome')->get();
        $pacote_cursos =\App\PacoteCurso::get();
        $dados=collect();
        $dados->put('programas',$programas);
        $dados->put('professores',$professores);
        $dados->put('unidades',$unidades);
        $dados->put('parcerias',$parcerias);

        //return $dados;

        return view('turmas.cadastrar',compact('dados'))->with('requisitos',$requisitos)->with('pacote_cursos',$pacote_cursos);
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
            "dt_inicio"=>"date|required",
            "dt_termino"=>"date|required",
            "hr_inicio"=>"required",
            "hr_termino"=>"required",
            "vagas"=>"numeric|required",
            "sala"=>"numeric",
            "valor"=>"required",
            "parcelas"=>"required|numeric"


        ]);

        if(date('Y', strtotime($request->dt_inicio))<date('Y')){
            return redirect()->back()->withErrors(['Não é possível cadastrar turmas de anos anteriores']);
            
        }
        
        //verificar disponibilidade da sala **************************************************************************************


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
        $turma->valor=str_replace(',','.',$request->valor);
        $turma->parcelas = $request->parcelas;
        $turma->vagas=$request->vagas;
        $turma->carga=$request->carga;
        $turma->sala=$request->sala;
        $turma->atributos=$request->atributo;
        $turma->status='lancada';
        $turma->save();

        if(isset($request->requisito)){
            foreach($request->requisito as $req){
                $curso_requisito=new CursoRequisito;
                $curso_requisito->para_tipo='turma';
                $curso_requisito->curso=$turma->id;
                $curso_requisito->requisito=$req;
                $curso_requisito->obrigatorio=1;
                $curso_requisito->timestamps=false;
                $curso_requisito->save();
            }
        }

        if(isset($request->pacote) && is_array($request->pacote) && count($request->pacote)>0){
            foreach($request->pacote as $pcte) {
                $pacote = new \App\TurmaDados;
                $pacote->turma = $turma->id;
                $pacote->dado = 'pacote';
                $pacote->valor = $pcte;
                $pacote->save();
            }

        }
        if(isset($request->ead)){
            $ead = new \App\TurmaDados;
            $ead->turma = $turma->id;
            $ead->dado = 'ead';
            $ead->valor = '1';
            $ead->save();

        }

        if($request->btn==1)
            return redirect(asset('/turmas'));
        else
            return redirect(asset('/turmas/cadastrar'));
        
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
            $programas=Programa::orderBy('nome')->get();
            $parcerias=Parceria::orderBy('nome')->get();
            $requisitos=RequisitosController::listar();
            $professores=PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
            $unidades=Local::orderBy('nome')->get();
            $salas= \App\Sala::where('local',$turma->local->id)->get();
            $dados=collect();
            $dados->put('programas',$programas);
            $dados->put('professores',$professores);
            $dados->put('unidades',$unidades);
            $dados->put('parcerias', $parcerias);
            $dados->put('salas',$salas);
            $pacote_cursos =\App\PacoteCurso::get();
            $turma->data_iniciov=Data::converteParaBd($turma->data_inicio);
            $turma->data_terminov=Data::converteParaBd($turma->data_termino);
            $turma_dados = \App\TurmaDados::where('turma',$turma->id)->get();
            $turma->pacote = $turma_dados->where('dado','pacote')->pluck('valor')->toArray();
            //dd($turma->pacote);

         


            //return $turma;

            return view('turmas.editar',compact('dados'))->with('turma',$turma)->with('requisitos',$requisitos)->with('pacote_cursos',$pacote_cursos);
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
            "sala"=>"numeric",
            "parcelas"=>"required:numeric"


        ]);
        

        if(date('Y', strtotime($request->dt_inicio))<date('Y')){
            return redirect()->back()->withErrors(['Não é possível modificar dados de turmas de anos anteriores.']);
            
        }
        
        
        //verificar disponibilidade da sala.
        //verificar se a turma tem aulas executadas e matriculas ativas

        $turma=Turma::find($request->turmaid);
        if($turma->status == 'iniciada'){
            
            if($turma->matriculados >0 && \Carbon\Carbon::createFromFormat('d/m/Y', $turma->data_inicio)->format('Y-m-d')!=$request->dt_inicio)               
                return redirect()->back()->withErrors(['Não é possível alterar datas de início de turmas com alunos matriculados.']);
        }

        if($turma->data_inicio!=$request->dt_inicio || $turma->dias_semana!=$request->dias ||  $turma->data_termino!=$request->dt_termino ){
            $aula_controller = new AulaController;
            $aula_controller->recriarAulas($turma->id);
            
        }


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
        $turma->valor=str_replace(',','.',$request->valor);
        $turma->parcelas = $request->parcelas;
        $turma->vagas=$request->vagas;
        $turma->carga=$request->carga;
        $turma->atributos=$request->atributo;
        $turma->periodicidade=$request->periodicidade;
        $turma->parceria = $request->parceria;
        $turma->sala=$request->sala;
        

        

        $alteracoes = 'Edição dos dados: ';
        $colunas = \Schema::getColumnListing('turmas'); // users table

        
        foreach($colunas as $dado){
            if($turma->isDirty($dado))
                if(isset($turma->$dado->id))
                    $alteracoes.= $dado.' alterado '. $turma->$dado->id . ' => '.($turma->getOriginal($dado))->id.', ';
                else{
                    if(is_array($turma->$dado))
                        $alteracoes.= $dado.' alterado '. implode(',',$turma->$dado) . ' => '.implode($turma->getOriginal($dado)).', ';
                    else
                        $alteracoes.= $dado.' alterado '. $turma->$dado . ' => '.$turma->getOriginal($dado).', ';
                }

        }
        
        LogController::registrar('turma',$turma->id,$alteracoes, \Auth::user()->pessoa);
        $turma->update();

        $turma_dados = \App\TurmaDados::where('turma',$turma->id)->get();
        $turma->pacote = $turma_dados->where('dado','pacote')->pluck('valor')->toArray();


        foreach($turma->pacote as $pcte){ 
            if(!isset($request->pacote) || !in_array($pcte,$request->pacote)){
                \App\TurmaDados::where('turma',$turma->id)->where('dado','pacote')->where('valor',$pcte)->delete();
                LogController::registrar('turma',$turma->id,'Remoção do pacote '.$pcte, \Auth::user()->pessoa);

            }
        }
        if(isset($request->pacote))
            foreach($request->pacote as $pcte){
                if(!in_array($pcte,$turma->pacote)){
                    $pacote = new \App\TurmaDados;
                    $pacote->turma = $turma->id;
                    $pacote->dado = 'pacote';
                    $pacote->valor = $pcte;
                    $pacote->save();
                    LogController::registrar('turma',$turma->id,'Adição do pacote '.$pcte, \Auth::user()->pessoa);
                }
                    
            }



        return redirect(asset('/turmas'));
       
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
                    $inscricoes=Inscricao::where('turma',$turma->id)->count();
                    if($inscricoes==0){
                        $msgs[]= "Turma ".$turma->id." excluída com sucesso.";
                        $turma->delete();
                    }
                    else{
                        $msgs[]="Turma ".$turma->id." não pôde ser excluída pois possui alunos inscritos. Caso não apareça, a inscrição pode ter sido cancelada, mesmo assim precisamos preservar o histórico das inscrições.";
                    }
                }
            }
        }
        return redirect()->back()->withErrors($msgs);
    }



    public function status($status,$itens_url)
    {
        $turmas=explode(',',$itens_url);
        foreach($turmas as $turma){
            if(is_numeric($turma)){
                $turma=Turma::find($turma);
                if(isset($turma->id)){
                    switch($status){
                        case 'encerrada':
                            $this->finalizarTurma($turma);
                            break;
                        case 'iniciada' : //turmas abertas que aceitam matriculas
                            //pegar todas inscriçoes finalizadas e espera da turma e colocar como regular
                            $lista_inscricoes = '';
                            $inscricoes = $turma->getInscricoes(['finalizada','espera']);                            
                            foreach($inscricoes as $inscricao){
                                $lista_inscricoes .= $inscricao->id.',';
                            }
                            InscricaoController::alterarStatus($lista_inscricoes,'regular');
                            unset($turma->inscricoes);
                            break;
                        case 'cancelada': 
                            break;
                        default:
                            $turma->status=$status;
                            break;
                            

                    }
                    $msgs['alert_sucess'][]="Turma ".$turma->id." modificada com sucesso.";      
                    $turma->status=$status;
                    $turma->save();
                    
                }
            }
        }
        return redirect()->back()->withErrors($msgs);
    }

    public function statusMatriculas($status,$itens_url)
    {
        $turmas=explode(',',$itens_url);
        foreach($turmas as $turma){
            if(is_numeric($turma)){
                $turma=Turma::find($turma);
                if(isset($turma->id)){
                    $turma->status_matriculas = $status;
                    $msgs['alert_sucess'][]="Turma ".$turma->id." modificada com sucesso.";      
                    $turma->save();
                    
                }
            }
        }
        return redirect()->back()->withErrors($msgs);
    }


    public function turmasDisponiveis($pessoa, $turmas_atuais='0',$query='')
    {
        
        $turmas_af=collect();
        $lista=array();
        $lst=array();

        //transforma a string de turmas atuais em collection de turmas
        $turmas_atuais=explode(',',$turmas_atuais);
        foreach($turmas_atuais as $turma){
            if(is_numeric($turma)){
                if(Turma::find($turma))
                    $turmas_af->push(Turma::find($turma));
            }
        }

        
        


        //se não tiver nenhuma turma atual
        if(count($turmas_af)==0){ 

            $turmas = Turma::select(['turmas.*','cursos.nome as nome_curso','disciplinas.nome as disciplina_nome','pessoas.nome as nome_professor','programas.sigla as sigla_programa'])
                        ->join('cursos', 'cursos.id', '=', 'turmas.curso')
                        ->leftjoin('disciplinas', 'disciplinas.id', '=', 'turmas.disciplina')
                        ->join('pessoas', 'pessoas.id', '=', 'turmas.professor')
                        ->join('programas', 'programas.id', '=', 'turmas.programa')
                        ->whereIn('turmas.status_matriculas', ['aberta','presencial'])
                        ->where(function($busca) use ($query){
                            $busca->where('cursos.nome', 'like','%'.$query.'%')
                                    ->orwhere('turmas.id', $query)
                                    ->orwhere('disciplinas.nome', 'like','%'.$query.'%')
                                    ->orwhere('pessoas.nome', 'like','%'.$query.'%')
                                    ->orwhere('programas.sigla', 'like','%'.$query.'%')
                                    ->orwhere('dias_semana', 'like','%'.$query.'%');
                        })
                        ->orderBy('cursos.nome')->orderBy('disciplinas.nome')
                        ->limit(30)
                        ->get();

            /*
    
            $turmas = Turma::whereIn('turmas.status_matriculas', ['aberta','presencial'])
                            ->get();
                            
            foreach($turmas as $turma){
                $turma->parcelas = $turma->getParcelas();
            }
            $turmas = $turmas->SortBy('cursos.nome')->SortBy('disciplinas.nome');*/
            
           
            return view('turmas.lista-matricula', compact('turmas'))->with('pessoa',$pessoa);
        }
        //cria limitação nos horários das turmas
        else{
            foreach($turmas_af as $turma){
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

            $turmas = Turma::select(['turmas.*','cursos.nome as nome_curso','disciplinas.nome as disciplina_nome','pessoas.nome as nome_professor','programas.sigla as sigla_programa'])
                        ->join('cursos', 'cursos.id', '=', 'turmas.curso')
                        ->leftjoin('disciplinas', 'disciplinas.id', '=', 'turmas.disciplina')
                        ->join('pessoas', 'pessoas.id', '=', 'turmas.professor')
                        ->join('programas', 'programas.id', '=', 'turmas.programa')
                        ->whereIn('turmas.status_matriculas', ['aberta','presencial'])
                        ->whereNotIn('turmas.id', $lst)
                        ->where(function($busca) use ($query){
                            $busca->where('cursos.nome', 'like','%'.$query.'%')
                                    ->orwhere('turmas.id',$query)
                                    ->orwhere('disciplinas.nome', 'like','%'.$query.'%')
                                    ->orwhere('pessoas.nome', 'like','%'.$query.'%')
                                    ->orwhere('programas.sigla', 'like','%'.$query.'%')
                                    ->orwhere('dias_semana', 'like','%'.$query.'%');
                        })
                        ->orderBy('cursos.nome')->orderBy('disciplinas.nome')
                        ->get();

            /*

            $turmas = Turma::whereIn('turmas.status_matriculas', ['aberta','presencial'])
                            ->whereNotIn('turmas.id', $lst)
                            ->get();
            foreach($turmas as $turma){
                $turma->parcelas = $turma->getParcelas();
                $turma->nome_curso = $turma->getNomeCurso();
            }
            $turmas = $turmas->SortBy('nome_curso');
            */
            foreach($turmas as $turma){
                $turma->parcelas = $turma->getParcelas();
                //$turma->nome_curso = $turma->getNomeCurso();
            }
            


        }
       
        return view('turmas.lista-matricula', compact('turmas'))->with('pessoa',$pessoa);
        
    }
    public function turmasEscolhidas($lista='0'){
        $turmas=collect();
        $valor=0;
        $uati=0;
        $lista=explode(',',$lista);
        foreach($lista as $turma){
            if(is_numeric($turma)){
                $db_turma=Turma::find($turma);
                if(isset($db_turma->id))
                    $turmas->push($db_turma);
            }

        }


        return view('secretaria.inscricao.turmas-escolhidas', compact('turmas'))->with('valor',$valor);

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

        
        $turmas=Turma::where('turmas.status_matriculas', 'aberta')
                ->whereIn('turmas.local',[84,85,86,118])
                ->whereColumn('turmas.vagas','>','turmas.matriculados')
                ->get();
        foreach($turmas as $turma){
            $turma->nome_curso = $turma->getNomeCurso();
        }
        $turmas = $turmas->sortBy('nome_curso');

        
        return view('turmas.turmas-site',compact('turmas'));
    }

 
    public function turmasProfessor(Request $r){
        $turmas=Turma::whereIn('turmas.status', ['lancada','iniciada'])
                ->whereIn('turmas.local',[84,85,86])
                ->whereColumn('turmas.vagas','>','turmas.matriculados')
                ->where('professor',$r->professor)
                ->get();
        foreach($turmas as $turma){
            $turma->nome_curso = $turma->getNomeCurso();
        }
        $turmas = $turmas->sortBy('nome_curso');
        $professor=Pessoa::find($r->professor);

        return view('turmas.turmas-site',compact('turmas'))->with('professor',$professor->nomeSimples);

    }
    
    public function uploadImportaTurma(Request $request){
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($request->arquivo);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestDataRow();
        if($highestRow>51)
            return redirect()->back()->withErrors('Erro: o arquivo importado não pode ter mais de 50 registros neste momento.');
        $pessoas = collect();
        for($i=2;$i<=$highestRow;$i++){
            if($worksheet->getCell('A'.$i)->getValue() != null){
                $insc= (object)[];
                $insc->id = $i;
                $insc->nome=$worksheet->getCell('A'.$i)->getValue();
                $insc->nascimento=$worksheet->getCell('G'.$i)->getFormattedValue();
                try{
                    $insc->nascimento = \Carbon\Carbon::createFromFormat('d/m/Y', $insc->nascimento)->format('Y-m-d');
                }
                catch(\Exception $e){
                    
                }
                $insc->genero=$worksheet->getCell('B'.$i)->getValue();

                $insc->fone=$worksheet->getCell('E'.$i)->getValue().' '.$worksheet->getCell('F'.$i)->getValue();
                $insc->rg=$worksheet->getCell('C'.$i)->getValue();
                $insc->cpf=$worksheet->getCell('D'.$i)->getValue();
                $insc->endereco=$worksheet->getCell('H'.$i)->getValue();
                $insc->numero=$worksheet->getCell('I'.$i)->getValue();
                $insc->bairro=$worksheet->getCell('K'.$i)->getValue();
                $insc->complemento=$worksheet->getCell('J'.$i)->getValue();
                $insc->cep=$worksheet->getCell('L'.$i)->getValue();
                $insc->cidade=$worksheet->getCell('M'.$i)->getValue();
                $insc->estado=$worksheet->getCell('N'.$i)->getValue();
                $insc->turma=$worksheet->getCell('O'.$i)->getValue();
                $pessoas->push($insc);
            }
        }
        $pessoas = $pessoas->sortBy('nome');

        return view('turmas.listar-importados')->with('pessoas',$pessoas)->with('arquivo',$request->arquivo);
    }



    public function processarImportacao(Request $request){
        //dd($request);
        $cadastrados = array();

        foreach ($request->pessoa as $id=>$key){ // para cada elemento do array pessoa (campo checkbox)
            $nascimento = \Carbon\Carbon::createFromFormat('Y-m-d', $request->nascimento[$id])->format('Y-m-d');
            
            if($key == 'on'){ //se o checkbox estiver marcado
                //verifica se já está cadastrado
                
                if(isset($request->cpf[$id])){
                    $buscar_porcpf = \App\PessoaDadosGerais::where('dado',3)->where('valor',preg_replace( '/[^0-9]/is', '', $request->cpf[$id]))->first();
                    if(!is_null($buscar_porcpf))
                        $pessoa = Pessoa::find($buscar_porcpf->pessoa);
                    else{
                        $pessoa = Pessoa::where('nome','like',$request->nome[$id])->where('nascimento',$nascimento)->first();
                        if(is_null($pessoa))
                            $pessoa = PessoaController::cadastrarPessoa($request->nome[$id],$request->genero[$id],\DateTime::createFromFormat('Y-m-d',$request->nascimento[$id]));        
                    }
                }
                else{
                    $pessoa = Pessoa::where('nome','like',$request->nome[$id])->where('nascimento',$nascimento)->first();
                    if(is_null($pessoa))
                        $pessoa = PessoaController::cadastrarPessoa($request->nome[$id],$request->genero[$id],\DateTime::createFromFormat('Y-m-d',$request->nascimento[$id]));
                }

                //dd($pessoa);
                
              

                
                   
                if(isset($request->rg[$id]))
                    PessoaDadosGeraisController::gravarDocumento($pessoa->id,'rg',$request->rg[$id]);
                if(isset($request->cpf[$id]))
                    PessoaDadosGeraisController::gravarDocumento($pessoa->id,'cpf',$request->cpf[$id]);
                if(isset($request->telefone[$id]))
                    PessoaDadosContatoController::gravarTelefone($pessoa->id,$request->telefone[$id]);
               
                
                if(isset($request->endereco[$id]) && isset($request->cep[$id])){
                    $dado = PessoaDadosContato::where('dado','6')->where('pessoa',$pessoa->id)->get();
                    if(count($dado) == 0){
                        $endereco = new \App\Endereco;
                        $endereco->logradouro = $request->endereco[$id];
                        if(isset($request->cidade[$id]))
                            $endereco->cidade = $request->cidade[$id];
                        if(isset($request->estado[$id]))
                            $endereco->estado = $request->estado[$id];

                        $endereco->cep = preg_replace( '/[^0-9]/is', '', $request->cep[$id]);
                        $bairro = \App\classes\CepUtils::bairroCompativel(preg_replace( '/[^0-9]/is', '', $request->cep[$id]));  
                        if(isset($endereco->bairro_str))
                            $endereco->bairro_str = $request->bairro[$id];       
                        
                        if($bairro>0)
                            $endereco->bairro = $bairro;
                        else
                            $endereco->bairro = 0;
                        $endereco->save();
                        $dado_contato = new PessoaDadosContato;
                        $dado_contato->pessoa = $pessoa->id;
                        $dado_contato->dado = 6;
                        $dado_contato->valor = $endereco->id;
                        $dado_contato->save();
                    }

                }
                //verifica se a turma existe
                $turma = Turma::find($request->turma[$id]);
                if($turma != null){
                    //Inscreve a pessoa (ele verifica antes se a pessoa está inscrita)
                    if(InscricaoController::inscreverAluno($pessoa->id,$turma->id)){
                        $cadastrados[]=$id;
                    }
                }


            }
            
        }
        //return $cadastrados;
        return view('turmas.confirmar-importados')->with('cadastrados',$cadastrados)->with('pessoas',$request->nome);
    }

    /**
     * Modifica a quantidade de pessoas inscritas na turma.
     * @param  \App\Turma  $turma
     * @param  $operaçao - 0 reduz, 1 aumenta
     * @param  $qnde - numero para adicionar ou reduzir
     * @return \Illuminate\Http\Response
     */
    public static function modInscritos($turma){
        $turma=Turma::find($turma);
        $inscricoes = Inscricao::where('turma',$turma->id)->whereIn('status',['regular','pendente'])->count();
        $turma->matriculados = $inscricoes;
        $turma->save();
        
    }


    /**
     * acao em lote verifica alguma ação pedagogica nas turmas que receber por post
     */
    public function acaolote($acao, $turmas){
        $turmas = explode(',',$turmas);
        if(count($turmas) == 0)
                     return redirect()->back()->withErrors(['Não foi possivel efetuar sua solicitação: Nenhuma turma selecionada.']);
        switch ($acao) {
            case 'encerrar':
                foreach($turmas as $turma_id){
                    $turma = Turma::find($turma_id);
                    if(isset($turma->id))
                        $this->finalizarTurma($turma);
                }
                return redirect()->back()->withErrors(['Turmas encerradas com sucesso']);
                break;
            case 'relancar':
                
                $programas=Programa::orderBy('nome')->get();
                $professores=PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
                $unidades=Local::orderBy('nome')->get(['id' ,'nome']);
                $parcerias=Parceria::orderBy('nome')->get();
                $dados=collect();

                $dados->put('programas',$programas);
                $dados->put('professores',$professores);
                $dados->put('unidades',$unidades);
                $dados->put('parcerias',$parcerias);

                //dd($dados);

                return view('turmas.recadastrar',compact('dados'))->with('turmas',$turmas);
                break;

            case 'requisitos':
                $turmas = implode(',',$turmas);
                $requisitos = \App\Requisito::all();
                return redirect('/turmas/modificar-requisitos/'.$turmas);


                break;
            
            default:
                return redirect()->back()->withErrors(['Não foi possivel identificar sua solicitação.']);
                break;
        }
    }

    
    public function storeRecadastro(Request $r){
        
        
        $turmas = explode(',', $r->turmas);

        //dd($turmas);
        foreach($turmas as $turma_id){

            if($turma_id>0)
            $turma=Turma::find($turma_id);

            else
                continue;
            if(!isset($turma->id))
                continue;

            $novaturma = new Turma;
            if($r->programa > 0 )
                $novaturma->programa = $r->programa;
            else
                $novaturma->programa = $turma->programa->id;

            if($r->curso > 0 )
                $novaturma->curso = $r->curso;
            else
                $novaturma->curso = $turma->curso->id;

            if($r->disciplina > 0 )
                $novaturma->disciplina = $r->disciplina;
            else
                if(isset( $turma->disciplina))
                    $novaturma->disciplina = $turma->disciplina->id;

            if($r->professor > 0 )
                $novaturma->professor = $r->professor;
            else
                $novaturma->professor = $turma->professor->id;

            if($r->unidade > 0 )
                $novaturma->local = $r->unidade;
            else
                $novaturma->local = $turma->local->id;
            if($r->sala> 0 )
                $novaturma->sala = $r->sala;

            if($r->parceria > 0 )
                $novaturma->parceria = $r->parceria;
            else
                $novaturma->parceria = $turma->parceria;

            if($r->periodicidade != $turma->periodicidade )
                $novaturma->periodicidade = $r->periodicidade;
            else
                $novaturma->periodicidade  = $turma->periodicidade ;

            if(!empty($r->dias))
                $novaturma->dias_semana = $r->dias;
            else
                $novaturma->dias_semana = $turma->dias_semana;

            if($r->dt_inicio != '' )
                $novaturma->data_inicio = $r->dt_inicio;
            else
                $novaturma->data_inicio = \Carbon\Carbon::createFromFormat('d/m/Y', $turma->data_inicio, 'Europe/London')->format('Y-m-d');

            if($r->hr_inicio != '' )
                $novaturma->hora_inicio = $r->hr_inicio;
            else
                $novaturma->hora_inicio = $turma->hora_inicio;

            if($r->dt_termino != '' )
                $novaturma->data_termino = $r->dt_termino;
            else
                $novaturma->data_termino = \Carbon\Carbon::createFromFormat('d/m/Y', $turma->data_termino, 'Europe/London')->format('Y-m-d');

            if($r->hr_termino != '' )
                $novaturma->hora_termino = $r->hr_termino;
            else
                $novaturma->hora_termino = $turma->hora_termino;

            if($r->vagas != '' )
                $novaturma->vagas = $r->vagas;
            else
                $novaturma->vagas = $turma->vagas;

            if($r->valor != '' )
                $novaturma->valor = $r->valor;
            else
                $novaturma->valor = $turma->valor;

            if($r->parcelas != '' )
                $novaturma->parcelas = $r->parcelas;
            else
                $novaturma->parcelas = $turma->parcelas;

            if($r->carga != '' )
                $novaturma->carga = $r->carga;
            else
                $novaturma->carga = $turma->carga;

            $novaturma->status = 'lancada';
            $novaturma->status_matriculas = 'fechada';

            $novaturma->save();

            $requisitos = CursoRequisito::where('para_tipo','turma')->where('curso',$turma->id)->get();
            foreach($requisitos as $requisito){
                $novo_requisito = new CursoRequisito;
                $novo_requisito->para_tipo = 'turma';
                $novo_requisito->curso = $novaturma->id;
                $novo_requisito->requisito = $requisito->requisito;
                $novo_requisito->obrigatorio = $requisito->obrigatorio;
                $novo_requisito->save();
            }
            $dados = TurmaDados::where('turma',$turma->id)->where('dado','<>','proxima_turma')->get();
            foreach($dados as $dado){
                $novo_dado = new TurmaDados;
                $novo_dado->turma = $novaturma->id;
                $novo_dado->dado = $dado->dado;
                $novo_dado->valor = $dado->valor;
                $novo_dado->save();
            }


        }
        
        return redirect('/turmas')->withErrors(['Turmas recadastradas com sucesso.']);
    }
    public static function listarTurmasDocente($docente,$semestre){
        if($semestre > 0){
            $intervalo = \App\classes\Data::periodoSemestre($semestre);
            $turmas = Turma::where('professor', $docente)->whereIn('status',['lancada','iniciada','encerrada'])->whereBetween('data_inicio', $intervalo)->orderBy('hora_inicio')->get();
        }
        else{
            $turmas = Turma::where('professor', $docente)->whereIn('status',['lançada','iniciada'])->orderBy('hora_inicio')->get();
        }

        foreach($turmas as $turma){
              
            $turma->weekday = \App\classes\Strings::convertWeekDay($turma->dias_semana[0]);

        }
    
        $turmas = $turmas->sortBy('weekday');
         return $turmas;
    }
    public function getChamada($turma_id,$page,$opt,$mostrar='todos'){

        if($opt=='pdf')
            $opt='pdf&rel_pdf=rel_freq';

        if($page == 0)
            $url = "https://script.google.com/macros/s/AKfycbwY09oq3lCeWL3vHoxdXmocjVPnCEeZMVQgzhgl-J0WNOQPzQc/exec?id=".$turma_id."&portrait=false&tipo=".$opt;
        
        else
            $url = "https://script.google.com/macros/s/AKfycbwY09oq3lCeWL3vHoxdXmocjVPnCEeZMVQgzhgl-J0WNOQPzQc/exec?id=".$turma_id."&portrait=false&tipo=".$opt."&page=".$page;

        if($mostrar != 'todos')
            $url .= '&hide=s';
        print '<div style="font-family:tahoma;font-size:10px;margin:50px auto 0;">Acessando sua lista em: '.$url.'</div><br>';

        $ch = curl_init();
        //não exibir cabeçalho
        curl_setopt($ch, CURLOPT_HEADER, false);
        // redirecionar se hover
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // desabilita ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //envia a url
        curl_setopt($ch, CURLOPT_URL, $url);
        //executa o curl
        $result = curl_exec($ch);
        //encerra o curl
        curl_close($ch);



       $ws = json_decode($result);


       if( isset($ws{0}->url) )
            return redirect( $ws{0}->url);

        elseif(isset($ws{0}->url_pdf))
            return redirect( $ws{0}->url_pdf);

        else

            return $result;
    }





    public function getPlano($professor,$tipo,$curso){

        print 'Carregando...';
      
        $url = "https://script.google.com/macros/s/AKfycbwY09oq3lCeWL3vHoxdXmocjVPnCEeZMVQgzhgl-J0WNOQPzQc/exec?id_pro=".$professor. "&id_curso=".$curso."&tipo=plano";
        
        $ch = curl_init();
        //não exibir cabeçalho
        curl_setopt($ch, CURLOPT_HEADER, false);
        // redirecionar se hover
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // desabilita ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //envia a url
        curl_setopt($ch, CURLOPT_URL, $url);
        //executa o curl
        $result = curl_exec($ch);
        //encerra o curl
        curl_close($ch);

        $ws = json_decode($result);

        if( isset($ws{0}->url) )

            return redirect( $ws{0}->url);

        else

            return $result;
    }



    /**
     * Finaliza turma individualmente
     * @param  [Turma] $turma [Objeto Turma]
     * @return [type]        [description]
     */
    public function finalizarTurma(Turma $turma){
        if($turma->termino > date('Y-m-d'))
            die('Turma '.$turma->id. ' não pode ser encerrada pois a data de término não foi atingida. Se a turma não ocorreu utilize a opção CANCELAR.');
        $inscricoes = Inscricao::where('turma', $turma->id)->get();   
        
        $turma->status = 'encerrada';
        $turma->save();

        foreach($inscricoes as $inscricao){

            $executar = InscricaoController::finaliza($inscricao);

        }

        return $turma;

    }

    public function processarTurmasExpiradas(){

        $turmas_finalizadas = 0;
        $turmas = Turma::where('data_termino','<', date('Y-m-d'))
            ->where('status','iniciada')
            ->get();

        foreach($turmas as $turma){

            $this->finalizarTurma($turma);
            $turmas_finalizadas ++;

        }

        return redirect($_SERVER['HTTP_REFERER'])->withErrors([$turmas_finalizadas.' turmas estavam expiradas e foram finalizadas.']);
    }


    public function atualizarInscritos(){
        $turmas = Turma::select(['id','matriculados'])->whereIn('status',['iniciada','lancada'])->get();
        foreach($turmas as $turma){
            $inscritos = Inscricao::where('turma',$turma->id)->whereIn('status',['regular','pendente','finalizada','finalizado'])->count();
            if($turma->matriculados != $inscritos){
                $turma->matriculados = $inscritos;
                $turma->save();
            }

        }
        return "Turmas atualizadas.";
    }

    public function frequencia(int $turma){
        $aulas = \App\Aula::where('turma',$turma)->get();
        if(count($aulas) == 0)
            dd("sem aulas cadastradas pra essa turma. Cadastrar?");
        $frequencias = \App\Frequencia::whereIn('aula',$aulas);
        $inscritos=\App\Inscricao::where('turma',$turma)->whereIn('status',['regular','espera','ativa','pendente'])->get();
        $inscritos= $inscritos->sortBy('pessoa.nome');
        if(count($inscritos))
            return view('pedagogico.frequencia.index',compact('inscritos'))->with('i',1);
        else
            return "Nenhum aluno cadastrado para esta turma.";

        return $aulas.$frequencias;
    }


   
    

  
        
        



}
