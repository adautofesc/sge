<?php
namespace App\classes;

use Session;
use App\Pessoa;



Class Hdr{


public function __construct(){
	$hoje=new Data();
	$data=$hoje->getData();
	$user=Session::get('usuario');
	$usuario= Pessoa::where('id',$user)->first();
	$array_nome=explode(' ',$usuario->nome);
	$nome=$array_nome[0].' '.end($array_nome);           
	$dados=['data'=>$data,'usuario'=>$nome];
	return $dados['data'];
}
public function __toString(){
	$hoje=new Data();
	$data=$hoje->getData();
	$user=Session::get('usuario');
	$usuario= Pessoa::where('id',$user)->first();
	$array_nome=explode(' ',$usuario->nome);
	$nome=$array_nome[0].' '.end($array_nome);           
	$dados=compact(['data'=>$data,'usuario'=>$nome]);
	return $dados;

}

}
