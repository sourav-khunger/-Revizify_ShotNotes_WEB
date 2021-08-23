<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/user.php';
	include_once '../vendor/autoload.php';
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input")); 
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	// initialize object
	$user = new user($db);
	$user->push_token = trim($data->push_token);
    $user->device_id = trim($data->device_id);
    
    $user->user_type=trim($data->user_type);
    if($user->user_type=='apple')
	{
	 $user->aid= trim($data->id);
	 $user->name= trim($data->name);
	 $user->email= trim($data->email);
	 $user->profile_photo= trim($data->profile_photo);
	 $response = $user->registerApple();
    }
    
    elseif($user->user_type=='google')
	{
	    $user->gid= trim($data->id);
	    $user->name= trim($data->name);
	   $user->email= trim($data->email);
	   $user->profile_photo= trim($data->profile_photo);
	    $response = $user->registerGoogle();
	}
	elseif($user->user_type=='facebook')
	{
	    $user->fid= trim($data->id);
	    $user->name= trim($data->name);
	   $user->email= trim($data->email);
	   $user->profile_photo= trim($data->profile_photo);
	    $response = $user->registerFacebook();
	}
        
  else {
      	$user->email = trim($data->email);
        $user->password = trim($data->password);
    	$user->password = md5($user->password);
	    $response = $user->login();
	    if($response['success'] == "1"){
		    $user->id = $response['id'];
	    
	    $token="";
	    /* JWT Token Starts Here */
		$token = array(
		   "iss" => $iss,
		   "aud" => $aud,
		   "iat" => $iat,
		   "nbf" => $nbf,
		   "data" => array(
			                "id" =>$response['id'],
			                "name" =>$response['name'],
			                "email" => $response['email'],
			                "phone_number" => $response['phone_number'],
			                "user_type"=>$response['user_type']
		                      )
	                         );
	        
	    }
		//print_r($token);
		// generate jwt
		$jwt = JWT::encode($token, $key);
		/* JWT Token Ends Here */
		$response['jwt'] = $jwt;
	    
    }
	    
	echo json_encode($response);
?>