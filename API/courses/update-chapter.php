<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/courses.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize token object

	$bearer = new Token();
	$courses = new courses($db);
	// initialize user object
	$courses->jwt =$bearer->getBearerToken();
	$courses->user_id=trim($data->user_id);
	$courses->course_id=trim($data->course_id);
	$courses->chapter_id=trim($data->chapter_id);
    $courses->chapter_name= trim($data->chapter_name);
	$courses->chapter_description= trim($data->chapter_description);


	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($courses->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $courses->uid = $decoded->data->id;
    	    
              if($courses->user_id==$courses->uid){
            	
                 $response=$courses->updateChapter();
                 
        	} 
        	else{
            $response['success'] = 0;
            $response['chapter_id'] ="";
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}