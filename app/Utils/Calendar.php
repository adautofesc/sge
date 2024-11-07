<?php
namespace App\Utils;
/**
 * Classe de instancia de calendário em PHP
 * Utiliza classe de dias Não Letivos
 * 
 */
Class Calendar
{
    public $data;
    public $dias;
    /**
     * Metodo construtor
     * A entrada da classe é mY ex.: 52023 -> maio 2023
     *
     * @param string|null $string_date
     * @return collection dias
     */
    public function __construct(string $string_date = null){
        $this->dias = collect();
        if(is_null($string_date))
            $this->data = new \DateTimeImmutable();
        else
            $this->data =  \DateTimeImmutable::createFromFormat('mY',$string_date);
        
        //dd($data);

        $dias_mes = $this->get_days_count_in_month($this->data->format('Y'), $this->data->format('m'));

        //pegar o primeiro dia do mês
        $primeiro_dia = \DateTimeImmutable::createFromFormat('Y-m-d',$this->data->format('Y-m-01'));
        $ultimo_dia = \DateTimeImmutable::createFromFormat('Y-m-d',$this->data->format('Y-m-'.$dias_mes));
        $dia = $primeiro_dia->format('w');
        //dd($dia);


        //pegar todos eventos do mês;



        //Pegar todos dias não letivos
        $dias_nao_letivos = \App\DiaNaoLetivo::whereYear('data',$this->data->format('Y'))->whereMonth('data',$this->data->format('m'))->get();
        //dd($dias_nao_letivos );
        for($i=0;$i<$primeiro_dia->format('w');$i++){
    
            $cell = new \stdClass();
            $cell->id = $i;
            $cell->weekday = $i;
            $cell->class = '';
            $cell->number = '';
            $cell->title = '';
            $this->dias->push($cell);
        }
        for($i=1;$i<=$dias_mes;$i++){
            
            $cell = new \stdClass();
            $cell->id = $i+$primeiro_dia->format('w');

            if($primeiro_dia->format('Y')== date('Y') && $primeiro_dia->format('m')== date('m') && date('d') == $i)
                $cell->class = 'current-month today';
            else
                $cell->class = 'current-month';
            
            $nl = $dias_nao_letivos->where('data',$this->data->format('Y').'-'.$this->data->format('m').'-'.str_pad($i , 2 , '0' , STR_PAD_LEFT))->first();
            $cell->title = '';
            if($nl){
                $cell->class .= ' weekend';
                $cell->title = $nl->descricao;
            }
            $cell->weekday = $dia;
            $cell->number = $i;
            $cell->events = [];
            $this->dias->push($cell);
            if($dia == 6)
                $dia = 0;
            else
                $dia++;
        }
        for($i=$ultimo_dia->format('w');$i<6;$i++){        
            $cell = new \stdClass();
            $cell->id = $i+$primeiro_dia->format('w');
            $cell->class = '';
            $cell->weekday = $i+1;
            $cell->number = '';
            $cell->title = '';
            $cell->events = [];
            $this->dias->push($cell); 
        }
        return $this;
        //$eventos = Evento::where('data_termino','>=',date('Y-m-d'))->orderBy('data_inicio')->get();
        //return view('eventos.index')->with('eventos',$eventos)->with('data',$data)->with('mes',$mes);
    }

    
    
    /**
     * Numero de dias que o mês possui
     *
     * @param [type] $year
     * @param [type] $month
     * @return void
     */
    public function get_days_count_in_month($year, $month) {
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }


    public function get_next_month($y, $m) {
        $y = intval($y);
        $m = intval($m);

        //***
        $m++;
        if ($m % 13 == 0 OR $m > 12) {
            $y++;
            $m = 1;
        }

        return array('y' => $y, 'm' => $m);
    }

    public function get_prev_month($y, $m) {
        $y = intval($y);
        $m = intval($m);

        //***
        $m--;
        if ($m <= 0) {
            $y--;
            $m = 12;
        }

        return array('y' => $y, 'm' => $m);
    }

    public function __toString(){
        return $this->data;

    }





}