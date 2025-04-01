<?php
	if(file_exists('../../sge/app/classes/BarCodeGenrator.php')){
		require_once('../../sge/app/classes/BarCodeGenrator.php');
	}
	elseif(file_exists('../../app/classes/BarCodeGenrator.php')){
		require_once('../../app/classes/BarCodeGenrator.php');	
	}
	else
	throw new Exception("BarCodeGenrator class not found");
 
 	header("Content-type: image/gif");
 	
 	try{
     	new App\classes\BarCodeGenrator($_GET['code'],0,null, 600, 50, false);    	
 		
 	}
 	catch(Exception $e){
 		echo $e->getMessage();
 	}
 

?>