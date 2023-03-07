<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boleto;

class RemessaController extends Controller
{
    public function gerarRemessa(){
		$BC = new BoletoController;
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
		
		//$boletos =Boleto::whereIn('status',['impresso','pelosite','cancelar'])->paginate(300);
		$boletos =Boleto::where('status','emitido')->where('vencimento','like','2023-03-10 %')->paginate(300);

		if($boletos->count() == 0)
			return redirect($_SERVER['HTTP_REFERER'])->withErrors(['Nenhum boleto encontrado']);


		foreach($boletos as $boleto){

			try{
				$boleto_completo = $BC->gerarBoleto($boleto);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,5);
				continue;
			}
			if($boleto->status == 'cancelar' && isset($boleto_completo))
				$boleto_completo->baixarBoleto();

					
			try{
				$remessa->addBoleto($boleto_completo);
			}
			catch(\Exception $e){
				NotificacaoController::notificarErro($boleto->pessoa,6);
				continue;
			}

			

			$boleto->remessa = intval(date('ymdHi'));
			$boleto->save();

			
	
		}

		//dd($remessa);

		if(isset($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = 1;

		$remessa->save( 'documentos/remessas/'.date('Ymd').'_'.$page.'.rem');
		$arquivo = date('Ymd').'_'.$page.'.rem';

		return view('financeiro.remessa.gerador-paginado',compact('boletos'))->with('arquivo',$arquivo);

	}
	public function downloadRemessa($arquivo){
		$arquivo='documentos/remessas/'.$arquivo;
		$arquivo = str_replace('/','-.-', $arquivo);
		return \App\classes\Arquivo::download($arquivo);

	}
	public function listarRemessas(){
		chdir( 'documentos/remessas/' );
		$arquivos = glob("{*.rem}", GLOB_BRACE);
		rsort($arquivos);
		//return $arquivos;
		return view('financeiro.remessa.lista')->with('arquivos',$arquivos);
	}
}
