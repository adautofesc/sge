<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\Data;
use App\Pessoa;
use App\Local;
use App\PessoaDadosAcesso;
use App\Http\Controllers\PessoaController;
use Session;
use Illuminate\Support\Facades\DB;

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
        
        $db_turmas=DB::table('tb_turmas')->join('tb_cursos', 'tb_turmas.CurCod','=','tb_cursos.CurCod')->where('tb_turmas.TurDatIni','>','2017-06-01')->get(['tb_turmas.TurCod','tb_turmas.TurDatIni','tb_cursos.CurDsc','tb_turmas.TurDsc']);

        return $db_turmas;
       
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

        return $alunos;
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


    	
}
