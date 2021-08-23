<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/card.php';
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
	$card = new card($db);
	$user = new user($db);
	// initialize user object
	$card->jwt =$bearer->getBearerToken();
	$card->chapter_id=trim($data->chapter_id);
	
	 try {
        $decoded = JWT::decode($card->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $user->id = $decoded->data->id;
    	    
              if($user->doesUserExist()){
                $card->user_id = $decoded->data->id;
                 $stmt=$card->getAllcardsNameByChapterID();
                 $allcards=$stmt->fetchAll(PDO::FETCH_ASSOC);
                 $response['success'] = 1;
                foreach($allcards as $key=>$value){
			    $card->card_id=$allcards[$key]['card_id'];
			    $cardsdetails=$card->getCardDetailsByCardID();
			    $cardsdetails["isAnswer"]="false";
			  
			     $response['data'][]=$cardsdetails;
	            }
                 
                  //$response['cards'] =$allcards;
              }
              
            	else{
            $response['success'] = 0;
            $response['course_id'] ="";
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
             echo json_encode( $response
		
		);
	 }
	 catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		 $response['url'] ="";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode($response
		);
	}
	   