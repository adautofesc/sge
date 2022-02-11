<?php

namespace App\Http\Controllers;

use App\Bolsa;
use App\BolsaMatricula;
use App\Matricula;
use Illuminate\Http\Request;


class BolsaController extends Controller
{   
    const max_matriculas = 2;
    public function listar(Request $r){

        if($r->codigo){
            $bolsas = Bolsa::where('id',$r->codigo)->paginate(10);
            foreach($bolsas as $bolsa){
                $bolsa->matriculas = $bolsa->getMatriculas();
                $bolsa->desconto_str = \App\Desconto::find($bolsa->desconto->id);
            }
        }
        else{
            $bolsas = Bolsa::orderByDesc('created_at')->paginate(10);
            foreach($bolsas as $bolsa){
                $bolsa->matriculas = $bolsa->getMatriculas();
                $bolsa->desconto_str = \App\Desconto::find($bolsa->desconto->id);
            }
        }

        return view('bolsas.index',compact('bolsas'));
    }
    
    public function alterarStatus($status,$itens){
        $bolsas=explode(',',$itens);
        foreach($bolsas as $bolsa){
            if(is_numeric($bolsa)){
                $bolsa = Bolsa::find($bolsa);
                if($bolsa){
                    // Aqui virá uma verificação que se há matrículas antes de excluir
                    switch($status){
                        case 'aprovar':
                            $bolsa->status = 'ativa';
                            $bolsa->save();
                            $this->alterarStatusMatricula($bolsa,'ativa');
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' aprovada.',$bolsa->pessoa);
                            break;
                        case 'negar':
                            $bolsa->status = 'indeferida';
                            $bolsa->save();
                            $this->alterarStatusMatricula($bolsa,'cancelada');
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' indeferida.',$bolsa->pessoa);
                            break;
                        case 'analisando':
                            $bolsa->status = 'analisando';
                            $bolsa->save();
                            $this->alterarStatusMatricula($bolsa,'espera');
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' em análise.',$bolsa->pessoa);
                            break;
                        case 'cancelar':
                            $bolsa->status = 'cancelada';
                            $bolsa->save();
                            $this->alterarStatusMatricula($bolsa,'ativa');
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' cancelada.',$bolsa->pessoa);
                            break;
                        case 'apagar':
                            $atendimento = AtendimentoController::novoAtendimento('Solicitação de bolsa '.$bolsa->id.' excluída.',$bolsa->pessoa);
                            $matriculas = $bolsa->getMatriculas();
                            $this->alterarStatusMatricula($bolsa,'ativa');
                            foreach($matriculas as $matricula){
                                $matricula->delete();
                            }

                            $bolsa->delete();
                            return redirect('/')->withErrors(['Bolsa excluída com sucesso.']);

                            break;
                        case 'reativar':
                            $bolsa->status = 'analisando';
                            $bolsa->save();
                            $this->alterarStatusMatricula($bolsa,'pendente');
                            $atendimento = AtendimentoController::novoAtendimento('Solicitação de bolsa '.$bolsa->id.' reativada.',$bolsa->pessoa);
                           
                            break;
                        
                    }
                }
            }
        }
        return redirect()->back()->withErrors(['Bolsa(s) processadas.']);


    }


    public function alterarStatusMatricula($bolsa,$status){
        $matriculas = $bolsa->getMatriculas(); 
        foreach($matriculas as $mat){
            MatriculaController::alterarStatus($mat->id,$status);
        }
    }


    /*
    Função que verificaa bolsa no financeiro.
     */
    public static function verificaBolsa($pessoa,$matricula){
        //********************************************* aqui colocar a validade dos descontos
        $bmatricula = BolsaMatricula::where('matricula',$matricula)->orderByDESC('id')->first();
        //dd($bmatricula);        
        if($bmatricula){
            //$bolsa = Bolsa::where('id',$bmatricula->bolsa)->where('status','ativa')->where('validade','>',date('Y-m-d'))->first();
            $bolsa = Bolsa::where('id',$bmatricula->bolsa)->where('status','ativa')->first();
           
            if($bolsa->id)              
                return $bolsa;
            else
                return null;

        }
        else
            return null;
     
       

    }

    /**
     * Formulário de nova Bolsa com listagem das atuais
     * @param  [Int] $pessoa [Id da pessoa]
     * @return [type]         [description]
     */
    public function nova($pessoa){
        $pessoa = \App\Pessoa::find($pessoa);
        $matriculas = \App\Matricula::where('pessoa',$pessoa->id)->whereIn('status',['ativa','pendente','espera'])->get();
        $descontos = \App\Desconto::orderBy('nome')->get();
        $bolsas = Bolsa::where('pessoa',$pessoa->id)->get();
        foreach($bolsas as $bolsa){
            $bolsa->matriculas = $bolsa->getMatriculas();
            $bolsa->desconto_str = \App\Desconto::find($bolsa->desconto->id);

        }



        return view('pessoa.bolsa.cadastrar',compact('pessoa'))->with('matriculas',$matriculas)->with('bolsas',$bolsas)->with('descontos',$descontos);
    }

    /**
     * Gravação da Bolsa
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function gravar(Request $request){

        //Falta colocar a verificação de qnde de vagas para bolsisas antes de gerar a Bolsa
        //Recomenda-se que a pessoa que for conceder a bolsa, verifique a quantidade de pessoas bolsistas na turma atua

        $this->validate($request,[
            'pessoa' => 'required|integer',
            'desconto' =>'required',
            'matricula'=>'required'

        ]);

        if(date('m')>=11){
            $bolsa = Bolsa::where('pessoa',$request->pessoa)
                ->whereIn('status',['ativa','analisando'])
                ->where('desconto',$request->desconto)
                ->WhereYear('validade',date('Y', strtotime("+12 months",strtotime(date('Y')))))
                ->first();
        }      
        else{
            $bolsa = Bolsa::where('pessoa',$request->pessoa)
                ->whereIn('status',['ativa','analisando'])
                ->where('desconto',$request->desconto)
                ->WhereYear('validade',date('Y'))
                ->first();
        }    

        if(isset($bolsa->id)){
            $matriculas = \App\BolsaMatricula::where('bolsa',$bolsa->id)->whereIn('matricula',[$request->matricula[0]])->get();
            
            if($matriculas->count()>0)
                    return redirect()->back()->withErrors(['Já existe uma solicitação de bolsa para esta matícula.']);

            $bolsa_matricula = new BolsaMatricula();
            $bolsa_matricula->bolsa = $bolsa->id;
            $bolsa_matricula->pessoa = $bolsa->pessoa;
            $bolsa_matricula->matricula = $request->matricula[0];
            $bolsa_matricula->programa = \App\Matricula::find($bolsa_matricula->matricula)->getPrograma()->id;
            $bolsa_matricula->save();

            return redirect()->back()->withErrors(['Matrícula inserida na bolsa com sucesso.']);  
        }
        else{
            if(date('m')>=11)
                $validade = date('Y-12-31 23:23:59', strtotime("+12 months",strtotime(date('Y-m-d')))); 
            else
                $validade = date('Y-12-31 23:23:59'); 
            
        
            if($this->vericaSeSolicitado($request->pessoa,$request->matricula))
                return redirect()->back()->withErrors(['Bolsa já solicitada.']);

            $bolsa = new Bolsa;
            $bolsa->pessoa = $request->pessoa;
            $bolsa->desconto = $request->desconto;
            $bolsa->rematricula = $request->rematricula;
            $bolsa->validade = $validade;

            //ativa atutomaticamente os encaminhamentos do caps e saúde
            if($request->desconto == 7 || $request->desconto == 8)
                $bolsa->status = 'ativa';
            else 
                $bolsa->status = 'analisando';

            $bolsa->save();

            foreach($request->matricula as $matricula){

                $bolsa_matricula = new BolsaMatricula();
                $bolsa_matricula->bolsa = $bolsa->id;
                $bolsa_matricula->pessoa = $bolsa->pessoa;
                $bolsa_matricula->matricula = $matricula;

                $obj_matricula = \App\Matricula::find($matricula);
                $programa_matricula = $obj_matricula ->getPrograma();
                $bolsa_matricula->programa = $programa_matricula->id;
                $bolsa_matricula->save();

                if($bolsa->status == 'analisando'){
                    $matricula_obj = \App\Matricula::find($matricula);
                    $matricula_obj->status = 'pendente';
                    $matricula_obj->save();
                }
            }
            
        }

        $atendimento = AtendimentoController::novoAtendimento('Solicitação de Bolsa',$request->pessoa);

        return redirect()->back()->withErrors(['Bolsa registrada com sucesso. Aguarde análise da Comissão de Avaliação']);

    }
    public function vericaSeSolicitado($pessoa,$matricula){
        
        $bmatricula = BolsaMatricula::where('matricula',$matricula)->orderByDesc('id')->first();
        if(isset($bmatricula->id)){
            $bolsa = Bolsa::find($bmatricula->bolsa);
            
            if(isset($bolsa->id)){
                if($bolsa->status == 'ativa' || $bolsa->status == 'analisando')
                    return true;
                else
                    return false;
            }
            else{    
                return false;
            }
        }
        else
            return false;
        
    }



    public function imprimir($bolsa){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $bolsa = Bolsa::find($bolsa);

        if(is_null($bolsa))
            return redirect()->back()->withErrors("Erro ao localizar bolsa");

        $pessoa = \App\Pessoa::find($bolsa->pessoa);

        $pessoa = PessoaController::formataParaMostrar($pessoa);
        $pessoa->cpf = \App\classes\Strings::mask($pessoa->cpf,'###.###.###-##');
        $pessoa->rg = \App\classes\Strings::mask($pessoa->rg,'##.###.###-##');

        $matriculas = \App\BolsaMatricula::where('bolsa',$bolsa->id)->get();

        $bolsa->matriculas = $matriculas;
        $bolsa->desconto_str = \App\Desconto::find($bolsa->desconto->id);
        $hoje = strftime('%d de %B de %Y', strtotime($bolsa->created_at));



        return view('bolsas.requerimento',compact('bolsa'))->with('pessoa',$pessoa)->with('hoje',$hoje);

    }

    public function analisar($bolsas){
        $bolsa_array = explode(",", $bolsas);
        if(count($bolsa_array)==1){
            $bolsa = Bolsa::find($bolsa_array[0]);
            if(!$bolsa){
                return redirect()->back()->withErrors(["Bolsa ".$bolsa. " não encontrada em nosso sistema."]);
            }


        }else 
            $bolsa=null;

        return view('bolsas.analisar')->with('bolsa',$bolsa)->with('bolsas',$bolsas);
        

    }



    public function gravarAnalise(Request $r){
         $this->validate($r,[
            'parecer' => 'required',
        ]);


        $bolsa_array = explode(",", $r->bolsas);
        foreach($bolsa_array as $bolsa_i){
            $bolsa = Bolsa::find($bolsa_i);
            if($bolsa){
                $bolsa->status = $r->parecer;
                $bolsa->obs = $r->obs."\n".date('d/m/Y').' parecer: '.$r->parecer.' por '.session('nome_usuario');
                $bolsa->save();
            }
        }


        return redirect('/bolsas/liberacao')->withErrors(['Bolsa(s) alteradas com sucesso.']);
    }


    public function uploadForm($bolsa){
        return view('pessoa.bolsa.upload')->with('bolsa',$bolsa);
    }



    public function uploadExec(Request $r){
        $arquivo = $r->file('arquivo');
            
                if (!empty($arquivo)) {
                    $arquivo->move('documentos/bolsas/requerimentos',$r->matricula.'.pdf');
                }

            return redirect(asset('secretaria/atender'));
    }



    public function uploadParecerForm($bolsa){
        return view('pessoa.bolsa.upload-parecer')->with('bolsa',$bolsa);
    }



    public function uploadParecerExec(Request $r){
        $arquivo = $r->file('arquivo');
            
                if (!empty($arquivo)) {
                    $arquivo->move('documentos/bolsas/pareceres',$r->matricula.'.pdf');
                }

            return redirect(asset('secretaria/atender'));
    }

   

    public function ajusteBolsaSemMatriculaxs(){
        $bolsas = Bolsa::where('matricula',null)->get();
        foreach ($bolsas as $bolsa){
            $matricula = \App\Matricula::where('curso',$bolsa->curso)->where('pessoa',$bolsa->pessoa)->first();
            if($matricula){
                $bolsa->matricula = $matricula->id;
                $bolsa->save();
            }
            
       
        }
        return $bolsas;
    }



    public function novaBolsa(){
        $bolsas = Bolsa::all();
        foreach($bolsas as $bolsa){
            $bolsa_m = new BolsaMatricula();
            $bolsa_m->pessoa = $bolsa->pessoa;
            $bolsa_m->bolsa = $bolsa->id;
            $bolsa_m->matricula = $bolsa->matricula;
            $bolsa->save();
        }
    }



    public function ajusteBolsaSemMatricula(){
        $bolsas = Bolsa::whereIn('status',['ativa','analisando'])->get();
        foreach ($bolsas as $bolsa){
            if (isset($bolsa->matricula)){
                $matricula = \App\Matricula::find($bolsa->matricula);
                if($matricula){
                
                    if($matricula->status!='espera'){
                        $bolsa->status = 'expirada';
                        $bolsa->save();
                    }
                    else{
                        $matriculas = \App\Matricula::where('pessoa',$bolsa->pessoa)->where('status','espera')->get();
                        foreach($matriculas as $mt){
                            $bolsa_m = new BolsaMatricula();
                            $bolsa_m->pessoa = $bolsa->pessoa;
                            $bolsa_m->bolsa = $bolsa->id;
                            $bolsa_m->matricula = $mt->id;
                            $programa = $mt->getPrograma();
                            $bolsa_m->programa = $programa->id;
                            $bolsa_m->save();

                        }
                    }

                   

                   
                }
            }

        }
        return "Bolsas processadas";
    }
    public function unLinkMe($matricula,$bolsa){
        $bolsa_matricula = BolsaMatricula::where('matricula',$matricula)->where('bolsa',$bolsa)->first();
        if($bolsa_matricula == null)
            return false;
        $bolsa_matricula->delete();
        $bolsa = Bolsa::find($bolsa);
        $bolsa->obs = $bolsa->obs."\n".date('d/m/Y').' matricula desvinculada: '.$matricula.' por '.session('nome_usuario');
        if(count($bolsa->getMatriculas())==0){
            $bolsa->status = 'expirada';
            $bolsa->obs = $bolsa->obs."\n".date('d/m/Y').' Bolsa expirada por extinção de matrículas';

        }
        $bolsa->save();

        return true;

    }
    public function desvincular($matricula,$bolsa){
        if($this->unLinkMe($matricula,$bolsa)){
            return redirect()->back()->withErrors(["Matricula ".$matricula." foi desvinculado com sucesso da bolsa ".$bolsa]);
        }
        else{
            return redirect()->back()->withErrors(["Erro ao desvincular matrícula."]);
        }

    }

    /**
     * Retorna array com ids de alunos que possivelmente perderiam a bolsa;
     */
    public function fiscalizarBolsa(){
        $alunos = array();
        $matriculas = collect();
        $array_bolsas = Bolsa::where('status','ativa')
                    ->whereIn('desconto',[1,2,6,7,8])
                    ->leftjoin('bolsa_matriculas', 'bolsas.id', '=', 'bolsa_matriculas.bolsa')
                    ->get();
        foreach($array_bolsas as $array_bolsa){
            $matricula = Matricula::find($array_bolsa->matricula);
            $matricula->getInscricoes();
            foreach($matricula->inscricoes as $inscricao){


                $aulas = $inscricao->turma->getAulas();
                $aulasexec = $aulas->where('status','executada');
                $falta=0;
                //dd($aulasexec);

                foreach($aulasexec as $aula){
                    $frequencia = \App\Frequencia::where('aula',$aula->id)->where('aluno',$inscricao->pessoa->id);
                    if(isset($frequencia->id))
                        $falta=0;
                    else{
                        $falta++;
                        if($falta>=3){
                            $alunos[$inscricao->pessoa->id] = 'turma '.$inscricao->turma->id.' aluno';
                            break;
                        }

                    }

                }

            }
            //$matriculas->push($matricula);
        }
      

        return $alunos;


    }



}
