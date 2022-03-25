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
}
