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
	//$courses->id=trim($data->id);
	 try {
        $decoded = JWT::decode($courses->jwt, $key, array('HS256'));
        //print_r($decoded);
    	     $user->id = $decoded->data->id;
    	    
              if( $user->doesUserExist()){
                  
                   $courses->user_id= $decoded->data->id;
                   $stmt=$courses->getAllCourses();
                   $allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
                   
               foreach($allcourses as $key=>$value){
                   
	            $courses->user_id = $decoded->data->id;
	            $courses->course_id =$value['course_id'];
	            //total purcahse
	            $total_purchases=$courses->getTotalPurchasesByCourseID();
	            //total rating
	            $average_rating=$courses->getAverageRatingByCourseID();
	            $allcourses[$key]["total_chapter"]=$courses->getCourseChapterCount();
	            $allcourses[$key]["total_card"]=$courses->getCourseChapterALLCardCount();
	             if($courses->DoesUserDownloadedCourseByCourseID())
	            {
	              $allcourses[$key]['purchase']="true";  
	            }
	            else{
	                $allcourses[$key]['purchase']="false";
	            }
	            $allcourses[$key]["total_purchases"]="$total_purchases";
	            if($average_rating>0){
	            $allcourses[$key]["average_rating"]=$average_rating;
	            }
	            else{
	                $allcourses[$key]["average_rating"]="0";
	            }
	        }
                   $response['success'] = 1;
                   $response['courses'] =$allcourses;
                   
              }
              
            	else{
            $response['success'] = 0;
            $response['course_id'] ="";
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
             echo json_encode(array(
			"response" => $response
		));
	 }
	 catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		 $response['url'] ="";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode($response
		);
	}
	   