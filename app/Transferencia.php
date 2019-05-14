
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transferencia extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    public function matricula(){
    	return $this->hasOne('App\Matricula');
    }
    public function anterior(){
    	return $this->hasOne('App\Inscricao')
    }
    public function nova){
    	return $this->hasOne('App\Inscricao')
    }
    public function por(){
    	return $this->hasOne('App\Pessoa')
    }
}
