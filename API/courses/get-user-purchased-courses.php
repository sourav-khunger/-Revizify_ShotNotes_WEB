<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/courses.php';
	include_once '../objects/user.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	include_once '../objects/deck.php';
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize token object

	$bearer = new Token();
	$user = new user($db);
	$courses = new courses($db);
	$deck = new Deck($db);
	// initialize user object
	$courses->jwt =$bearer->getBearerToken();
	 try {
        $decoded = JWT::decode($courses->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $user->id = $decoded->data->id;
    	    
              if($user->doesUserExist()){
                 $courses->user_id = $decoded->data->id;
                   $stmt=$courses->getAllUserPurchasedCourses();
                   $allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                 
               foreach($allcourses as $key=>$value){
                   
	            $courses->user_id = $decoded->data->id;
	            $courses->course_id =$value['course_id'];
	            $total_purchases=$courses->getTotalPurchasesByCourseID();
	            $average_rating=$courses->getAverageRatingByCourseID();
	            $allcourses[$key]['purchase']="true";
	            $allcourses[$key]["total_purchases"]="$total_purchases";
	            if($average_rating>0){
	            $allcourses[$key]["average_rating"]=$average_rating;
	            }
	            else{
	                $allcourses[$key]["average_rating"]="0";
	            }
	              $allcourses[$key]["total_card"]=$courses->getCourseChapterALLCardCount();
	             $allcourses[$key]['deck_cards']=$courses->getRevisedCardByCourseID();
	             $stmt=$courses->getAllchaptersIDByCID();
	            $chaptercount=$stmt->rowCount();
                $allchapters=$stmt->fetchAll(PDO::FETCH_ASSOC);
                $allcourses[$key]['total_chapter']=$chaptercount;
                $percentage=0;
                if($chaptercount>0){
                foreach($allchapters as $keys=>$value){
                   $deck->user_id= $decoded->data->id;
                   $deck->chapter_id=$allchapters[$keys]['chapter_id'];
                  
                   $deck_percentage=$deck->getDeckPercentage();
                  
                   $first_revision_percentage=$deck->getFirstRevisionPercentage();
                  
                  $second_revision_percentage=$deck->getSecondRevisionPercentage();
                   
                   $third_revision_percentage=$deck->getThirdRevisionPercentage();
                    
                   $fourth_revision_percentage=$deck->getFourthRevisionPercentage();
                   
                  $totalrevisedpercentage=($deck_percentage+$first_revision_percentage+$second_revision_percentage+$third_revision_percentage+$fourth_revision_percentage)/5;
                       $percentage+=number_format($totalrevisedpercentage, 2); 
                        $allcourses[$key]["percentage"]=$percentage;
                        ;
                  
                  }
              //    $allcourses[$key]["percentage"]=$percentage/$chaptercount;
                   }
                   else{
                        $allcourses[$key]["percentage"]=0;
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
	   