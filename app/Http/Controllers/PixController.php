<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\classes\phpqrcode;

class PixController extends Controller
{
   /**
   * IDs do Payload do Pix
   * @var string
   */
  const ID_PAYLOAD_FORMAT_INDICATOR = '00';
  const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
  const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
  const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
  const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
  const ID_MERCHANT_CATEGORY_CODE = '52';
  const ID_TRANSACTION_CURRENCY = '53';
  const ID_TRANSACTION_AMOUNT = '54';
  const ID_COUNTRY_CODE = '58';
  const ID_MERCHANT_NAME = '59';
  const ID_MERCHANT_CITY = '60';
  const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
  const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
  const ID_CRC16 = '63';

    /**
     * Chave Pix
     * @var string
     */
    private $pixKey;

    /**
     * Descrição do pagamento
     * @var string
     */
    private $description;

    /**
     * Merchant Name
     * @var string
     */
    private $merchantName;

    private $merchantCity;
    private $txid;
    private $amount;

    public function setPixKey($pixKey){
        $this->pixKey = $pixKey;
        return $this;
    }

    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    public function setMerchantName($merchantName){
        $this->merchantName = $merchantName;
        return $this;
    }

    public function setMerchantCity($merchantCity){
        $this->merchantCity = $merchantCity;
        return $this;
    }
    public function setAmount($amount){
        $this->amount = (string)number_format($amount,2,'.','');
        return $this;
    }



    /**
   * Método responsável por calcular o valor da hash de validação do código pix
   * @return string
   */
    private function getCRC16($payload) {
        //ADICIONA DADOS GERAIS NO PAYLOAD
        $payload .= self::ID_CRC16.'04';

        //DADOS DEFINIDOS PELO BACEN
        $polinomio = 0x1021;
        $resultado = 0xFFFF;

        //CHECKSUM
        if (($length = strlen($payload)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $resultado ^= (ord($payload[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($resultado <<= 1) & 0x10000) $resultado ^= $polinomio;
                    $resultado &= 0xFFFF;
                }
            }
        }

        //RETORNA CÓDIGO CRC16 DE 4 CARACTERES
        return self::ID_CRC16.'04'.strtoupper(dechex($resultado));
    }

    /**
     * Envia o registo do boletos para o banco e recebe o código pix
     */
    public function testePix(){
        return env('BB_gw');
    }


}


?>
