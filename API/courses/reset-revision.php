<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/deck.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
 

// initialize token object

	$bearer = new Token();
	$deck = new Deck($db);
	// initialize user object
	$deck->jwt =$bearer->getBearerToken();
	$deck->chapter_id=trim($data->chapter_id);
	$deck->user_id=trim($data->user_id);

	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($deck->jwt, $key, array('HS256'));
        //print_r($decoded);
    	     $deck->uid = $decoded->data->id;
              if($deck->uid==$deck->user_id){
                $response=$deck->resetRevision();
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