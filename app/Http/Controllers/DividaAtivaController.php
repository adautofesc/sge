<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DividaAtiva;
use App\DividaAtivaDados;
use App\Boleto;

class DividaAtivaController extends Controller
{
    public function index(Request $r){
        $dividas = DividaAtiva::select('*','divida_ativa.id as id_divida',)->join('pessoas','divida_ativa.pessoa','pessoas.id');
        if(isset($r->buscar))
            $dividas = $dividas->where('divida_ativa.id',$r->buscar)
                            ->orwhere('ano',$r->buscar)
                            ->orwhere('nome','like','%'.$r->buscar.'%')
                            ->orwhere('status',$r->buscar);

        $dividas = $dividas->orderBy('ano')->orderBy('pessoas.nome')->paginate(30);
        return view('financeiro.divida.index',compact('dividas'));
    }

    public function gerarDividaAtiva(){
		$ipca = ValorController::getIPCA();

		$boletos = Boleto::where('status','emitido')->whereYear('vencimento','=',date('Y')-1)->paginate(900);
        //dd($boletos);
			
		$beneficiario = new \Eduardokum\LaravelBoleto\Pessoa([
		    'documento' => '45.361.904/0001-80',
		    'nome'      => 'Fundação Educacional São Carlos',
		    'cep'       => '13560-230',
		    'endereco'  => 'Rua São Sebastiao, 2828, ',
		    'bairro' => ' Vila Nery',
		    'uf'        => 'SP',
		    'cidade'    => 'São Carlos',
		]);
		$remessa = new \Eduardokum\LaravelBoleto\Cnab\Remessa\Cnab240\Banco\Bb(
		    [
		        'agencia'      => '0295',
		        'carteira'     => 17,
		        'conta'        => 52822,
		        'convenio'     => 2838669,
		        'variacaoCarteira' => '019',
		        'beneficiario' => $beneficiario,
		    ]
		);



		if($boletos->count() == 0)
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhum boleto encontrado']);


		foreach($boletos as $boleto){
			try{ //tentar gerar boleto completo
                $boleto_controller = new \App\Http\Controllers\BoletoController;
				$boleto_completo = $boleto_controller->gerarBoleto($boleto);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro ao gerar Boleto');
				continue;
			}
			
			
			try{//tentar gerar remessa desse boleto
				$remessa->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,'Erro ao gerar Remessa');
				continue;
			}

			
			$boleto_completo->baixarBoleto();
			$boleto->status='divida';			
			//$boleto->save();
			DividaAtiva::cadastrar($boleto, $ipca);



		}
        //dd('divida ativa controller @ gerarDividaAtiva executado');
		$remessa->save( 'remessas/'.date('YmdHi').'.rem');
		$arquivo = date('YmdHi').'.rem';
		return view('financeiro.remessa.divida-arquivo',compact('boletos'))->with('arquivo',$arquivo);
	}
}
