<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/deck.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	include_once '../objects/user.php';
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize token object

	$bearer = new Token();
	$deck = new Deck($db);
	$user = new user($db);
	// initialize user object
	$deck->jwt =$bearer->getBearerToken();
	$deck->feedback_to_user_id=trim($data->feedback_to_user_id);
	$deck->feedback_message=trim($data->feedback_message);
	$deck->feedback_rating=trim($data->feedback_rating);

	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($deck->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $user->id = $decoded->data->id;
              if($user->doesUserExist()){
                 $deck->feedback_by_user_id = $decoded->data->id;
                 $response=$deck->saveUserFeedback();
        	} 
        	else{
            $response['success'] = 0;
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}