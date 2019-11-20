<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valor;
use App\Matricula;
ini_set('max_execution_time', 180);
class ValorController extends Controller
{
    //
    public static function valorMatricula($id_matricula)
    {

    	$matricula = Matricula::find($id_matricula);


    	if($matricula)
    	{
            if($matricula->curso == null){
                \App\Http\Controllers\MatriculaController::matriculaSemCurso($matricula);

            }
            $inscricao_t = \App\Inscricao::where('matricula',$matricula->id)->first();

            if($inscricao_t == null){
                return ValorController::retornarZero('Não há inscrições ativas');
            }
            $turma = \App\Turma::find($inscricao_t->turma->id);

            //dd($turma->parceria->id);
            $fesc=[84,85,86];
            if(!in_array($turma->local->id,$fesc)){
                 return ValorController::retornarZero('Turma fora da fesc');

            }
            if(isset($turma->parceria))
                return ValorController::retornarZero('Parcerias/Ação Social');

            
            if($turma->programa->id == 4)
                return ValorController::retornarZero('Escola Municipal de Governo');




    		if($matricula->curso == 307)
    		{
    			$inscricoes = \App\Inscricao::where('matricula',$matricula->id)->whereIn('status',['regular','pendente'])->get();
    			switch (count($inscricoes)) {
    				case 0:
                         return ValorController::retornarZero('Não há inscrições ativas');
                        break;
                    case 1:
                    	$valor = Valor::where('curso','307')->where('carga','1')->where('ano',substr($inscricoes->first()->turma->data_inicio,-4))->first();
                        return $valor; 
                        //return $this->gerar($valor->valor/$valor->parcelas, qnde de parcelas,
                        break;
                    case 2:
                    case 3:
                    
                        $valor = Valor::where('curso','307')->where('carga','2')->where('ano',substr($inscricoes->first()->turma->data_inicio,-4))->first();
                        return $valor;
                        break;
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                        $valor = Valor::where('curso','307')->where('carga','3')->where('ano',substr($inscricoes->first()->turma->data_inicio,-4))->first();
                        return $valor;
                        break;
    			}
    			

    		}
    		else
    		{

    			//pega a primeira inscricao da matricula
    			$inscricao = \App\Inscricao::where('matricula',$matricula->id)->first();
                if(!$inscricao){
                    return ValorController::retornarZero('Não há inscrições ativas');
                }
                else

                    $turma= \App\Turma::find($inscricao->turma->id);
                    if($turma->valor>0){
                        $valor = new Valor;
                        $valor->valor = $turma->valor;
                        switch($turma->periodicidade){
                            case 'mensal' :
                                $valor->parcelas = 1;
                                break;
                            case 'bimestral' :
                                $valor->parcelas = 2;
                                break;
                            case 'trimestral' :
                                $valor->parcelas = 3;
                                break;
                            case 'semestral' :
                                $valor->parcelas = 5;
                                break;
                            case 'anual' :
                                if($inscricao->turma->programa->id == 12 || $inscricao->turma->programa->id == 2)
                                    $valor->parcelas = 10;
                                else 
                                    $valor->parcelas = 11;
                                break;
                            case 'eventual' :
                                $valor->parcelas = 1;
                                break;
                            default :
                                $valor->parcelas = 5;
                                break;
                        }
                        
                        $valor->referencia = 'parcelas temporaria';
                        return $valor;
                    }
                

               


                
                if(isset($valor))
                    return $valor;//number_format($valor->valor,2,',','.');
                else

                    throw new \Exception("Erro ao acessar valor da turma:".$inscricao->turma->id.' Matrricula:'.$matricula->id, 1);
                    
                    /*$valor = new Valor;
                        $valor->valor = 0;
                        $valor->parcelas = 1;
                        $valor->referencia = 'Valor não disponível no tabela de valores.';
                        return $valor;*/
                     
                    
                    
                

    			//pegar programa e  carga horária
    			//listar se existe algum valor com programa e curso
    				//se sim retornar o valor
    				//se não verificar programa e carga horária
    		}
    	}

    }
    public static function retornarZero($msg='Valor não disponível no tabela de valores.'){
        $valor = new Valor;
        $valor->valor = 0;
        $valor->parcelas = 1;
        $valor->referencia = $msg;
        return $valor;

    }

    public function gerar($valor,$parcelas,$referencia='gerado por alguma função'){
        $valor = new Valor;
        $valor->valor = $valor;
        $valor->parcelas = $parcelas;
        $valor->referencia = $referencia;
        return $valor;

    }

    public function getIPCA($data_inicial='201901' ,$data_final = null){
        $acumulado = 0;
        if($data_final ==null)
            $data_final=date('Ym');

        //https://api.bcb.gov.br/dados/serie/bcdata.sgs.10844/dados?formato=json
        
        $url = "http://api.sidra.ibge.gov.br/values/t/1419/p/".$data_inicial."-".$data_final."/n1/all/h/n/v/63/c315/7169/d/v63%205?formato=json";

        $ch = curl_init();
        //não exibir cabeçalho
        curl_setopt($ch, CURLOPT_HEADER, false);
        // redirecionar se hover
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // desabilita ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //envia a url
        curl_setopt($ch, CURLOPT_URL, $url);
        //executa o curl
        $result = curl_exec($ch);
        //encerra o curl

        $status = curl_getinfo($ch);

        if($status["http_code"]== 400 || $status["http_code"]== 500)
                throw new \Exception("Erro ".$status["http_code"]. " ao acessar URL com os dados IPCA em ValorController:getIPCA-> ".$url, 1);
                
        curl_close($ch);


        $ws = json_decode($result);
        //dd($ws);
       
       
        if(isset($ws->erro) || !$ws)
                throw new \Exception("Erro ao processar dados do IPCA. Verifique o status do serviço do IBGE: ".$ws->erro, 1);


        return $ws;
                
        
    }


    function jurosSimples($valor, $taxa, $parcelas) {
            $taxa = $taxa / 100;
     
            $m = $valor * (1 + $taxa * $parcelas);
            $valParcela = number_format($m / $parcelas, 2, ",", ".");
     
            return $valParcela;
    }
     
    function jurosComposto($valor, $taxa, $parcelas) {
            $taxa = $taxa / 100;
     
            $valParcela = $valor * pow((1 + $taxa), $parcelas);
            $valParcela = number_format($valParcela / $parcelas, 2, ",", ".");
     
            return $valParcela;
    }

    function correcaoValor($valor='66', $vencimento = '2018-09-20'){
        //calcula os dias
        $vencimento_formatado = strtotime($vencimento);
        $margem = strtotime("+1 month", $vencimento_formatado);
        $data__atual_formatada = strtotime(date('Y-m-d'));
        $diferenca = (($data__atual_formatada - $vencimento_formatado)/86400)-1;

        //calcula correcao
        $taxa_acumulada_anterior= $this->getIPCA( date('Ym', $margem));
        $taxa_acumulada= $this->getIPCA( date('Ym', $vencimento_formatado));
     




        return   $valor_taxa;
        //
    }


}
