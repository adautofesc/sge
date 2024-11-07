<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;
use App\PessoaDadosAdministrativos;
use Auth;


class PessoaDadosAdminController extends Controller
{
    public function relacaoInstitucional_view($id){
		if(!in_array('3', Auth::user()->recursos))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($id))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional ou não está acessivel. O código de pessoa também pode ser inválido']));

		$nome = Pessoa::getNome($id);
		if(!$nome)
			return view('error-404-alt')->with(array('error'=>['id'=>'404','desc'=>'Pessoa não encontrada']));


		return view('gestaopessoal.relacao-institucional')->with('nome',$nome)->with('id',$id);



	}
	public function relacaoInstitucional_exec(Request $request){
		
		if(!in_array('3', Auth::user()->recursos))
			return view('error-404-alt')->with(array('error'=>['id'=>'403.3','desc'=>'Você não pode editar os cadastrados.']));
		if(!loginController::autorizarDadosPessoais($request->pessoa))
			return view('error-404-alt')->with(array('error'=>['id'=>'403','desc'=>'Erro: pessoa a ser editada possui relação institucional, não está acessivel ou não existe.']));
		
		$nova_relacao=new PessoaDadosAdministrativos;
		$nova_relacao->dado='relacao_institucional';
		$nova_relacao->pessoa=$request->pessoa;
		$nova_relacao->valor=$request->cargo;
		$nova_relacao->save();

		return redirect(asset('gestaopessoal/atender').'/'.$request->pessoa);



	}
    
    public function excluir($ri){
    	PessoaDadosAdministrativos::destroy($ri);
    	return redirect()->back()->withErrors(['Relação removida com sucesso.']);

    }

    public static function listarProfessores(){

        $professores=PessoaDadosAdministrativos::getFuncionarios('Educador');
        return view('docentes.lista-professores',compact('professores'));

    }

    public static function liberarPendencia($pessoa,$valor){
        $pendencia = PessoaDadosAdministrativos::where('pessoa',$pessoa)->where('dado','pendencia')->where('valor',$valor)->first();
        if($pendencia)
            $pendencia->delete();
        
        
        $outras_pendencias = PessoaDadosAdministrativos::where('pessoa',$pessoa)->where('dado','pendencia')->first();
        if($outras_pendencias == null){
            $matriculas = \App\Matricula::where('pessoa',$pessoa)->where('status','pendente')->get();
            $inscricoes = \App\Inscricao::where('pessoa',$pessoa)->where('status','pendente')->get();
            foreach($matriculas as $matricula){
                $matricula->status = 'ativa';
                $matricula->save();
            }
            foreach($inscricoes as $inscricao){
                $inscricao->status = 'regular';
                $inscricao->save();
            }

        }
        
    }
    /**
     * Removendo pendencias de saúde de alunos sem matrículas
     *
     * @param integer $id
     * @return void
     */
    public static function removePendenciasSemMatriculas(int $id=0){
        if($id>0)
             $pendencias = \App\PessoaDadosAdministrativos::where('pessoa',$id)->where('dado','pendencia')->whereIn('valor',['Falta atestado de vacinação aprovado.','Falta atestado de saúde aprovado.'])->get();
        else
            $pendencias = \App\PessoaDadosAdministrativos::where('dado','pendencia')->whereIn('valor',['Falta atestado de vacinação aprovado.','Falta atestado de saúde aprovado.'])->get();
        foreach($pendencias as $pendencia){
            $matriculas = \App\Matricula::where('pessoa',$pendencia->pessoa)->whereIn('status',['ativa','pendente'])->count();
            if($matriculas==0)
               //dd($pendencia);Falta atestado de saúde aprovado..
               $pendencia->delete();

        }
    }

    public static function verificaPendencias(int $pessoa){
        
        $pendencias = PessoaDadosAdministrativos::where('pessoa',$pessoa)->where('dado','pendencia')->get();
        foreach($pendencias as $pendencia){
            switch($pendencia->valor){
                case 'Falta atestado de vacinação aprovado.':
                    $atestado = \App\Atestado::where('pessoa',$pessoa)->where('tipo','vacinacao')->where('status','aprovado')->first();
                    if($atestado)
                        PessoaDadosAdminController::liberarPendencia($atestado->pessoa,'Falta atestado de vacinação aprovado.');
                break;
                case 'Falta atestado de saúde aprovado.':
                    $atestado = \App\Atestado::where('pessoa',$pessoa)->where('tipo','saude')->where('status','aprovado')->first();
                    if($atestado)
                        PessoaDadosAdminController::liberarPendencia($atestado->pessoa,'Falta atestado de saúde aprovado.');
                break;

            }
        }

        return 'Pendencias verificadas';
    }

    public function relatorioPendentes(){
        $pendencias = PessoaDadosAdministrativos::where('dado','pendencia')->get();
        $pessoas = Array();
        $atestados_vacina = Array();
        $atestados_saude = Array();
        
        foreach($pendencias as $pendencia){
            if(!in_array($pendencia->pessoa,$pessoas))
                $pessoas[] = $pendencia->pessoa;
            if($pendencia->valor == 'Falta atestado de vacinação aprovado.' && !in_array($pendencia->pessoa,$atestados_vacina))
                $atestados_vacina[] = $pendencia->pessoa;
            if($pendencia->valor == 'Falta atestado de saúde aprovado.' && !in_array($pendencia->pessoa,$atestados_saude))
                $atestados_saude[] = $pendencia->pessoa;
            
            
        }

        $pessoas_collection = \App\Pessoa::whereIn('id',$pessoas)->paginate(50);

       

        return view('pessoa.dados-administrativos.listar-pendencias')->with('pessoas',$pessoas_collection)->with('atestados_vacina',$atestados_vacina)->with('atestados_saude',$atestados_saude);
		
	}


    public function vincularPrograma(int $pessoa,int $programa){
        $vinculo = new PessoaDadosAdministrativos;
        $vinculo->pessoa = $pessoa;
        $vinculo->dado = 'programa';
        $vinculo->valor = $programa;
        $vinculo->save();

        return response(200);

    }

    public function desvincularPrograma(int $pessoa,int $programa){
        $vinculo = PessoaDadosAdministrativos::where('pessoa',$pessoa)->where('dado','programa')->where('valor',$programa)->delete();
        return response(200);
    }

    public function definirCarga(int $pessoa,int $valor){
        $vinculo = new PessoaDadosAdministrativos;
        $vinculo->pessoa = $pessoa;
        $vinculo->dado = 'carga_horaria';
        $vinculo->valor = $valor;
        $vinculo->save();

        return response(200);

    }

    public function removerCarga(int $id){
        $vinculo = PessoaDadosAdministrativos::where('id',$id)->delete();
        return response(200);
    }

    public function listarFuncionarios(){ // lista pessoas com relação institucional (RI)
		$com_ri = PessoaDadosAdministrativos::select('pessoa')->where('dado','relacao_institucional')->groupBy('pessoa')->get();
		$pessoas = Pessoa::whereIn('id',$com_ri)->orderBy('nome')->paginate(50);
		foreach($pessoas as $pessoa){
			$pessoa->cargo = PessoaDadosAdministrativos::where('pessoa',$pessoa->id)->where('dado','relacao_institucional')->first()->valor;
			$telefone = \App\PessoaDadosContato::where('pessoa',$pessoa->id)->where('dado',2)->orderByDesc('id')->first();
            $pessoa->carga = PessoaDadosAdministrativos::where('dado','carga_horaria')->where('pessoa',$pessoa->id)->first();
			if($telefone)
			 $pessoa->telefone = \App\classes\Strings::formataTelefone($telefone->valor);
			else
			 $pessoa->telefone = "Necessita de atualização";	
		}
		return view('gestaopessoal.listarusuarios')->with('pessoas',$pessoas);
	}
}
