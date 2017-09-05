<?php

namespace App\Http\Controllers;

use App\Disciplina;
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
        return view('pedagogico.disciplinas')->with(array('disciplinas'=>$this->disciplinas($r->buscar)));
    }

    /**
     * Lista as disciplinas
     *
     * @return \Illuminate\Http\Response
     */
    public function disciplinas($nome='')
    {
        if($nome !='')
            $disciplina=Disciplina::where('nome', 'like', $nome)->orderBy('nome')->paginate(35);
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
        
        return view('pedagogico.cadastrar-disciplina');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

        switch($disciplina->programa){
            case "EMG" :
                $disciplina->emg="selected";
            break;
            case "PID" :
                $disciplina->pid="selected";
            break;
            case "UATI" :
                $disciplina->uati="selected";
            break;
            case "UNIT" :
                $disciplina->unit="selected";
            break;

        }
        return view('pedagogico.editar-disciplina', compact('disciplina'));


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
        $disciplina=Disciplina::find($r->disciplina);
        $disciplina->delete();
        return redirect(asset('/pedagogico/disciplinas'));
    }
}
