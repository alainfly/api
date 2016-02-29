<?php

class apikey extends dbserver { 
			public function __construct($key, $user){

					this->pdo = parent::connect();
					this->user = $user;
					this->key = $key;	
			}
		   protected function getKey($key,$user){

		   }	



}

?>