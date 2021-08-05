<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use Exception;
use App\Pessoa;
use App\Endereco;
use App\PessoaDadosGerais;
use App\PessoaDadosContato;

class PerfilController extends Controller
{
    //

    public function painel(Request $r){
        //$r já contem pessoa do middleware

        $login = \App\PessoaDadosAcademicos::where('pessoa',$r->pessoa->id)->where('dado','email_fesc')->orderbyDesc('id')->first();
        if($login)
            $login = $login->valor;
            
        return view('perfil.painel')->with('pessoa',$r->pessoa)->with('login',$login);
    }

    public function cadastrarView($cpf = null){
        return view('perfil.cadastro')->with('cpf',$cpf);
    }

    public function cadastrarExec(Request $r){
        //dd($r->rg); 76813339087
        $r->validate([
            'nome'=>'required|min:10|max:255',
            'nascimento'=>'required|date',
            'genero'=> Rule::in(['M','F','Z']),
            'rg'=> 'required|max:12',
            'cpf'=>'required|max:11',
            'email'=>'required|email',
            'telefone'=>'required|size:11',
            'cep' => 'required|max:9',
            'rua' => 'required|max:120',
            'numero_endereco' => 'required|max:5',
            'bairro_str'=> 'required|max:50',
            'cidade'=> 'required|max:50',
            'estado'=> 'required|max:2',
            'senha'=> 'required|min:6|max:20',
            'contrasenha' => 'same:senha'
        ]);
        $pessoa = new Pessoa;
        $pessoa->nome = mb_convert_case($r->nome, MB_CASE_UPPER, 'UTF-8');
        $pessoa->genero = $r->genero;
        $pessoa->nascimento = $r->nascimento;
        $pessoa->por = 0;
        $pessoa->save();

        $pessoa->por = $pessoa->id;
        $pessoa->save();

        $rg = new PessoaDadosGerais;
        $rg->pessoa = $pessoa->id;
        $rg->dado = 4;
        $rg->valor = preg_replace( '/[^0-9]/is', '', $r->rg);
        $rg->save();

        $cpf = new PessoaDadosGerais;
        $cpf->pessoa = $pessoa->id;
        $cpf->dado = 3;
        $cpf->valor = preg_replace( '/[^0-9]/is', '', $r->cpf);;
        $cpf->save();

        $senha = new PessoaDadosGerais;
        $senha->pessoa = $pessoa->id;
        $senha->dado = 26;
        $senha->valor = Hash::make($r->senha);
        $senha->save();

        $celular = new PessoaDadosContato;
        $celular->pessoa = $pessoa->id;
        $celular->dado = 9;
        $celular->valor = $r->telefone;
        $celular->save();

        $email = new PessoaDadosContato;
        $email->pessoa = $pessoa->id;
        $email->dado = 1;
        $email->valor = mb_convert_case($r->email, MB_CASE_LOWER, 'UTF-8');
        $email->save();

        $endereco = new Endereco;
        $endereco->logradouro = mb_convert_case($r->rua, MB_CASE_UPPER, 'UTF-8'); 
        $endereco->numero = $r->numero_endereco;
        $endereco->complemento = mb_convert_case($r->complemento_endereco, MB_CASE_UPPER, 'UTF-8'); 
        $endereco->cep = preg_replace( '/[^0-9]/is', '',$r->cep);
        $endereco->bairro = 0;
        $endereco->bairro_str = mb_convert_case($r->bairro_str, MB_CASE_UPPER, 'UTF-8'); 
        $endereco->cidade = mb_convert_case($r->cidade, MB_CASE_UPPER, 'UTF-8'); 
        $endereco->estado = $r->estado;
        $endereco->atualizado_por = $pessoa->id;
        $endereco->save();

        $contato = new PessoaDadosContato;
        $contato->pessoa = $pessoa->id;
        $contato->dado = 6;
        $contato->valor = $endereco->id;
        $contato->save();

        return redirect('/perfil/cpf');
    }


    public function parceriaIndex(Request $r){
        $parceria = \App\PessoaDadosAdministrativos::where('pessoa',$r->pessoa->id)->where('dado',28)->first();
        if($parceria != null)
            return view('perfil.parceria')->with('pessoa',$r->pessoa)->with('parceria',$parceria->valor);
        else
            return view('perfil.parceria')->with('pessoa',$r->pessoa);

    }

    public function parceriaExec(Request $r){
        $r->validate([
                'curriculo' => 'required|file|mimes:pdf|max:2000',
            ]);
        
        $arquivo = $r->file('curriculo');
       
        if (empty($arquivo))
            return redirect()->back()->withErrors(['Nenhum arquivo selecionado.']);         
        
        elseif(!substr($arquivo->getClientOriginalName(),-3,3)=='pdf' || !substr($arquivo->getClientOriginalName(),-3,3)=='PDF' )
            return redirect()->back()->withErrors(['Apenas arquivos PDF são aceitos.']);

        elseif($arquivo->getSize()>2097152) 
            return redirect()->back()->withErrors(['O arquivo deve ser menor que 2MB.']);
        
        else{


        
            $parceria = new \App\PessoaDadosAdministrativos;
            $parceria->pessoa = $r->pessoa->id;
            $parceria->dado = 28;
            $parceria->valor = $r->area;
            

            try{
                $arquivo->move('documentos/curriculos/',$r->pessoa->id.'.pdf');

            }
            catch(\Exception $e){
                return redirect('/perfil/parceria')->withErrors([$e->getMessage()]);
            }

        
            $parceria->save();
            return redirect('/perfil/parceria');
        }


    }

    public function parceriaCurriculo(Request $r){
        return \App\classes\Arquivo::download('-.-documentos-.-curriculos-.-'.$r->pessoa->id.'.pdf');
    }

    public function parceriaCancelar(Request $r){
        $parceria = \App\PessoaDadosAdministrativos::where('pessoa',$r->pessoa->id)->where('dado',28)->first();
        if($parceria != null)
        $parceria->delete();
        
        try{
            unlink('documentos/curriculos/'.$r->pessoa->id.'.pdf');
        }
        catch(\Exception $e){
            return redirect('/perfil/parceria')->withErrors([$e->getMessage()]);
        }

        
        
        return redirect('/perfil/parceria');

    }

    public function alterarDadosView(Request $r){
        return view('perfil.alterar-dados')->with('pessoa',$r->pessoa);;
    }

    public function alterarDadosExec(Request $r){
        $pessoa = $r->pessoa->id;
        $mensagem = '';

        if(isset($r->celular)){
            $celular = new PessoaDadosContato;
            $celular->pessoa = $pessoa;
            $celular->dado = 9;
            $celular->valor = preg_replace( '/[^0-9]/is','',$r->celular);
            $celular->save();
            $mensagem.=', celular';
        }

        if(isset($r->telefone)){
            $telefone = new PessoaDadosContato;
            $telefone->pessoa = $pessoa;
            $telefone->dado = 2;
            $telefone->valor = preg_replace( '/[^0-9]/is','',$r->telefone);
            $telefone->save();
            $mensagem.=', telefone';
        }

        if(isset($r->email)){
            $email = new PessoaDadosContato;
            $email->pessoa = $pessoa;
            $email->dado = 1;
            $email->valor = mb_convert_case($r->email, MB_CASE_LOWER, 'UTF-8');
            $email->save();
            $mensagem.=', e-mail';
        }

        if(isset($r->cep) && isset($r->rua) && isset($r->numero_endereco) && isset($r->bairro_str) && isset($r->cidade) && isset($r->estado)){
            $endereco = new Endereco;
            $endereco->logradouro = mb_convert_case($r->rua, MB_CASE_UPPER, 'UTF-8'); 
            $endereco->numero = $r->numero_endereco;
            $endereco->complemento = mb_convert_case($r->complemento_endereco, MB_CASE_UPPER, 'UTF-8'); 
            $endereco->cep = preg_replace( '/[^0-9]/is', '',$r->cep);
            $endereco->bairro = 0;
            $endereco->bairro_str = mb_convert_case($r->bairro_str, MB_CASE_UPPER, 'UTF-8'); 
            $endereco->cidade = mb_convert_case($r->cidade, MB_CASE_UPPER, 'UTF-8'); 
            $endereco->estado = $r->estado;
            $endereco->atualizado_por = $pessoa->id;
            $endereco->save();

            $contato = new PessoaDadosContato;
            $contato->pessoa = $pessoa;
            $contato->dado = 6;
            $contato->valor = $endereco->id;
            $contato->save();
            $mensagem.=', endereço';
        }
        
        return redirect('/perfil')->withErrors(['Foram atualizados os seguintes dados: data'.$mensagem]);

    }
    public function boletosPerfil(Request $r){
        $boletos = \App\Boleto::where('pessoa',$r->pessoa->id)->whereYear('vencimento','2021')->orderby('vencimento')->get();
        return view('perfil.boletos')->with('pessoa',$r->pessoa)->with('boletos',$boletos);

    }

    public function imprimirBoleto(int $boleto){
        
    }

    public function autenticarRematricula(Request $r){
		if(!isset($r->pessoa))
			return redirect('/rematricula')->withErrors(['Cadastro não encontrado']);
		else{
			$vencimento = \Carbon\Carbon::today()->addDays(-5);
			$boleto_vencido = \App\Boleto::where('pessoa',$r->pessoa)->whereIn('status',['emitido','divida','aberto executado'])->where('vencimento','<',$vencimento->toDateString())->get();
			if($boleto_vencido->count()>0)		
				return redirect('/rematricula')->withErrors(['Existem pendências abertas em seu cadastro. Entre em contato pelo 3372-1308 para maiores informações.']);
			
			$pessoa = Pessoa::find($r->pessoa);
			if(isset($pessoa->id)){
				$rg = PessoaDadosGerais::where('pessoa',$pessoa->id)->where('dado',4)->orderBy('id','desc')->first();
				$nome = explode(' ',$pessoa->nome_simples);
				$nome = strtolower($nome[0]);
				
				if($rg->valor == $r->rg && $nome == strtolower($r->nome)){
					//$pessoa = \App\Pessoa::cabecalho($pessoa);
					$matriculas = \App\Matricula::where('pessoa', $pessoa->id)
								->where('status','expirada')
								->whereDate('data','>','2019-11-01')
								->orderBy('id','desc')->get();
								
							//listar inscrições de cada matricula;
					foreach($matriculas as $matricula){
						$matricula->inscricoes = \App\Inscricao::where('matricula',$matricula->id)->where('status','finalizada')->get();
						foreach($matricula->inscricoes as $inscricao){  
							$inscricao->proxima_turma = \App\Turma::where('professor',$inscricao->turma->professor->id)
																	->where('dias_semana',implode(',', $inscricao->turma->dias_semana))
																	->where('hora_inicio',$inscricao->turma->hora_inicio)
																	->where('data_inicio','>',\Carbon\Carbon::createFromFormat('d/m/Y', $inscricao->turma->data_termino)->format('Y-m-d'))
							
																	->whereIn('status',['espera','incricao'])
																	->get();
							//dd($inscricao->turma->vagas);
							$alternativas = \App\TurmaDados::where('turma',$inscricao->turma->id)->where('dado','proxima_turma')->get();
							foreach($alternativas as $alternativa){
								$turma =\App\ Turma::find($alternativa->valor);
								$inscricao->proxima_turma->push($turma);

							}
						}
					}

					return view('rematricula.renovacao',compact('pessoa'))->with('matriculas',$matriculas);
					
				}
				else
					return redirect()->back()->withErrors(['Os dados informados não conferem, verifique novamente.']);


			}
			
		}
		

	}
        

}

