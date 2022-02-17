<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valor;
use App\Matricula;
ini_set('max_execution_time', 180);
class ValorController extends Controller
{
    private const vencimento = 10;
	private const data_corte = 20;
	private const dias_adicionais = 5;



    public function cadastrarValores(){
        
        $itens = array();
        $itens[1] = ['programa' => 3,
                     'curso' => 307,
                     'carga' => 1,
                     'referencia' => "UATI 1 disciplina",
                     'valor'=> 294,
                     'parcelas' => 10,
                     'ano' => 2021];


        foreach($itens as $item){
            $registro = Valor::where('programa',$item['programa'])->where('curso',$item['curso'])->where('carga',$item['carga'])->where('ano',$item['ano'])->first();
            if(!isset($registro->id)){
                $valor = new Valor;
                $valor->programa = $item['programa'];
                $valor->curso = $item['curso'];
                $valor->carga = $item['carga'];
                $valor->referencia = $item['referencia'];
                $valor->valor=$item['valor'];
                $valor->parcelas = $item['parcelas'];
                $valor->ano = $item['ano'];
                $valor->save();
            }
        }


        return $itens;

    }

    public static function valorMatricula($id_matricula)
    {


        $matricula = Matricula::find($id_matricula);
        
       

    	if($matricula)
    	{
            

            
            

            $inscricoes = \App\Inscricao::where('matricula',$matricula->id)->whereIn('status',['regular','pendente','espera'])->get();
            if($matricula->curso == null){
                \App\Http\Controllers\MatriculaController::matriculaSemCurso($matricula);

            }
            //$inscricao_t = \App\Inscricao::where('matricula',$matricula->id)->first();

            if($inscricoes->count() == 0){
                return ValorController::retornarZero('Não há inscrições ativas');
            }
            $turma = \App\Turma::find($inscricoes->first()->turma->id);
            if(isset($matricula->pacote)){
        
                $valor = Valor::where('pacote',$matricula->pacote)->where('ano',substr($turma->data_inicio,-4))->first();
                if($valor)
                    return $valor;
                else
                    dd('Valor do pacote '.$matricula->pacote.' não encontrado para o ano de '.substr($turma->data_inicio,-4) );

            }

            

            
            //dd($turma->parceria->id);
            $fesc=[84,85,86,118];
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
                        if($valor)
                            return $valor;
                        else{
                            //redirect()->back()->withErrors(['teste']);
                            return ValorController::retornarZero("Pacote não definido para turma ".$turma->id);

                        }
                            
                        break;
                    case 2:
                    case 3:
                    
                        $valor = Valor::where('curso','307')->where('carga','2')->where('ano',substr($inscricoes->first()->turma->data_inicio,-4))->first();
                        if($valor)
                            return $valor;
                        else
                            return ValorController::retornarZero("Pacote não definido para turma ".$turma->id);
                        break;
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                        $valor = Valor::where('curso','307')->where('carga','3')->where('ano',substr($inscricoes->first()->turma->data_inicio,-4))->first();
                        if($valor)
                            return $valor;
                        else
                            return ValorController::retornarZero("Pacote não definido para turma ".$turma->id);
                        break;
    			}
    			

    		}
    		else //não é 307
    		{
               /*
    			$inscricao = \App\Inscricao::where('matricula',$matricula->id)->first();
                if($inscricoes->count()==0){
                    return ValorController::retornarZero('Não há inscrições ativas');
                

                else*/
                $valor = new Valor;
                $valor->valor =0;
                foreach($inscricoes as $inscricao){
                    $turma= \App\Turma::find($inscricao->turma->id); 
                    $valor->valor += $turma->valor;
                    
                    
                }
                

                
                if($valor->valor>0){
                    $valor->parcelas = $turma->getParcelas();
                    $valor->referencia = 'parcelas temporaria';
                    //return $valor;
                }
                //dd($matricula->getParcelas());

                if($valor->valor>0 && $valor->parcelas>0 && $matricula->getParcelas()>0){
                    $valor->valor = ($valor->valor/$valor->parcelas)*$matricula->getParcelas();
                    return $valor;
                }
                else
                    {
                    return ValorController::retornarZero("Pacote não definido para turma ".$turma->id);
                    // o ideal é parar as matriculas dessa turma e emitir um aviso para secretaria de que a turma está dando problema. 
                    //throw new \Exception("Erro ao acessar valor da turma:".$inscricoes->first()->turma->id.' Matrricula:'.$matricula->id .'. Verifique se a turma está com seu valor devidamente atribuído ou se são foi escolhido a parceria no caso de disciplinas gratuítas.', 1);
                }
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

    public static function gerar($valor,$parcelas,$referencia='gerado por alguma função'){
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

        dd($url);

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

    function correcaoValor($valor, $vencimento){
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
