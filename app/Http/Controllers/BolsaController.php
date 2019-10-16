<?php

namespace App\Http\Controllers;

use App\Bolsa;
use App\BolsaMatricula;
use Illuminate\Http\Request;


class BolsaController extends Controller
{   
    const max_matriculas = 2;
    public function listar(Request $r = Request){
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

        return view('juridico.bolsas.index',compact('bolsas'));
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
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' aprovada.',$bolsa->pessoa);
                            break;
                        case 'negar':
                            $bolsa->status = 'indeferida';
                            $bolsa->save();
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' indeferida.',$bolsa->pessoa);
                            break;
                        case 'analisando':
                            $bolsa->status = 'analisando';
                            $bolsa->save();
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' em análise.',$bolsa->pessoa);
                            break;
                        case 'cancelar':
                            $bolsa->status = 'cancelada';
                            $bolsa->save();
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' cancelada.',$bolsa->pessoa);
                            break;
                        case 'apagar':
                            $atendimento = AtendimentoController::novoAtendimento('Solicitação de bolsa '.$bolsa->id.' excluída.',$bolsa->pessoa);
                            $matriculas = $bolsa->getMatriculas();
                            foreach($matriculas as $matricula){
                                $matricula->delete();
                            }

                            $bolsa->delete();
                            return redirect('/')->withErrors(['Bolsa excluída com sucesso.']);

                            break;
                        case 'reativar':
                            $bolsa->status = 'analisando';
                            $bolsa->save();
                            $atendimento = AtendimentoController::novoAtendimento('Solicitação de bolsa '.$bolsa->id.' reativada.',$bolsa->pessoa);
                           
                            break;
                        
                    }
                }
            }
        }
        return redirect()->back()->withErrors(['Bolsa(s) processadas.']);


    }


    /*
    Função que verificaa bolsa no financeiro.
     */
    public static function verificaBolsa($pessoa,$matricula){


        //********************************************* aqui colocar a validade dos descontos
        

        $bmatricula = BolsaMatricula::where('matricula',$matricula)->first();
        //dd($bmatricula);
        if($bmatricula){
            $bolsa = Bolsa::where('id',$bmatricula->bolsa)->where('status','ativa')->where('validade','>',date('Y-m-d'))->first();
        }
        else
            return null;
        
        /*
        $bolsa = Bolsa::where('pessoa',$pessoa)->where(function($query) use ($matricula) {
            $query->where('matricula',$matricula)
            ->orWhere('matricula2',$matricula);
        })->where('status','ativa')->first();
        //*/
     
        if($bolsa)
            return $bolsa;
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

        //$matricula = \App\Matricula::find($request->matricula);
        //$curso = \App\Curso::find($matricula->curso);

        //verifica se qnde de matriculas escolhidas ultrapassa o limite (max)
        //if(count($request->matricula) > self::max_matriculas)
            //return redirect()->back()->withErrors(['Mais de duas matrículas selecionadas.']);


        //procura bolsas ativas dessa pessoa
        $bolsa = Bolsa::where('pessoa',$request->pessoa)->whereIn('status',['ativa','analisando'])->where('desconto',$request->desconto)->first();

        //se houver bolsa
        if($bolsa){

            //pega as matriculas da bolsa
            $matriculas = \App\BolsaMatricula::where('bolsa',$bolsa->id)->get();
            //dd($matriculas);
           

           

            //se já tiver duas matriculas na bolsa retorna erro
            /*
            if(count($matriculas)>= self::max_matriculas )
                return redirect()->back()->withErrors(['Erro: Já consta uma solicitação de bolsa aberta com o máximo de matrículas permitida.']);
            */
            //else{


                 

                // instancia primeira matricula fornecida
                $matricula =  \App\Matricula::find($request->matricula[0]);

                // a matricula in
                if(count($matriculas)>0)
                    if($matriculas->first()->matricula == $matricula->id)
                        return redirect()->back()->withErrors(['Já existe uma solicitação de bolsa para esta matícula.']);

                $bolsa_matricula = new BolsaMatricula();
                $bolsa_matricula->bolsa = $bolsa->id;
                $bolsa_matricula->pessoa = $bolsa->pessoa;
                $bolsa_matricula->matricula = $matricula->id;
                $bolsa_matricula->programa = \App\Matricula::find($bolsa_matricula->matricula)->getPrograma()->id;
                $bolsa_matricula->save();
                return redirect()->back()->withErrors(['Matrícula inserida na bolsa com sucesso.']);


            //}
        }
        else{
            if(date('m')>11)
                $validade = date('Y-12-31 23:23:59', strtotime("+12 months",strtotime(date('Y-m-d')))); 
            else
                $validade = date('Y-12-31 23:23:59'); 
            //gerar bolsa
        }


        if($this->vericaSeSolicitado($request->pessoa,$request->matricula))
            return redirect()->back()->withErrors(['Bolsa já solicitada.']);

        /****************************** Varifica se a bolsa é EMG para impedir cadastro em turmas não emg
        if($request->desconto ==10){
            foreach($request->matricula as $matricula){
                $obj_matricula = \App\Matricula::find($matricula);
                $programa_matricula = $obj_matricula ->getPrograma();
                if($programa_matricula->id != 4)
                    return redirect()->back()->withErrors(['Turma não destinada para desconto EMG.']);

            }
            
        }
        */


        $bolsa = new Bolsa;
        $bolsa->pessoa = $request->pessoa;
        $bolsa->desconto = $request->desconto;
        $bolsa->rematricula = $request->rematricula;
        $bolsa->validade = date('Y-12-31');
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

        //dd($bolsa);
        

        

        
        

        $atendimento = AtendimentoController::novoAtendimento('Solicitação de Bolsa',$request->pessoa);

        return redirect()->back()->withErrors(['Bolsa registrada com sucesso. Aguarde análise da Comissão de Avaliação']);

    }
    public function vericaSeSolicitado($pessoa,$matricula){
        $bolsa = Bolsa::where('pessoa',$pessoa)->where('matricula',$matricula)->whereIn('status',['ativa','analisando'])->get();

        //dd(is_array($bolsa));
        if(count($bolsa))
            return true;
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

        //dd($bolsa->desconto_str);


        $hoje = strftime('%d de %B de %Y', strtotime($bolsa->created_at));



        return view('juridico.bolsas.requerimento',compact('bolsa'))->with('pessoa',$pessoa)->with('hoje',$hoje);

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

        return view('juridico.bolsas.analisar')->with('bolsa',$bolsa)->with('bolsas',$bolsas);
        

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


        return redirect('/juridico/bolsas/liberacao')->withErrors(['Bolsa(s) alteradas com sucesso.']);
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
        //dd($bolsa->getMatriculas());
        $bolsa->obs = $bolsa->obs."\n".date('d/m/Y').' matricula desvinculada: '.$matricula.' por '.session('nome_usuario');
        if(count($bolsa->getMatriculas())==0){
            $bolsa->status = 'cancelada';
            $bolsa->obs = $bolsa->obs."\n".date('d/m/Y').' Bolsa cancelada por extinção de matrículas';

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



}
