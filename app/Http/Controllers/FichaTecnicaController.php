<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FichaTecnica;
use App\Programa;
use App\Pessoa;
use App\PessoaDadosAdministrativos;
use App\Local;
use App\Sala;

class FichaTecnicaController extends Controller
{
    public function index(){
        $fichas = FichaTecnica::paginate(50);

        return view('fichas-tecnicas.index')->with('fichas',$fichas);

    }
    public function pesquisar(Request $r){
        $fichas = FichaTecnica::where('curso','like','%'.$r->curso.'%')->paginate(50);

        return view('fichas-tecnicas.index')->with('fichas',$fichas);

    }

    public function cadastrar(){
        $programas = Programa::all();
        $unidades=Local::get(['id' ,'nome']);
        $professores = PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
        return view('fichas-tecnicas.cadastrar')
                ->with('professores',$professores)
                ->with('unidades',$unidades)
                ->with('programas',$programas);
    }

    public function gravar(Request $r){
        $ficha = new FichaTecnica;
        $ficha->programa = $r->programa;
        $ficha->docente = $r->professor;
        $ficha->curso = $r->curso;
        $ficha->objetivo = $r->objetivos;
        $ficha->requisitos = $r->requisitos;
        $ficha->idade_minima = $r->idade_min;
        $ficha->idade_maxima = $r->idade_max;
        $ficha->carga = $r->carga;
        $ficha->periodicidade = $r->periodicidade;
        $ficha->dias_semana = implode(',',$r->dias);
        $ficha->data_inicio = $r->data_inicio;
        $ficha->data_termino = $r->data_termino;
        $ficha->hora_inicio = $r->hora_inicio;
        $ficha->hora_termino = $r->hora_termino;
        $ficha->lotacao_maxima = $r->lotacao_max;
        $ficha->lotacao_minima = $r->lotacao_min;
        $ficha->valor = $r->valor;
        $ficha->local = $r->local;
        $ficha->sala = $r->sala;
        $ficha->status = 'docente';

        $ficha->save();

        if($r->btn==2)
            return redirect()->back()->with('success','Ficha cadastrada com sucesso');
        else
            return redirect('fichas')->with('success','Ficha cadastrada com sucesso');

    }

    public function visualizar($id){
        $ficha = FichaTecnica::find($id);
        return view('fichas-tecnicas.exibir',compact('ficha'));
                    
    }

    public function editar($id){
        $ficha = FichaTecnica::find($id);
        $programas = Programa::all();
        $unidades = Local::get(['id' ,'nome']);
        $salas = Sala::where('local',$ficha->local)->get();
        $professores = PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
        return view('fichas-tecnicas.editar',compact('ficha'))
                ->with('professores',$professores)
                ->with('salas',$salas)
                ->with('unidades',$unidades)
                ->with('programas',$programas);
    }

    public function update(Request $r){
        $ficha = FichaTecnica::find($r->id);
        $ficha->programa = $r->programa;
        $ficha->docente = $r->professor;
        $ficha->curso = $r->curso;
        $ficha->objetivo = $r->objetivos;
        $ficha->requisitos = $r->requisitos;
        $ficha->idade_minima = $r->idade_min;
        $ficha->idade_maxima = $r->idade_max;
        $ficha->carga = $r->carga;
        $ficha->periodicidade = $r->periodicidade;
        $ficha->dias_semana = implode(',',$r->dias);
        $ficha->data_inicio = $r->data_inicio;
        $ficha->data_termino = $r->data_termino;
        $ficha->hora_inicio = $r->hora_inicio;
        $ficha->hora_termino = $r->hora_termino;
        $ficha->lotacao_maxima = $r->lotacao_max;
        $ficha->lotacao_minima = $r->lotacao_min;
        $ficha->valor = $r->valor;
        $ficha->local = $r->local;
        $ficha->sala = $r->sala;
        $ficha->status = 'docente';
        $ficha->save();

        return redirect('fichas')->with('success','Ficha cadastrada com sucesso');

    }

    public function excluir(Request $r){
        $ficha = FichaTecnica::find($r->id);
        if(isset($ficha->id)){
            $ficha->delete();
            return response('Done!',200);

        }
        else        
            return response('Id não encontrado',404);
     }
}
