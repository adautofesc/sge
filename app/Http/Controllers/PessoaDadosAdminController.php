<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaDadosAdministrativos;


class PessoaDadosAdminController extends Controller
{
    
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
}
