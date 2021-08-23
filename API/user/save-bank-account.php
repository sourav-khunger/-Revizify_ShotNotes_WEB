<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
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
	
	// initialize object
	$user = new user($db);
	$user->jwt = $bearer->getBearerToken();
	$user->account_holder_name=trim($data->account_holder_name);	
	$user->account_number=trim($data->account_number);
	$user->bank_name=trim($data->bank_name);
	$user->ifsc_code=trim($data->ifsc_code);
	   try {
        $decoded = JWT::decode($user->jwt, $key, array('HS256'));
        //print_r($decoded);
        
           	$user->id = $decoded->data->id;
           	if($user->doesUserExist()){
           	$response=$user->saveBankAccount();
           	}
           	
           	
           	else{
           	     $response['success'] = 0;
            $response['url'] ="";
		    $response['message'] = "You are not an authorised user to perform this action.";
           	}
           	
           	 echo json_encode($response);
	   }
	   
	  catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		 $response['url'] ="";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}
?>