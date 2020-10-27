<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Requisito;
use App\Programa;
use App\CursoRequisito;
use Illuminate\Http\Request;
use App\Http\Controllers\RequisitosController;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)    {

        $cursos=Curso::all();
        //return $cursos;
        if(isset($r->buscar))
            return view('curso.lista')->with(array('cursos'=>$this->cursos($r->buscar)));
        else
            return view('curso.lista')->with('cursos',$this->cursos());
    }

    /**
     * Retorna Lista de cursos.
     *
     * @return \Illuminate\Http\Response
     */
    public function cursos($nome='')    {
        if($nome !='')
            $curso=Curso::where('nome', 'like', '%'.$nome.'%')->orWhere('id',$nome)->orderBy('nome')->paginate(35);
        else
            $curso=Curso::select()->paginate(35);


        return $curso;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()    {
        $requisitos=RequisitosController::listar();
        $programas=Programa::all();
        return view('curso.cadastrar',compact('requisitos'))->with('programas',$programas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)    {
        $this->validate($r, [
            'nome'=>'required|min:5',
            'programa'=>'required|numeric',
            'desc'=>'required',
            'vagas'=>'sometimes|nullable|numeric'

            ]);
        $curso = new Curso;
        $curso->timestamps=false;
        $curso->nome=$r->nome;
        $curso->programa=$r->programa;
        $curso->desc=$r->desc;
        $curso->carga=$r->carga;
        $curso->vagas=$r->vagas;
        $curso->valor=$r->valor;
        $curso->save();

        if(isset($r->requisito)){
            foreach($r->requisito as $req){
                $curso_requisito=new CursoRequisito;
                $curso_requisito->curso=$curso->id;
                $curso_requisito->requisito=$req;
                $curso_requisito->obrigatorio=1;
                $curso_requisito->timestamps=false;
                $curso_requisito->save();
            }
        }

        if($r->btn==1)
            return redirect(asset('/cursos'));
        if($r->btn==2)
            return $this->create();
        if($r->btn==3)
            return redirect(asset('/cursos/grade/'.$curso->id));
       

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show($id)    {
        $curso=Curso::find($id);
        if(!isset($curso->id))
             return redirect(asset('/cursos'))->withErrors(['Código de curso não encontrado. '.$id]); 

        if(DisciplinaController::disciplinasDoCurso($id))
            $curso->disciplinas=DisciplinaController::disciplinasDoCurso($id);
        //if($this->requisitos($id))
           // $curso->requisitos=$this->requisitos($id);

        //return $curso;
        
        return view('curso.mostrar', compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)    {
        $curso=Curso::find($id);
        if(!isset($curso->id))
             return redirect(asset('/cursos'))->withErrors(['Código de curso não encontrado. '.$id]); 
        $programas=Programa::all();
        $requisitos=RequisitosController::listar();
        return view('curso.editar', compact('curso'))->with('programas',$programas)->with('requisitos',$requisitos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $this->validate($request, [
            'nome'=>'required|min:5',
            'programa'=>'required',
            'desc'=>'required',
            'vagas'=>'required',
            'carga'=>'required'

            ]);
        $curso=curso::find($request->id);
        $curso->timestamps=false;
        $curso->nome=$request->nome;
        $curso->programa=$request->programa;
        $curso->desc=$request->desc;
        $curso->vagas=$request->vagas;
        $curso->carga=$request->carga;
        $curso->save();

        return redirect('/cursos');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r) {
        $this->validate($r, [
            'curso'=>'required|Integer'
            ]);
        $curso=curso::find($r->curso);
        if($curso)
            $curso->delete();
        return redirect(asset('/cursos'));
    }



    public function requisitos($curso)    {
        $curso_requisitos=CursoRequisito::where('curso',$curso)->get();
        if($curso_requisitos->count()){
            foreach($curso_requisitos->all() as $requisito) {
                $requisito=Requisito::find($requisito->requisito);
                $requisitos[]=$requisito;
            }              
        }
        if(isset($requisitos))
            return $requisitos;
        else
            return false;


    }
    public function listarPorPrograma($programa){
        $cursos=Curso::where('nome','like', '%'.$programa.'%')->orWhere('id', $programa)->get(['id','nome']);

        return $cursos;
    }
    public function qndeModulos($curso){
        $curso=Curso::select('modulos')->where('id',$curso)->get();
        if ($curso)
            return $curso[0]->modulos;
        else
            return "";
    }

}
