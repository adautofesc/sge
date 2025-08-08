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
                        $this->diaSemana = date("w", mktime( 0, 0 , 0 , $this->mes, $this->dia, $this->ano));
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

                return $Mes[$this->mes*1];
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

                return $Dia[$this->diaSemana*1];
        }
        public static function converteParaBd($d)
        {
            $data= Carbon::createFromFormat('d/m/Y',$d)->toDateString();
            return $data;
        }
        public static function converteParaUsuario($d)
        {
            $data= Carbon::parse($d)->format('d/m/Y');
            return $data;
        }
        public static function calculaIdade($data_nasc)
         {
           if($data_nasc ==null || $data_nasc=='000-00-00' )
           return 0;

            $data_nasc=explode('-',$data_nasc);

            $data=date('d/m/Y');

            $data=explode('/',$data);

            $anos=$data[2]-$data_nasc[0];

            if($data_nasc[1] > $data[1])

            return $anos-1;

            if($data_nasc[1] == $data[1])
            if($data_nasc[2] <= $data[0]) {
            return $anos;
            
            }
            else{
            return $anos-1;
            
            }

            if ($data_nasc[1] < $data[1])
            return $anos;
        }
        public static function semestres(){
            //$semestres = \DB::select( \DB::raw('select CASE WHEN month(data_termino)<=7 THEN 1 else 2 end as semestre,year(data_termino)as ano FROM turmas where deleted_at is null GROUP BY semestre,ano order by ano DESC, semestre DESC'));
            $semestres = collect();
            for($ano=2018;$ano<=date('Y')+1;$ano++){
                for($i=0;$i<3;$i++){
                    $semestre = new \stdClass;
                    $semestre->semestre = $i;
                    $semestre->ano = $ano;
                    $semestres->push($semestre);
                }
            }
            return $semestres;
        }

        public static function periodoSemestre($valor){
            if($valor==0){
                if(date('m')<8)
                        $semestre = 1;
                else
                        $semestre = 2;
                $ano = date('Y');
            }
            else{
                    $semestre = substr($valor, 0,1);
                    $ano= substr($valor, 1,4);
            }         
            switch($semestre){
                case 0:
                    $datas = [($ano-1).'-11-20%', $ano.'-11-19%']; //ano td
                    break;    
                case 1:
                    $datas = [($ano-1).'-11-20%', $ano.'-06-30%']; //1º semestre
                    break;       
                case 2:
                    $datas = [$ano.'-07-01%',$ano.'-11-19%']; //2º semestre
                    break;         
                default :
                    $datas = [($ano-1).'-11-20%', $ano.'-11-19%']; // padrão ano td.
                    
            }

            //dd($datas);
            return $datas;

        }
        public static function periodoSemestreTurmas($valor){
                if($valor==0){
                    if(date('m')<8)
                            $semestre = 1;
                    else
                            $semestre = 2;
                    $ano = date('Y');
                }
                else{
                        $semestre = substr($valor, 0,1);
                        $ano= substr($valor, 1,4);
                }         
                switch($semestre){
                    case 0:
                        $datas = [($ano).'-01-01%', $ano.'-12-31%']; //ano td
                        break;    
                    case 1:
                        $datas = [($ano).'-01-01%', $ano.'-06-30%']; //1º semestre
                        break;       
                    case 2:
                        $datas = [$ano.'-07-01%',$ano.'-12-31%']; //2º semestre
                        break;         
                    default :
                        $datas = [($ano).'-01-01%', $ano.'-12-31%']; // padrão ano td.
                        
                }
    
                //dd($datas);
                return $datas;
    
        }

        public static function stringDiaSemana($data){
                //dd($data);
                $data_obj = \DateTime::createFromFormat('d/m/Y',$data);
                switch($data_obj->format('w')){
                        case 0:
                        return 'dom';
                        break;
                        case 1:
                        return 'seg';
                        break;
                        case 2:
                        return 'ter';
                        break;
                        case 3:
                        return 'qua';
                        break;
                        case 4:
                        return 'qui';
                        break;
                        case 5:
                        return 'sex';
                        break;
                        case 6:
                        return 'sab';
                        break;
                }
        }

        

        //guiliredu/feriados-brasileiros-em-php.php
        public static function diasFeriados($ano = null){
                if(empty($ano))
                {
                        $ano = intval(date('Y'));
                }

                $pascoa = easter_date($ano); // Limite de 1970 ou após 2037 da easter_date PHP consulta http://www.php.net/manual/pt_BR/function.easter-date.php
                $dia_pascoa = date('j', $pascoa);
                $mes_pascoa = date('n', $pascoa);
                $ano_pascoa = date('Y', $pascoa);

                $feriados = array(
                        // Datas Fixas dos feriados Nacionail Basileiras
                        'Confraternização Universal' => date("Y-m-d", mktime(0, 0, 0, 1, 1, $ano)), // Confraternização Universal - Lei nº 662, de 06/04/49
                        'Tiradentes' => date("Y-m-d", mktime(0, 0, 0, 4, 21, $ano)), // Tiradentes - Lei nº 662, de 06/04/49
                        'Dia do Trabalhador' => date("Y-m-d", mktime(0, 0, 0, 5, 1, $ano)), // Dia do Trabalhador - Lei nº 662, de 06/04/49
                        'Dia da Independência' => date("Y-m-d", mktime(0, 0, 0, 9, 7, $ano)), // Dia da Independência - Lei nº 662, de 06/04/49
                        'N.S. Aparecida' => date("Y-m-d", mktime(0, 0, 0, 10, 12, $ano)), // N. S. Aparecida - Lei nº 6802, de 30/06/80
                        'Todos os santos' => date("Y-m-d", mktime(0, 0, 0, 11, 2, $ano)), // Todos os santos - Lei nº 662, de 06/04/49
                        'Proclamação da republica' => date("Y-m-d", mktime(0, 0, 0, 11, 15, $ano)), // Proclamação da republica - Lei nº 662, de 06/04/49
                        'Natal' => date("Y-m-d", mktime(0, 0, 0, 12, 25, $ano)), // Natal - Lei nº 662, de 06/04/49
                        'Dia da Consciência Negra' => date("Y-m-d", mktime(0, 0, 0, 11, 20, $ano)), // Dia da Consciência Negra -  nº 14.759/2023

                        // Essas Datas depem diretamente da data de Pascoa
                        // mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48, $ano_pascoa), //2ºferia Carnaval
                        
                       '2ª feria Carnaval' => date("Y-m-d", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48, $ano_pascoa)), //2ºferia Carnaval
                       '3ª feria Carnaval' => date("Y-m-d", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47, $ano_pascoa)), //3ºferia Carnaval
                        
                        '6ª feira Santa' => date("Y-m-d", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2, $ano_pascoa)), //6ºfeira Santa
                        //'Páscoa' => date("Y-m-d", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa, $ano_pascoa)), //Pascoa
                        'Corpus Christi' =>date("Y-m-d", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60, $ano_pascoa)), //Corpus Cirist

                );

                

                return $feriados;
        }
}

// $data = \Carbon\Carbon::parse($tr->data)->format('d').' de '.$mes.' de '.\Carbon\Carbon::parse($tr->data)->format('Y');
/* para retornar uma data específica por extenso 
$Data = new Data('14/12/1988');//dia em que nasci ^^
echo $Data->getData();

echo '<hr />';

/* para retornar a data atual
$Data = new Data();
echo $Data->getData(); */
?>