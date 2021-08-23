<?php

	class payment{
	    
	
	    	// database connection and table name
		private $conn;
		private $table_courses = "courses";
		private $table_admin = "admin_info";
		private $table_chapter = "course_chapter";
		private $table_user ="user_info";
		private $table_payment ="course_payment";
	    private $table_course_feedback ="course_feedback";
	    private $table_wallet ="user_wallet";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}	
		
	     public function getAdminCommision(){
	         $query = "SELECT commission FROM $this->table_admin";
	         $stmt = $this->conn->prepare($query);
	         $stmt->execute();
	         $admin_commision=$stmt->fetch(PDO::FETCH_ASSOC);
    		 return $admin_commision;
	     }
		public function doesCourseAlreadyPurchased(){
		    $query = "SELECT * FROM ". $this->table_payment ." WHERE course_id='". htmlspecialchars(strip_tags($this->course_id)) ."' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
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
		
			public function userExist(){
		    $query = "SELECT * FROM ". $this->table_wallet ." WHERE user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
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
		
			public function saveAmountToWallet(){
			    
			 if($this->userExist()){
			    $query = " UPDATE ". $this->table_wallet  ." SET 
    			    user_id='". htmlspecialchars(addslashes($this->user_id)) ."', 
    			    total_amount=total_amount+'". htmlspecialchars(addslashes($this->course_price)) ."' WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'";  

			 }
			 else{
			   	$query = "INSERT INTO ". $this->table_wallet  ." SET 
    			    user_id='". htmlspecialchars(addslashes($this->user_id)) ."', 
    			    total_amount='". htmlspecialchars(addslashes($this->course_price)) ."'";
			 }
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$num = $stmt->rowCount();
			if($num > 0){
				return $query;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		
		
	public function requestPayemnt(){
	      $query = " UPDATE ". $this->table_wallet  ." SET requested_amount=requested_amount+'". htmlspecialchars(strip_tags($this->requested_amount)) ."', total_amount=total_amount-'". htmlspecialchars(strip_tags($this->requested_amount)) ."' WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'";  
    	    // prepare query statement
			$stmt = $this->conn->prepare($query);
			if($stmt->execute())
			{
			    return true;
			}
			else
			{
			    return false;
			}
	}
		public function updatePayment(){
	      $query = " UPDATE ". $this->table_wallet  ." SET requested_amount=requested_amount-'". htmlspecialchars(strip_tags($this->requested_amount)) ."'WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'";  
    	    // prepare query statement
			$stmt = $this->conn->prepare($query);
			if($stmt->execute())
			{
			    return true;
			}
			else
			{
			    return false;
			}
	}
	
	
		public function savePayemnt(){
		     $OK=true;
	          if($this->doesCourseAlreadyPurchased()){
		        $OK = false;
		        $error = "You have already purchased this course.";
		    }
		   if($OK){ 
		    	  $query = "INSERT INTO ". $this->table_payment ." SET 
    			    user_id='". htmlspecialchars(strip_tags($this->user_id)) ."', admin_commission='". htmlspecialchars(strip_tags($this->commission)) ."',
    			    course_id='". htmlspecialchars(strip_tags($this->course_id)) ."',purchased_by='". htmlspecialchars(strip_tags($this->purchased_by)) ."', created_by='". htmlspecialchars(strip_tags($this->created_by)) ."', 
    			    amount='". htmlspecialchars(strip_tags($this->course_price)) ."',
    			    payment_id='". htmlspecialchars(strip_tags($this->payment_id)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	             if($this->saveAmountToWallet())
    	             {
    			     $response['success'] =1;
    			     $response['message']='Please visit the ‘Downloads’ section to study this course.';
		             //$response['message'] = "Payment Added Successfully";
    	             }
    	             else{
    	             $response['success'] =0;
		             $response['message'] = "Payment Saving Failed into wallet"; }   
    	             }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Payment Added Failed";
    			     }
		   }
    			 else{
    			     $response['success'] =0;
		             $response['message'] = "$error";
    			 }
    			     return $response;
		}
		
	}
		