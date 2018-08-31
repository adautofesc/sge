<?php

namespace App\Http\Controllers;

use App\Bolsa;
use Illuminate\Http\Request;

class BolsaController extends Controller
{   
    public function listar(Request $r = Request){
        if($r->codigo)
             $bolsas = Bolsa::where('id',$r->codigo)->paginate(10);
        else
            $bolsas = Bolsa::orderByDesc('created_at')->paginate(10);

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
                            $bolsa->status = 'indefirida';
                            $bolsa->save();
                            $atendimento = AtendimentoController::novoAtendimento('Bolsa '.$bolsa->id.' indefirida.',$bolsa->pessoa);
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
                            $bolsa->delete();
                            break;
                        
                    }
                }
            }
        }
        return redirect()->back()->withErrors(['Bolsa(s) processadas.']);


    }



    /**
     * Gerador de Bolsas, para migração do sistema de bolsas em matriculas para bolsas independentes
     * @return [type] [description]
     */
    public function gerador(){
        //pegar todas matriculas com bolsa
        $matriculas = \App\Matricula::select(['id','desconto','curso','pessoa'])->whereIn('status',['ativa','pendente'])->where('desconto','>',0)->get();

       

        //Contador
       $bolsas_criadas = 0;

        foreach($matriculas as $matricula){

            //verifica se já tem bolsa para essa pessoa nesse curso
            $bolsa = Bolsa::select(['id'])->where('pessoa',$matricula->pessoa)->where('curso',$matricula->curso)->get();
            $inscricao = \App\Inscricao::select(['id','turma'])->where('matricula',$matricula->id)->first();
            //dd($inscricao);



            //se não tiver, criar uma nova
            if(count($bolsa)==0)
            {

                $bolsa = new Bolsa;
                $bolsa->pessoa = $matricula->pessoa;
                $bolsa->curso = $matricula->curso;
                $bolsa->desconto = $matricula->desconto;
                $bolsa->curso = $inscricao->turma->curso->id;
                $bolsa->programa = $inscricao->turma->programa->id;
                $bolsa->validade = '2018-12-31';
                $bolsa->obs = 'Bolsa gerada a partir das matrículas do 1º semestre';
                $bolsa->status = 'ativa'; 
                $bolsa->save();
                $bolsas_criadas++;

            }
        }
        return "Foram geradas ".$bolsas_criadas. " bolsas a partir de matrículas do 1º semestre";
        
    }
    public static function verificaBolsa($pessoa,$curso){
        $bolsa = Bolsa::where('pessoa',$pessoa)->where('curso',$curso)->where('status','ativa')->first();
        //die('teste');
        //
        //dd($bolsa);
        if($bolsa)
            return $bolsa->desconto;
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
        $bolsas = Bolsa::where('pessoa',$pessoa->id)->get();
        return view('pessoa.bolsa.cadastrar',compact('pessoa'))->with('matriculas',$matriculas)->with('bolsas',$bolsas);
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
            'matricula' => 'required|integer',
            'desconto' =>'required'
        ]);

        $matricula = \App\Matricula::find($request->matricula);
        $curso = \App\Curso::find($matricula->curso);

        if(!$curso)
            return redirect()->back()->withErrors(['Não foi possível encontrar o curso. BolsaController 88.']);

        $bolsa = new Bolsa;
        $bolsa->pessoa = $request->pessoa;
        $bolsa->curso = $curso->id;
        $bolsa->desconto = $request->desconto;
        $bolsa->programa = $curso->programa->id;
        $bolsa->matricula = $request->matricula;
        $bolsa->status = 'analisando';

        //dd($bolsa);
        if(!$this->vericaSeSolicitado($request->pessoa,$request->matricula))
            $bolsa->save();
        else
            return redirect()->back()->withErrors(['Bolsa já solicitada.']);


        $atendimento = AtendimentoController::novoAtendimento('Solicitação de Bolsa',$request->pessoa);

        return redirect()->back()->withErrors(['Bolsa registrada com sucesso. Aguarde análise da Comissão de Avaliação']);

    }
    public function vericaSeSolicitado($pessoa,$matricula){
        $bolsa = Bolsa::where('pessoa',$pessoa)->where('matricula',$matricula)->get();

        //dd(is_array($bolsa));
        if(count($bolsa))
            return true;
        else
            return false;

    }
    public function imprimir($bolsa){

        return view('juridico.bolsas.requerimento');

    }
}
