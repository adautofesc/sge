<?php

namespace App\Http\Controllers;
use App\Evento;
use App\Sala;
use App\Local;

use Illuminate\Http\Request;

class EventoController extends Controller
{

    public function index(Request $r){
        $mes = collect();
        if(!isset($r->data))
            $data = new \DateTimeImmutable();
        else
            $data =  \DateTimeImmutable::createFromFormat('Y-m-d',$r->data);
        
        //dd($data->format('w'));

        $dias_mes = $this->get_days_count_in_month($data->format('Y'), $data->format('m'));

        //pegar o primeiro dia do mês
        $primeiro_dia = \DateTimeImmutable::createFromFormat('Y-m-d',$data->format('Y-m-01'));
        $dia = $primeiro_dia->format('w');;
        
        for($i=0;$i<$primeiro_dia->format('w');$i++){
            $cell = new \stdClass();
            $cell->id = $i;
            $cell->weekday = $primeiro_dia->format('w');
            $cell->class = '';
            $cell->number = '';
            $mes->push($cell);

        }
        

        for($i=0;$i<=$dias_mes;$i++){
            if($dia == 6)
                $dia = 0;
            else
                $dia++;
            $cell = new \stdClass();
            $cell->id = $i+$primeiro_dia->format('w');
            $cell->class = 'current-month';
            $cell->weekday = $dia;
            $cell->number = $i+1;
            $cell->events = [];
            $mes->push($cell);



        }

//dd($mes);


        $dia_semana = 0;

       

        
        


        $eventos = Evento::where('data_termino','>=',date('Y-m-d'))->orderBy('data_inicio')->get();
        return view('eventos.index')->with('eventos',$eventos)->with('data',$data)->with('week',0);

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


    public function filter(){

    }

    public function create($tipo='unico'){

        $locais = Local::all();
        $salas = Sala::where('local',84)->where('locavel','s')->get(); 
        switch($tipo){
            case 'continuo': 
                return view('eventos.cadastrar-multiplos')->with('salas',$salas)->with('tipo',$tipo);
                break;
            default:  
                return view('eventos.cadastrar-unico')->with('locais',$locais)->with('salas',$salas)->with('tipo',$tipo);
        }
    }
    public function store(Request $r){
        $evento =  new Evento;
        $evento->tipo = $r->tipo;
        $evento->nome = $r->nome;
        $evento->responsavel = $r->responsavel;
        $evento->data_inicio = $r->data_inicio;
        $evento->data_termino = $r->data_inicio;
        $evento->horario_inicio = $r->h_inicio;
        $evento->horario_termino = $r->h_termino;
        $evento->sala = $r->sala;
        $evento->auto_insc = $r->autoinsc;
        $evento->obs = $r->descricao;
        if($r->tipo == 'continuo'){
            $evento->data_termino = $r->data_termino;
            $evento->dias_semana = implode(', ',$r->dias_semana);
        }
        $evento->save();
        $this->index($r);  
    }

    public function edit($id){

    }
    public function update(Request $r){

    }
    public function delete($ids){

    }

    

}
