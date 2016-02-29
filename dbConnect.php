<?php

echo $ip_address;
   $server ='mysql:host=flysyseccpfl0679.mysql.db;dbname=flysyseccpfl0679';
    $user='flysyseccpfl0679';
    $pass ='Quenelle2016';
  try {
          $pdo = new PDO($server, $user,$pass);
            echo "works";    
              return $pdo ;     
      } catch (Exception $e) {
               echo "error DB ";
              }
         return;
?>