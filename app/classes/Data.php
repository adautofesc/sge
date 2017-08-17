<?php
namespace App\classes;

use Carbon\Carbon;

Class Data
{
        private $dia;
        private $diaSemana;
        private $mes;
        private $ano;

        /*
         * construtor
         Aug 16, 2009 • William Bruno

         */
        public function __construct($day='')
        {
                if( $day == '' )
                {
                        $this->diaSemana = date('w');
                        $this->dia = date('d');
                        $this->mes = date('n');
                        $this->ano = date('Y');
                }
                else
                {
                        $p = explode('/', $day);
                        $this->dia = $p[0];
                        $this->mes = $p[1];
                        $this->ano = $p[2];
                        $this->diaSemana = date("w", mktime( $hora, $minuto , $segundo , $this->mes, $this->dia, $this->ano));
                }
        }
        public function getData()
        {
                $mes = self::Mes();
                $diaSemana = self::Dia();
                $data = $diaSemana.', '.$this->dia.' de '.$mes.' de '.$this->ano;
                return $data;
        }

        public function Mes()
        {
                $Mes = array(
                1=>'Janeiro',
                2=>'Fevereiro',
                3=>'Março',
                4=>'Abril',
                5=>'Maio',
                6=>'Junho',
                7=>'Julho',
                8=>'Agosto',
                9=>'Setembro',
                10=>'Outubro',
                11=>'Novembro',
                12=>'Dezembro'
                );

                return $Mes[$this->mes];
        }

        public function Dia()
        {
                $Dia = array(
                0=>'Domingo',
                1=>'Segunda-feira',
                2=>'Terça-feira',
                3=>'Quarta-feira',
                4=>'Quinta-feira',
                5=>'Sexta-feira',
                6=>'Sábado'
                );

                return $Dia[$this->diaSemana];
        }
        public static function converteParaBd($d){
            $data= Carbon::createFromFormat('D/M/Y',$d)->toDateString();
            return $data;
        }
        public static function converteParaUsuario($d){
            $data= Carbon::parse($d)->format('d/m/Y');
            return $data;
        }
}

/* para retornar uma data específica por extenso 
$Data = new Data('14/12/1988');//dia em que nasci ^^
echo $Data->getData();

echo '<hr />';

/* para retornar a data atual
$Data = new Data();
echo $Data->getData(); */
?>