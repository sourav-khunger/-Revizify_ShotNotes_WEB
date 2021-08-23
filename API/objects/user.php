<?php
require_once '../config/core.php';
use \Firebase\JWT\JWT;

	class user{

		// database connection and table name
		private $conn;
		private $table_user = "user_info";
		private $table_rating = "ratings_feedback";
		private $table_token = "token";
		private $table_bank = "user_bank_account_details";
		
	 
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}
		
		
		public function doesUserExist(){
		    
		      $query = "SELECT * FROM ". $this->table_user ." WHERE id='". htmlspecialchars(addslashes($this->id)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
		if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
				
		}
	    public function getUserAverageRatingbyID(){
	        $query = " SELECT AVG(feedback_rating) FROM ". $this->table_rating ." WHERE feedback_to_user_id='". htmlspecialchars(addslashes($this->id)) ."'";
                $stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $average_rating = $stmt->fetch(PDO::FETCH_ASSOC);
			    $average_rating=$average_rating['AVG(feedback_rating)'];
			    return $average_rating;
	        
	        
	    }
		public function doesEmailExist(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE email='". htmlspecialchars(addslashes($this->email)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
			public function doesPhoneNumberExist(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE phone_number='". htmlspecialchars(addslashes($this->phone_number)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		
		public function doesCurrentPasswordMatch(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE password='". $this->password ."' AND id=". $this->id;
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		
		public function doesEmailExistExceptId(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE email='". htmlspecialchars(strip_tags($this->email)) ."' AND id != '". htmlspecialchars(strip_tags($this->id)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		

		
		public function doesuserIdExist(){
		    $query = "SELECT * FROM ".$this->table_user." WHERE id='". htmlspecialchars(strip_tags($this->user_id)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		
		public function doesBankAccountExist(){
		    $query = "SELECT * FROM ".$this->table_bank." WHERE account_number='". htmlspecialchars(strip_tags($this->account_number)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		
	public function getUserBankDetails(){
		    $query = "SELECT * FROM ". $this->table_bank." WHERE   user_id='". htmlspecialchars(strip_tags($this->id)) ."'";;
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    		return $stmt;
		}
		
		public function updateBankAccount(){
		     $query="UPDATE ". $this->table_bank ." SET 
    			    account_number='".$this->account_number ."', 
    			    account_ifsc_code='". $this->ifsc_code ."',
    			    account_holder_name='".$this->account_holder_name ."', 
    			     bank_name='". $this->bank_name."' WHERE   user_id='". htmlspecialchars(strip_tags($this->id)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			     if($stmt->execute())
    			     {
    			     $response['success'] = 1;
    			     $response['message'] = "Bank Account updated successfully.";
    			     }
    			     else
    			     {
    			     $response['success'] = 0;
    			     $response['message'] = $stmt->errorInfo();
    			     }
    			     return $response;
		}
		
		
	public function saveBankAccount(){
	     $OK = true;
		    
		    if($this->doesBankAccountExist()){
		        $OK = false;
		        $error = "Account number already exist.";
		    }
		    
		    
		    if($OK){
		        
		        $query="INSERT INTO ". $this->table_bank ." SET 
		        user_id='". $this->id ."', 
    			    account_number='". $this->account_number ."', 
    			    account_ifsc_code='". $this->ifsc_code ."', 
    			    account_holder_name='". $this->account_holder_name ."', 
    			     bank_name='". $this->bank_name ."'";
    			     $stmt = $this->conn->prepare($query);
    			     if($stmt->execute())
    			     {
    			     $response['success'] = 1;
    			     $response['message'] = "Bank Account added successfully.";
    			     }
    			     else
    			     {
    			     $response['success'] = 0;
    			     $response['message'] = $stmt->errorInfo();
    			     }
		        
		    }
		    else
		    {
		         $response['success'] = 0;
    			$response['message'] = $error;
		    }
		    return $response;
	}
		
		public function register(){
		    
		    global $iss;
		    global $aud;
		    global $iat;
		    global $nbf;
		    global $key;
		    $OK = true;
		    
		    if($this->doesEmailExist()){
		        $OK = false;
		        $error = "user email already exists.";
		    }
		    elseif($this->doesPhoneNumberExist()){
		        $OK = false;
		        $error = "user Phone Number already exists.";
		    }
		    
		    
		    if($OK){
    		    // query to insert record
    			  $query1 = "INSERT INTO ". $this->table_user ." SET 
    			    name='".$this->name."', 
    			    email='".$this->email ."', 
    			     user_type='".$this->user_type ."', 
    			    password='".$this->password ."',
    			    phone_number='".$this->phone_number ."'"; 
    			     $stmt2 = $this->conn->prepare($query1);
    			     $stmt2->execute();
    			// query to insert record
    		
    		  $query2 = "INSERT INTO ". $this->table_token ." SET
    			    push_token='".$this->push_token ."', 
    			    device_id='". $this->device_id ."'";
    			    $stmt1 = $this->conn->prepare($query2);
    			    $stmt1->execute();
    			    
    			    
    			    $query3 = "SELECT * FROM ". $this->table_user ." WHERE email='". htmlspecialchars(strip_tags($this->email)) ."'";
    			// prepare query statement
    			$stmt= $this->conn->prepare($query3);
    		
    			// execute query
    			if($stmt->execute()){
    			    	 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    			     /* JWT Token Starts Here */
	              	$token = array(
		                        "iss" => $iss,
		                        "aud" => $aud,
		                        "iat" => $iat,
		                        "nbf" => $nbf,
		                        "data" => array(
			                                    "id" =>$user_data[id],
			                                    "user_type"=>   $user_data[user_type]
		                                        )
	                                        	);
		                                //print_r($token);
		                                // generate jwt
		                        $jwt = JWT::encode($token, $key);
		/* JWT Token Ends Here */
	
    				$response['success'] = 1;
    				$response['message'] = "user registered successfully.";
    				$response['id']=$user_data[id];
    				$response['name']=$user_data[name];
    				$response['email'] = $user_data[email];
    				$response['phone_number'] = $user_data[phone_number];
    				$response['jwt'] = $jwt;
    			
    			}else{
    			//	print_r($stmt->errorInfo());
    		
    				$response['success'] = 0;
    			    $response['message'] = $stmt->errorInfo();
    			    $response['id'] = "";
    			    $response['name'] = "";
    				$response['email'] = "";
    				$response['phone_number'] = "";
    				$response['jwt'] = "";
    			}
		    }else{
		        $response['success'] = 0;
    			$response['message'] = $error;
    			$response['id'] = "";
    			$response['name'] = "";
    			$response['email'] = "";
    			$response['phone_number'] = "";
    			$response['jwt'] = "";
		    }
		    
			
			return $response;
		}
		
		public function login(){
		    $OK = true;
		    
		    if(!$this->doesEmailExist()){
		        $OK = false;
		        $error = "This email address is not associated with any account.";
		    }
		    
		    if($OK){
		         $query2 = "INSERT INTO ". $this->table_token ." SET
    			    push_token='".$this->push_token ."', 
    			    device_id='". $this->device_id ."'";
    			    $stmt1 = $this->conn->prepare($query2);
    			    $stmt1->execute();
    		    $query = "SELECT * FROM ". $this->table_user ." WHERE email='". htmlspecialchars(strip_tags($this->email)) ."' AND password='". htmlspecialchars(strip_tags($this->password)) ."'";
    			// prepare query statement
    			$stmt = $this->conn->prepare($query);
    
    			$stmt->execute();
    			$num = $stmt->rowCount();
    			if($num > 0){
    			    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    				$response['success'] = 1;
    		    	$response['message'] = "Successfully logged in.";
					$response['id'] = $user_data[id];
					$response['name'] = $user_data[name];
			        $response['email'] = $user_data[email];
			        $response['phone_number'] = $user_data[phone_number];
			        
    			}else{
    				$response['success'] = 0;
    			    $response['message'] = "Password do not match.";
    			    $response['id'] ="";
    			    $response['name']="";
			        $response['email'] ="";
			        $response['phone_number'] = "";
    			}
		    }else{
		        $response['success'] = 0;
    			$response['message'] = $error;
    			$response['id'] ="";
    			$response['name']="";
			    $response['email'] ="";
			    $response['phone_number'] = "";
		    }
			
			return $response;
		}
		
		
		
		public function getAllusers(){
		    $query = "SELECT * FROM ". $this->table_user;
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    		return $stmt;
		}
		public function getuserDetails(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE id='". $this->id ."'";
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    		$stmt->execute();
    		return $stmt;
		}

	     public function getUserFeedbacks(){
	         
	         $query = "SELECT user.name, rating.feedback_id, rating.feedback_message, rating.feedback_rating, rating.feedback_time FROM ". $this->table_rating ." as rating, ". $this->table_user ." as user WHERE rating.feedback_to_user_id='". $this->id ."' AND rating.feedback_by_user_id=user.id";
	         $stmt = $this->conn->prepare($query);
    	     $stmt->execute();
             $feedbackuid= $stmt->fetchAll(PDO::FETCH_ASSOC);
    	     return $feedbackuid;
	     }
	     
	     
	     
		public function getuserDetailsById(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE id='". $this->id ."'";
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    		$stmt->execute();
    			$num = $stmt->rowCount();
    			if($num > 0){
    			    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    				$response['success'] = 1;
    		    	$response['message'] = "Profile Updated Successfully.";
					$response['id'] = $user_data[id];
					$response['name'] = $user_data[name];
			        $response['email'] = $user_data[email];
			        $response['phone_number'] = $user_data[phone_number];
			         $response['bio'] = $user_data[bio];
			        
    			}else{
    				$response['success'] = 0;
    			    $response['message'] = "Password do not match.";
    			    $response['id'] ="";
					$response['name'] = "";
			        $response['email'] ="";
			        $response['phone_number'] ="";
			         $response['bio'] = "";
    			}
    			return $response;
		}
			public function getuserDataById(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE id='". $this->id ."'";
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    		$stmt->execute();
    			$num = $stmt->rowCount();
    			if($num > 0){
    			    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    		      	return $user_data;
			        
    			}else{
    				return false;
    			}
    			return false;
		}
			
		
		public function getuserStatusById(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE id='". $this->id ."'";
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    		$stmt->execute();
    		$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    		$response['success'] = 1;
    		$response['status'] = $user_data[Status];
    		if($user_data[Status]==1)
    		{
    		   $response['message'] = "User Online"; 
    		}
    		else{
    		$response['message'] = "User Ofline ";
    		}
    		return $response;
		}
		

		
		public function updatePassword(){
		    $query = "UPDATE ". $this->table_user ." SET password = '". $this->password ."' WHERE id = '". $this->id ."'";
		    $stmt = $this->conn->prepare($query);
		    if($stmt->execute()){
				return true;
			}else{
				return false;
				//print_r($stmt->errorInfo());
			}
		}
			
		public function updateImage(){
		    $query = "UPDATE ". $this->table_user ." SET profile_photo = '". $this->url ."' WHERE id = '". $this->id ."'";
		    $stmt = $this->conn->prepare($query);
		     $stmt->execute();
			}
		public function updateUserDetails(){
		    $query = "UPDATE ". $this->table_user ." SET name = '". $this->name ."',email = '". $this->email ."',bio = '". $this->bio ."',phone_number = '". $this->phone_number ."' WHERE id = '". $this->id ."'";
		    $stmt = $this->conn->prepare($query);
		      if($stmt->execute()){
				return true;
			}else{
				return false;
				//print_r($stmt->errorInfo());
			}

			}
			
		
		public function updatePasswordWithEmail(){
		    $query = "UPDATE ". $this->table_user ." SET password = '". $this->password ."' WHERE email = '". $this->email ."'";
		    $stmt = $this->conn->prepare($query);
		    if($stmt->execute()){
				return true;
			}else{
				return false;
				//print_r($stmt->errorInfo());
			}
		}
		
		public function deletePushToken(){
		    $query  = "DELETE  FROM ". $this->table_token ." WHERE device_id='". $this->device_id ."'";
		    $stmt = $this->conn->prepare($query);
		    if($stmt->execute()){
		        $response['success'] = 1;
    			$response['message'] = "You have successfully logged out.";
			}else{
				$response['success'] = 0;
    			$response['message'] = "Error Logging out.";
				//print_r($stmt->errorInfo());
			}
			
			return $response;
		}
		
     /* -------------Social Regsiter & Login API's--------------------------  */



        public function doesAppleIdExist(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE aid='". htmlspecialchars(addslashes($this->aid)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		
		
		
		public function doesFacebookIdExist(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE fid='". htmlspecialchars(addslashes($this->fid)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
        
        
        
            
        public function doesGoogleIdExist(){
		    $query = "SELECT * FROM ". $this->table_user ." WHERE gid='". htmlspecialchars(addslashes($this->gid)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}



		public function registerApple(){
		    
		    global $iss;
		    global $aud;
		    global $iat;
		    global $nbf;
		    global $key;
		    $OK = true;
		    
		    if($this->doesAppleIdExist()){
		        $OK = false;
		        $error = "user already exists.";
		    }
   
		    if($OK){
    		    // query to insert record
    			   $query1 = "INSERT INTO ". $this->table_user ." SET 
    			    aid='". $this->aid ."', 
    			    name='". $this->name ."',
    			    profile_photo='". $this->profile_photo ."',
    			    user_type='".$this->user_type ."', 
    			    email='". $this->email ."'";

    			   
    			     $stmt2 = $this->conn->prepare($query1);
    			     $stmt2->execute();
    			// query to insert record
    		
    		  $query2 = "INSERT INTO ". $this->table_token ." SET
    			    push_token='".$this->push_token ."', 
    			    device_id='". $this->device_id ."'";
    			    $stmt1 = $this->conn->prepare($query2);
    			    $stmt1->execute();
    			    
    			    
    			    $query3 = "SELECT * FROM ". $this->table_user ." WHERE aid='". htmlspecialchars(addslashes($this->aid)) ."'";
    			// prepare query statement
    			$stmt= $this->conn->prepare($query3);
    		
    			// execute query
    			if($stmt->execute()){
    			    	 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    			     /* JWT Token Starts Here */
	              	$token = array(
		                        "iss" => $iss,
		                        "aud" => $aud,
		                        "iat" => $iat,
		                        "nbf" => $nbf,
		                        "data" => array(
			                                    "id" =>$user_data[id],
			                                    "user_type"=>$user_data[user_type]
		                                        )
	                                        	);
		                                //print_r($token);
		                                // generate jwt
		                        $jwt = JWT::encode($token, $key);
		/* JWT Token Ends Here */
	
    				$response['success'] = 1;
    				$response['message'] = "user registered successfully.";
    				$response['id']=$user_data[id];
    				$response['name']=$user_data[name];
    				$response['email'] = $user_data[email];
    				$response['phone_number'] = $user_data[phone_number];
    				$response['profile_photo'] = $user_data[profile_photo];
    				$response['jwt'] = $jwt;
    			
    			}else{
    			//	print_r($stmt->errorInfo());
    		
    				$response['success'] = 0;
    			    $response['message'] = $stmt->errorInfo();
    			    $response['id'] = "";
    			    $response['name'] = "";
    				$response['email'] = "";
    				$response['phone_number'] = "";
    				$response['profile_photo'] ="";
    				$response['jwt'] = "";
    			}
		    }else{
		            		// query to insert record
    		
    		  $query2 = "INSERT INTO ". $this->table_token ." SET
    			    push_token='". $this->push_token ."', 
    			    device_id='".$this->device_id ."'";
    			    $stmt1 = $this->conn->prepare($query2);
    			    $stmt1->execute();
		           $query3 = "SELECT * FROM ". $this->table_user ." WHERE aid='". htmlspecialchars(strip_tags($this->aid)) ."'";
    			// prepare query statement
    			$stmt= $this->conn->prepare($query3);
    		
    			// execute query
    			if($stmt->execute()){
    			    	 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    			     /* JWT Token Starts Here */
	              	$token = array(
		                        "iss" => $iss,
		                        "aud" => $aud,
		                        "iat" => $iat,
		                        "nbf" => $nbf,
		                        "data" => array(
			                                    "id" =>$user_data[id],
			                                    "user_type"=>$user_data[user_type]
		                                        )
	                                        	);
		                                //print_r($token);
		                                // generate jwt
		                        $jwt = JWT::encode($token, $key);
		/* JWT Token Ends Here */
	
    				$response['success'] = 1;
    				$response['message'] = "logged in successfully.";
    				$response['id']=$user_data[id];
    				$response['name']=$user_data[name];
    				$response['email'] = $user_data[email];
    				$response['phone_number'] = $user_data[phone_number];
    				$response['profile_photo'] = $user_data[profile_photo];
    				$response['jwt'] = $jwt;
    			
    			}
		    }
		    
			
			return $response;
		}
		
			public function registerFacebook(){
		    
		    global $iss;
		    global $aud;
		    global $iat;
		    global $nbf;
		    global $key;
		    $OK = true;
		    
		    if($this->doesFacebookIdExist()){
		        $OK = false;
		        $error = "user already exists.";
		    }
   
		    if($OK){
    		    // query to insert record
    			   $query1 = "INSERT INTO ". $this->table_user ." SET 
    			    fid='". $this->fid ."', 
    			    name='". $this->name ."',
    			    profile_photo='".$this->profile_photo ."',
    			    user_type='". $this->user_type ."', 
    			    email='".$this->email ."'";

    			   
    			     $stmt2 = $this->conn->prepare($query1);
    			     $stmt2->execute();
    			// query to insert record
    		
    		  $query2 = "INSERT INTO ". $this->table_token ." SET
    			    push_token='". $this->push_token ."', 
    			    device_id='".$this->device_id ."'";
    			    $stmt1 = $this->conn->prepare($query2);
    			    $stmt1->execute();
    			    
    			    
    			    $query3 = "SELECT * FROM ". $this->table_user ." WHERE fid='". htmlspecialchars(strip_tags($this->fid)) ."'";
    			// prepare query statement
    			$stmt= $this->conn->prepare($query3);
    		
    			// execute query
    			if($stmt->execute()){
    			    	 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    			     /* JWT Token Starts Here */
	              	$token = array(
		                        "iss" => $iss,
		                        "aud" => $aud,
		                        "iat" => $iat,
		                        "nbf" => $nbf,
		                        "data" => array(
			                                    "id" =>$user_data[id],
			                                    "user_type"=>$user_data[user_type]
		                                        )
	                                        	);
		                                //print_r($token);
		                                // generate jwt
		                        $jwt = JWT::encode($token, $key);
		/* JWT Token Ends Here */
	
    				$response['success'] = 1;
    				$response['message'] = "user registered successfully.";
    				$response['id']=$user_data[id];
    				$response['name']=$user_data[name];
    				$response['email'] = $user_data[email];
    				$response['phone_number'] = $user_data[phone_number];
    				$response['profile_photo'] = $user_data[profile_photo];
    				$response['jwt'] = $jwt;
    			
    			}else{
    			//	print_r($stmt->errorInfo());
    		
    				$response['success'] = 0;
    			    $response['message'] = $stmt->errorInfo();
    			    $response['id'] = "";
    			    $response['name'] = "";
    				$response['email'] = "";
    				$response['phone_number'] = "";
    				$response['profile_photo'] ="";
    				$response['jwt'] = "";
    			}
		    }else{
		        		// query to insert record
    		
    		  $query2 = "INSERT INTO ". $this->table_token ." SET
    			    push_token='".$this->push_token ."', 
    			    device_id='". $this->device_id ."'";
    			    $stmt1 = $this->conn->prepare($query2);
    			    $stmt1->execute();
		            
		           $query3 = "SELECT * FROM ". $this->table_user ." WHERE fid='". htmlspecialchars(strip_tags($this->fid)) ."'";
    			// prepare query statement
    			$stmt= $this->conn->prepare($query3);
    		
    			// execute query
    			if($stmt->execute()){
    			    	 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    			     /* JWT Token Starts Here */
	              	$token = array(
		                        "iss" => $iss,
		                        "aud" => $aud,
		                        "iat" => $iat,
		                        "nbf" => $nbf,
		                        "data" => array(
			                                    "id" =>$user_data[id],
			                                    "user_type"=>$user_data[user_type]
		                                        )
	                                        	);
		                                //print_r($token);
		                                // generate jwt
		                        $jwt = JWT::encode($token, $key);
		/* JWT Token Ends Here */
	
    				$response['success'] = 1;
    				$response['message'] = "logged in successfully.";
    				$response['id']=$user_data[id];
    				$response['name']=$user_data[name];
    				$response['email'] = $user_data[email];
    				$response['phone_number'] = $user_data[phone_number];
    				$response['profile_photo'] = $user_data[profile_photo];
    				$response['jwt'] = $jwt;
    			
    			}
		    }
		    
			
			return $response;
		}
			public function registerGoogle(){
		    
		    global $iss;
		    global $aud;
		    global $iat;
		    global $nbf;
		    global $key;
		    $OK = true;
		    
		    if($this->doesGoogleIdExist()){
		        $OK = false;
		        $error = "user already exists.";
		    }
   
		    if($OK){
    		    // query to insert record
    			   $query1 = "INSERT INTO ". $this->table_user ." SET 
    			    gid='".$this->gid ."', 
    			    name='".$this->name ."',
    			    profile_photo='".$this->profile_photo ."',
    			    user_type='". $this->user_type ."', 
    			    email='".$this->email ."'";

    			   
    			     $stmt2 = $this->conn->prepare($query1);
    			     $stmt2->execute();
    			// query to insert record
    		
    		  $query2 = "INSERT INTO ". $this->table_token ." SET
    			    push_token='". $this->push_token ."', 
    			    device_id='".$this->device_id."'";
    			    $stmt1 = $this->conn->prepare($query2);
    			    $stmt1->execute();
    			    
    			    
    			    $query3 = "SELECT * FROM ". $this->table_user ." WHERE gid='". htmlspecialchars(strip_tags($this->gid)) ."'";
    			// prepare query statement
    			$stmt= $this->conn->prepare($query3);
    		
    			// execute query
    			if($stmt->execute()){
    			    	 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    			     /* JWT Token Starts Here */
	              	$token = array(
		                        "iss" => $iss,
		                        "aud" => $aud,
		                        "iat" => $iat,
		                        "nbf" => $nbf,
		                        "data" => array(
			                                    "id" =>$user_data[id],
			                                    "user_type"=>$user_data[user_type]
		                                        )
	                                        	);
		                                //print_r($token);
		                                // generate jwt
		                        $jwt = JWT::encode($token, $key);
		/* JWT Token Ends Here */
	
    				$response['success'] = 1;
    				$response['message'] = "user registered successfully.";
    				$response['id']=$user_data[id];
    				$response['name']=$user_data[name];
    				$response['email'] = $user_data[email];
    				$response['phone_number'] = $user_data[phone_number];
    				$response['profile_photo'] = $user_data[profile_photo];
    				$response['jwt'] = $jwt;
    			
    			}else{
    			//	print_r($stmt->errorInfo());
    		
    				$response['success'] = 0;
    			    $response['message'] = $stmt->errorInfo();
    			    $response['id'] = "";
    			    $response['name'] = "";
    				$response['email'] = "";
    				$response['phone_number'] = "";
    				$response['profile_photo'] ="";
    				$response['jwt'] = "";
    			}
		    }else{
		        		// query to insert record
    		
    		  $query2 = "INSERT INTO ". $this->table_token ." SET
    			    push_token='". $this->push_token ."', 
    			    device_id='". $this->device_id ."'";
    			    $stmt1 = $this->conn->prepare($query2);
    			    $stmt1->execute();
		            
		           $query3 = "SELECT * FROM ". $this->table_user ." WHERE gid='". htmlspecialchars(strip_tags($this->gid)) ."'";
    			// prepare query statement
    			$stmt= $this->conn->prepare($query3);
    		
    			// execute query
    			if($stmt->execute()){
    			    	 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    			     /* JWT Token Starts Here */
	              	$token = array(
		                        "iss" => $iss,
		                        "aud" => $aud,
		                        "iat" => $iat,
		                        "nbf" => $nbf,
		                        "data" => array(
			                                    "id" =>$user_data[id],
			                                    "user_type"=>$user_data[user_type]
		                                        )
	                                        	);
		                                //print_r($token);
		                                // generate jwt
		                        $jwt = JWT::encode($token, $key);
		/* JWT Token Ends Here */
	
    				$response['success'] = 1;
    				$response['message'] = "logged in successfully.";
    				$response['id']=$user_data[id];
    				$response['name']=$user_data[name];
    				$response['email'] = $user_data[email];
    				$response['phone_number'] = $user_data[phone_number];
    				$response['profile_photo'] = $user_data[profile_photo];
    				$response['jwt'] = $jwt;
    			
    			}
		    }
		    
			
			return $response;
		}
	}
?>