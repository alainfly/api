<?php

require_once 'abstractAPI.php';
require_once 'sqlRequest.php';
require_once 'sessionStore/session.php';

class MyAPI extends SQLrequest
{
    protected $User;

    public function __construct($val,$pdo) {        
       // parent::__construct($request);
        //$this->val= $val;
         $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == "DELETE") {
                $this->method = "DELETE";
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == "PUT") {
                $this->method = "PUT";
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        switch($this->method) {
        case 'DELETE':
            //echo json_encode("tu vien d'envoyer un delete");        
        case 'POST': //Get request params, check if special key exist and call appropriate function
            //$this->request = $this->_cleanInputs($_POST);
                if (array_key_exists('insetPatient', $val)) {
                    $res = parent::insetPatient($val,$pdo);
                    echo json_encode($res[0][0]);

                }else if(array_key_exists('from_login', $val)) {
                    $res = parent::login($val,$pdo);
                    echo json_encode($res);
                }else if(array_key_exists('storeSession',$val)){
                    // received user id encrypte and store in the DB along with session ID 
                    $Inst = new sessionManager();
                    $res = $Inst->createSession($val->userCryptedId);
                    echo json_encode('$this->method');        
                }

            break;
        case 'GET': //Get request params, check if speccial key exist and call appropriate function
             
               if (array_key_exists('objpostcode', $_REQUEST)) {
                    $res = parent::localpostal($pdo);
                    echo json_encode($res);
                }else if (array_key_exists('listpatient', $_REQUEST)) {
                    $res = parent::listpatient($_REQUEST['idPatient'],$pdo);
                    //print_r($_REQUEST);
                    echo json_encode($res);
                }else if (array_key_exists('login', $_REQUEST)) {
                    $res = parent::login($_REQUEST['email'], $_REQUEST['password'], $pdo);
                    //print_r($res);
                    echo json_encode($res);
                }else if(array_key_exists('fichepatient', $_REQUEST)) {
                    $res = parent::fichepatient($_REQUEST['id'],$pdo);
                    echo json_encode($res);
                }else if(array_key_exists('storeSession',$_REQUEST)){
                    // received user id encrypte and store in the DB along with session ID 
                    $Inst = new sessionManager();
                    $res = $Inst->createSession($_REQUEST['userCryptedId']);
                    print_r($res);       
                }else if(array_key_exists('destroySession',$_REQUEST)){
                    // received user id encrypte and store in the DB along with session ID 
                    $Inst = new sessionManager();
                    $res = $Inst->destroySession($_REQUEST['userCryptedId']);
                    print_r($res);        
                }else if(array_key_exists('sessionId',$_REQUEST)){
                    // received user id encrypte and store in the DB along with session ID 
                    $Inst = new sessionManager();
                    $res = $Inst->readSession($_REQUEST['sessionId']);
                    echo json_encode($res);      
                }              
            break;
        case 'PUT':
            //$this->request = $this->_cleanInputs($_GET);
            $this->file = file_get_contents("php://input");
            break;
        default:
            $this->_response('Invalid Method', 405);
            break;
        }
    }

    /**
     * Endpoint
     */
     protected function example() {
        if ($this->method == 'GET') {
            return "Your name is " . $this->User->name;
        } else {
            return "Only accepts GET requests";
        }
     }
 }
 ?>