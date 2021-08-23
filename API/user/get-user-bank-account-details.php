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
	   try {
        $decoded = JWT::decode($user->jwt, $key, array('HS256'));
        //print_r($decoded);
        
           	$user->id = $decoded->data->id;
           	if($user->doesUserExist()){
           	$stmt=$user->getUserBankDetails();
           	$bank_data=$stmt->fetch(PDO::FETCH_ASSOC);
            $response['success'] = 1;
    	    $response['account_holder_name'] =$bank_data[account_holder_name];
    	    $response['account_number'] =$bank_data[account_number];
    	    $response['account_ifsc_code'] =$bank_data[account_ifsc_code];
    	    $response['bank_name'] =$bank_data[bank_name];
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