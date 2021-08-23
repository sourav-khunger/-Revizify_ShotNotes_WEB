<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
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
	
	// initialize user object
	$user = new user($db);
	$user->jwt =$bearer->getBearerToken();
	$user->id=trim($data->id);
	$user->photo= trim($data->profile_photo);
	$user->photo=base64_decode($user->photo);


	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($user->jwt, $key, array('HS256'));
        //print_r($decoded);
        
        $isAuthenticated = false;
        
        if($decoded->data->id == $user->id){
            $isAuthenticated = true;
        }
        
       if($isAuthenticated){
    	    $user->id = $decoded->data->id;
    	    $t=time();
              if($user->photo){
            	$add = $t."user-". $user->id ."-image.png";
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/user_profile_photo/". $add;
                 $flag= file_put_contents($target_dir,$user->photo);
                 $user->url=$baseurl."/API/uploads/user_profile_photo/". $add;
                 $response=$user->updateImage();
                 $response['success'] =1;
                 $response['url'] =$user->url;
		         $response['message'] = "Profile Updated Successfully";
        	} 
        	else{
        	 $response['success'] = 0;
        	 $response['url'] ="";
		    $response['message'] = "Error Updating File";
        	}
		
        }else{
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