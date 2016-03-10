<?php
//allow_url_include=1; 
//include_once 'accessControle.php'; 
require_once('sessionHandler.php');

class sessionManager{ 

	public function createSession($id){
	
	//
	$db = new PDO("mysql:host=localhost;dbname=nursecare", "root", "root");	
	$clean = preg_replace('/\s+/', '', trim($_REQUEST['userCryptedId']));
    $query = $db->prepare("SELECT * FROM `session` WHERE `session`.`session_data` like :clean");
	$query->bindParam(":clean",$clean);	
	$query->execute();
	$res = $query->fetchAll();	
	if (count($res)>0){
	return $res[0][0];	
	}else{
	@session_start();	
	$handler = new SysSession();
	//$handler->write(session_id(), $id);
		$getses = session_id();
	   
		$sql = "INSERT INTO session SET session_id =" . $db->quote($getses) . ", session_data =" . $db->quote($_REQUEST['userCryptedId']) . " ON DUPLICATE KEY UPDATE session_data =" . $db->quote($_REQUEST['userCryptedId']);
	    $db->query($sql);
	return session_id();
		}	
	} 

	public function destroySession($id){	
	$handler = new SysSession();
	$cleanid = preg_replace('/\s+/', '', $id);
	$handler->destroy($cleanid);
	$res="destryed";
	return $id;	
	} 
	//must compare the cliend session with db session, if not match we return instruction
	public function readSession($sesid){
		$value = array();
		$cleanid = preg_replace('/\s+/', '',$sesid);	
	    $pdo = new PDO("mysql:host=localhost;dbname=nursecare", "root", "root");
		$sth = $pdo->prepare("SELECT * FROM `session` WHERE `session`.`session_id` like :ses ");
		$sth->bindParam(":ses",$cleanid);
		$sth->execute();
		$postcode = $sth->fetchAll(PDO::FETCH_OBJ);
		$postcode = array_filter($postcode);
		/*
		if (count($postcode)>0){
			$value = array("report",true); 
			$postcode = array_merge($postcode, $value);			
			return $postcode;
		}else if ((count($postcode)<0)){
			$value = array("report",false); 
			$postcode = array_merge($postcode, $value);			
			return $postcode;
		}	*/
		$value = array("report"=>true); 
		//$postcode = array_merge($postcode, $value);	
		return $postcode;
	
	}
}

?>