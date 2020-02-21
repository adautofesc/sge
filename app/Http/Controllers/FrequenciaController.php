<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;
use App\AulaDado;
use App\Turma;
use App\Frequencia;

class FrequenciaController extends Controller
{
    public function listaChamada(int $turma){
        $turma = Turma::find($turma);
        $aulas = Aula::where('turma',$turma->id)->orderBy('data')->get();
        foreach($aulas as $aula){
            $aula->presentes = $aula->getAlunosPresentes();    
        }
        if(isset($_GET['filtrar']))
        $inscritos=\App\Inscricao::where('turma',$turma->id)->get();
        else
        $inscritos=\App\Inscricao::where('turma',$turma->id)->whereIn('status',['regular','espera','ativa','pendente'])->get();
        $inscritos= $inscritos->sortBy('pessoa.nome');

        //dd($aulas);
        return view('frequencias.lista-unitaria',compact('inscritos'))->with('i',1)->with('aulas',$aulas)->with('turma',$turma);
    }

    public function novaFrequencia(int $aula, int $aluno){
        $frequencia =  new Frequencia;
        $frequencia->aula = $aula;
        $frequencia->aluno = $aluno;
        $frequencia->save();
        return $frequencia;
    }

    public function removeFrequencia(int $aula, int $aluno){
        $frequencia = Frequencia::where('aula',$aula)->where('aluno',$aluno)->first();
        if(isset($frequencia->id)){
            $frequencia->delete();
        }     
    }

    public function novaChamada_view(int $turma){
        $aulas = Aula::where('turma',$turma)->whereIn('status',['prevista','planejada'])->orderBy('data')->get();
        if(count($aulas)==0){
            $AULA_CONTROLER = new AulaController;
            $aulas = $AULA_CONTROLER->gerarAulas($turma);
        }    
        
        $turma = \App\Turma::find($turma);

        if($turma->professor->id != session('usuario') && !unserialize(Session('recursos_usuario'))->contains('recurso','17'))
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';

        if(isset($_GET['filtrar']))
            $turma->getInscricoes('todas');
        else
            $turma->getInscricoes('regulares');

        $aulas_anteriores = Aula::where('turma',$turma->id)->whereIn('status',['executada','adiada','cancelada'])->orderByDesc('data')->get();
        foreach($aulas_anteriores as $aula_anterior){
            if($aula_anterior->status == 'executada')
                $aula_anterior->conteudo = $aula_anterior->getConteudo();
            else
                $aula_anterior->conteudo = 'Aula '.$aula_anterior->status;
            $aula_anterior->ocorrencia = $aula_anterior->getOcorrencia();
        }

        return view('frequencias.chamada')->with('turma',$turma)->with('aulas',$aulas)->with('anteriores',$aulas_anteriores);

    }

    public function novaChamada_exec(Request $req){
       
        $aula = Aula::find($req->aula);

        $turma = \App\Turma::find($aula->turma);
        
        if($turma->professor->id != session('usuario') && !unserialize(Session('recursos_usuario'))->contains('recurso','17'))
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';
    
        if(!is_null($req->conteudo)){
            $auladado = new AulaDadoController;
            $auladado->createDadoAula($req->aula,'conteudo',$req->conteudo);
            
        }
        if(!is_null($req->ocorrencia)){
            $auladado = new AulaDadoController;
            $auladado->createDadoAula($req->aula,'ocorrencia', $req->ocorrencia);
            
        }
        foreach($req->aluno as $aluno){  
            $this->novaFrequencia($req->aula,$aluno);
        }

        $aula->status = 'executada';
        $aula->save();
        
        return redirect(asset('/docentes'))->withErrors(['Chamada registrada.']);

    }


    public function editarChamada_view(int $aula){

        $aula = Aula::find($aula);
    
        if(!isset($aula->id)){
            return redirect()->back()->withErrors(['Aula inexistente']);

        }    
        
        $turma = \App\Turma::find($aula->turma);

        if($turma->professor->id != session('usuario') && !unserialize(Session('recursos_usuario'))->contains('recurso','17'))
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';

        if(isset($_GET['filtrar']))
            $turma->getInscricoes('todas');
        else
            $turma->getInscricoes('regulares');

        $frequencias = Frequencia::where('aula', $aula->id)->get();      
        $arr_frequencias = $frequencias->pluck('aluno')->toArray();

        $aulas_anteriores = Aula::where('turma',$turma->id)->whereIn('status',['executada','adiada','cancelada'])->orderByDesc('data')->get();
        foreach($aulas_anteriores as $aula_anterior){
            if($aula_anterior->status == 'executada')
                $aula_anterior->conteudo = $aula_anterior->getConteudo();
            else
                $aula_anterior->conteudo = 'Aula '.$aula_anterior->status;
            $aula_anterior->ocorrencia = $aula_anterior->getOcorrencia();
        }

        return view('frequencias.editar-chamada')->with('turma',$turma)->with('aula',$aula)->with('anteriores',$aulas_anteriores)->with('frequencias',$arr_frequencias);

    }
    public function editarChamada_exec(Request $req){

        
            
        $aula = Aula::find($req->aula);
        $frequencias = Frequencia::select('aluno')->where('aula', $aula->id)->get();
        $arr_frequencias = $frequencias->pluck('aluno')->toArray();
        $turma = \App\Turma::find($req->turma);

        if($turma->professor->id != session('usuario') && !unserialize(Session('recursos_usuario'))->contains('recurso','17'))
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';

        
        if(isset($_GET['filtrar']))
            $turma->getInscricoes('todas');
        else
            $turma->getInscricoes('regulares');

        foreach($turma->inscricoes as $inscricao){
            if(in_array($inscricao->pessoa->id, $req->aluno)){
                if(!in_array($inscricao->pessoa->id,$arr_frequencias))
                    $this->novaFrequencia($req->aula,$inscricao->pessoa->id);
                
            }
            else{
                if(in_array($inscricao->pessoa->id,$arr_frequencias))
                    $this->removeFrequencia($req->aula,$inscricao->pessoa->id);
            }

        }
    
        if(!is_null($req->conteudo)){
            $auladado = new AulaDadoController;
            $conteudo = $auladado->updateDadoAula($aula->id,'conteudo',$req->conteudo);
        }
        if(!is_null($req->ocorrencia)){
            $auladado = new AulaDadoController;
            $conteudo = $auladado->updateDadoAula($aula->id,'ocorrencia',$req->ocorrencia);
        }
      
        return redirect(asset('/docentes'))->withErrors(['Chamada da aula '.$aula->id.' atualizada.']);

    }
}
