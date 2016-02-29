<?php
   
class SQLrequest {
	public function __construct($token, $accesskey){
		$this->token = $token;
		$this->accesskey = $accesskey;		
	}

	public function localpostal($pdo){
		$sth = $pdo->prepare("SELECT * FROM `postalcode` ");
		//$sth->bindParam(":code",$code);
		//$sth->bindParam(":pass",$pass);
		$sth->execute();
		$postcode = $sth->fetchAll(PDO::FETCH_OBJ);
		$postcode = array_filter($postcode);
		return $postcode;
	}

	public function listpatient($idPatient,$pdo){
		$sth = $pdo->prepare("SELECT *
								FROM `nurse` n
								JOIN mypatient mp ON n.id=mp.id_nurse
								JOIN patient p ON p.id=mp.id_patient WHERE n.id = :id");
	    $sth->bindParam(":id",$idPatient);
	    $sth->execute();
	    $patient = $sth->fetchAll(PDO::FETCH_OBJ);
	    $patient = array_filter($patient);
		return $patient;
/*
SELECT *
FROM user u
JOIN user_clockits uc ON u.user_id=uc.user_id
JOIN clockits cl ON cl.clockits_id=uc.clockits_id
WHERE user_id = 158
*/
/*
SELECT *
FROM patient p
JOIN mypatient mp ON p.id=mp.id_patient
JOIN nurse ns ON ns.id=mp.id_nurse
WHERE user_id = 158
*/


	}
	public function fichepatient($id,$pdo){
		//$id = $val->id;    
	    $sth = $pdo->prepare("SELECT *
	    FROM `patient` where `patient`.`id` like :id"); 
	/*
	     FROM `patient` JOIN `doctor` 
	    ON `patient`.`id`= `doctor`.`id_patient` where `patient`.`id` like :id"); 
	*/
	    $sth->bindParam(":id",$id);
	    $sth->execute();
	    $fiche = $sth->fetchAll(PDO::FETCH_OBJ);
	    $fiche= array_filter($fiche);
		return $fiche;
	}

	public function login($email,$password,$pdo){		
		//$password = $val->password;    
	    $sth = $pdo->prepare("SELECT *
	    FROM `nurse` where `nurse`.`email` like :email "); 
	    $sth->bindParam(":email",$email);
	    //$sth->bindParam(":password",$password);
	    $sth->execute();
	    $fiche = $sth->fetchAll(PDO::FETCH_OBJ);
	    $fiche= array_filter($fiche);
		return $fiche;
	}

	public function checktoken($pdo){
		//$pdo = new dbserver();
		$req = $pdo->prepare("SELECT * 
			 					FROM `apiaccess` 
			 					WHERE `token` 
			 					like :tokenapi AND `key` like :keyapis");
		$req->bindParam(":tokenapi",$this->token);
		$req->bindParam(":keyapis", $this->accesskey);
		$req->execute();
		$res = $req->fetchAll(PDO::FETCH_OBJ);	
		$res = array_filter($res);

		return $res; 
	}

	public function insetPatient($val,$pdo){
		$status='H';
		$query = $pdo->prepare("SELECT EXISTS (SELECT * FROM Patient WHERE SIS ='$val->SIS' AND lastname='$val->lastname')");
		$query->execute();
		$res = $query->fetchAll();

		if ($res[0][0]){
			return $res;
		}else{
			$sth = $pdo->prepare("INSERT INTO Patient (name, 
													lastname, 
													housenumber,
													street,
													city, 
													postalcode, 
													SIS,
													telephone,
													birth_date,
													Medecin,
													profession,													
													Mutuelle,
													Status) VALUES (:name, 
																	 :lastname, 
																	 :housenumber,
																	 :street,
																	 :city, 
																	 :postalcode, 
																	 :SIS, 
																	 :telephone,
																	 :birth_date,
																	 :Medecin,
																	 :profession,																	 
																	 :mutuelle,
																	 :status)");
	    $sth->bindParam(":name",$val->name);
	    $sth->bindParam(":lastname",$val->lastname);
	    $sth->bindParam(":housenumber",$val->housenumber);
	    $sth->bindParam(":street",$val->street); 
	    $sth->bindParam(":city",$val->city);
	    $sth->bindParam(":postalcode",$val->postalcode);
	    $sth->bindParam(":SIS",$val->SIS);
	    $sth->bindParam(":telephone",$val->telephone);
	    $sth->bindParam(":Medecin",$val->doctor);
	    $sth->bindParam(":birth_date",$val->birth_date);
	    $sth->bindParam(":profession",$val->profession);
	    $sth->bindParam(":mutuelle",$val->mutuelle);
	    $sth->bindParam(":status",$status); 
	    $sth->bindParam(":postalcode",$val->postalcode);
	    $sth->execute();
	    //$yellow = $sth->fetchAll(PDO::FETCH_OBJ);
	 // echo json_encode($request);
	 		//$pdo = new dbserver();
	    /*
		$req = $pdo->prepare("SELECT * 
			 					FROM `Patient`");
		//$req->bindParam(":tokenapi",$this->token);
		//$req->bindParam(":keyapis", $this->accesskey);
		$req->execute();
		$res = $req->fetchAll(PDO::FETCH_OBJ);	
		$res = array_filter($res);
		return $res; */
	}
	}	

}

 ?> 