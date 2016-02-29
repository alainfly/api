<?php

   header("Access-Control-Allow-Origin:http://localhost:1337");  
   /* Allowed request method */
   header("Access-Control-Allow-Methods: GET,POST,PUT");
   /* Allowed custom header */
   header("Access-Control-Allow-Headers: Content-Type");  
   /* Age set to 1 day to improve speed caching */
   header("Access-Control-Max-Age: 86400");     
    /* Options request exits before the page is completely loaded */ 
   if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') 
   {
      exit();
   }

$params = file_get_contents("php://input");
$Getparams = json_decode($params);

$get_requestType = $Getparams->type;
$name = $Getparams->name;
$to = $get_requestType;  
$subject = 'Votre inscription a Infidome';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Put your HTML here
//$message = '<html><body>hello world</body></html>';
//$message = file_get_contents('emailTemplate.html');

$message ="
<!DOCTYPE html>
<html >
   <Head>
		<!-- Latest compiled and minified JavaScript -->
	</Head>
	<body>	
					<div style='border:2px solid #FFF; height:300px; width:4O0px; float:center;border-radius:0.5em;'>
						<div style='height:50px; text-align:center; width:100%; background:#86bd3b; padding-top:20px'>
								<label style='color:#fff; font-family:sans-serif; font-size:20px; padding-top:10px;' >Activation du Compte</label>
						</div>
						<br/><br/><br/>
						<div style='  padding-left:85px;   padding-top:14px'>
							<p style='color:#86bd3b; font-family:sans-serif; font-size:25px; font-weight: bold;'>$name</p>
							<br/>
							<p style='color:#2F4F4F; font-family:sans-serif; font-size:15px'> 
								Pour creer votre mot de passe, clicker sur ce lien</p>							
						</div>
						
						
						<form method='POST' action='http://localhost:1337/newuserPassword'>
						<div style='font-size:15px; text-align:center; padding-top:20px; padding-bottom:20px'>
							<input type='hidden' name='email' value='$get_requestType'/>
						<input type='submit'  style='background:#86bd3b; border-radius:0.5em; margin:7px; font-size:bold; color:#fff; padding:20px;
						border: 1px solid #86bd3b' value='Activer votre compte Infidome'/>
								<br/>		
								
								<p style='color:#2F4F4F; font-family:sans-serif; font-size:15px'> 
								si vous n'avait pas acces au button , suivez ce lien</p>
								<a href='http://localhost:1337/newuserPassword?email=$get_requestType'> cliclez ici </a>
								
						</div>
						</form>						
						<br/>
						<br/>
						<br/>
						<br/>
					</div>
	</body>
	</html>	";	

// Mail it
mail($to, $subject, $message, $headers);
//You've just sent HTML email. To load an external HTML file replace $message = '' with:

//$message = file_get_contents('emailTemplate.html');

echo json_encode($get_requestType);
?>