<?php


$request = "flysyse.com/api/index.php";

$retrive = explode('/',rtrim($request,'/'));

//echo $retrive[0];
//echo $retrive[1];
//print_r($_SERVER);
print_r($_SERVER['HTTP_X_HTTP_METHOD']); 


/*
$test = array("name" => "Alain",
              "lastname" =>"muya",
              "adresse" =>"ernest cambier",
              "telephone"=>"048905414");

*/

?>