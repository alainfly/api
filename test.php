<?php


//include_once 'dbclass.php'; 

class SysSession implements SessionHandlerInterface{   

	function open($path, $name) {
	    $db = new PDO("mysql:host=localhost;dbname=nursecare", "root", "root");

	    $sql = "INSERT INTO session SET session_id =" . $db->quote($sessionId) . ", session_data = '' ON DUPLICATE KEY UPDATE session_lastaccesstime = NOW()";
	    $db->query($sql);    
	}

	function read($sessionId) { 
	    $db = new PDO("mysql:host=localhost;dbname=nursecare", "root", "root");
	    $sql = "SELECT session_data FROM session where session_id =" . $db->quote($sessionId);
	    $result = $db->query($sql);
	    $data = $result->fetchColumn();
	    $result->closeCursor();

	    return $data;
	}

	function write($sessionId, $data) { 
	    $db = new PDO("mysql:host=localhost;dbname=nursecare", "root", "root");

	    $sql = "INSERT INTO session SET session_id =" . $db->quote($sessionId) . ", session_data =" . $db->quote($data) . " ON DUPLICATE KEY UPDATE session_data =" . $db->quote($data);
	    $db->query($sql);
	}

	function close() {
	    $sessionId = session_id();
	    //perform some action here
	}


	function destroy($sessionId) {
	    $db = new PDO("mysql:host=localhost;dbname=nursecare", "root", "root");

	    $sql = "DELETE FROM session WHERE session_id =" . $db->quote($sessionId); 
	    $db->query($sql);

	    setcookie(session_name(), "", time() - 3600);
	}

	function gc($lifetime) {
	    $db = new PDO("mysql:host=localhost;dbname=nursecare", "root", "root");

	    $sql = "DELETE FROM session WHERE session_lastaccesstime < DATE_SUB(NOW(), INTERVAL " . $lifetime . " SECOND)";
	    $db->query($sql);
	}

}


$handler = new SysSession();
session_set_save_handler($handler, true);


?>