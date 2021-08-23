<?php

	class card{
	    
	
	    	// database connection and table name
		private $conn;
		private $table_courses = "courses";
		private $table_chapter = "course_chapter";
		private $table_user ="user_info";
		private $table_card ="card_info";
		private $table_answer_image ="card_answer_image";
		private $table_answer_audio ="card_answer_audio";
	    private $table_answer_pdf="card_answer_pdf";
	    private $table_answer_video ="card_answer_video";
	    private $table_question_image ="card_question_image";
		private $table_question_audio ="card_question_audio";
	    private $table_question_pdf="card_question_pdf";		
	    private $table_question_video ="card_question_video";
	 	private $table_deck ="new_deck";	 	
	 	private $table_bookmark ="bookmark_card";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}
	    
	
		public function doesCardExist(){
		    $query = "SELECT * FROM ". $this->table_card ." WHERE card_ques='".$this->card_ques ."'  AND chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
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
		
		
	  public function getAllRemainingCardsByChapterID(){
	      	    $query ="SELECT card.* FROM ".$this->table_card." as card WHERE card.chapter_id='". htmlspecialchars(addslashes($this->chapter_id)) ."' AND  NOT EXISTS (SELECT * FROM ".$this->table_deck." as deck WHERE card.card_id = deck.card_id AND deck.user_id='". htmlspecialchars(strip_tags($this->user_id)) ."')";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
	      
	  }	
		
	     public function getAllcardsNameByChapterID()
	     {
	         $query = "SELECT card_id FROM ". $this->table_card ." WHERE  chapter_id = '". htmlspecialchars(addslashes($this->chapter_id)) ."'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
	    }
		public function getCardDetailsByCardID(){
		    
		   $query1 = "SELECT * FROM ". $this->table_card ." WHERE  card_id='". htmlspecialchars(addslashes($this->card_id)) ."'";
    			     $stmt1= $this->conn->prepare($query1);
    			    // execute query
    			     $stmt1->execute();
    		$card_data = $stmt1->fetch(PDO::FETCH_ASSOC);
    		
    		$query3 = "SELECT * FROM ". $this->table_answer_image ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt3 = $this->conn->prepare($query3);
    		$stmt3->execute();
    		$answer_image_data =$stmt3->fetchAll(PDO::FETCH_ASSOC);
    			     
		    $query2 = "SELECT * FROM ". $this->table_answer_audio ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt2 = $this->conn->prepare($query2);
    		$stmt2->execute();
    		$answer_audio_data =$stmt2->fetchAll(PDO::FETCH_ASSOC);
    		
    		$query8 = "SELECT * FROM ". $this->table_answer_video ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt8 = $this->conn->prepare($query8);
    		$stmt8->execute();
    		$answer_video_data =$stmt8->fetchAll(PDO::FETCH_ASSOC);
    		
    	  	$query4 = "SELECT * FROM ". $this->table_answer_pdf ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt4 = $this->conn->prepare($query4);
    		$stmt4->execute();
    		$answer_pdf_data =$stmt4->fetchAll(PDO::FETCH_ASSOC);
    		
    		$query5 = "SELECT * FROM ". $this->table_question_image ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt5 = $this->conn->prepare($query5);
    		$stmt5->execute();
    		$question_image_data =$stmt5->fetchAll(PDO::FETCH_ASSOC);
    		
    	   $query6 = "SELECT * FROM ". $this->table_question_audio ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt6 = $this->conn->prepare($query6);
    		$stmt6->execute();
    		$question_audio_data =$stmt6->fetchAll(PDO::FETCH_ASSOC);
    		 	  
    		$query9 = "SELECT * FROM ". $this->table_question_video ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt9 = $this->conn->prepare($query9);
    		$stmt9->execute();
    		$question_video_data =$stmt9->fetchAll(PDO::FETCH_ASSOC);
    		
    	   $query7 = "SELECT * FROM ". $this->table_question_pdf ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt7 = $this->conn->prepare($query7);
    		$stmt7->execute();
    		$question_pdf_data =$stmt7->fetchAll(PDO::FETCH_ASSOC);    		
    		
    		
    		
    		
                     $cardsdetails['card_id']=$card_data['card_id'];
                     $cardsdetails['card_question']=$card_data['card_ques'];
                     $cardsdetails['card_answer']=$card_data['card_answer'];
                     if($this->doesCardBookmarked()){
                     $cardsdetails['bookmark_status']='true';
                     }
                     else{
                         $cardsdetails['bookmark_status']='false';
                     }
                     $cardsdetails['card_question_image']=$question_image_data;
                     $cardsdetails['card_question_audio']=$question_audio_data;
                      $cardsdetails['card_question_video']=$question_video_data;
                     $cardsdetails['card_question_pdf']=$question_pdf_data;
                     $cardsdetails['card_answer_image']=$answer_image_data;
                     $cardsdetails['card_answer_audio']=$answer_audio_data; 
                     $cardsdetails['card_answer_video']=$answer_video_data;
                     $cardsdetails['card_answer_pdf']=$answer_pdf_data;
    		         return $cardsdetails;	     
		}
	    
	    public function addNewCard(){
	        $OK=true;
	          if($this->doesCardExist()){
		        $OK = false;
		        $error = "You have already created this card with same name.";
		    }
	        
	        	   if($OK){ 
	        	       // query to insert record
    			  $query = "INSERT INTO ". $this->table_card ." SET 
    			    chapter_id='".$this->chapter_id ."', 
    			    course_id='". $this->course_id ."',
    			    card_ques='". $this->card_ques ."', 
    			     card_answer='". $this->card_answer ."'";
    			     $stmt = $this->conn->prepare($query);
    			     if( $stmt->execute())
    			     {
    			     $query1 = "SELECT * FROM ". $this->table_card ." WHERE card_ques ='". $this->card_ques ."' AND chapter_id='". htmlspecialchars(strip_tags($this->chapter_id)) ."'";
    			     $stmt1= $this->conn->prepare($query1);
    		
    			    // execute query
    			     $stmt1->execute();
    			     $card_data = $stmt1->fetch(PDO::FETCH_ASSOC);
    			     $response['success'] =1;
    			     $response['message'] = "Card Created Succesfully";
                     $response['card_id']=$card_data['card_id'];
                     $response['card_question']=$card_data['card_ques'];
                     $response['card_answer']=$card_data['card_answer'];
    			     }
    			     else{
    			         
                 $response['success'] =0;
		         $response['message'] = "Adding card failed.";
    			     }
	        	}
	        	else{
		        $response['success'] = 0;
    			$response['message'] = $error;
		    }
	        return $response;
	    }
	   	public function updateCard(){
	     
	        	       // query to insert record
    			  $query = "UPDATE ". $this->table_card ." SET 
    			           card_ques='". $this->card_ques ."', 
    			           card_answer='". $this->card_answer ."'
    			           WHERE card_id='". $this->card_id ."' AND chapter_id='". $this->chapter_id ."'";
    			           $stmt = $this->conn->prepare($query);
    			           if($stmt->execute()){
                           $response['success'] =1;
                           $response['card_id'] =$this->card_id;
		                   $response['message'] = "card Updated Successfully";
    			                 }
    			         else{
    			         
                         $response['success'] =0;
                         $response['card_id'] ="";
		                 $response['message'] = "Card Updating Failed";
    			           }
	       
	        return $response;
	    }
	 	    
		public function doesCardBookmarked(){
		    $query = "SELECT * FROM ". $this->table_bookmark ." WHERE card_id='". htmlspecialchars(strip_tags($this->card_id)) ."'  AND user_id='". htmlspecialchars(strip_tags($this->user_id)) ."'";
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
		
	}