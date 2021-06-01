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

        $itens[2] = ['programa' => 3,
                     'curso' => 307,
                     'carga' => 2,
                     'referencia' => "UATI 2 ou 3 disciplinas",
                     'valor'=> 622,
                     'parcelas' => 10,
                     'ano' => 2021];

        $itens[3] = ['programa' => 3,
                     'curso' => 307,
                     'carga' => 3,
                     'referencia' => "UATI 4 ou mais disciplina",
                     'valor'=> 961,
                     'parcelas' => 10,
                     'ano' => 2021];

        $itens[4] = ['programa' => 12,
                     'curso' => 0,
                     'carga' => 60,
                     'referencia' => "Hidroginástica e natação",
                     'valor'=> 769,
                     'parcelas' => 10,
                     'ano' => 2021];

        $itens[5] = ['programa' => 2,
                     'curso' => 0,
                     'carga' => 40,
                     'referencia' => "Cursos PID 40 horas",
                     'valor'=> 266,
                     'parcelas' => 5,
                     'ano' => 2021];

        $itens[6] = ['programa' => 2,
                     'curso' => 0,
                     'carga' => 80,
                     'referencia' => "Cursos PID 80 horas",
                     'valor'=> 385,
                     'parcelas' => 5,
                     'ano' => 2021];

        $itens[7] = ['programa' => 1,
                     'curso' => 0,
                     'carga' => 50,
                     'referencia' => "Cursos UNIT 50 horas",
                     'valor'=> 267,
                     'parcelas' => 5,
                     'ano' => 2021];

        $itens[8] = ['programa' => 1,
                     'curso' => 0,
                     'carga' => 66,
                     'referencia' => "Cursos UNIT 66 horas",
                     'valor'=> 274,
                     'parcelas' => 5,
                     'ano' => 2021];

        $itens[9] = ['programa' => 1,
                     'curso' => 0,
                     'carga' => 80,
                     'referencia' => "Cursos UNIT 80 horas",
                     'valor'=> 374,
                     'parcelas' => 5,
                     'ano' => 2021];

        $itens[10] = ['programa' => 1,
                     'curso' => 0,
                     'carga' => 120,
                     'referencia' => "Cursos UNIT 120 horas",
                     'valor'=> 436,
                     'parcelas' => 5,
                     'ano' => 2021];

        $itens[11] = ['programa' => 1,
                     'curso' => 1567,
                     'carga' => 80,
                     'referencia' => "Curso de Contabilidade UNIT 80 horas",
                     'valor'=> 436,
                     'parcelas' => 5,
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
            $inscricoes = \App\Inscricao::where('matricula',$matricula->id)->whereIn('status',['regular','pendente'])->get();
            if($matricula->curso == null){
                \App\Http\Controllers\MatriculaController::matriculaSemCurso($matricula);

            }
            //$inscricao_t = \App\Inscricao::where('matricula',$matricula->id)->first();

            if($inscricoes->count() == 0){
                return ValorController::retornarZero('Não há inscrições ativas');
            }
            $turma = \App\Turma::find($inscricoes->first()->turma->id);

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
                //dd($valor);

                
                if($turma->valor>0){
                    $valor->parcelas = $turma->getParcelas();
                    /*
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
                            $valor->parcelas = 10;
                            break;      
                            
                        case 'eventual' :
                            $valor->parcelas = $turma->getTempoCurso();;
                            break;
                        default :
                            $valor->parcelas = 5;
                            break;
                    }
                    */

                    
                    
                    $valor->referencia = 'parcelas temporaria';
                    //return $valor;
                }

                if($valor->valor>0 && $valor->parcelas>0 && $matricula->getParcelas()>0){
                    $valor->valor = ($valor->valor/$valor->parcelas)*$matricula->getParcelas();
                    return $valor;
                }
                else
                    throw new \Exception("Erro ao acessar valor da turma:".$inscricoes->first()->turma->id.' Matrricula:'.$matricula->id .'. Verifique se a turma está com seu valor devidamente atribuído ou se são foi escolhido a parceria no caso de disciplinas gratuítas.', 1);

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
