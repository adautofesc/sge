<?php
namespace App\classes;

Class Arquivo {

	public static function download($arquivo){

	  //require $arquivo;
            $arquivo = str_replace('-.-','/',$arquivo);
            //dd(substr($arquivo,1));
            if(substr($arquivo,0,1) =='/')
                  $arquivo = substr($arquivo,1);
            if(file_exists($arquivo)){
                  //dd($arquivo);
                  header("Content-Type: application/force-download");
                  header("Content-Type: application/octet-stream;");
                  header("Content-Length:".filesize($arquivo));
                  header("Content-disposition: attachment; filename=".$arquivo);
                  header("Pragma: no-cache");
                  header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
                  header("Expires: 0");
                  readfile($arquivo);
                  flush();
            }
            else
                  return "Arquivo ".$arquivo. ' não encontrado.';
      
	}






}

