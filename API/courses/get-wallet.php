<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/wallet.php';
	include_once '../objects/user.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize token object

	$bearer = new Token();
	$user = new user($db);
	$wallet = new wallet($db);
	// initialize user object
	$wallet->jwt =$bearer->getBearerToken();
	 try {
        $decoded = JWT::decode($wallet->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $user->id = $decoded->data->id;
    	    
              if($user->doesUserExist()){
                  $wallet->user_id = $decoded->data->id;
                   $response=$wallet->getWalletBalance();
              }
              
            	else{
            $response['success'] = 0;
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
             echo json_encode($response
		);
	 }
	 catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode($response
		);
	}
	   