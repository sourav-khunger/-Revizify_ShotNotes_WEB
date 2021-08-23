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
    $courses->course_name= addslashes(trim($data->course_name));
	$courses->course_desc= addslashes(trim($data->course_desc));
//	$courses->course_type= trim($data->course_type);
	$courses->course_type= "free";
	$courses->course_status= trim($data->course_status);
	$courses->course_price= trim($data->course_price);
	$courses->domain_sector= trim($data->domain_sector);


	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($courses->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $courses->user_id = $decoded->data->id;
    	    
              if($courses->id==$courses->user_id){
                  if($data->course_img!="")
                  {
                   $courses->photo= trim($data->course_img);
	               $courses->photo=base64_decode($courses->photo);
                  
                $t=time();
            	$add = $t."-user-". $courses->id ."-image.png";
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/course_images/". $add;
                 $flag= file_put_contents($target_dir,$courses->photo);
                 $courses->url=$baseurl."/API/uploads/course_images/". $add;
                  }
                  else{
                      $courses->url="";
                  }
                 $response=$courses->addnNewCourse();
                 
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