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
    $courses->course_name= addslashes(trim($data->course_name));
    $courses->course_status=addslashes(trim($data->course_status));
	$courses->course_desc= addslashes(trim($data->course_desc));
	$courses->course_type= addslashes(trim($data->course_type));
	$courses->course_price= trim($data->course_price);
	$courses->domain_sector= addslashes(trim($data->domain_sector));
	
	$courses->photo= trim($data->course_img);  
    $courses->image_update=trim($data->image_update);  


	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($courses->jwt, $key, array('HS256'));
        //print_r($decoded);
    	   $courses->uid = $decoded->data->id;
            if($courses->user_id==$courses->uid){
            if($courses->image_update==true){
                $courses->photo=base64_decode($courses->photo);
                $t=time();
            	$add = $t."-user-". $courses->user_id ."-image.png";
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/course_images/". $add;
                $flag= file_put_contents($target_dir,$courses->photo);
                $courses->url=$baseurl."/API/uploads/course_images/". $add;
                }
                 else{
                 $courses->url=$courses->photo;
                 }
                 
                 $response=$courses->updateCourse();
                 
                 
        	} 
        	else{
            $response['success'] = 0;
            $response['course_id'] ="";
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}