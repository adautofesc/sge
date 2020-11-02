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
use Auth;
use Illuminate\Support\Facades\DB;
use LancamentoContoller;
use stdClass;



class painelController extends Controller
{


    public function index(){

            if(!Auth::check())
             return redirect('login');
        
        $hoje=new Data();
            $data=$hoje->getData();        
            $dados=['data'=>$data];
            
            $user = Auth::user();
            //dd($user->recursos);
            

        if(in_array('18',$user->recursos)){
            $pendencias = \App\PessoaDadosGerais::where('dado',20)->paginate(10);
            return view('home', compact('dados'))->with("pendencias",$pendencias);

        }
        return view('home', compact('dados'));
	
    }

    public function indexDev(){
        return view('desenvolvimento.home');
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
            
                       
            if($db_aulas->count()){
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
    public function docentes($semestre=0){

        $semestres = \App\classes\Data::semestres();
        $turmas = \App\Http\Controllers\TurmaController::listarTurmasDocente(Auth::user()->pessoa,$semestre);
                    
        
        return view('docentes.home')->with('turmas',$turmas)->with('semestres',$semestres)->with('semestre_selecionado',$semestre);




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
        $pessoa->relacoes_institucionais = \App\PessoaDadosAdministrativos::where('dado',16)->where('pessoa',$pessoa->id)->get();

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
    



    public function smsRecado(){
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment;filename="'. 'aviso-sms' .'.txt"'); /*-- $filename is  xsl filename ---*/
        header('Cache-Control: max-age=0');

        $linha='Cadastros com Celular'."\n";
        $erros="\n"."\n".'Cadastros SEM Celular'."\n";


        $turmas = \App\Turma::where('professor',20477)->whereIn('status',['iniciada','andamento'])->get();
        foreach($turmas as $turma){
            $inscricoes = \App\Inscricao::where('turma',$turma->id)->get();
            foreach ($inscricoes as $inscricao){
                $pessoa = Pessoa::find($inscricao->pessoa->id);
                if($pessoa->getCelular() != '-')
                    $linha.= $pessoa->getCelular().';'.$pessoa->nome_simples."\n";
                else{
                    $telefones = $pessoa->getTelefones();
                    $all='';
                    foreach($telefones as $telefone){
                        $all .= $telefone->valor.'  ';  
                    }
                    
                    $erros.= "\n".$pessoa->nome_simples.' : '.$all;
                }

            }
        }

        return $linha.$erros;

    }
    public function atualizarParcelas(){
        $arr_matriculas=array();
        $matriculas = Matricula::whereIn('status',['pendente','ativa'])->get();
        foreach($matriculas as $matricula){
            $matricula->parcelas = $matricula->getParcelas();
           
            $matricula->save();

   
        $arr_matriculas[]= 'Matricula '.$matricula->id.' com data de inscricao em '.$matricula->data.' possui '. $matricula->parcelas.' parcelas.';

        }
        return $arr_matriculas;
        
    }
    public function relatorioJson(){

        header('Contet-Type: text/csv');
        header('Content-Disposition: attachment; filename="alunos-cj.csv"');
        header("Pragma: no-cache");
        header("Expires: 0");
        $arquivo = fopen('php://output','wb');

        $pessoas = Array();
        $turmas  = Turma::whereYear('data_inicio',2019)->whereIn('local',[51,52,53])->get();
        foreach($turmas as $turma){
            $turma->getInscricoes(null);
            foreach($turma->inscricoes as $inscricao){
                $pessoa = Pessoa::find($inscricao->pessoa->id);
                $pessoa->idade = $pessoa->getIdade();
                unset($pessoa->id);
                unset($pessoa->genero);
                unset($pessoa->nascimento);
                unset($pessoa->por);
                unset($pessoa->created_at);
                unset($pessoa->updated_at);
                unset($pessoa->deleted_at);
                $pessoa->curso = $turma->curso->nome;
                if($pessoa->idade < 21)                    
                    fputcsv($arquivo,json_decode(json_encode($pessoa),true));
            }
        }
        fclose($arquivo);
        

        

             
    }
    
    public function testarClasse(){
        $VC = new ValorController;
        return $VC->cadastrarValores();
    }


    public function testarClassePost(Request $r){
        
        foreach($r->matricula as $id){
            $inst= new MatriculaController;
            $inst->cancelarMatricula($id);
        }
        return $r->matricula;


    }

    public function alertaCovid(){
        $CC = new ContatoController;
        //$msg = "FESC INFORMA: Aulas suspensas por tempo indeterminado. Saiba mais no site fesc.com.br";
        //$msg = "FESC INFORMA: Aulas suspensas A PARTIR DO DIA 17/03 por tempo indeterminado. Duvidas? Ligue 3372-1308";
        //$msg = "FESC INFORMA: Prezados alunos, os boletos do mês de maio, com vencimento em 10/05 serão cancelados.Fique seguro, fique em casa.";
        //$msg = "FESC INFORMA: Prezados alunos, os boletos do mês de julho, com vencimento em 10/07 serão cancelados.Fique seguro, fique em casa.";
        $msg = "FESC INFORMA: Prezados alunos, os boletos do mês de agosto, com vencimento em 10/08 serão cancelados.Fique seguro, fique em casa.";
        $matriculas=Matricula::where('status','ativa')->groupBy('pessoa')->get();
        foreach($matriculas as $matricula){
            $this->dispatch(new \App\Jobs\EnviarSMS($msg,$matricula->pessoa));
            //$CC->enviarSMS($msg,[$matricula->pessoa]);
        }
        return "Notificações enviadas";

    }


    //essa função atualiza os boletos com divida ativa
    public function importarStatusBoletos(){
        $boletos_alterados=collect();
        $input='./documentos/dividas_2018.xlsx';
        //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($input);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($input);
        for($i=2;$i<=162;$i++){
            $insc= (object)[];
            $insc->cpfAlu=$spreadsheet->getActiveSheet()->getCell('B'.$i)->getValue();
            $insc->boletoVenc=$spreadsheet->getActiveSheet()->getCell('C'.$i)->getFormattedValue();
            
            $insc->boletoVenc = \DateTime::createFromFormat('d/m/Y',$insc->boletoVenc);
            //dd($insc);
            $pessoa_db=\App\PessoaDadosGerais::where('valor', $insc->cpfAlu)->first();

            if(isset($pessoa_db->pessoa) && $pessoa_db->pessoa>0){
               
                $boleto = \App\Boleto::where('pessoa',$pessoa_db->pessoa)->where('vencimento','like',$insc->boletoVenc->format('Y-m-d').'%')->first();

                //$boletos_alterados[] = $boleto.$pessoa_db->pessoa.'.'.$insc->boletoVenc->format('Y-m-d');
                if(isset($boleto->id)){
                    $boletos_alterados[] = $boleto;
                    if($boleto->status != $spreadsheet->getActiveSheet()->getCell('F'.$i)->getValue()){
                        $boleto->status = strtolower($spreadsheet->getActiveSheet()->getCell('F'.$i)->getValue());
                        $boleto->save();
                        LogController::alteracaoBoleto($boleto->id,'Processamento em lote D.A. Navka em '.date('d/m/Y').': '.$spreadsheet->getActiveSheet()->getCell('F'.$i)->getValue());
                    }
                }
            }
            

        }
        return $boletos_alterados;

    }
 

    	
}
