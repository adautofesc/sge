<?php
	header("Content-type: image/gif");
	//die("ok");
	if(file_exists('../../../laravel/app/classes/CodeGenrator.php'))
    	require_once('../../../laravel/app/classes/CodeGenrator.php'); 
    else
    	require_once('../../app/classes/CodeGenrator.php'); 
    new barCodeGenrator($_GET['code'],0,'hello.gif', 600, 50, false);
?>