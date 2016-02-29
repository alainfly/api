<?php
 	header("Access-Control-Allow-Origin:http://localhost:8080");	   
 	//  header("Content-Type: application/json");
   /* Allowed request method */
   header("Access-Control-Allow-Credentials: true");
   header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
   /* Allowed custom header */
   header("Access-Control-Allow-Headers:origin, Content-Type, accept");	
   /* Age set to 1 day to improve speed caching */
   header("Access-Control-Max-Age: 86400");	    
   /* Options request exits before the page is completely loaded */

?>