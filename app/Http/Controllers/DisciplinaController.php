<?php

namespace App\Http\Controllers;

use App\Disciplina;
use App\Grade;
use App\Curso;
use App\Programa;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r = Request)
    {
        //return $disciplinas=$this->disciplinas();

        //return $this->disciplinas();
        return view('pedagogico.curso.disciplina.listar')->with(array('disciplinas'=>$this->disciplinas($r->buscar)));
    }

    /**
     * Lista as disciplinas
     *
     * @return \Illuminate\Http\Response
     */
    public function disciplinas($nome='')
    {
        if($nome !='')
            $disciplina=Disciplina::where('nome', 'like', '%'.$nome.'%')->orderBy('nome')->paginate(35);
        else
            $disciplina=Disciplina::select()->paginate(35);


        return $disciplina;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programas=Programa::all();
        
        return view('pedagogico.curso.disciplina.cadastrar', compact('programas'));
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
            'nome'=>'required|min:5',
            'programa'=>'required',
            'desc'=>'required',
            'vagas'=>'required',
            'carga'=>'required'

            ]);

        $disciplina= new Disciplina;
        $disciplina->nome=$request->nome;
        $disciplina->programa=$request->programa;
        $disciplina->desc=$request->desc;
        $disciplina->vagas=$request->vagas;
        $disciplina->carga=$request->carga;
        $disciplina->save();

        if($request->btn==1)
            return redirect(asset('/pedagogico/disciplinas'));
        else
            return redirect(asset('/pedagogico/cadastrardisciplina'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function show(Disciplina $disciplina)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disciplina=Disciplina::find($id);
        if(!count($disciplina))
            return redirect(asset('/pedagogico/disciplinas'));

        $programas=Programa::all();

        foreach($programas as $programa){
            if($disciplina->programa->id==$programa->id)
                $programa->selected="selected";
        }

        return view('pedagogico.curso.disciplina.editar', compact('disciplina'))->with('programas', $programas);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id'=>'required|Integer',
            'nome'=>'required|min:5',
            'programa'=>'required',
            'desc'=>'required',
            'vagas'=>'required',
            'carga'=>'required'

            ]);
        $disciplina=Disciplina::find($request->id);
        $disciplina->nome=$request->nome;
        $disciplina->programa=$request->programa;
        $disciplina->desc=$request->desc;
        $disciplina->vagas=$request->vagas;
        $disciplina->carga=$request->carga;
        $disciplina->save();

        return redirect(asset('/pedagogico/disciplinas'));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r)
    {

        $this->validate($r, [
            'disciplina'=>'required|Integer'
            ]);
        $disciplina=Disciplina::find($r->disciplina);
        if($disciplina)
            $disciplina->delete();
        return redirect(asset('/pedagogico/disciplinas'));
    }
    /**
     * Abre página com as disciplinas obrigatórias sdo curso
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public static function editDisciplinasAoCurso($curso) {
        $cursoexiste=Curso::find($curso);
        if(!$cursoexiste)
            return redirect(asset('/pedagogico/cursos'));

        $disciplinas=Disciplina::select()->orderBy('nome')->get();
        foreach($disciplinas->all() as $disciplina)
        {
            $grade=Grade::where('curso', $curso)->where('disciplina',$disciplina->id)->first();
            if(count($grade)){
                $disciplina->checked = "checked";
                if($grade->obrigatoria=='1')
                    $disciplina->obrigatoria="checked";
            }
        }
        return view('pedagogico.curso.curso-disciplinas', compact('disciplinas'))->with(array('curso'=>['nome'=>$cursoexiste->nome, 'id_curso'=>$cursoexiste->id]));
    }
    public static function disciplinasDoCurso($curso,$str=''){
        $grade=Grade::select('disciplina')->where('curso', $curso)->get();
        if(count($grade)){

            $disciplinas=Disciplina::whereIn('id', $grade)->where('nome','like','%'.$str.'%')->orWhere('id',$str)->get(['id','nome']);
            /*
            foreach($grade->all() as $item_grade)            {
                array_push($disciplinas,Disciplina::where('id',$item_grade->disciplina)
                
            }*/
            if(count($disciplinas))
                return $disciplinas;
            else
                return "";
         }
         else{
            return "";
         }

        
    }

    public function storeDisciplinasAoCurso(Request $r){

        $grades=Grade::where('curso',$r->curso)->get();
        foreach($grades->all() as $grade){
            $grade->delete();
        }

        foreach($r->disciplina as $disciplina){
            $grade= new Grade;
            $grade->timestamps=false;
            $grade->curso=$r->curso;
            $grade->disciplina=$disciplina;
            if(isset($r->obrigatoria))
                if(in_array($disciplina, $r->obrigatoria))
                    $grade->obrigatoria=1;    
            $grade->save();
        }

        return redirect(asset('/pedagogico/curso').'/'.$r->curso);

    }

}
