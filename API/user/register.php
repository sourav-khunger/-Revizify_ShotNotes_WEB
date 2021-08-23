<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/user.php';
	include_once '../vendor/autoload.php';
	
	use \Firebase\JWT\JWT;
	
   // GET DATA FORM JSON
   $data = json_decode(file_get_contents("php://input"));

	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
 
	// initialize object
    $user = new User($db);		
    

	$user->user_type=trim($data->user_type);
	
	if($user->user_type=='apple')
	{
	   $user->aid= trim($data->id);
	   $user->name= trim($data->name);
	   $user->email= trim($data->email);
	   $user->profile_photo= trim($data->profile_photo);
	   $user->push_token = trim($data->push_token);
       $user->device_id = trim($data->device_id);
	   $response = $user->registerApple(); //id email
	}
	elseif($user->user_type=='google')
	{
	   $user->gid= trim($data->id);
	   $user->name= trim($data->name);
	   $user->email= trim($data->email);
	   $user->profile_photo= trim($data->profile_photo);
	   $user->push_token = trim($data->push_token);
       $user->device_id = trim($data->device_id);
	   $response = $user->registerGoogle(); //id email
	}
	elseif($user->user_type=='facebook')
	{
	    $user->fid= trim($data->id);
	    $user->name= trim($data->name);
	    $user->email= trim($data->email);
	    $user->profile_photo= trim($data->profile_photo);
	    $user->push_token = trim($data->push_token);
        $user->device_id = trim($data->device_id);
	    $response = $user->registerFacebook(); //id email
	    
	    
	}
	
	
	else{
	    
	$user->name= trim($data->name);
    $user->email= trim($data->email);
    $user->phone_number = trim($data->phone_number);
    $user->password = trim($data->password);
    $user->password = md5($user->password);
    $user->push_token = trim($data->push_token);
    $user->device_id = trim($data->device_id);
	
	$response = $user->register();
	
	}
	
	
	
	echo json_encode($response);
?>