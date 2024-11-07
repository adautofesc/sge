<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;
use App\AulaDado;
use App\Turma;
use App\Frequencia;
use Auth;

class FrequenciaController extends Controller
{
    public function index($id=0,$semestre=0){
        if($id == 0){
            $id = Auth::user()->pessoa;
        }

        $turmas = \App\Http\Controllers\TurmaController::listarTurmasDocente($id,$semestre);
        $semestres = \App\classes\Data::semestres();
        $docente = \App\Pessoa::withTrashed()->find($id);
        //dd($semestres);

        return view('frequencias.index')
                    ->with('turmas',$turmas)
                    ->with('semestres',$semestres)
                    ->with('docente',$docente)
                    ->with('semestre_selecionado',$semestre);


        
    }

    public function listaChamadaUnitaria(int $turma){
        $turma = Turma::find($turma);
        $aulas = Aula::where('turma',$turma->id)->orderBy('data')->get();
        foreach($aulas as $aula){
            $aula->presentes = $aula->getAlunosPresentes();    
        }
        if(isset($_GET['filtrar']))
            $inscritos=\App\Inscricao::where('turma',$turma->id)->get();
        else
            $inscritos=\App\Inscricao::where('turma',$turma->id)->whereIn('status',['regular','espera','ativa','pendente','finalizada'])->get();

        $inscritos= $inscritos->sortBy('pessoa.nome');

        //dd($aulas);
        return view('frequencias.lista-unitaria',compact('inscritos'))->with('i',1)->with('aulas',$aulas)->with('turma',$turma);
    }

    public function listaChamada($ids){
        $turmas_arr = explode(',',$ids);
        $turmas = \App\Turma::whereIn('id',$turmas_arr)->get();
        foreach($turmas as &$turma){      
            $turma->aulas = Aula::where('turma',$turma->id)->orderBy('data')->get();
            foreach($turma->aulas as &$aula){
                $aula->presentes = $aula->getAlunosPresentes();    
            }
            if(isset($_GET['filtrar']))
                $turma->inscritos=\App\Inscricao::where('turma',$turma->id)->get();
            else
                $turma->inscritos=\App\Inscricao::where('turma',$turma->id)->whereIn('status',['regular','espera','ativa','pendente','finalizada'])->get();

            $turma->inscritos= $turma->inscritos->sortBy('pessoa.nome');
        }
        //dd($aulas);
        return view('frequencias.lista-multipla',compact('turmas'))->with('i',1);
    }



    public function preencherChamada_view(int $turma){
        
        $turma = Turma::find($turma);

        if((date('Y')-substr($turma->data_inicio,6,4))>=1){   
            if((date('Y')-substr($turma->data_inicio,6,4))!=1 || date('md') > self::DATA_LIMITE_ALTERACAO)
                return redirect()->back()->withErrors(['Não é possível modificar dados de turmas de anos anteriores.']);    
        }

        if($turma->professor->id != Auth::user()->pessoa && !in_array('17', Auth::user()->recursos)){
            LogController::registrar('turma',$turma->id,'Acesso negado a frequencia da turma '.$turma->id.' para '. Auth::user()->nome, Auth::user()->pessoa);
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';
        }

        $aulas = Aula::where('turma',$turma->id)->orderBy('data')->get();
        foreach($aulas as $aula){
            $aula->presentes = $aula->getAlunosPresentes();    
        }
        if(isset($_GET['filtrar']))
        $inscritos=\App\Inscricao::where('turma',$turma->id)->get();
        else
        $inscritos=\App\Inscricao::where('turma',$turma->id)->whereIn('status',['regular','espera','ativa','pendente','finalizada'])->get();
        $inscritos= $inscritos->sortBy('pessoa.nome');

        

        //dd($aulas);
        return view('frequencias.lista-unitaria-editavel',compact('inscritos'))->with('i',1)->with('aulas',$aulas)->with('turma',$turma);
    }

    /**
     * Grava os dados da chamada completa
     *
     * @param Request $r
     * @return void
     */
    public function preencherChamada_exec(Request $r){
        $presentes = json_decode($r->presente, true);
        $conceitos = json_decode($r->conceitos, true);
        //dd(isset($presentes['7597']['29178']));
        //carregar todas presenças dessa turma
        $turma = Turma::find($r->turma);

        if($turma->professor->id != Auth::user()->pessoa && !in_array('17', Auth::user()->recursos)){
            LogController::registrar('turma',$turma->id,'Acesso negado a frequencia da turma '.$turma->id.' para '. Auth::user()->nome, Auth::user()->pessoa);
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';
        }
        //$id_aulas = Aula::where('turma',$turma->id)->pluck('id')->toArray();
        //$frequencias = Frequencia::whereIn('aula',$id_aulas)->get();
        $frequencias = Frequencia::select('*','frequencias.id as id')->join('aulas','frequencias.aula','aulas.id')->where('turma',$r->turma)->get();


        //verifica se aluno tem frequencia registrada mas ela nao esta na lista de presenca enviada (retirar presença)
        foreach($frequencias as $frequencia){
            if(!isset($presentes[$frequencia->aluno][$frequencia->aula]) || $presentes[$frequencia->aluno][$frequencia->aula] == false){
                //se tiver na lista atual de alunos, porque a pessoa pode estar na lista de cancelados
                if(in_array($frequencia->aluno,$r->alunos)){
                    //dd("Apagar frequencia do aluno".$frequencia->aluno.' na aula '.$frequencia->aula);
                    Frequencia::destroy($frequencia->id);
                    //dd('retirando item'.$presentes[$frequencia->aluno][$frequencia->aula]);
                }                 
            }
        }

        //verifica se ele recebeu alguma presença que não tinha (adicionar presença)      
        foreach($presentes as $aluno => $aulas){
            foreach($aulas as $aula => $presenca){    
                $freq = $frequencias->where('aluno',$aluno)->where('aula',$aula)->first();         
                if($presenca){
                    if(!isset($freq->id) ){
                        Frequencia::novaFrequencia($aula,$aluno);
                    }
                }
            }
        }
        

        //atribui conceitos se houver
        if(isset($conceitos)){
            foreach($conceitos as $key => $value){
                \App\Inscricao::addConceito($key,$value);
            }
        }
     
        //return redirect()->back()->with('success','Dados da turma '.$r->turma.' gravados com sucesso.');
        return response('Gravado!',200);

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
        $aulas = Aula::where('turma',$turma)->where('status','prevista')->orderBy('data')->get();         
        $turma = \App\Turma::find($turma);

        if((date('Y')-substr($turma->data_inicio,6,4))>=1){   
            if((date('Y')-substr($turma->data_inicio,6,4))!=1 || date('md') > self::DATA_LIMITE_ALTERACAO)
                return redirect()->back()->withErrors(['Não é possível modificar dados de turmas de anos anteriores.']);    
        }

        if($turma->professor->id != Auth::user()->pessoa && !in_array('17', Auth::user()->recursos)){
            LogController::registrar('turma',$turma->id,'Acesso negado a frequencia da turma '.$turma->id.' para '. Auth::user()->nome, Auth::user()->pessoa);
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';
        }

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
       
        if($req->aula>0)
            $aula = Aula::find($req->aula);
        else{
            $aula = new Aula;
            $aula->data = $req->data;
            $aula->turma = $req->turma;
            $aula->status = 'executada';
            $aula->save();
        }


        $turma = \App\Turma::find($aula->turma);
        
        if($turma->professor->id != Auth::user()->pessoa && !in_array('17', Auth::user()->recursos)){
            LogController::registrar('turma',$turma->id,'Acesso negado a frequencia da turma '.$turma->id.' para '. Auth::user()->nome, Auth::user()->pessoa);
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';
        }
            
    
        if(!is_null($req->conteudo)){
            $auladado = new AulaDadoController;
            $auladado->createDadoAula($aula->id,'conteudo',$req->conteudo);
            
        }
        if(!is_null($req->ocorrencia)){
            $auladado = new AulaDadoController;
            $auladado->createDadoAula($aula->id,'ocorrencia', $req->ocorrencia);
            
        }
        if(isset($req->aluno)){
            foreach($req->aluno as $aluno){  
               Frequencia::novaFrequencia($aula->id,$aluno);
            }
        }
        $aula->status = 'executada';
        $aula->save();
        
        return redirect()->back()->with(['success'=>'Chamada registrada.']);

    }


    public function editarChamada_view(int $aula){

        $aula = Aula::find($aula);
    
        if(!isset($aula->id)){
            return redirect()->back()->with(['warning'=>'Aula inexistente']);

        }    
        
        $turma = \App\Turma::find($aula->turma);

        $conteudo = AulaDado::where('aula',$aula->id)->where('dado','conteudo')->first();
        $ocorrencia = AulaDado::where('aula',$aula->id)->where('dado','ocorrencia')->first();


        if($turma->professor->id != Auth::user()->pessoa && !in_array('17', Auth::user()->recursos)){
            LogController::registrar('turma',$turma->id,'Acesso negado a frequencia da turma '.$turma->id.' para '. Auth::user()->nome, Auth::user()->pessoa);
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';
        }
            

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

        return view('frequencias.editar-chamada')
            ->with('turma',$turma)
            ->with('aula',$aula)
            ->with('anteriores',$aulas_anteriores)
            ->with('conteudo',$conteudo)
            ->with('ocorrencia',$ocorrencia)
            ->with('frequencias',$arr_frequencias);

    }
    public function editarChamada_exec(Request $req){   
        $aula = Aula::find($req->aula);
        $aula->data = $req->data;
        $aula->save();
        $frequencias = Frequencia::select('aluno')->where('aula', $aula->id)->get();
        $arr_frequencias = $frequencias->pluck('aluno')->toArray();
        $turma = \App\Turma::find($req->turma);

        if($turma->professor->id != Auth::user()->pessoa && !in_array('17', Auth::user()->recursos)){
            LogController::registrar('turma',$turma->id,'Acesso negado a frequencia da turma '.$turma->id.' para '. Auth::user()->nome, Auth::user()->pessoa);
            return 'Turma não corresponte ao professor logado. Ocorrência enviada ao setor de segurança.';
        }

        if(isset($_GET['filtrar']))
            $turma->getInscricoes('todas');
        else
            $turma->getInscricoes('regulares');

        foreach($turma->inscricoes as $inscricao){
            if(isset($req->aluno) && in_array($inscricao->pessoa->id, $req->aluno)){
                if(!in_array($inscricao->pessoa->id,$arr_frequencias))
                    Frequencia::novaFrequencia($req->aula,$inscricao->pessoa->id);
                
            }
            else{
                if(in_array($inscricao->pessoa->id,$arr_frequencias))
                    Frequencia::removeFrequencia($req->aula,$inscricao->pessoa->id);
            }

        }
    
        if(!is_null($req->conteudo)){
            $auladado = new AulaDadoController;
            $conteudo = $auladado->updateDadoAula($aula->id,'conteudo',$req->conteudo);
        }
        else{
            $dado = AulaDado::where('aula',$aula->id)->where('dado','conteudo')->first();
            if(isset($dado))
                $dado->delete();

        }
        if(!is_null($req->ocorrencia)){
            $auladado = new AulaDadoController;
            $conteudo = $auladado->updateDadoAula($aula->id,'ocorrencia',$req->ocorrencia);
        }
        else{
            $dado = AulaDado::where('aula',$aula->id)->where('dado','ocorrencia')->first();
            if(isset($dado))
                $dado->delete();

        }
      
        return redirect()->back()->with(['success'=>'Chamada da aula '.$aula->id.' atualizada.']);

    }

    public function controleDeFrequencia(){
        //$job = new JobClass();
       // $this->dispatch($job)
        return response(200);
    }


    



   
}
