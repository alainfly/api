<?php 
include_once 'accessControle.php';  
include_once 'dbclass.php'; 
require_once 'main-api.php';

//print_r($_SERVER);
$res = Array();
$req = file_get_contents("php://input");
$val = json_decode($req);


//instantiat the token class, call chectoken function, if callback array not empty then processd

try {

    $API = new MyAPI($val,$pdo);
	} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
/*
$checkToken = new token($val->token,$val->accesskey);
if(!empty($checkToken->checktoken($pdo))){

} else if(empty($checkToken->checktoken($pdo)))  {
	echo json_encode("no access allowed");
}*/
?>