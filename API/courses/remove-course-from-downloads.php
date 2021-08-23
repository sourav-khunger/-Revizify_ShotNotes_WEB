<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/user.php';
	include_once '../objects/courses.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	include_once '../objects/deck.php';
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize token object
    $user = new user($db);
	$bearer = new Token();
	$courses = new courses($db);
	$deck = new Deck($db);
	// initialize user object
	$courses->jwt =$bearer->getBearerToken();
	$courses->course_id=trim($data->course_id);
	 try {
        $decoded = JWT::decode($courses->jwt, $key, array('HS256'));
        //print_r($decoded);
    	     $user->id = $decoded->data->id;
    	    
              if( $user->doesUserExist()){
                  
                   $courses->user_id= $decoded->data->id;
                   if($courses->removeCourseFromDownloads()){
                   $response['success'] = 1;
                   $response['message'] ="course removed successfully.";
                   }
                  else{
                   $response['success'] = 0;
                   $response['message'] ="STMT ERROR";
                   }
              }
              
            	else{
            $response['success'] = 0;
            $response['course_id'] ="";
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
             echo json_encode($response);
	 }
	 catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		 $response['url'] ="";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode($response
		);
	}
	   