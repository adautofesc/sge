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
            
    	}

        if(unserialize(Session('recursos_usuario'))->contains('recurso','18')){
            $pendencias = \App\PessoaDadosGerais::where('dado',20)->paginate(10);
            return view('home', compact('dados'))->with("pendencias",$pendencias);

        }
        return view('home', compact('dados'));
	
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


        $turmas = \App\Http\Controllers\TurmaController::listarTurmasDocente(session('usuario'));
                    
        
        return view('docentes.home')->with('turmas',$turmas);




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
    /**
     * Função para corrigir eventuais problemas que ocorreram de importação de pessoas para as turmas das parcerias.
     * verifica se tem matriculas, se não tiver cria e atribui o numero para inscrição
     * se tiver, verifica se a pessoa da matricula e inscrição é a mesma, senão cria uma nova ]
     * @return [type] [description]
     */
    

    public function corrigeInscricoes(){

     
       
        //$instance = new BoletoController;
        //$inst = new LancamentoController; /// esse cara vai fazer os lancamentos atrasados
        $inst= new TurmaController;

        
        $turmas=Turma::where('parceria','>','0')->get();
        foreach($turmas as $turma){
            $inscricoes = \App\Inscricao::where('turma',$turma->id)->get();
            foreach($inscricoes as $inscricao){
                if($inscricao->matricula != null){
                    $matricula = \App\Matricula::find($inscricao->matricula);
                    if($matricula->pessoa != $inscricao->pessoa->id){
                        //dd($inscricao->turma->id);
                        $matricula_nova = MatriculaController::gerarMatricula($inscricao->pessoa->id,$inscricao->turma->id,'ativa');
                        $inscricao->matricula = $matricula_nova->id;
                        $inscricao->save();

                    }
                        
                }
                else{
                    $matricula_nova = MatriculaController::gerarMatricula($inscricao->pessoa->id,$inscricao->turma->id,'ativa');
                    $inscricao->matricula = $matricula_nova->id;
                    $inscricao->save();
                }
            }
        }
        return "inscrições normalizadas.";
   

        //return $inst->addPessoaLancamentos();
        

        
       /*$dados = \App\PessoaDadosContato::where('dado',10)->get();
        foreach($dados as $dado){
            $dado->valor = preg_replace( '/[^0-9]/is', '', $dado->valor);
            $dado->save();
        }*/

       
       
        
        
    }
    




    /**
     * 
     * @return [type] [description]
     */
    public function gerarLoginEducadores(){
        $professores = \App\PessoaDadosAdministrativos::getFuncionarios('Educador');
        foreach($professores as $professor){
            $cpf =  \App\PessoaDadosGerais::where('dado',3)->where('pessoa',$professor->id)->first();
            if($cpf)
                $professor->cpf = $cpf->valor;
            else
                $professor->cpf = '123456';
            $cpf='';

            $login_db = \App\PessoaDadosAcesso::where('pessoa',$professor->id)->get();
            //dd($professor);
             if(count($login_db)==0){
                $login = new PessoaDadosAcesso();
                $login->pessoa = $professor->id;
                $login->usuario = strtolower(str_replace(' ', '.', $professor->nome_simples));
                $login->senha = \Illuminate\Support\Facades\Hash::make($professor->cpf);
                $login->validade = '2018-12-31';
                $login->status = 1;
                $login->save();
                $acesso = new \App\ControleAcessoRecurso();
                $acesso->timestamps = false;
                $acesso->pessoa = $professor->id;
                $acesso->recurso = 13;
                $acesso->save();

                $professor->login = $login;


            }


        }
        return $professores;
    }
    public function testarClasse(){

        return ' Nenhum procedimento =)';

    }
    public function testarClassePost(Request $r){
        
        foreach($r->matricula as $id){
            $inst= new MatriculaController;
            $inst->cancelarMatricula($id);
        }
        return $r->matricula;


    }
    /*
    public function apiChamada($id){
    $inscritos=\App\Inscricao::where('turma',$id)->where('status','<>','cancelada')->get();
    $inscritos= $inscritos->sortBy('pessoa.nome');
    return $inscritos;
    }
    */
   
   /**
    * Lista em Brnco
    * @param  [type] $id [description]
    * @return [type]     [description]
    */
    public function chamada($id){
        $inscritos=\App\Inscricao::where('turma',$id)->where('status','<>','cancelada')->get();
        $inscritos= $inscritos->sortBy('pessoa.nome');
        if(count($inscritos))
            return view('pedagogico.frequencia.index',compact('inscritos'))->with('i',1);
        else
            return "Nenhum aluno cadastrado para esta turma.";
    }



    	
}
