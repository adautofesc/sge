<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FichaTecnica;
use App\FichaTecnicaDados;
use App\Programa;
use App\Pessoa;
use App\PessoaDadosAdministrativos;
use App\Local;
use App\Sala;
use Auth;

class FichaTecnicaController extends Controller
{
    /**
     * O dados das fichas são liberados de acordo 2 recursos: docentes - 13 - e secretaria - 17
     * 
     *  No caso de professor ele verifica se tem o recurso docente não tem o cordenador
     *  No caso do coordenador, ele com certeza terá os dois
     *  No caso da secretaria ele não cairá em nenhum dos casos acima, pois com certeza ele não terá o recurso de docente.
     * 
     */



    public function index(){
        
        $fichas = FichaTecnica::paginate(50);
        if(in_array('13', Auth::user()->recursos) && !in_array('17', Auth::user()->recursos))
            $fichas = FichaTecnica::where('docente',Auth::user()->pessoa)->paginate(50);
        if(in_array('17', Auth::user()->recursos) && in_array('13', Auth::user()->recursos)){
            $programas = \App\PessoaDadosAdministrativos::where('pessoa',Auth::user()->pessoa)->where('dado','programa')->pluck('valor')->toArray();
            $fichas = FichaTecnica::whereIn('programa',$programas)->paginate(50);
        }     

        return view('fichas-tecnicas.index')->with('fichas',$fichas);

    }
    public function pesquisar(Request $r){
        $fichas = FichaTecnica::where('curso','like','%'.$r->curso.'%')->paginate(50);

        return view('fichas-tecnicas.index')->with('fichas',$fichas);

    }

    public function cadastrar(){
        
        $unidades=Local::get(['id' ,'nome']);
        $programas = Programa::all();
        $professores = PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);

        if(in_array('13', Auth::user()->recursos) && !in_array('17', Auth::user()->recursos)){
            $programa = \App\PessoaDadosAdministrativos::where('pessoa',Auth::user()->pessoa)->where('dado','programa')->pluck('valor')->toArray();
            $programas = Programa::whereIn('id',$programa)->get();
            $professores = Pessoa::where('id',Auth::user()->pessoa)->get();

        }
        if(in_array('17', Auth::user()->recursos) && in_array('13', Auth::user()->recursos)){
            $programa = \App\PessoaDadosAdministrativos::where('pessoa',Auth::user()->pessoa)->where('dado','programa')->pluck('valor')->toArray();
            $programas = Programa::whereIn('id',$programa)->get();
            $professores_dos_programas = collect();
            $professoress = \App\PessoaDadosAdministrativos::getFuncionarios('Educador');
            foreach($professoress as $professor){
                $comparisson = array_intersect($programa,$professor->getProgramas());
                if(count($comparisson))
                    $professores_dos_programas->push($professor);
            }
            $professores = Pessoa::whereIn('id', $professores_dos_programas->pluck('id')->toArray())->get();
            $professores = $professores->sortBy('nome');
            //dd($professores);

        }

        return view('fichas-tecnicas.cadastrar')
                ->with('professores',$professores)
                ->with('unidades',$unidades)
                ->with('programas',$programas);
    }

    public function gravar(Request $r){
        $ficha = new FichaTecnica;
        $ficha->programa = $r->programa;
        $ficha->docente = $r->professor;
        $ficha->curso = mb_strtoupper($r->curso,'UTF-8');
        $ficha->objetivo = $r->objetivos;
        $ficha->conteudo = $r->conteudo;
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
        $ficha->valor = str_replace(',','.',$r->valor)*100;
        $ficha->local = $r->local;
        $ficha->sala = $r->sala;
        $ficha->status = 'docente';
        $ficha->materiais = $r->materiais;
        $ficha->obs = $r->obs;
        $ficha->save();

        $dados_ficha = new FichaTecnicaDados;
        $dados_ficha->ficha = $ficha->id;
        $dados_ficha->dado = 'log';
        $dados_ficha->conteudo = 'Cadastro efetuado';
        $dados_ficha->agente = Auth::user()->pessoa;
        $dados_ficha->save();

        if($r->btn==2)
            return redirect()->back()->with('success','Ficha cadastrada com sucesso');
        else
            return redirect('/fichas')->with('success','Ficha cadastrada com sucesso');

    }

    public function visualizar($id){
        $relacao = PessoaDadosAdministrativos::where('pessoa',Auth::user()->pessoa)->where('dado','relacao_institucional')->first();
        dd($relacao);
        $ficha = FichaTecnica::find($id);
        $dados_ficha = FichaTecnicaDados::where('ficha',$ficha->id)->get();
        return view('fichas-tecnicas.exibir',compact('ficha'))
            ->with('dados',$dados_ficha)
            ->with('relacao',$relacao);
                    
    }

    public function editar($id){
        $ficha = FichaTecnica::find($id);
        $unidades = Local::get(['id' ,'nome']);
        $salas = Sala::where('local',$ficha->local)->get();
        
        $programas = Programa::all();
        $professores = PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);

        if(in_array('13', Auth::user()->recursos) && !in_array('17', Auth::user()->recursos)){
            $programa = \App\PessoaDadosAdministrativos::where('pessoa',Auth::user()->pessoa)->where('dado','programa')->pluck('valor')->toArray();
            $programas = Programa::whereIn('id',$programa)->get();
            $professores = Pessoa::where('id',Auth::user()->pessoa)->get();

        }
        if(in_array('17', Auth::user()->recursos) && in_array('13', Auth::user()->recursos)){
            $programa = \App\PessoaDadosAdministrativos::where('pessoa',Auth::user()->pessoa)->where('dado','programa')->pluck('valor')->toArray();
            $programas = Programa::whereIn('id',$programa)->get();
            $professores_dos_programas = collect();
            $professoress = \App\PessoaDadosAdministrativos::getFuncionarios('Educador');
            foreach($professoress as $professor){
                $comparisson = array_intersect($programa,$professor->getProgramas());
                if(count($comparisson))
                    $professores_dos_programas->push($professor);
            }
            $professores = Pessoa::whereIn('id', $professores_dos_programas->pluck('id')->toArray())->get();
            $professores = $professores->sortBy('nome');
            //dd($professores);

        }

        return view('fichas-tecnicas.editar',compact('ficha'))
                ->with('professores',$professores)
                ->with('salas',$salas)
                ->with('unidades',$unidades)
                ->with('programas',$programas);
    }

    public function update(Request $r){
        $ficha = FichaTecnica::find($r->id);
        $edicoes = '';
        if($ficha->programa != $r->programa)
            $edicoes .= 'programa: '.$ficha->programa. ' => '.$r->programa.', ';
        $ficha->programa = $r->programa;
        if($ficha->docente != $r->professor)
            $edicoes .= 'docente: '.$ficha->docente. ' => '.$r->professor.', ';
        $ficha->docente = $r->professor;
        if($ficha->curso !=  mb_strtoupper($r->curso,'UTF-8'))
            $edicoes .= 'curso: '.$ficha->curso. ' => '. mb_strtoupper($r->curso,'UTF-8').', ';
        $ficha->curso = mb_strtoupper($r->curso,'UTF-8');
        if($ficha->objetivo != $r->objetivos)
            $edicoes .= 'objetivo modificado, ';
        $ficha->objetivo = $r->objetivos;
        if($ficha->conteudo != $r->conteudo)
            $edicoes .= 'conteudo modificado, ';
        $ficha->conteudo = $r->conteudo;
        if($ficha->requisitos != $r->requisitos)
            $edicoes .= 'requisitos: '.$ficha->requisitos. ' => '.$r->requisitos.', ';
        $ficha->requisitos = $r->requisitos;
        if($ficha->idade_minima != $r->idade_min)
            $edicoes .= 'idade mínima: '.$ficha->idade_minima. ' => '.$r->idade_min.', ';
        $ficha->idade_minima = $r->idade_min;
        if($ficha->idade_maxima != $r->idade_max)
            $edicoes .= 'idade máxima: '.$ficha->idade_maxima. ' => '.$r->idade_max.', ';
        $ficha->idade_maxima = $r->idade_max;
        if($ficha->carga != $r->carga)
            $edicoes .= 'carga: '.$ficha->carga. ' => '.$r->carga.', ';
        $ficha->carga = $r->carga;
        if($ficha->periodicidade != $r->periodicidade)
            $edicoes .= 'periodicidade: '.$ficha->periodicidade. ' => '.$r->periodicidade.', ';
        $ficha->periodicidade = $r->periodicidade;
        if($ficha->dias_semana != implode(',',$r->dias))
            $edicoes .= 'dias: '.$ficha->dias_semana. ' => '.implode(',',$r->dias).', ';
        $ficha->dias_semana = implode(',',$r->dias);
        if($ficha->data_inicio->format('Y-m-d') != $r->data_inicio)
            $edicoes .= 'data inicio: '.$ficha->data_inicio->format('Y-m-d'). ' => '.$r->data_inicio.', ';
        $ficha->data_inicio = $r->data_inicio;
        if($ficha->data_termino->format('Y-m-d') != $r->data_termino)
            $edicoes .= 'data termino: '.$ficha->data_termino->format('Y-m-d'). ' => '.$r->data_termino.', ';
        $ficha->data_termino = $r->data_termino;
        if($ficha->hora_inicio != $r->hora_inicio)
            $edicoes .= 'hora inicio: '.$ficha->hora_inicio. ' => '.$r->hora_inicio.', ';
        $ficha->hora_inicio = $r->hora_inicio;
        if($ficha->hora_termino != $r->hora_termino)
            $edicoes .= 'hora termino: '.$ficha->hora_termino. ' => '.$r->hora_termino.', ';
        $ficha->hora_termino = $r->hora_termino;
        if($ficha->lotacao_maxima != $r->lotacao_max)
            $edicoes .= 'lotação máxima: '.$ficha->lotacao_maxima. ' => '.$r->lotacao_max.', ';
        $ficha->lotacao_maxima = $r->lotacao_max;
        if($ficha->lotacao_minima != $r->lotacao_min)
            $edicoes .= 'lotação mínima: '.$ficha->lotacao_minima. ' => '.$r->lotacao_min.', ';
        $ficha->lotacao_minima = $r->lotacao_min;
        if($ficha->valor != str_replace(',','.',$r->valor)*100)
            $edicoes .= 'valor: '.$ficha->valor. ' => '.$r->valor.', ';
        $ficha->valor = str_replace(',','.',$r->valor)*100;
        if($ficha->local != $r->local)
            $edicoes .= 'local: '.$ficha->local. ' => '.$r->local.', ';
        $ficha->local = $r->local;
        if($ficha->sala != $r->sala)
            $edicoes .= 'sala: '.$ficha->sala. ' => '.$r->sala.', ';
        $ficha->sala = $r->sala;
        if($ficha->materiais != $r->materiais)
            $edicoes .= 'recursos necessários alterado, ';
        $ficha->materiais = $r->materiais;
        if($ficha->obs != $r->obs)
            $edicoes .= 'mais informações alterado, ';
        $ficha->materiais = $r->materiais;

        $ficha->save();
       

        $dados_ficha = new FichaTecnicaDados;
        $dados_ficha->ficha = $ficha->id;
        $dados_ficha->dado = 'log';
        $dados_ficha->conteudo = 'Edição realizada - '.$edicoes;
        $dados_ficha->agente = Auth::user()->pessoa;
        $dados_ficha->save();

        return redirect('/fichas')->with('success','Ficha cadastrada com sucesso');

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

     public function copiar($id){
        $ficha = FichaTecnica::find($id);
        if(!isset($ficha->id))
            return redirect()->back()->with('warning','Ficha não encontrada');
        /*$programas = Programa::all();
        $unidades = Local::get(['id' ,'nome']);
        $salas = Sala::where('local',$ficha->local)->get();
        $professores = PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
        return view('fichas-tecnicas.copiar',compact('ficha'))
                ->with('professores',$professores)
                ->with('salas',$salas)
                ->with('unidades',$unidades)
                ->with('programas',$programas);*/
        $unidades = Local::get(['id' ,'nome']);
        $salas = Sala::where('local',$ficha->local)->get();
        
        $programas = Programa::all();
        $professores = PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);

        if(in_array('13', Auth::user()->recursos) && !in_array('17', Auth::user()->recursos)){
            $programa = \App\PessoaDadosAdministrativos::where('pessoa',Auth::user()->pessoa)->where('dado','programa')->pluck('valor')->toArray();
            $programas = Programa::whereIn('id',$programa)->get();
            $professores = Pessoa::where('id',Auth::user()->pessoa)->get();

        }
        if(in_array('17', Auth::user()->recursos) && in_array('13', Auth::user()->recursos)){
            $programa = \App\PessoaDadosAdministrativos::where('pessoa',Auth::user()->pessoa)->where('dado','programa')->pluck('valor')->toArray();
            $programas = Programa::whereIn('id',$programa)->get();
            $professores_dos_programas = collect();
            $professoress = \App\PessoaDadosAdministrativos::getFuncionarios('Educador');
            foreach($professoress as $professor){
                $comparisson = array_intersect($programa,$professor->getProgramas());
                if(count($comparisson))
                    $professores_dos_programas->push($professor);
            }
            $professores = Pessoa::whereIn('id', $professores_dos_programas->pluck('id')->toArray())->get();
            $professores = $professores->sortBy('nome');
            //dd($professores);

        }
    
     }

     public function encaminhar($id,$local,$conteudo=''){
        $ficha = FichaTecnica::find($id);
        if(!isset($ficha->id))
            return redirect()->back()->with('warning','Ficha não encontrada');
        $ficha->status = $local;
        $ficha->save();

        $dados_ficha = new FichaTecnicaDados;
        $dados_ficha->ficha = $ficha->id;
        $dados_ficha->dado = 'log';
        $dados_ficha->conteudo = 'Ficha encaminhada para '.$local;
        $dados_ficha->agente = Auth::user()->pessoa;
        $dados_ficha->save();

        return redirect('/fichas');



     }
}
