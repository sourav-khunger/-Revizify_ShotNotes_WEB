<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/deck.php';
    include_once '../objects/card.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	include_once '../objects/user.php';
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize token object

	$bearer = new Token();
	$deck = new Deck($db);
	$user = new user($db);
	$card = new card($db);
	// initialize user object
	$deck->jwt =$bearer->getBearerToken();
	$deck->chapter_id=trim($data->chapter_id);
	$deck->revision_type=trim($data->revision_type);


	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($deck->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $user->id = $decoded->data->id;
              if($user->doesUserExist()){
                 $deck->user_id = $decoded->data->id;
                 $card->user_id = $decoded->data->id;
                 if($deck->revision_type==="first_revision")
                 {
                 $stmt=$deck->getFirstRevisionCards();
                 $num = $stmt->rowCount();
                 if($num>0){
                $response['success']=1;                
                 $allremainingcards=$stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($allremainingcards as $key=>$value){
			    $card->card_id=$allremainingcards[$key]['card_id'];
			    $cardsdetails=$card->getCardDetailsByCardID();
			    $cardsdetails["isAnswer"]="false";
			    $response['data'][]=$cardsdetails;
	            }
                }
                else{
                    $response['success']=1; 
                    $response['data']=[];
                }
                 }
                  elseif($deck->revision_type==="second_revision")
                 {
                 $stmt=$deck->getSecondRevisionCards();
                   $num = $stmt->rowCount();
                 if($num>0){
                $response['success']=1; 
                $allremainingcards=$stmt->fetchAll(PDO::FETCH_ASSOC);
                 foreach($allremainingcards as $key=>$value){
			    $card->card_id=$allremainingcards[$key]['card_id'];
			    $cardsdetails=$card->getCardDetailsByCardID();
			    $response['data'][]=$cardsdetails;
	            }
                 }
                 else{
                    $response['success']=1; 
                    $response['data']=[];
                } 
                 }
                  elseif($deck->revision_type==="third_revision")
                 {
                 $stmt=$deck->getThirdRevisionCards();
                    $num = $stmt->rowCount();
                 if($num>0){
                $response['success']=1; 
                $allremainingcards=$stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($allremainingcards as $key=>$value){
			    $card->card_id=$allremainingcards[$key]['card_id'];
			    $cardsdetails=$card->getCardDetailsByCardID();
			    $response['data'][]=$cardsdetails;
	            }
                 }
	             else{
                    $response['success']=1; 
                    $response['data']=[];
                }
                 }
                 elseif($deck->revision_type==="fourth_revision")
                 {
                 $stmt=$deck->getFourthRevisionCards();      
                 $num = $stmt->rowCount();
                 if($num>0){
                $response['success']=1; 
                 $allremainingcards=$stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($allremainingcards as $key=>$value){
			    $card->card_id=$allremainingcards[$key]['card_id'];
			    $cardsdetails=$card->getCardDetailsByCardID();
			    $response['data'][]=$cardsdetails;
	            }
                 }
	             else{
                    $response['success']=1; 
                    $response['data']=[];
                }
                 }
        	} 
        	else{
            $response['success'] = 0;
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}