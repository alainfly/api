<?php

require_once('sessionHandler.php');


$sessionId = session_id();
$handler = new SysSession();
session_set_save_handler($handler, true);

session_start();
$_SESSION['juyh'] = "My Portuguese text: SOU Gaucho!";

//echo session_save_path();
//echo session_save_path();
//session_start();
//$session
echo session_id();
//$arr = array("bleu","blanc");

//$_SESSION["couleur"]=$arr;
print_r($_SESSION['var1']); 

//session_write_close(); //cancel the session's auto start,important



?>