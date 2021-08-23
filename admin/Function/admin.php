<?php
	class Admin{
	 
		// database connection and table name
		private $conn;
		private $table_courses = "courses";
		private $table_admin = "admin_info";
		private $table_chapter = "course_chapter";
		private $table_card = "card_info";
		private $table_user ="user_info";
		private $table_payment ="course_payment";
		private $table_wallet ="user_wallet";
		private $table_paid ="paid_payments";
		private $table_bank ="user_bank_account_details";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}
		
		public function updateExploreStatus(){
		   	$query = "UPDATE ". $this->table_courses ." SET explore_status ='". htmlspecialchars(strip_tags($this->status)) ."' WHERE course_id= '". $this->course_id ."'";
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
		
			public function requestPayment(){
			  $query="SELECT user.* , payment.* FROM ". $this->table_wallet ." as payment,  ". $this->table_user ." as user WHERE user.id=payment.user_id AND payment.requested_amount>0";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			     $num = $stmt->rowCount();
			     if($num > 0){
			    $reqpayment=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $reqpayment="empty";
			    }
			    return $reqpayment;
	    }
	    
		
			public function paidPayment(){
			    
	          $query="SELECT user.* , payment.* FROM ". $this->table_paid ." as payment,  ". $this->table_user ." as user WHERE user.id=payment.user_id AND payment.status= 'Paid'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			     $num = $stmt->rowCount();
			     if($num > 0){
			    $paidpayment=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $paidpayment="empty";
			    }
			    return $paidpayment;
	    }
	    
	    
			public function getAllrejectPayment(){
			    
	         $query="SELECT user.* , payment.* FROM ". $this->table_paid ." as payment,  ". $this->table_user ." as user WHERE user.id=payment.user_id AND payment.status= 'Rejected'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			     $num = $stmt->rowCount();
			     if($num > 0){
			    $rejectpayment=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $rejectpayment="empty";
			    }
			    return $rejectpayment;
	    }
	    
		
		public function getAllusers(){
		 $query="SELECT * FROM ". $this->table_user ." ORDER BY name ASC";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			 $num = $stmt->rowCount();
			     if($num > 0){
			    $allCustomer=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $allCustomer="empty";
			    }
			    return $allCustomer;
	    }
	    
	    
		public function filterUser(){
		      $query = "SELECT * FROM ". $this->table_user ." 	WHERE name LIKE '%".$this->search."%' OR phone_number LIKE '%".$this->search."%' OR email LIKE '%".$this->search."%'";

				$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			 $num = $stmt->rowCount();
			     if($num > 0){
			    $all_users=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $all_users="empty";
			    }
			    return $all_users;
	    }
	    
	    	public function filterCourse(){
		      $query = "SELECT user.name, courses.* FROM ". $this->table_user ." as user,". $this->table_courses ." as courses WHERE courses.user_id=user.id AND courses.course_name LIKE '%".$this->search."%'";

				$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			     if($num > 0){
			    $allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $allcourses="empty";
			    }
			    return $allcourses;
	    }
	    
	    
		public function getUserRows(){ 
			 $query = "SELECT * FROM ". $this->table_user;
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			$stmt->execute();
			$total_rows = $stmt->rowCount();
			return $total_rows;
			}
		public function doesEmailExist(){
		    $query = "SELECT * FROM ". $this->table_admin ." WHERE email='". htmlspecialchars(strip_tags($this->email)) ."'";
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
		    $query = "SELECT * FROM ". $this->table_admin ." WHERE password='". $this->password ."' AND id=". $this->id;
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
		
		public function getAdminDataFromEmail(){
			$query = "SELECT * FROM ". $this->table_admin ." WHERE admin_email='". htmlspecialchars(strip_tags($this->email)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);
			
			if($stmt->execute()){
				return $stmt;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		public function getAdminData(){
			$query = "SELECT * FROM $this->table_admin";
			// prepare query statement
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$admin_data = $stmt->fetch(PDO::FETCH_ASSOC);
			return $admin_data;
		}
			public function getAdminDataFromID(){
			$query = "SELECT * FROM ". $this->table_admin ." WHERE id=". $this->id;
			// prepare query statement
			$stmt = $this->conn->prepare($query);
			
			if($stmt->execute()){
				 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
				 $response['user_data'] = $user_data;
				 return $response;
			}else{
				//print_r($stmt->errorInfo());
			}
			return false;
		}
		
		
		public function login(){
		    $OK = true;
		    
		    
		    if($OK){
    		    $query = "SELECT * FROM ". $this->table_admin ." WHERE username='". htmlspecialchars(strip_tags($this->username)) ."' AND password='". $this->password ."'";
    			// prepare query statement
    			$stmt = $this->conn->prepare($query);
    
    			$stmt->execute();
    			$num = $stmt->rowCount();
    			if($num > 0){
    			    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
			        $response['id'] = $user_data[id];
    				$response['status'] = "Success";
    		    	$response['message'] = "Successfully logged in.";
    			}else{
    				$response['status'] = "Failed";
    			    $response['message'] = "Password do not match.";
    			}
		    }else{
		        $response['status'] = "Failed";
    			$response['message'] = $error;
		    }
			
			return $response;
		}
		public function deleteuser(){
		    $query = "DELETE FROM ". $this->table_user ." WHERE id='". htmlspecialchars(strip_tags($this->id)) ."'";
			// prepare query statement
			$stmt = $this->conn->prepare($query);

			if($stmt->execute()){
				$response['status'] = "Success";
				$response['message'] = "User record deleted.";
			}else{
				//print_r($stmt->errorInfo());
				$response['status'] = "Failed";
				$response['message'] = $stmt->errorInfo();
			}
			
			return $response;
		}
		
		public function updatePassword(){
		    $query = "UPDATE ". $this->table_admin ." SET password = '". $this->password ."' WHERE email = '". $this->email ."'";
		    $stmt = $this->conn->prepare($query);
		    if($stmt->execute()){
				return true;
			}else{
				return false;
				//print_r($stmt->errorInfo());
			}
		}
		public function updateCommission(){
		    $query = "UPDATE ". $this->table_admin ." SET commission = '". $this->commission ."'";
		    $stmt = $this->conn->prepare($query);
		    if($stmt->execute()){
				return true;
			}else{
				return false;
				//print_r($stmt->errorInfo());
			}
		}
		
		public function updatePasswordById(){
		    $query = "UPDATE ". $this->table_admin ." SET password = '". $this->password ."' WHERE id = '". $this->id ."'";
		    $stmt = $this->conn->prepare($query);
		    if($stmt->execute()){
				return true;
			}else{
				return false;
				//print_r($stmt->errorInfo());
			}
		}
			public function updateInfoById(){
		    $query = "UPDATE ". $this->table_admin ." SET fname = '". $this->fname ."',lname = '". $this->lname ."',email = '". $this->email ."',Image = '". $this->url ."',username = '". $this->username ."' WHERE id = '". $this->id ."'";
		  	$stmt = $this->conn->prepare($query);
			
			if($stmt->execute()){
				 $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
				 $response['user_data'] = $user_data;
				 return $response;
			}else{
				return false;
				//print_r($stmt->errorInfo());
			}
		}
		
		public function getAllDownloadedCourses(){
		    
		    $query= " SELECT payment.*,courses.course_name,courses.course_type,courses.course_price FROM ".$this->table_courses." as courses, ".$this->table_payment." as payment WHERE payment.course_id= '".$this->course_id."' AND courses.course_id='".$this->course_id."'";
		    $stmt=$this->conn->prepare($query);
		    $stmt->execute();
		    return $stmt;
		}
			public function getAllUserbankDetails(){
		    
		    $query= " SELECT * FROM ".$this->table_bank;
		    $stmt=$this->conn->prepare($query);
		    $stmt->execute();
		    return $stmt;
		}
				
			public function getAllcoursesByuserID(){
	         $query="SELECT user.name, courses.* FROM ". $this->table_user ." as user,". $this->table_courses ." as courses WHERE user.id  ='". htmlspecialchars(strip_tags($this->id)) ."' AND courses.user_id=user.id";
	         $stmt=$this->conn->prepare($query);
	         $stmt->execute();
			 $num = $stmt->rowCount();
			 if($num > 0){
			   $allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			   else{
			        $allcourses="empty";
			   }
			    return $allcourses;
	    }
	    
	    	public function  getAllUsercourses(){
			    
	       // $query = "SELECT * FROM ". $this->table_courses ." WHERE  user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
	         
	         $query="SELECT user.name, courses.* FROM ". $this->table_user ." as user,". $this->table_courses ." as courses WHERE courses.user_id='". htmlspecialchars(strip_tags($this->user_id)) ."' AND user.id='". htmlspecialchars(strip_tags($this->user_id)) ."'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
	    }
	    
	   
	public function getAllcourses(){
			    
	         $query="SELECT user.name, courses.* FROM ". $this->table_user ." as user,". $this->table_courses ." as courses WHERE courses.user_id=user.id". htmlspecialchars(strip_tags($this->offset)) ."";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			     $num = $stmt->rowCount();
			     if($num > 0){
			    $allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $allcourses="empty";
			    }
			    return $allcourses;
	    }
	    
	    	public function getAllCourseChapterByCourseID(){
			    
	       $query = "SELECT courses.course_name , chapter.* FROM ". $this->table_chapter ." as chapter, ". $this->table_courses ." as courses WHERE chapter.course_id = '". htmlspecialchars(strip_tags($this->course_id))."' AND courses.course_id = '". htmlspecialchars(strip_tags($this->course_id))."' ORDER BY chapter_id;";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			  if($num > 0){
			    $allchapter=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $allchapter="empty";
			    }
			    
			   return $allchapter;
	    }
	    	public function getAllCardByChapterID(){
			    
	       $query = "SELECT * FROM ". $this->table_card ." WHERE  chapter_id = '". htmlspecialchars(strip_tags($this->chapter_id)) ."' order by card_id ";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			  if($num > 0){
			    $allcards=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $allcards="empty";
			    }
			    return $allcards;
	    }
	   public function getCourseName(){
	       $query = "SELECT course_name FROM ". $this->table_courses ." WHERE  course_id = '". htmlspecialchars(strip_tags($this->course_id)) ."'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $name=$stmt->fetch(PDO::FETCH_ASSOC);;
			    return $name;
	   }
	   public function getChapterName(){
	       $query = "SELECT chapter_name FROM ". $this->table_chapter ." WHERE  chapter_id = '". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $name=$stmt->fetch(PDO::FETCH_ASSOC);;
			    return $name;
	   }
	        
	  
	    
	    public function totalRows(){
			    
	         
	          $query="SELECT COUNT(*) FROM '". $this->table_user ."'";
	         	$stmt = $this->conn->prepare($query);
	         	$total_rows = mysqli_fetch_array($stmt)[0];
			    $stmt->execute();
			    return $stmt;
	    }
	    
	 public function getUserDataByID(){
			    
	        $query = "SELECT * FROM ". $this->table_user ." WHERE  user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";

	         	$stmt = $this->conn->prepare($query);
	         	if($stmt->execute())
			   {
			   
			       $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
			       return $user_data;
			   }
			   else
			   {
			    return false;   
			   }
	    }   
	    
			public function allusers(){
		    $OK = true;
		    
		    
		    if($OK){
    		    $query = "SELECT * FROM ". $this->table_user;
    			// prepare query statement
    			$stmt = $this->conn->prepare($query);
    
    			$stmt->execute();
    			$num = $stmt->rowCount();
    			if($num > 0){
    			    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
			        $response['data'] = $user_data;
    				$response['status'] = "Success";
    		    	$response['message'] = "Successfully logged in.";
    			}else{
    				$response['status'] = "Failed";
    			    $response['message'] = "Password do not match.";
    			}
		    }else{
		        $response['status'] = "Failed";
    			$response['message'] = $error;
		    }
			
			return $response;
		}
			
			
		public function updatePayment(){
	      $query = "UPDATE ". $this->table_wallet  ." SET requested_amount=requested_amount-'". htmlspecialchars(strip_tags($this->requested_amount)) ."' WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'";  
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


	public function rejectPayment(){
	      $query = " UPDATE ". $this->table_wallet  ." SET requested_amount=requested_amount-'". htmlspecialchars(strip_tags($this->requested_amount)) ."', total_amount=total_amount+'". htmlspecialchars(strip_tags($this->requested_amount)) ."' WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'";  
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
	public function	addEntry(){
	    $query = " INSERT INTO ". $this->table_paid  ." SET user_id='". htmlspecialchars(strip_tags($this->user_id)) ."', amount='". htmlspecialchars(strip_tags($this->requested_amount)) ."', status='". htmlspecialchars(strip_tags($this->status)) ."'";  
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
	
	public function updateUserStatus(){
	    $query="UPDATE ". $this->table_user ." SET Status='". htmlspecialchars(strip_tags($this->status)) ."' WHERE id=".$this->id;
	    $stmt = $this->conn->prepare($query);
			if($stmt->execute())
			{
			    
			    return $data;
			}
			else
			{
			    return false;
			}
	
	}
	public function deleteUserById(){
	    $query="DELETE from ". $this->table_user ." WHERE id='$this->id'";
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

	
	}
?>