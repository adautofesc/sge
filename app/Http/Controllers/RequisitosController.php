<?php

namespace App\Http\Controllers;

use App\Requisito;
use App\Curso;
use App\CursoRequisito;

use Illuminate\Http\Request;

class RequisitosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisitos=$this->listar();
        return view('pedagogico.requisitos', compact('requisitos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pedagogico.cadastrar-requisito');    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome'=>'required|max:150|min:3'
            ]);
        $requisito = new Requisito;
        $requisito->timestamps=false;
        $requisito->nome=$request->nome;
        $requisito->save();

        if($request->btn==1)
            return redirect(asset('/pedagogico/cursos/requisitos'));
        else
            return view('pedagogico.cadastrar-requisito')->with(array('dados'=>['alert_sucess'=>['Requisito cadastrado com sucesso.']]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove os requisitos do banco
     *
     * @param  string itens separados por vírgula
     * @return \Illuminate\Http\Response
     */
    public function destroy($itens)
    {
        $itens=explode(',',$itens);
        $itens_filtrados=[];
        foreach($itens as $l){
            if(is_numeric($l)){
                //verificar se ele não está vinculado a algum curso
                $vinculo=CursoRequisito::where('requisito', $l)->first();
                if($vinculo){
                    $requisito=Requisito::find($l);
                    $curso=Curso::find($vinculo->curso);
                    $dados['alert_warning']=[''.$requisito->nome.") é requisito do curso: ". $curso->nome];
                }
                else{
                    $req=Requisito::find($l);
                    if ($req) {
                       $req->delete();
                       $dados['alert_sucess']=['Requisito '.$l." foi apagado com sucesso"];
                    }
                    else
                        $dados['alert_warning']=['Requisito '.$l." não existe."];
                }
            }      
        }
        $requisitos=$this->listar();
        return view('pedagogico.requisitos', compact('requisitos'))->with(array('dados'=>$dados));
    }

    public static function listar()
    {
        $requisitos=Requisito::all();
        return $requisitos;
    }

    public function editRequisitosAoCurso($curso){
        $cursoexiste=Curso::find($curso);
        if(!$cursoexiste)
            return redirect(asset('/pedagogico/cursos'));
        $requisitos=Requisito::get();
        foreach($requisitos->all() as $requisito){
            $rc=CursoRequisito::where('curso', $curso)->where('requisito',$requisito->id)->first();
            if(count($rc)){
                $requisito->checked="checked";
                if($rc->obrigatorio==1)
                    $requisito->obrigatorio="checked";
            }
        }

        //return $requisitos;
        return view('pedagogico.curso-requisitos', compact('requisitos'))->with(array('curso'=>['nome'=>$cursoexiste->nome, 'id_curso'=>$cursoexiste->id]));
    }

    public function storeRequisitosAoCurso(Request $r){
        $rc=CursoRequisito::where('curso',$r->curso)->get();
        foreach($rc->all() as $reqcurso){
            $reqcurso->delete();
        }
        foreach($r->requisito as $requisito){
            $reqcur=new CursoRequisito;
            $reqcur->timestamps=false;
            $reqcur->curso=$r->curso;
            $reqcur->requisito=$r->requisito[$requisito];

            if(isset($r->obrigatorio))
                if(in_array($requisito, $r->obrigatorio))
                    $reqcur->obrigatorio=1;
            /*
            if($r->obrigatorio[$requisito]==1)
                $reqcur->obrigatorio=1;
                */
            $reqcur->save();
        }
        return redirect(asset('/pedagogico/curso').'/'.$r->curso);
    }
}
