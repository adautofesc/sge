<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Disciplina;
use App\Grade;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r = Request)
    {
        return view('pedagogico.cursos')->with(array('cursos'=>$this->cursos($r->buscar)));
    }

    /**
     * Retorna Lista de cursos.
     *
     * @return \Illuminate\Http\Response
     */
    public function cursos($nome='')
    {
        if($nome !='')
            $curso=Curso::where('nome', 'like', '%'.$nome.'%')->orderBy('nome')->paginate(35);
        else
            $curso=Curso::select()->paginate(35);


        return $curso;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pedagogico.cadastrar-curso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $this->validate($r, [
            'nome'=>'required|min:5',
            'programa'=>'required',
            'desc'=>'required',
            'vagas'=>'required',
            'carga'=>'required'

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

        if($r->btn==1)
            return redirect(asset('/pedagogico/cursos'));
        if($r->btn==2)
            return redirect(asset('/pedagogico/cadastrarcurso'));
        if($r->btn==3)
            return redirect(asset('/pedagogico/disciplinascursos'.'/'.$curso->id));
       

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso=Curso::find($id);
        if(!count($curso))
             return redirect(asset('/pedagogico/cursos')); 

        switch($curso->programa){
            case "EMG" :
                $curso->emg="selected";
            break;
            case "PID" :
                $curso->pid="selected";
            break;
            case "UATI" :
                $curso->uati="selected";
            break;
            case "UNIT" :
                $curso->unit="selected";
            break;

        }
        
        return view('pedagogico.mostrar-curso', compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curso=Curso::find($id);
        if(!count($curso))
             return redirect(asset('/pedagogico/cursos'));

        switch($curso->programa){
            case "EMG" :
                $curso->emg="selected";
            break;
            case "PID" :
                $curso->pid="selected";
            break;
            case "UATI" :
                $curso->uati="selected";
            break;
            case "UNIT" :
                $curso->unit="selected";
            break;

        }
        return view('pedagogico.editar-curso', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
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

        return redirect(asset('/pedagogico/cursos'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r)
    {
        $this->validate($r, [
            'curso'=>'required|Integer'
            ]);
        $curso=curso::find($r->curso);
        if($curso)
            $curso->delete();
        return redirect(asset('/pedagogico/cursos'));
    }


    /**
     * Abre página com as disciplinas obrigatórias sdo curso
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function addDisciplinas($curso)
    {
        $disciplinas=Disciplina::get();
        foreach($disciplinas->all() as $disciplina)
        {
            $grade=Grade::where('curso', $curso)->where('disciplina',$disciplina->id)->first();
            if(count($grade)){
                $disciplina->checked = "checked";
                if($grade->obrigatoria=='1')
                    $disciplina->obrigatoria="checked";
            }

        }


        return view('pedagogico.curso-disciplinas', compact('disciplinas'));





    }

}
