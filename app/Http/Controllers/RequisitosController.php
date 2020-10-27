<?php

namespace App\Http\Controllers;

use App\Requisito;
use App\Curso;
use App\CursoRequisito;
use App\Turma;

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
        return view('curso.requisito.lista', compact('requisitos'))->with('filtros',['nome'=>0,'descricao'=>1,'importancia'=>2]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('curso.requisito.cadastrar');    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd('teste');
        $this->validate($request, [
            'nome'=>'required|max:150|min:3'
            ]);
        $requisito = new Requisito;
        $requisito->timestamps=false;
        $requisito->nome=$request->nome;
        $requisito->save();

        if($request->btn==1)
            return redirect(asset('cursos/requisitos'));
        else
            return view('curso.requisito.cadastrar')->with(array('dados'=>['alert_sucess'=>['Requisito cadastrado com sucesso.']]));
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
       
        return redirect('/cursos/requisitos');
    }

    public static function listar()
    {
        $requisitos=Requisito::paginate(50);
        return $requisitos;
    }

    public function editRequisitosAoCurso($curso){
        $cursoexiste=Curso::find($curso);
        if(!$cursoexiste)
            return redirect(asset('/pedagogico/cursos'));
        $requisitos=Requisito::get();
        foreach($requisitos->all() as $requisito){
            $rc=CursoRequisito::where('curso', $curso)->where('requisito',$requisito->id)->first();
            if(isset($rc->id)){
                $requisito->checked="checked";
                if($rc->obrigatorio==1)
                    $requisito->obrigatorio="checked";
            }
        }

        //return $requisitos;
        return view('curso.curso-requisitos', compact('requisitos'))->with(array('curso'=>['nome'=>$cursoexiste->nome, 'id_curso'=>$cursoexiste->id]));
    }

    public function editRequisitosTurma($turmas){

        $requisitos=Requisito::get();
        $turmas_arr = explode(',',$turmas);
        if(count($turmas_arr)!=1)
            return view('pedagogico.turma.turma-requisitos', compact('requisitos'))->with('turmas',$turmas);

        $turma=Turma::find($turmas);
        foreach($requisitos->all() as $requisito){
            $rc=CursoRequisito::where('curso', $turma->id)->where('para_tipo','turma')->where('requisito',$requisito->id)->first();
            if(isset($rc->id)){
                $requisito->checked="checked";
                if($rc->obrigatorio==1)
                    $requisito->obrigatorio="checked";
            }
        }

        //return $requisitos;
        //dd($turma);
        return view('turmas.turma-requisitos', compact('requisitos'))->with('turma',$turma);
    }
    public function storeRequisitosTurma(Request $r){


        $array_turmas = explode(',',$r->turmas);


        foreach($array_turmas as $turma){

            $this->clear('turma',$turma);
            if(isset($r->requisito)){
                foreach($r->requisito as $requisito){

                    if(isset($r->obrigatorio))
                        if(in_array($requisito, $r->obrigatorio))
                            $this->gerar('turma',$turma,$r->requisito[$requisito],1);
                            
                        else
                            $this->gerar('turma',$turma,$r->requisito[$requisito],0);
                    else
                        $this->gerar('turma',$turma,$r->requisito[$requisito],0);

                  
                }
            }


        }


       return redirect('pedagogico/turmas')->withErrors('Requisitos atualizados das turmas '.$r->turmas);
    }

    public function storeRequisitosAoCurso(Request $r){

        $this->clear('curso',$r->curso);
        if(!is_null($r->requisito))
        foreach($r->requisito as $requisito){
            if(isset($r->obrigatorio))
                if(in_array($requisito, $r->obrigatorio))
                    $this->gerar('curso',$r->curso,$r->requisito[$requisito],1);
                else
                    $this->gerar('curso',$r->curso,$r->requisito[$requisito],0);
            else
                $this->gerar('curso',$r->curso,$r->requisito[$requisito],0);

            /*
            if($r->obrigatorio[$requisito]==1)
                $reqcur->obrigatorio=1;
                */
        
        }
        return redirect(asset('/cursos/curso').'/'.$r->curso);
    }

    public function clear($tipo,$valor){
        $requisitos = CursoRequisito::where('para_tipo',$tipo)->where('curso',$valor)->get();
        foreach($requisitos as $requisito){
            $requisito->delete();
        }
        return true;
    }
    public function gerar($tipo,$item,$requisito,$obrigatorio=0){

        $reqcur = new CursoRequisito;
        $reqcur->para_tipo = $tipo; 
        $reqcur->curso = $item;
        $reqcur->requisito = $requisito;
        $reqcur->obrigatorio = $obrigatorio;
        $reqcur->timestamps=false;
        $reqcur->save();

        
        return $reqcur;

    }
}
