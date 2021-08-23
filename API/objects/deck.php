<?php

	class Deck{
	    
	
	    	// database connection and table name
		private $conn;
		private $table_courses = "courses";
		private $table_chapter = "course_chapter";
		private $table_user ="user_info";
		private $table_payment ="course_payment";
		private $table_card ="card_info";
	 	private $table_deck ="new_deck";
	 	private $table_bookmark ="bookmark_card";
	 	private $table_rating ="ratings_feedback";
	 	private $table_first_revision ="first_revision";
	 	private $table_second_revision ="second_revision";
	 	private $table_third_revision ="third_revision";
	 	private $table_fourth_revision ="fourth_revision";
	 	private $table_course_feedback ="course_feedback";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}

	   	public function doesCardAlreadyExistInDeck(){
		    $query = "SELECT * FROM ". $this->table_deck ." WHERE card_id='". htmlspecialchars(strip_tags($this->card_id)) ."' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
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
		
	public function resetRevision(){
	    $tables= array($this->table_deck,$this->table_first_revision,$this->table_second_revision,$this->table_third_revision,$this->table_fourth_revision);
	    foreach($tables as $table) {
	        $query = "DELETE FROM $table WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."' AND  chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
	         $stmt = $this->conn->prepare($query);
	         $count=0;
	         $count2=0;
              	if($stmt->execute()){
    			$count++;
              	}
	           else{
	               $count++;
	           }
	    }
	          $response['success'] =1;
		      $response['message'] = "Revision Reset Successfully";  
	    
	    return $response;
	    
	}	
		
		public function addCardToNewDeck(){
		  
		     $query = "INSERT INTO ". $this->table_deck ." SET 
    			    user_id='". htmlspecialchars(addslashes($this->user_id)) ."', 
    			    course_id='". htmlspecialchars(addslashes($this->course_id)) ."', 
    			    card_id='". htmlspecialchars(addslashes($this->card_id)) ."', 
    			    chapter_id='". htmlspecialchars(addslashes($this->chapter_id)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] = "Card added to 1st Revision deck.";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Card Adding Failed to deck";
    			     }
    			     return $response;
		}
		
		
				public function addCardToBookmark(){
		  
		     $query = "INSERT INTO ". $this->table_bookmark ." SET 
    			    user_id='". htmlspecialchars(addslashes($this->user_id)) ."', 
    			    card_id='". htmlspecialchars(addslashes($this->card_id)) ."'"; 
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] = "Card  bookmarked Successfully";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Card bookmarking failed";
    			     }
    			     return $response;
		}
		
				
				public function removeCardFromBookmark(){
		  
		     $query = "DELETE FROM ". $this->table_bookmark ." WHERE
    			    user_id='". htmlspecialchars(strip_tags($this->user_id)) ."' AND
    			    card_id='". htmlspecialchars(strip_tags($this->card_id)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] = "Bookmark removed Successfully";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Bookmark removing failed";
    			     }
    			     return $response;
		}

	    public function updateFirstRevisionCardStatus(){
		  
		     $query = "UPDATE ".$this->table_first_revision." SET status='true' WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'AND card_id='". htmlspecialchars(strip_tags($this->card_id)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] ="Card added to 2nd Revision deck.";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Card Updating Failed";
    			     }
    			     return $response;
		}
	   
	   	    public function updateSecondRevisionCardStatus(){
		  
		     $query = "UPDATE ".$this->table_second_revision." SET status='true' WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'AND card_id='". htmlspecialchars(strip_tags($this->card_id)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] =" Card added to 3rd Revision deck. ";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Card Updating Failed";
    			     }
    			     return $response;
		}
		
			    public function updateThirdRevisionCardStatus(){
		  
		     $query = "UPDATE ".$this->table_third_revision." SET status='true' WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'AND card_id='". htmlspecialchars(strip_tags($this->card_id)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] ="Card added to 4th Revision deck.";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Card Updating Failed";
    			     }
    			     return $response;
		}
			    public function updateFourthRevisionCardStatus(){
		  
		     $query = "UPDATE ".$this->table_fourth_revision." SET status='true' WHERE user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'AND card_id='". htmlspecialchars(strip_tags($this->card_id)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] = " All revisions for this card completed.";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		            // $response['message'] = "Card Updating Failed";
    			     }
    			     return $response;
		}
		
		public function getFirstRevisionCards(){
		  
		     $query = "SELECT card_id FROM ". $this->table_first_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='false' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
		}
		public function getSecondRevisionCards(){
		  
		     $query = "SELECT card_id FROM ". $this->table_second_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='false' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
		}
				public function getThirdRevisionCards(){
		  
		     $query = "SELECT card_id FROM ". $this->table_third_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='false' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
		}
				public function getFourthRevisionCards(){
		  
		     $query = "SELECT card_id FROM ". $this->table_fourth_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='false' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
		}
		
		
		public function getDeckCount(){
		  
		        $query = "SELECT * FROM ". $this->table_card ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    $query1 = "SELECT * FROM ". $this->table_deck ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'  AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			    $response["revised_cards"]=$num1;
			    $response["total_cards"]=$num;
			    return $response;
		}	
		
				public function getFirstRevisionCount(){
		  
		        $query = "SELECT * FROM ". $this->table_first_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='true' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    $query1 = "SELECT * FROM ". $this->table_first_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'  AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			    $response["revised_cards"]=$num;
			    $response["total_cards"]=$num1;
			    return $response;
		}
	   		
	   				public function getSecondRevisionCount(){
		  
		        $query = "SELECT * FROM ". $this->table_second_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='true' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    $query1 = "SELECT * FROM ". $this->table_second_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'  AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			    $response["revised_cards"]=$num;
			    $response["total_cards"]=$num1;
			    return $response;
		} 
		
				public function getThirdRevisionCount(){
		  
		        $query = "SELECT * FROM ". $this->table_third_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='true' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    $query1 = "SELECT * FROM ". $this->table_third_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'  AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			    $response["revised_cards"]=$num;
			    $response["total_cards"]=$num1;
			    return $response;
		}
	  public function getFourthRevisionCount(){
		  
		        $query = "SELECT * FROM ". $this->table_fourth_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='true' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    $query1 = "SELECT * FROM ". $this->table_fourth_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'  AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			    $response["revised_cards"]=$num;
			    $response["total_cards"]=$num1;
			    return $response;
		}
		
		
			public function getDeckPercentage(){
		  
		        $query = "SELECT * FROM ". $this->table_card ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    $query1 = "SELECT * FROM ". $this->table_deck ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'  AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			    $deck_percentage=$num1/max($num, 1)*100;
			    return $deck_percentage;
		}	
		
				public function getFirstRevisionPercentage(){
		  
		        $query = "SELECT * FROM ". $this->table_first_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='true' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			      $query1 = "SELECT * FROM ". $this->table_card ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			   $first_revision_percentage=$num/max($num1, 1)*100;
			    return $first_revision_percentage;
		}
	   		
	   				public function getSecondRevisionPercentage(){
		  
		        $query = "SELECT * FROM ". $this->table_second_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='true' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			          $query1 = "SELECT * FROM ". $this->table_card ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			    $second_revision_percentage=$num/max($num1, 1)*100;
			    return $second_revision_percentage;
		} 
		
				public function getThirdRevisionPercentage(){
		  
		        $query = "SELECT * FROM ". $this->table_third_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='true' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			          $query1 = "SELECT * FROM ". $this->table_card ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
				$third_revision_percentage=$num/max($num1, 1)*100;
			    return $third_revision_percentage;
		}
	  public function getFourthRevisionPercentage(){
		  
		        $query = "SELECT * FROM ". $this->table_fourth_revision ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."' AND status='true' AND user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
    			$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			         $query1 = "SELECT * FROM ". $this->table_card ." WHERE chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			$stmt1 = $this->conn->prepare($query1);
			    $stmt1->execute();
			    $num1 = $stmt1->rowCount();
			    $fourth_revision_percentage=$num/max($num1, 1)*100;
			    return $fourth_revision_percentage;
		}
		
		
			public function saveUserFeedback(){
		  
		     $query = "INSERT INTO ". $this->table_rating ." SET 
    			    feedback_to_user_id='". htmlspecialchars(addslashes($this->feedback_to_user_id)) ."', 
    			    feedback_by_user_id='". htmlspecialchars(addslashes($this->feedback_by_user_id)) ."', 
    			    feedback_message='". htmlspecialchars(addslashes($this->feedback_message)) ."', 
    			    feedback_rating='". htmlspecialchars(addslashes($this->feedback_rating)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] = "Feedback submited Successfully";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Feedback submission failed";
    			     }
    			     return $response;
		}	
		
				
			public function saveCourseFeedback(){
		  
		     $query = "INSERT INTO ". $this->table_course_feedback ." SET 
		            feedback_course_id='". htmlspecialchars(addslashes($this->feedback_course_id)) ."', 
    			    feedback_to_user_id='". htmlspecialchars(addslashes($this->feedback_to_user_id)) ."', 
    			    feedback_by_user_id='". htmlspecialchars(addslashes($this->feedback_by_user_id)) ."', 
    			    feedback_message='". htmlspecialchars(addslashes($this->feedback_message)) ."', 
    			    feedback_rating='". htmlspecialchars(addslashes($this->feedback_rating)) ."'";
    			     $stmt = $this->conn->prepare($query);
    			    
    			     if( $stmt->execute()){
    	
    			       $response['success'] =1;
		               $response['message'] = "Feedback submited Successfully";
    			     }
    			     else{
    			           
    			     $response['success'] =0;
		             $response['message'] = "Feedback submission failed";
    			     }
    			     return $response;
		}
		
	}