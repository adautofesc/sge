<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\Data;
use App\Pessoa;
use App\Local;
use App\Turma;
use App\Matricula;
use App\PessoaDadosAcesso;
use App\Http\Controllers\PessoaController;
use Session;
use Illuminate\Support\Facades\DB;
use LancamentoContoller;

class painelController extends Controller
{
    public function index(){

    	if(!Session::has('sge_fesc_logged'))
    		return loginController::login();
    	
    	else{
    		$hoje=new Data();
            $data=$hoje->getData();        
            $dados=['data'=>$data];
            
            return view('home', compact('dados'));
    	}
	
    }
    public function verTurmasAnterioresCursos(){
        
        $db_turmas=DB::table('tb_turmas')->join('tb_cursos', 'tb_turmas.CurCod','=','tb_cursos.CurCod')->where('tb_turmas.TurDatIni','>','2017-06-01')->where('tb_cursos.CurCod','!=','1416')->whereIn('tb_turmas.LocCod', [1,2,69])->get(['tb_turmas.TurCod','tb_turmas.TurDatIni','tb_cursos.CurDsc','tb_turmas.TurDsc','tb_turmas.LocCod','tb_turmas.ProCod']);

        //return $db_turmas;
        $turmas_novas=Turma::where('curso','!=','307')->orderBy('programa','dias_semana','hora_inicio')->get();
        return view('admin.migrarturmas',compact('db_turmas'))->with('nova',$turmas_novas);
       
    }
    public function gravarMigracao(Request $r){
        foreach($r->turma as $navka=>$sge){
            if($sge>0){
                $turma[$navka]=array();
                $alunos_navka=DB::table('tb_matriculas')->where('TurCod',$navka)->get(['AluCod']);
                foreach($alunos_navka as $aluno){
                    $matricula= new Matricula;
                    $matricula->pessoa = $aluno->AluCod;
                    $matricula->atendimento=51;
                    $matricula->status="pendente";
                    $matricula->dia_venc=7;
                    $matricula->forma_pgto="boleto";
                    $matricula->parcelas=5;
                    $matricula->turma=$sge;
                    $matricula->save();

                    array_push($turma[$navka], $matricula);
                }
            }
        }

 

        return $turma;
   
    }
    public function verTurmasAnterioresAulas(){
        // listar as turmas
        $db_aulas=DB::select("select distinct(AulCod) from tb_matriculas m join tb_matriculas_aulas a on a.MatCod = m.MatCod where MatDat > '2017-06-01' order by AulCod");
  
        foreach($db_aulas as $aula){

            //para cada turma, verificar as matriculas daquela turma no periodo fornecido
            $db_turma=DB::select("select AluCod from tb_matriculas m join tb_matriculas_aulas a on a.MatCod = m.MatCod where MatDat > '2017-06-01' and AulCod = ".$aula->AulCod);
            
                       
            if(count($db_aulas)){
                foreach($db_turma as $turma){
                    $alunos[$aula->AulCod][] = $turma->AluCod;                    

                }
            }
        }

        return count($alunos);
    }


    public function administrativo(){
        return view('admin.home');
    }
    public function docentes(){
        return view('docentes.home');
    }
    public function financeiro(){
        return view('financeiro.home');
    }
    public function gestaoPessoal(){

        return view('gestaopessoal.inicio-atendimento');
    }
    public function atendimentoPessoal(){
        if(session('rh_atendimento')){            
            $pessoa=session('rh_atendimento');
            return view('gestaopessoal.home')->with('pessoa',$pessoa);
        }

        return view('gestaopessoal.home');
    }
    public function importarLocais(){
        $db_locais=DB::select('select * from tb_localizacoes order by LocDsc');

        foreach($db_locais as $db_local){
            $local=new Local();
            $local->nome=$db_local->LocDsc;
            $local->sigla=$db_local->LocSig;
            $local->save();
        }
        return "Locais importados com sucesso.";
    }       
    
    public function atendimentoPessoalPara($id=0){
        if($id>0){
            session('rh_atendimento',$id);
        }
        else{
            $id=session('rh_atendimento');
        }
        
        $pessoa=Pessoa::find($id);
        // Verifica se a pessoa existe
        if(!$pessoa)
            return redirect(asset('/gestaopessoal/inicio-atendimento'));
        else
            Session::put('rh_atendimento',$id);
        

        $pessoa=Pessoa::find($id);
        // Verifica se a pessoa existe
        if(!$pessoa)
            return view('gestaopessoal.inicio-atendimento');

        $pessoa_controller= new PessoaController;
        $pessoa=$pessoa_controller->formataParaMostrar($pessoa);
        $pessoa_acesso=PessoaDadosAcesso::where('pessoa',$pessoa->id)->first();
        if(!$pessoa_acesso)
            $pessoa_acesso=0;
        $pessoa->acesso=$pessoa_acesso;

        return view('gestaopessoal.atendimento', compact('pessoa'));
    }



    public function juridico(){
        return view('juridico.home');
    }
    public function pedagogico(){
        return view('pedagogico.home');
    }
    public function secretaria(){
        if(session('pessoa_atendimento')){            
            $pessoa=session('pessoa_atendimento');
            return view('secretaria.home')->with('pessoa',$pessoa);
        }

        return view('secretaria.home');
    }
    public function salasDaUnidade($unidade){
        $salas=Local::where('unidade', 'like', '%'.$unidade.'%')->get();
        return $salas;

    }
    public function testarClasse(){
        /*
        $recurso_desejado = 99;

        foreach(unserialize(Session('recursos_usuario')) as $controle){
            if($controle->recurso == $recurso_desejado)
                return "true";
        }
        return redirect()->route('403');
    */
        $instance = new BoletoController;
        $instance->corrigirBoletos();
        //return $instance->cancelarGravados();
        //return fopen('retornos/IEDCBR921502201814938.ret',"r");
        //return $inst->cadastrar();
        //$inst->atualizaTodasMatriculas();
        //
        //
        //
        //
        //
        //
        //$inst = new LancamentoController; /// esse cara vai fazer os lancamentos atrasados
        //$inst->gerarLancamentosAtrasados();
        //return date('Y-m-20 23:59:59');

        //return $inst->gerarRemessa();*/
        //$inst= new MatriculaController;
        //return MatriculaController::regularizarCancelamentos();
        
        //return $inst->verificaSeMatriculado(23234,307);
        //return $inst->modMatriculas();
        //return $inst->verificaSeMatriculado(13977,307);
        //return $inst->arrumarMultiplasUati();
          //return LancamentoController::atualizaMatricula('2051');
        //
        //return LancamentoController::relancarPorBoleto('2199');
        //return $inst->atualizarLMC();
        //return $inst->cancelamentoMatricula(2004);
    }
    public function testarClassePost(Request $r){
        
        foreach($r->matricula as $id){
            $inst= new MatriculaController;
            $inst->cancelarMatricula($id);
        }
        return $r->matricula;


    }
    public function apiChamada($id){
    $inscritos=\App\Inscricao::where('turma',$id)->where('status','<>','cancelado')->get();
    $inscritos= $inscritos->sortBy('pessoa.nome');
    return $inscritos;
    }
    public function chamada($id){
        $inscritos=\App\Inscricao::where('turma',$id)->where('status','<>','cancelado')->get();
        $inscritos= $inscritos->sortBy('pessoa.nome');
        return view('pedagogico.frequencia.index',compact('inscritos'))->with('i',1);
    }



    	
}
