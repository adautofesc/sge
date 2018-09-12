<?php
	header("Content-type: image/gif");
	//die("ok");
    require_once('../../../laravel/app/classes/CodeGenrator.php'); 
    //include('../../app/classes/CodeGenrator.php'); 
    new barCodeGenrator($_GET['code'],0,'hello.gif', 600, 50, false);
?>