<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    private function local(){
    	return $this->belongsTo(Local::Class);
    }
}
