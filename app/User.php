<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'pessoas_dados_acesso';
    //use HasApiTokens, Notifiable;
    use Notifiable;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pessoa', 'username', 'password', 'validade','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','status',
    ];

    public function getRecursosAttribute(){
        $recursos = \App\ControleAcessoRecurso::select('recurso')->where('pessoa',$this->pessoa)->get();
        return $recursos->pluck('recurso')->toArray();
        
    }

    public function getPessoa(){
        return Pessoa::find($this->pessoa);

    }

   

    
}
