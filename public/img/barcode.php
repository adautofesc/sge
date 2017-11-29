<?php
    require_once('../../app/classes/CodeGenrator.php'); 
    new barCodeGenrator($_GET['code'],0,'hello.gif', 600, 50, false);
?>