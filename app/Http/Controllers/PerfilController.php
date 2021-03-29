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
             

        return view('perfil.painel')->with('pessoa',$r->pessoa);
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
        $pessoa->nome = strtoupper($r->nome);
        $pessoa->genero = $r->genero;
        $pessoa->nascimento = $r->nascimento;
        $pessoa->por = 0;
        $pessoa->save();

        $pessoa->por = $pessoa->id;
        $pessoa->save();

        $rg = new PessoaDadosGerais;
        $rg->pessoa = $pessoa->id;
        $rg->dado = 4;
        $rg->valor = $r->rg;
        $rg->save();

        $cpf = new PessoaDadosGerais;
        $cpf->pessoa = $pessoa->id;
        $cpf->dado = 3;
        $cpf->valor = $r->cpf;
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
        $email->valor = $r->email;
        $email->save();

        $endereco = new Endereco;
        $endereco->logradouro = $r->rua;
        $endereco->numero = $r->numero_endereco;
        $endereco->complemento = $r->complemento_endereco;
        $endereco->bairro = 0;
        $endereco->bairro_str = $r->bairro_str;
        $endereco->cidade = $r->cidade;
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
}
