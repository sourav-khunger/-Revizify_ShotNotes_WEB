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
	$courses->id=trim($data->id);
	$courses->course_id=trim($data->course_id);
    $courses->chapter_name= addslashes(trim($data->chapter_name));
	$courses->chapter_description= addslashes(trim($data->chapter_description));


	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($courses->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $courses->user_id = $decoded->data->id;
    	    
              if($courses->id==$courses->user_id){
            	
                 $response=$courses->addnNewChapter();
                 
        	} 
        	else{
            $response['success'] = 0;
            $response['course_id'] ="";
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