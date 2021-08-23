<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/user.php';	
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
	$user = new user($db);
	$user->jwt =$bearer->getBearerToken();

	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($user->jwt, $key, array('HS256'));
        //print_r($decoded);
        
           	$user->id = $decoded->data->id;
    	    
              if($user->doesUserExist()){
               $user->id= trim($data->user_id);
    	       $stmt=$user->getuserDetails();
    	       if($stmt->execute()){
         	    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
         	    $average_rating=$user->getUserAverageRatingbyID();
         	   	$response['success'] = 1;
    		    $response['message'] = "User Details.";
				$response['id'] = $user_data[id];
				$response['name'] = $user_data[name];
			    $response['email'] = $user_data[email];
			    $response['phone_number'] = $user_data[phone_number];
			    $response['profile_photo'] = $user_data[profile_photo];
			    //$response['courses']=$user_data[profile_photo];
			    $response['bio'] = $user_data[bio];
			    $response["average_rating"]=$average_rating;
			    $courses->user_id =$user_data[id];
			    $stmt=$courses->getAllcoursesByID();
                $allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($allcourses as $key=>$value){
                $courses->user_id = $decoded->data->id;
	            $courses->course_id =$value['course_id'];
	            $total_purchases=$courses->getTotalPurchasesByCourseID();
	            $allcourses[$key]["total_purchases"]="$total_purchases";
                $allcourses[$key]["total_chapter"]=$courses->getCourseChapterCount();
	            $allcourses[$key]["total_card"]=$courses->getCourseChapterALLCardCount();
	             if($courses->DoesUserDownloadedCourseByCourseID())
	            {
	              $allcourses[$key]['purchase']="true";  
	            }
	            else{
	                $allcourses[$key]['purchase']="false";
	            }
                }
                $response['courses'] =$allcourses;
			    $feedbackuid=$user->getUserFeedbacks();
			    $response["feedback"]=$feedbackuid;
			    $response["average_rating"]=$average_rating;
    	       }
    	       else{
    	        $response['success'] = 0;
    		    $response['message'] = "query not executed";
    	       }
              }
        else{
            $response['success'] = 0;
            $response['url'] ="";
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
?>