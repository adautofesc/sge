<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Local;

class Sala extends Model
{
    public $timestamps = false;


    private function local()
    {
    	return $this->belongsTo(Local::Class);
    }

    
    public function getLocal()
    {
        $local = Local::find($this->local);
        return $local;

    }

    public static function getUsoLivre(){
        // na observação da sala tem que ter "Atende Uso Livre"
        $uso_livre = \App\Sala::select('salas.id as id_sala','locais.id as id_local', 'locais.nome as local', 'salas.nome as sala')
            ->where('obs','like','%Uso Livre%')
            ->join('locais','salas.local','locais.id')
            ->orderBy('locais.nome')
            ->get();
        //$salas = \App\Sala::whereIn('salas.id',$uso_livre);
            
        //$locais = Local::whereIn('id',$salas)->orderBy('nome')->get();

        return $uso_livre;




    }
}
