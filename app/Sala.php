<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    public $timestamps = false;
    private function local(){
    	return $this->belongsTo(Local::Class);
    }
}
