<?php

	header("Content-type: image/gif");
	
	if(file_exists('../../sge/app/classes/CodeGenrator.php'))
    	require_once('../../sge/app/classes/CodeGenrator.php'); 
    else
    	require_once('../../app/classes/CodeGenrator.php'); 

    new barCodeGenrator($_GET['code'],0,'hello.gif', 600, 50, false);
?>