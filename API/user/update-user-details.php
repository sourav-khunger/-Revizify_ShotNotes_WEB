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
	$user->id=trim($data->id);
	$user->name=trim($data->name);
	$user->email=trim($data->email);
	$user->phone_number=trim($data->phone_number);
    $user->bio=trim($data->bio);

	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($user->jwt, $key, array('HS256'));
        //print_r($decoded);
        
        $isAuthenticated = false;
        
        if($decoded->data->id == $user->id){
            $isAuthenticated = true;
        }
        
       if($isAuthenticated){
    	    $user->id = $decoded->data->id;
    	    
             if($user->updateUserDetails()){
              $response=$user->getuserDetailsById();
        	} 
        	else{
        	 $response['success'] = 0;
        	 $response['url'] ="";
		     $response['message'] = "Error Updating File";
        	}
		
        }else{
            $response['success'] = 0;
            $response['url'] ="";
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		 $response['url'] ="";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}
?>