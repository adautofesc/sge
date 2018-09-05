<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
	header("Content-type: image/gif");
	//die("");

    //require_once('../../../laravel/app/classes/CodeGenrator.php'); //externo

    require_once('../../app/classes/CodeGenrator.php'); //interno

    new barCodeGenrator($_GET['code'],0,'hello.gif', 110, 50, True);

?>