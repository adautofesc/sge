<?php

namespace App\Http\Controllers;

use App\Turma;
use App\Local;
use App\Programa;
use App\classes\Data;
use App\PessoaDadosAdministrativos;
use Illuminate\Support\Facades\DB;
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


        //return $dados;
        //$dados=['alert_sucess'=>['hello world']];
        return view('pedagogico.turma.listar', compact('turmas'))->with('programas',$programas)->with('dados',$dados);
    }

    public function listarSecretaria($dados='')
    {
        $turmas=Turma::orderBy('curso')->get();
       
        $programas=Programa::all();


        //return $dados;
        //$dados=['alert_sucess'=>['hello world']];
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
        $unidades=Local::getUnidades();
        //Locais=Local::getLocaisPorUnidade($unidade);
        $dados=collect();
        $dados->put('programas',$programas);
        $dados->put('professores',$professores);
        $dados->put('unidades',$unidades);

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
            "local"=>"required|numeric",
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
        $turma->local=$request->local;
        $turma->dias_semana=$request->dias;
        $turma->data_inicio=$request->dt_inicio;
        $turma->data_termino=$request->dt_termino;
        $turma->hora_inicio=$request->hr_inicio;
        $turma->hora_termino=$request->hr_termino;
        $turma->valor=$request->valor;
        $turma->vagas=$request->vagas;
        $turma->atributos=$request->atributo;
        $turma->status=1;
        $turma->save();
        return $this->index();
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
            //$cursos=Curso::getCursosPrograma(); ok
            $professores=PessoaDadosAdministrativos::getFuncionarios('Educador');
            $unidades=Local::getUnidades();
            //Locais=Local::getLocaisPorUnidade($unidade);
            $dados=collect();
            $dados->put('programas',$programas);
            $dados->put('professores',$professores);
            $dados->put('unidades',$unidades);
            $turma->data_iniciov=Data::converteParaBd($turma->data_inicio);
            $turma->data_terminov=Data::converteParaBd($turma->data_inicio);

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
            "local"=>"required|numeric",
            "dias"=>"required",
            "dt_inicio"=>"required",
            "hr_inicio"=>"required",
            "vagas"=>"required",
            "valor"=>"required"


        ]);
        $turma=Turma::find($request->turmaid);
        $turma->programa=$request->programa;
        $turma->curso=$request->curso;
        $turma->disciplina=$request->disciplina;
        $turma->professor=$request->professor;
        $turma->local=$request->local;
        $turma->dias_semana=$request->dias;
        $turma->data_inicio=$request->dt_inicio;
        $turma->data_termino=$request->dt_termino;
        $turma->hora_inicio=$request->hr_inicio;
        $turma->hora_termino=$request->hr_termino;
        $turma->valor=$request->valor;
        $turma->vagas=$request->vagas;
        $turma->atributos=$request->atributo;
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
        $turmas_atuais=explode(',',$turmas_atuais);
        foreach($turmas_atuais as $turma){
            if(is_numeric($turma)){
                if(Turma::find($turma))
                    $turmas_af->push(Turma::find($turma));
            }
        }
        //return $turmas_af;



        if(count($turmas_af)==0){
            $turmas=Turma::all();
            return $turmas;
        }
        else{

            foreach($turmas_af as $turma){
                        $lista=DB::table('turmas')->select('turmas.id')->where('dias_semana', 'like', '%'.$turma->dias_semana[0].'%')->whereBetween('hora_inicio', [$turma->hora_inicio,$turma->hora_termino])->get();
                    
                }

            //return $lista;

            
            $turmas=Turma::whereNotIn('id', $lista[])->toSql();

        }
        return $turmas;

       


        /*
        switch(true){
            case $contagem_turmas==0:
             $turmas=Turma::all();

            break;
            case $contagem_turmas>0:
                foreach($turmas_af as $turma){
                    foreach($turma->dias_semana as $dia){
                        $lista->push(Turma::select('id')->where('dias_semana', 'like', '%'.$dia.'%')->whereBetween('hora_inicio', [$turma->hora_inicio,$turma->hora_termino])->get());
                    }
                }
                //return $lista;



                $turmas=Turma::whereNotIn('id', $lista)->get();

                

            break;
            /*
            case $contagem_turmas>2:
                $turmas=Turma::whereNotIn('id', function($query){    
                         $query->select('id')->from('turmas')
                                ->where('dias_semana', 'like', '%seg%')->whereBetween('hora_inicio', ['12:00','18:00'])
                                ->orWhere('dias_semana', 'like', '%seg%')->whereBetween('hora_inicio', ['10:00','18:00']) 
                                ->orWhere('dias_semana', 'like', '%seg%')->whereBetween('hora_inicio', ['10:00','18:00']) 
                                ->orWhere('dias_semana', 'like', '%seg%')->whereBetween('hora_inicio', ['10:00','18:00']) 
                                ->orWhere('dias_semana', 'like', '%seg%')->whereBetween('hora_inicio', ['10:00','18:00']) 
                                ->get();

                })->get();

            break;

        };

        */
    
       
        
    }

}
