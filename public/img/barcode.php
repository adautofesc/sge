<?php


	header("Content-type: image/gif");
	
	
	if(file_exists('../../sge/app/classes/CodeGenrator.php'))
    	require_once('../../sge/app/classes/CodeGenrator.php'); 
    else
    	require_once('../../app/classes/CodeGenrator.php'); 

	
	try{
    	new App\classes\BarCodeGenrator($_GET['code'],0,null, 600, 50, false);
		
	}
	catch(Exception $e){
		echo $e->getMessage();
	}

?>