<?php

namespace App\Http\Controllers;

use App\Bolsa;
use Illuminate\Http\Request;

class BolsaController extends Controller
{
    
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
            'curso' => 'required|integer',
            'desconto' =>'required'
        ]);

        $curso = \App\Curso::find($request->curso);

        if(!$curso)
            return redirect()->back()->withErrors(['Não foi possível encontrar o curso. BolsaController 88.']);

        $bolsa = new Bolsa;
        $bolsa->pessoa = $request->pessoa;
        $bolsa->curso = $request->curso;
        $bolsa->desconto = $request->desconto;
        $bolsa->programa = $curso->programa;
        $bolsa->status = 'analisando';
        $bolsa->save();

        $atendimento = AtendimentoController::novoAtendimento('Solicitação de Bolsa',$request->pessoa);

        return redirect()->back()->withErrors(['Bolsa registrada com sucesso.']);




    }
}
