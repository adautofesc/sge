<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Message;
use Carbon\Carbon;
use App\Boleto;
use App\Pessoa;
use App\QrcodeBoletos;
use App\Http\Controllers\PessoaController;

class IntegracaoBBController extends Controller
{
	CONST BB_URL = 'https://api.sandbox.bb.com.br/cobrancas/v2';
	CONST OAUTH_BB_URL =  'https://oauth.sandbox.bb.com.br/oauth/token';

	protected $urlToken;
    protected $header;
    protected $token;
    protected $config;
    protected $urls;
    protected $uriToken;
    protected $uriCobranca;
    protected $clientToken;
    protected $clientCobranca;
    protected $fields;
    protected $headers;
    // protected $optionsRequest = [];

    private $client;
    // function __construct(array $config)
    function __construct($config = array())
    {
        $this->config = $config;
        if(env('APP_ENV') == 'production'){
            $this->urls = 'https://api.bb.com.br/cobrancas/v2/boletos';
            $this->urlToken = 'https://oauth.bb.com.br/oauth/token';
            $this->appKeyField = 'gw-dev-app-key';
            //GuzzleHttp
            $this->uriToken = 'https://oauth.bb.com.br/oauth/token';
            $this->uriCobranca = 'https://api.bb.com.br';
        }else{
            $this->urls = 'https://api.hm.bb.com.br/cobrancas/v2/boletos';
            $this->urlToken = 'https://oauth.sandbox.bb.com.br/oauth/token';
            $this->appKeyField = 'gw-app-key';
            //GuzzleHttp
            $this->uriToken = 'https://oauth.sandbox.bb.com.br';
            $this->uriCobranca = 'https://api.hm.bb.com.br';
        }
        $this->clientToken = new Client([
            'base_uri' => $this->uriToken,
        ]);
        $this->clientCobranca = new Client([
            'base_uri' => $this->uriCobranca,
        ]);
        
        //startar o token
        if($this->token == null){     
            $this->gerarToken();     
        }

      
    }

    ######################################################
    ############## TOKEN #################################
    ######################################################

    public function gerarToken(){
        try {
            $response = $this->clientToken->request(
                'POST',
                '/oauth/token',
                [
                    'headers' => [
                        'Accept' => '*/*',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Authorization' => 'Basic '. base64_encode(env('BB_client_id').':'.env('BB_client_secret')).''
                    ],
                    'verify' => false,
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'scope' => 'cobrancas.boletos-info cobrancas.boletos-requisicao'
                    ]
                ]
            );
            $retorno = json_decode($response->getBody()->getContents());
            if (isset($retorno->access_token)) {
                $this->token = $retorno->access_token;
            }
            return $this->token;
        } catch (\Exception $e) {
            return new Exception("Falha ao gerar Token: {$e->getMessage()}");
        }
    }

    public function setToken(string $token){
        $this->token = $token;
    }

    public function getToken(){
        return $this->token;
    }

    protected function fields(array $fields, string $format="json"): void {
        if($format == "json") {
            $this->fields = (!empty($fields) ? json_encode($fields) : null);
        }
        if($format == "query"){
            $this->fields = (!empty($fields) ? http_build_query($fields) : null);
        }
    }

    protected function headers(array $headers): void {
        if (!$headers) { return; }
        foreach ($headers as $k => $v) {
            $this->header($k,$v);
        }
    }
    
    protected function header(string $key, string $value): void {
        if(!$key || is_int($key)){ return; }
        $keys = filter_var($key, FILTER_SANITIZE_STRIPPED);
        $values = filter_var($value, FILTER_SANITIZE_STRIPPED);
        $this->headers[] = "{$keys}: {$values}";
    }
    
    public function testar(){
        return $this->token;
    }

    ######################################################
    ############## COBRANÇAS #############################
    ######################################################
    public function processarRegistro($registro, Boleto $boleto){
        //boleto,status, response
        $response = json_decode($registro->getBody()->getContents());
        $boleto->status = 'emitido';
        $boleto->save();
        BoletoLogController::alteracaoBoleto($boleto->id,'Boleto registrado via API BB');

        if(isset($response->qrCode->txId)){
            $qr_code = new QrcodeBoletos();
            $qr_code->boleto_id = $boleto->id;
            $qr_code->txId = $response->qrCode->txId;
            $qr_code->url = $response->qrCode->url;
            $qr_code->emv = $response->qrCode->emv;
            $qr_code->save();

        }
        else{
            return 'Erro ao registrar o QrCode boleto'.$boleto->id;
        }
        
        return 'Boleto registrado com sucesso';
      
    }

    /**
     * Aqui se concentra todas as ações de registro de boletos
     */
    public function registroBoletosLote(Request $request){
        $registros_boletos = collect();// new stdClass();
        
        $boletos = Boleto::whereIn('id',$request->boletos)->get();
        foreach($boletos as $boleto){ 
            $registro = new \stdClass();
            $registro->boleto = $boleto->id;    

            $boleto_BB = $this->montarBoletoBB($boleto);
            try{
                $req_registro = $this->registrarBoleto($boleto_BB);
                
            } 
            
            catch (ClientException $e) {
                $response = $e->getResponse();
                $responseBodyAsString = json_decode($response->getBody()->getContents());
                if($responseBodyAsString==''){
                    return ($response);
                }
                $registro->status = 'erro';
                $registro->msg = $responseBodyAsString->erros[0]->mensagem;
                $registros_boletos->push($registro);
                continue;

            } 
            catch (\Exception $e) {
                $response = $e->getMessage();
                $registro->status = 'erro';
                $registro->msg = "Falha ao registrar boleto: {$response}";
                $registros_boletos->push($registro);
                continue;
            }

            
            $registro->status = 'ok';
            $registro->msg = $this->processarRegistro($req_registro,$boleto);
            $registros_boletos->push($registro);
            
           


            
        }

        //dd(json_encode($boleto_BB));

        return $registros_boletos;

    }


    public function montarBoletoBB(Boleto $boleto){
        $cliente = Pessoa::withTrashed()->find($boleto->pessoa);
        $cliente = PessoaController::formataParaMostrar($cliente);
        return array(
                'numeroConvenio' => 3128557, //env('BB_CONVENIO'),
                'numeroCarteira' => 17,
                'numeroVariacaoCarteira' => 35,//19
                'dataEmissao' => date('d.m.Y'),
                'dataVencimento'=> Carbon::parse($boleto->vencimento)->format('d.m.Y'),
                'valorOriginal' => $boleto->valor,
                'codigoAceite' => 'A',
                'codigoModalidade' =>'4',
                'codigoTipoTitulo' => '2',
                'descricaoTipoTitulo' => 'Cobrança de Pagamento',
                'numeroTituloBeneficiario' => $boleto->id,
                'numeroTituloCliente' =>'0003128557'.str_pad($boleto->id,10,'0',STR_PAD_LEFT),// '000'.env('BB_CONVENIO').str_pad($boleto->id,10,'0',STR_PAD_LEFT),
                'mensagemBloquetoOcorrencia' => 'Boleto gerado pelo sistema de cobrança',

                'pagador' => array(
                    'tipoInscricao' => '1',
                    'numeroInscricao' => $cliente->cpf,
                    'nome' => str_replace(['º', 'ª', '°', '´', '~', '^', '`', '\''], '', substr($cliente->nome, 0, 37)),
                    'endereco' => str_replace(['º', 'ª', '°', '´', '~', '^', '`', '\''], '', $cliente->logradouro . ' ' . $cliente->end_numero . ' ' . $cliente->end_complemento),
                    'cep' => $cliente->cep,
                    'cidade' => $cliente->cidade,
                    'uf' => $cliente->estado,
                    'telefone' => $cliente->telefone,
                    'email' => $cliente->email,
                ),
                'beneficiarioFinal' => array(
                    'tipoInscricao' => '2',
                    'numeroInscricao' => 98959112000179,//'45361904000180',
                    'nome' => 'Dirceu Borboleta'//'FUNDAÇÃO EDUCACIONAL SÃO CARLOS',
                  
                ),


                'indicadorPermissaoRecebimentoParcial' => 'N',
                'indicadorPix' => 'S',
            );

    }



    public function registrarBoleto(array $fields){
        
            $response = $this->clientCobranca->request(
                'POST',
                '/cobrancas/v2/boletos',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Developer-Application-Key' => env('BB_client_id'),
                        'Authorization' => 'Bearer ' . $this->token.''
                    ],
                    'verify' => false,
                    'query' => [
                        $this->appKeyField => env('BB_dev_app_key'),
                    ],
                    'body' => json_encode($fields),
                ]
            );
           return $response;
        
    }

    public function alterarBoleto(string $id, array $fields){
        try {
            $response = $this->clientCobranca->request(
                'PATCH',
                "/cobrancas/v2/boletos/{$id}",
                [
                    'headers' => [
                        'accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'X-Developer-Application-Key' => env('BB_dev_app_key'),
                        'Authorization' => 'Bearer ' . $this->token.''
                    ],
                    'verify' => false,
                    'query' => [
                        'gw-dev-app-key' => env('BB_dev_app_key'),
                    ],
                    'body' => json_encode($fields),
                ]
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            throw new \Exception( "Falha ao alterar Boleto Cobranca: {$response}");
        }
    }

    public function detalheDoBoleto(string $id){
        try {
            $response = $this->clientCobranca->request(
                'GET',
                "/cobrancas/v2/boletos/{$id}",
                [
                    'headers' => [
                        'X-Developer-Application-Key' => env('BB_dev_app_key'),
                        'Authorization' => 'Bearer ' . $this->token.''
                    ],
                    'verify' => false,
                    'query' => [
                        'numeroConvenio' => env('BB_CONVENIO'),
                    ],
                ]
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao detalhar Boleto Cobranca: {$response}"];
        }
    }

    public function listarBoletos($filters){
        try {
            $response = $this->clientCobranca->request(
                'GET',
                "/cobrancas/v2/boletos",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->token.''
                    ],
                    'verify' => false,
                    'query' => [
                        'gw-dev-app-key' => env('BB_dev_app_key'),
                        'indicadorSituacao' => 'B', // A ou B - Abertos ou Baixados
                        'agenciaBeneficiario' =>'0295' ,
                        'contaBeneficiario' => env('BB_CONTA'),
                        'carteiraConvenio' =>17,
                        'dataInicioVencimento' => $filters['dataInicioVencimento'],
                        'dataFimVencimento' => $filters['dataFimVencimento']
                        
                    ],
                ]
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            return ($e);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao baixar Boleto Cobranca: {$response}"];
        }
    }

    public function baixarBoleto(string $id){
        $fields['numeroConvenio'] = env('BB_CONVENIO');
        try {
            $response = $this->clientCobranca->request(
                'POST',
                "/cobrancas/v2/boletos/{$id}/baixar",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Developer-Application-Key' => env('BB_dev_app_key'),
                        'Authorization' => 'Bearer ' . $this->token.''
                    ],
                    'verify' => false,
                    'body' => json_encode($fields),
                ]
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = json_decode($response->getBody()->getContents());
            if($responseBodyAsString==''){
                return ($response);
            }
            return ($responseBodyAsString);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao baixar Boleto Cobranca: {$response}"];
        }
    }

    public function consultaPixBoleto(string $id){
        try {
            $response = $this->clientCobranca->request(
                'GET',
                "/cobrancas/v2/boletos/{$id}/pix",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->token.''
                    ],
                    'verify' => false,
                    'query' => [
                        'gw-dev-app-key' => env('BB_dev_app_key'),
                        'numeroConvenio' => env('BB_CONVENIO'),
                    ],
                ]
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            return ($e);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao baixar Boleto Cobranca: {$response}"];
        }
    }

    public function cancelarPixBoleto(string $id){
        $fields['numeroConvenio'] = env('BB_CONVENIO');
        try {
            $response = $this->clientCobranca->request(
                'POST',
                "/cobrancas/v2/boletos/{$id}/cancelar-pix",
                [
                    'headers' => [
                        'accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->token.''
                    ],
                    'verify' => false,
                    'query' => [
                        'gw-dev-app-key' => env('BB_dev_app_key'),
                    ],
                    'body' => json_encode($fields),
                ]
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            return ($e);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao baixar Boleto Cobranca: {$response}"];
        }
    }
    
    public function gerarPixBoleto(string $id){
        $fields['numeroConvenio'] = env('BB_CONVENIO');
        try {
            $response = $this->clientCobranca->request(
                'POST',
                "/cobrancas/v2/boletos/{$id}/gerar-pix",
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token.'',
                        'accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'X-Developer-Application-Key' => env('BB_dev_app_key'),
                    ],
                    'verify' => false,
                    'query' => [
                        'gw-dev-app-key' => env('BB_dev_app_key'),
                    ],
                    'body' => '{"numeroConvenio": 3128557}',
                ]
            );
            $statusCode = $response->getStatusCode();
            $result = json_decode($response->getBody()->getContents());
            return array('status' => $statusCode, 'response' => $result);
        } catch (ClientException $e) {
            return ($e);
        } catch (\Exception $e) {
            $response = $e->getMessage();
            return ['error' => "Falha ao baixar Boleto Cobranca: {$response}"];
        }
    }

    public function gerarPixBoleto2(string $id, array $fields){
        $this->headers([
            "Authorization"     => "Bearer " . $this->token,
            "accept"      => "application/json",
            "Content-Type"      => "application/json",
            // "X-Developer-Application-Key" => env('BB_dev_app_key')
        ]);
        $this->fields($fields,'json');

        $curl = curl_init("https://api.sandbox.bb.com.br/cobrancas/v2/boletos/00031285570000150024/gerar-pix?gw-dev-app-key=d27be77909ffab001369e17d80050056b9b1a5b0");
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
                "numeroConvenio": 3128557
              }',
            CURLOPT_HTTPHEADER => ($this->headers),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLINFO_HEADER_OUT => true
        ]);
        
        $gerarPixBoleto = json_decode(curl_exec($curl));
        return $gerarPixBoleto;
    }

    ######################################################
    ############## FIM - COBRANÇAS #######################
    ######################################################





    //NADA FEITO DAQUI PARA BAIXO



    ######################################################
    ############## PAGAMENTOS ############################
    ######################################################
    public function pagarBoletoLinha(string $linhaDigitavel){
        // $this->headers([
        //     "accept"            => "application/json",
        //     // "Content-Type"      => "application/json",
        //     // "Authorization"     => "Bearer " . $this->getToken()->access_token,
        //     // "X-Developer-Application-Key" => env('BB_dev_app_key')
        // ]);
        // //falta colocar produção
        // $curl = curl_init("https://api.hm.bb.com.br/testes-portal-desenvolvedor/v1/boletos-cobranca/{$linhaDigitavel}/pagar?gw-app-key={env('BB_dev_app_key')}");
        // curl_setopt_array($curl,[
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => '',
        //     CURLOPT_HTTPHEADER => ($this->headers),
        //     CURLOPT_SSL_VERIFYPEER => false,
        //     CURLINFO_HEADER_OUT => true
        // ]);
        
        // $pagarBoletoLinha = json_decode(curl_exec($curl));        
        // return $pagarBoletoLinha;
    }

    public function pagarBoletoPix(string $pix){
        // $this->headers([
        //     "Content-Type"      => "application/json",
        //     "accept"            => "application/json",
        //     // "Authorization"     => "Bearer " . $this->getToken()->access_token,
        //     // "X-Developer-Application-Key" => env('BB_dev_app_key')
        // ]);
        // //falta colocar produção
        // $curl = curl_init("https://api.hm.bb.com.br/testes-portal-desenvolvedor/v1/boletos-pix/pagar?gw-app-key={env('BB_dev_app_key')}");
        // curl_setopt_array($curl,[
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => '{
        //         "pix": "00020101021226870014br.gov.bcb.pix2565qrcodepix-h.bb.com.br/pix/v2/c8ecd24d-f648-44ff-b568-6806fbd3d01a5204000053039865802BR5920ALAN GUIACHERO BUENO6008BRASILIA62070503***6304072C"
        //       ',
        //     CURLOPT_HTTPHEADER => ($this->headers),
        //     CURLOPT_SSL_VERIFYPEER => false,
        //     CURLINFO_HEADER_OUT => true
        // ]);
        
        // $pagarBoletoPix = json_decode(curl_exec($curl));        
        // return $pagarBoletoPix;
    }
    ######################################################
    ############## FIM - PAGAMENTOS ######################
    ######################################################


    ######################################################
    ############## QRCODES ###############################
    ######################################################
    public function gerarQRCode(string $pix){
        // $this->headers([
        //     "Content-Type"      => "application/json",
        //     "accept"            => "application/json",
        //     "Authorization"     => "Bearer " . $this->getToken()->access_token,
        //     "X-Developer-Application-Key" => env('BB_dev_app_key')
        // ]);
        // //falta colocar produção
        // $curl = curl_init("https://api.sandbox.bb.com.br/pix-bb/v1/arrecadacao-qrcodes?gw-dev-app-key={env('BB_dev_app_key')}");
        // curl_setopt_array($curl,[
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => '{
        //         "numeroConvenio": 62191,
        //         "indicadorCodigoBarras": "S",
        //         "codigoGuiaRecebimento": "83660000000199800053846101173758000000000000",
        //         "emailDevedor": "contribuinte.silva@provedor.com.br",
        //         "codigoPaisTelefoneDevedor": 55,
        //         "dddTelefoneDevedor": 61,
        //         "numeroTelefoneDevedor": "999731240",
        //         "codigoSolicitacaoBancoCentralBrasil": "88a33759-78b0-43b7-8c60-e5e3e7cb55fe",
        //         "descricaoSolicitacaoPagamento": "Arrecadação Pix",
        //         "valorOriginalSolicitacao": 19.98,
        //         "cpfDevedor": "19917885250",
        //         "nomeDevedor": "Contribuinte da Silva",
        //         "quantidadeSegundoExpiracao": 3600,
        //         "listaInformacaoAdicional": [
        //           {
        //             "codigoInformacaoAdicional": "IPTU",
        //             "textoInformacaoAdicional": "COTA ÚNICA 2021"
        //           }
        //         ]
        //       }',
        //     CURLOPT_HTTPHEADER => ($this->headers),
        //     CURLOPT_SSL_VERIFYPEER => false,
        //     CURLINFO_HEADER_OUT => true
        // ]);
        
        // $gerarQRCode = json_decode(curl_exec($curl));        
        // return $gerarQRCode;
    }
    ######################################################
    ############## FIM - QRCODES #########################
    ######################################################


}