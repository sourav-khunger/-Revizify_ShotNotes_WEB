<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/courses.php';
	include_once '../objects/deck.php';
	
	include_once '../objects/user.php';
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
	$user = new user($db);
	$deck = new Deck($db);
	
	// initialize user object
	$courses->jwt =$bearer->getBearerToken();
	//$courses->id=trim($data->id);
	$courses->course_id=trim($data->course_id);
	
	 try {
        $decoded = JWT::decode($courses->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $user->id = $decoded->data->id;
    	    $deck->user_id = $decoded->data->id;
              if($user->doesUserExist()){
                $courses->user_id = $decoded->data->id;
                $course_data=$courses->getCourseByID();
                $stmt = $courses->getUserPurchasedCourseByCourseID();
	            $num = $stmt->rowCount();
	            
			    if($num > 0){
			    $purchase="true";
			    }else{
				$purchase="false";
			    }
                  $stmt=$courses->getAllchaptersByCID();
                   
                  $allchapters=$stmt->fetchAll(PDO::FETCH_ASSOC);
                  $revised_cards=$courses->getRevisedCardByCourseID();
                  
                  foreach($allchapters as $key=>$value){
                  $courses->chapter_id=$allchapters[$key]['chapter_id'];
                  $chapter_card=$courses->getTotalChapterCardsByChapterID();
                  
                  $total_cards+=$chapter_card;
                  }
                  $total_purchases=$courses->getTotalPurchasesByCourseID();
	              $average_rating=$courses->getAverageRatingByCourseID();
                
                  $response['success'] = 1;
                  $response['user_id']=$course_data[user_id];
                  $response['user_name']=$course_data[name];
                  $response['course_name']=$course_data[course_name];
                  $response['course_description']=$course_data[course_desc];
                  $response['course_image']=$course_data[course_img];
                  $response['course_price']=$course_data[course_price];
                  $response['domain_sector']=$course_data[domain_sector];
                  $response['course_type']=$course_data[course_type];
                  $response['course_status']=$course_data[course_status];
                  $response['purchase']=$purchase;
                  $response['total_cards']="$total_cards";
                  $response['deck_cards']="$revised_cards";
	              $response['total_purchases']="$total_purchases";
	               if($average_rating>0){
	              $response['average_rating']="$average_rating";
	            }
	            else{
	               $response['average_rating']="0";
	            }
	              
        
            
                  foreach($allchapters as $key=>$value){
                      
                   $deck->chapter_id=$allchapters[$key]['chapter_id'];
                   
                   $deck_percentage=$deck->getDeckPercentage();
                   $first_revision_percentage=$deck->getFirstRevisionPercentage();
                   $second_revision_percentage=$deck->getSecondRevisionPercentage();
                   $third_revision_percentage=$deck->getThirdRevisionPercentage();
                   $fourth_revision_percentage=$deck->getFourthRevisionPercentage();
                   
                  $totalrevisedpercentage=($deck_percentage+$first_revision_percentage+$second_revision_percentage+$third_revision_percentage+$fourth_revision_percentage)/5;
                   $allchapters[$key]["chapter_percentage"]=number_format($totalrevisedpercentage, 2);
                   }
                  $response['chapters'] =$allchapters;
                  $feedback=$courses->getCourseFeedbacks();
			      $response["feedback"]=$feedback;
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
	   