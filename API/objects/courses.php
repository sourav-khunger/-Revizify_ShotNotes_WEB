<?php

	class courses{
	    
	
	    	// database connection and table name
		private $conn;
		private $table_courses = "courses";
		private $table_chapter = "course_chapter";
		private $table_user ="user_info";
		private $table_payment ="course_payment";
		private $table_card ="card_info";
	    private $table_course_feedback ="course_feedback";
	 	private $table_deck ="new_deck";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}
	    
	    public function DoesUserDownloadedCourseByCourseID(){
		    //$query = "SELECT * FROM ". $this->table_courses;
		    $query="SELECT * FROM " . $this->table_payment ." WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."' AND course_id ='". htmlspecialchars(strip_tags($this->course_id)) ."'";
		    
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
	
		public function doesCourseExist(){
		    $query = "SELECT * FROM ". $this->table_courses ." WHERE course_name='". htmlspecialchars(strip_tags($this->course_name)) ."' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
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
		
		
		public function getAllchaptersIDByCID(){
		   $query = "SELECT chapter_id FROM ". $this->table_chapter ." WHERE  course_id = '". $this->course_id ."'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
		} 
		
		public function getCourseChapterCount(){
		    $query="SELECT * FROM ". $this->table_chapter ." WHERE course_id='".$this->course_id."'";
		    $stmt=$this->conn->prepare($query);
		    $stmt->execute();
		    $num=$stmt->rowcount();
		    return $num;
		}
		public function getCourseChapterALLCardCount(){
		    $query="SELECT * FROM ". $this->table_card ." WHERE course_id='".$this->course_id."'";
		    $stmt=$this->conn->prepare($query);
		    $stmt->execute();
		    $num=$stmt->rowcount();
		    return $num;
		}
		
		public function savePayemnt(){
		     $OK=true;
	          if($this->doesCourseAlreadyPurchased()){
		        $OK = false;
		        $error = "You have already purchased this course.";
		    }
		   if($OK){ 
		    	  $query = "INSERT INTO ". $this->table_payment ." SET 
    			    user_id='". $this->user_id ."', 
    			    course_id='".$this->course_id ."', 
    			    payment_id='".$this->payment_id ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			    
    			      $response['success'] =1;
		             $response['message'] = "Payment Added Successfully";
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
		
		
		
		public function doesChapterExist(){
		    $query = "SELECT * FROM ". $this->table_chapter ." WHERE chapter_name='". $this->chapter_name ."' AND user_id = '". $this->user_id ."' AND course_id='". $this->course_id ."'";
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
		
			    public function getAllcoursesByID(){
			    
	       // $query = "SELECT * FROM ". $this->table_courses ." WHERE  user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
	         
	         $query="SELECT user.name, courses.* FROM ". $this->table_user ." as user,". $this->table_courses ." as courses WHERE user.id='". $this->user_id ."' AND courses.user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'";
	         

	         
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
	    }
	     public function getAllchaptersByCID()
	     {
	         $query = "SELECT * FROM ". $this->table_chapter ." WHERE  course_id = '". htmlspecialchars(strip_tags($this->course_id)) ."'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
	    }
			public function getAllCourses(){
		    //$query = "SELECT * FROM ". $this->table_courses;
		    $query="SELECT user.name, courses.* FROM ". $this->table_user ."  as user,". $this->table_courses ." as courses WHERE courses.user_id=user.id AND courses.user_id!= '". htmlspecialchars(strip_tags($this->user_id))."' AND course_type!='private'";
		    
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    		return $stmt;
		}
			public function getAllExploreCourses(){
		    $query="SELECT user.name, courses.*  FROM ". $this->table_user ."  as user,". $this->table_courses ." as courses WHERE courses.user_id=user.id AND courses.explore_status='true'";
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    		return $stmt;
		}
		
	    
     	public function getAllUserPurchasedCourses(){
		    //$query = "SELECT * FROM ". $this->table_courses;
		    $query="SELECT  user.name, courses.* FROM " . $this->table_payment ." as payment,". $this->table_user ." as user,". $this->table_courses ." as courses WHERE  user.id=courses.user_id AND payment.user_id='". htmlspecialchars(strip_tags($this->user_id)) ."' AND courses.course_id = payment.course_id";
		    
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    		return $stmt;
		}
		
	    
     	public function getUserPurchasedCourseByCourseID(){
		    //$query = "SELECT * FROM ". $this->table_courses;
		    $query="SELECT  * FROM " . $this->table_payment ."  WHERE  user_id='". htmlspecialchars(strip_tags($this->user_id)) ."' AND course_id='". htmlspecialchars(strip_tags($this->course_id)) ."'";
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    		return $stmt;
		}
	    
	    public function getCourseByID(){
	        
		   $query="SELECT user.name, courses.* FROM ". $this->table_user ." as user,". $this->table_courses ." as courses WHERE courses.user_id=user.id AND course_id = '". htmlspecialchars(strip_tags($this->course_id)) ."'";

		    
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    		$course_data=$stmt->fetch(PDO::FETCH_ASSOC);
    		return $course_data;
		}
	    public function addnNewCourse(){
	        $OK=true;
	          if($this->doesCourseExist()){
		        $OK = false;
		        $error = "You have already created this course with same name.";
		    }
	        
	        	   if($OK){ 
	        	       // query to insert record
    			  $query = "INSERT INTO ". $this->table_courses ." SET 
    			    user_id='". $this->user_id ."', 
    			      course_name='". $this->course_name ."', 
    			     course_desc='".$this->course_desc."', 
    			     course_type='". $this->course_type ."',
    			     course_status='". $this->course_status ."',
    			     domain_sector='".$this->domain_sector ."',
    			     course_price='". $this->course_price ."',
    			    course_img='". $this->url."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute())
    			     {
    			         $query1 = "SELECT * FROM ". $this->table_courses ." WHERE course_name ='". htmlspecialchars(strip_tags($this->course_name)) ."'";
    			         	$stmt1= $this->conn->prepare($query1);
    		
    			    // execute query
    			     $stmt1->execute();
    			     $course_data = $stmt1->fetch(PDO::FETCH_ASSOC);
    			     
                 $response['success'] =1;
                 $response['course_id'] =$course_data[course_id];
		         $response['message'] = "Course Added Successfully";
    			     }
    			     else{
    			         
                 $response['success'] =0;
                 $response['course_id'] ="";
		         $response['message'] = " Adding course failed";
    			     }
	        	}
	        	else{
		        $response['success'] = 0;
    			$response['message'] = $error;
    			$response['course_id'] = "";
		    }
	        return $response;
	    }
	 	    
	   public function updateCourse(){
	       
	        	       // query to insert record
    			  $query = "UPDATE ".  $this->table_courses ." SET 
    			           course_name='". $this->course_name ."', 
    			           course_desc='".$this->course_desc ."', 
    			           course_type='". $this->course_type ."',
    			           course_status='". $this->course_status ."',
    			           course_price='". $this->course_price."',
    			           domain_sector='".$this->domain_sector ."',
    			           course_img='".$this->url."'
    			           WHERE course_id='". $this->course_id ."' AND user_id='".$this->user_id."'";
    			           $stmt = $this->conn->prepare($query);
    			           if($stmt->execute()){
                           $response['success'] =1;
                           $response['course_id'] =$this->course_id;
		                   $response['message'] = "Course Updated Successfully";
    			                 }
    			         else{
    			         
                         $response['success'] =0;
                         $response['course_id'] ="";
		                 $response['message'] = "Course Updating Failed";
    			           }
	       
	        return $response;
	    }
	 
	 	    
	 	    
	 	    
	    public function addnNewChapter(){
	        $OK=true;
	          if($this->doesChapterExist()){
		        $OK = false;
		        $error = "You have already created this chapter with same name.";
		    }
	        
	        	   if($OK){ 
	        	       // query to insert record
    			  $query = "INSERT INTO ". $this->table_chapter ." SET 
    			    user_id='". $this->user_id ."', 
    			    chapter_name='". $this->chapter_name ."', 
    			     chapter_description='". $this->chapter_description ."', 
    			    course_id='".$this->course_id ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute())
    			     {
    			         $query1 = "SELECT * FROM ". $this->table_chapter ." WHERE chapter_name ='". htmlspecialchars(strip_tags($this->chapter_name)) ."'";
    			         	$stmt1= $this->conn->prepare($query1);
    		
    			    // execute query
    			     $stmt1->execute();
    			     $course_data = $stmt1->fetch(PDO::FETCH_ASSOC);
    			     
                 $response['success'] =1;
                 $response['chapter_id'] =$course_data[chapter_id];
		         $response['message'] = "Chapter created Successfully";
    			     }
    			     else{
    			         
                 $response['success'] =0;
                 $response['chapter_id'] ="";
		         $response['message'] = "Chapter creating Failed";
    			     }
	        	}
	        	else{
		        $response['success'] = 0;
    			$response['message'] = $error;
    			$response['chapter_id'] = "";
		    }
	        return $response;
	    }
	    	   public function updateChapter(){
	     
	        	       // query to insert record
    			  $query = "UPDATE ". $this->table_chapter  ." SET 
    			           chapter_name='".$this->chapter_name ."', 
    			           chapter_description='". $this->chapter_description ."'
    			           WHERE course_id='".$this->course_id ."' AND user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'  AND chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			           $stmt = $this->conn->prepare($query);
    			           if($stmt->execute()){
                           $response['success'] =1;
                           $response['chapter_id'] =$this->chapter_id;
		                   $response['message'] = "Chapter Updated Successfully";
    			                 }
    			         else{
    			         
                         $response['success'] =0;
                         $response['chapter_id'] ="";
		                 $response['message'] = "Chapter Updating Failed";
    			           }
	       
	        return $response;
	    }
	   public function getCourseFeedbacks(){
	         
	         $query = "SELECT user.name, rating.feedback_id, rating.feedback_message, rating.feedback_rating, rating.feedback_time FROM ". $this->table_course_feedback ." as rating, ". $this->table_user ." as user WHERE rating.feedback_course_id='". $this->course_id ."' AND rating.feedback_by_user_id=user.id";
	         $stmt = $this->conn->prepare($query);
    	     $stmt->execute();
             $feedback= $stmt->fetchAll(PDO::FETCH_ASSOC);
    	     return $feedback;
	     }
	     
	   public function getRevisedCardByCourseID()
	   {
	         $query = "SELECT * FROM ". $this->table_deck ." WHERE course_id='". htmlspecialchars(strip_tags($this->course_id)) ."'  AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $revised_cards = $stmt->rowCount();
			    return $revised_cards;
	   }
	   
	   	   public function getTotalChapterCardsByChapterID()
	   {	        
	       $query = "SELECT * FROM ". $this->table_card ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $chapter_card = $stmt->rowCount();
			    return $chapter_card;
	   }
	   	   	
	   public function getTotalPurchasesByCourseID()
	   {	        
	       $query = "SELECT * FROM ". $this->table_payment ." WHERE course_id='". htmlspecialchars(strip_tags($this->course_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $total_purchases = $stmt->rowCount();
			    return $total_purchases;
	   }
	  public function getAverageRatingByCourseID()
	 
	  {
	      	    $query = " SELECT AVG(feedback_rating) FROM ". $this->table_course_feedback ." WHERE feedback_course_id='". htmlspecialchars(strip_tags($this->course_id)) ."'";
                $stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $average_rating = $stmt->fetch(PDO::FETCH_ASSOC);
			    $average_rating=$average_rating['AVG(feedback_rating)'];
			    return $average_rating;
	  }
	  public function removeCourseFromDownloads(){
		    //$query = "SELECT * FROM ". $this->table_courses;
		    $query="DELETE FROM " . $this->table_payment ." WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."' AND course_id ='". htmlspecialchars(strip_tags($this->course_id)) ."'";
		    
    		// prepare query statement
    		$stmt = $this->conn->prepare($query);
			if($stmt->execute()){
				return true;
			}else{
				//print_r($stmt->errorInfo());
			}
			return $stmt;
		}
	    
	}