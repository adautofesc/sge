<?php

namespace App\Http\Controllers;

use App\Contato;
use Illuminate\Http\Request;
use Session;

class ContatoController extends Controller
{
    public function registrar(Request $r){

        switch($r->meio){
            case 'sms': 
                $sms = $this->enviarSMS($r->mensagem,[$r->pessoa]);
                if(isset($sms->id))
                    return response($sms,200);
                else
                    return response($sms->msg,500);

                break;

            default:
                $contato = $this->novoContato($r->pessoa,$r->meio,$r->mensagem,Session::get('usuario'));
                return response($contato,200);
                break;
        }
            
       
        
    }

    public function novoContato($para,$meio,$mensagem,$por){

        $contato = new Contato;
        $contato->meio = $meio;
        $contato->mensagem = $mensagem;
        $contato->por = $por;
        $contato->para = $para;
        $contato->save();

        return $contato;

    }

    public function enviarSMS(string $mensagem,Array $pessoas){
        foreach($pessoas as $pessoa){
            $pessoa = \App\Pessoa::find($pessoa);
            $pessoa->celular = $pessoa->getCelular();
            if(strlen($pessoa->celular)>5){
                $mensagem=substr(urlencode('FESC Informa: '.$mensagem),0,140);
                $url = 'http://209.133.205.2/painel/api.ashx?action=sendsms&lgn=16997530315&pwd=194996&msg='.$mensagem.'&numbers='.$pessoa->celular;
                $ch = curl_init();
                //não exibir cabeçalho
                curl_setopt($ch, CURLOPT_HEADER, false);
                // redirecionar se hover
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                // desabilita ssl
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                // Will return the response, if false it print the response
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //envia a url
                curl_setopt($ch, CURLOPT_URL, $url);
                //executa o curl
                $result = curl_exec($ch);
                //encerra o curl
                curl_close($ch);

                $ws = json_decode($result);
                if(isset($ws->msg) && $ws->msg == 'SUCESSO'){
                    $contato = $this->novoContato($pessoa->id,'sms',urldecode($mensagem).' numero:'.$pessoa->celular,Session::get('usuario'));
                    return $contato;
                }
                else
                    return $ws;
                
            }
        }            
    }

    public function enviarWhats(){
        
        if(isset($_GET['pessoa'])){
            $pessoa = \App\Pessoa::find($_GET['pessoa']);
            if(isset($pessoa->id)){
                $pessoa->celular =  $pessoa->getCelular();
                $contato = $this->novoContato($pessoa->id,'whatsapp',$_GET['msg'].' numero:'.$pessoa->celular,Session::get('usuario'));
                return redirect('https://wa.me/55'.$pessoa->celular.'?text='.$_GET['msg']);
            }
        }
        else
            return response('Pessoa não identificada', 500);
            

    }

    
}
