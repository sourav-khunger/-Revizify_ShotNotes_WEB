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
	
	// initialize user object
	$user = new user($db);
	
	$user->id = trim($data->id);
	$user->device_id = trim($data->device_id);
    $user->jwt =$bearer->getBearerToken();
	$user->push_token = trim($data->push_token);
	
	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($user->jwt, $key, array('HS256'));
        
        $isAuthenticated = true;
        
        if($decoded->data->id == $user->id){
            $isAuthenticated = true;
        }
        
        if($isAuthenticated){
         $user->id = $decoded->data->id;
         $response = $user->deletePushToken();
        }else{
            $response['success'] = 0;
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] =$user->jwt ;
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response);
	}
?>