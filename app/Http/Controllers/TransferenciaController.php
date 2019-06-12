<?php

namespace App\Http\Controllers;

use \App\Transferencia;
use \App\Turma;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    //Classe para registrar tranferências das inscrições;
    //
    public static function gravarRegistro($matricula,$turma_anterior,$turma_nova,$motivo){
    	$transf = new Transferencia;
    	$transf->matricula = $matricula;
    	$transf->anterior = $turma_anterior;
    	$transf->nova = $turma_nova;
    	$transf->data = date('Y-m-d H:i');
        $transf->motivo = $motivo;
    	$transf->responsavel = \Session::get('usuario');
    	$transf->save();

        return $transf;


    }
    public function imprimir($id){
        $tr = Transferencia::find($id);

        $tr->getAnterior();
        $tr->getNova();
        $mes = (new \App\classes\Data(\Carbon\Carbon::parse($tr->data)->format('d/m/Y')))->mes();
        $data = \Carbon\Carbon::parse($tr->data)->format('d').' de '.$mes.' de '.\Carbon\Carbon::parse($tr->data)->format('Y');

        return view('juridico.documentos.troca-turma',compact('tr'))->with('pessoa',$tr->getPessoa())->with('data',$data);

    }




    public function imprimirTransferencia($inscricao){


        $insc=Inscricao::find($inscricao);

        //existe mesmo essa inscrição?
        if($insc==null)
            return redirect($_SERVER['HTTP_REFERER'])->withErrors(["Inscrição não encontrada"]);

        $pessoa = Pessoa::find($insc->pessoa->id);


        return view('juridico.documentos.troca-turma')->with('pessoa',$pessoa)->with('inscricao',$insc);
    }
    
}
