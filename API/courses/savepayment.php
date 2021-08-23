<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/payment.php';
	include_once '../objects/courses.php';
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
	$payment = new payment($db);
	$courses = new courses($db);
	$user = new user($db);
	// initialize user object
	$payment->jwt =$bearer->getBearerToken();
	$payment->course_id=trim($data->course_id);
    $payment->payment_id= trim($data->payment_id);


	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($payment->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $user->id = $decoded->data->id;
            $stmt=$user->getuserDetails();
            $purchased_by=$stmt->fetch(PDO::FETCH_ASSOC);
            $payment->purchased_by=$purchased_by["name"];
              if($user->doesUserExist()){
                  $payment->user_id = $decoded->data->id;
                  $courses->course_id=trim($data->course_id);
                  $course_data=$courses->getCourseByID();
                  $user->id=$course_data["user_id"];
                  $stmt=$user->getuserDetails();
                  $created_by=$stmt->fetch(PDO::FETCH_ASSOC);
                  $payment->created_by=$created_by["name"];
                  $admin_commision=$payment->getAdminCommision();
                  $admin_commision=$admin_commision['commission'];
                  $payment->commission=$course_data[course_price]/100*$admin_commision;
                  $payment->course_price=$course_data[course_price]-$payment->commission;
                  $response=$payment->savePayemnt();
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