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
	
	$user->jwt =$bearer->getBearerToken();
	$user->id = trim($data->id);
	$user->current_password = trim($data->current_password);
	$user->new_password = trim($data->new_password);
	
	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($user->jwt, $key, array('HS256'));
        //print_r($decoded);
        
        $isAuthenticated = false;
        
        if($decoded->data->id ==$user->id){
            $isAuthenticated = true;
            $user->id =$decoded->data->id;
            $user->email =$decoded->data->email;
        }
        
        if($isAuthenticated){
            $user->password = md5($user->current_password);
            if($user->doesCurrentPasswordMatch()){
                $user->password = md5($user->new_password);
                if($user->updatePassword()){
                    $response['success'] = 1;
		            $response['message'] = "Password updated.";
                }else{
                    $response['success'] = 0;
		            $response['message'] = "Something went wrong.";
                }
            }else{
                $response['success'] = 0;
		        $response['message'] = "Current password do not match.";
            }
        }else{
            $response['success'] = 0;
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = 0;
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}
?>