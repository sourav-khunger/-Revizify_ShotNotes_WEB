<?php

	class uploaddocs{
	    
	
	    	// database connection and table name
		private $conn;
		private $table_courses = "courses";
		private $table_chapter = "course_chapter";
		private $table_user ="user_info";
		private $table_card ="card_info";
		private $table_answer_image ="card_answer_image";
		private $table_answer_audio ="card_answer_audio";
		private $table_answer_video ="card_answer_video";
	    private $table_answer_pdf="card_answer_pdf";
	    private $table_question_image ="card_question_image";
		private $table_question_audio ="card_question_audio";
		private $table_question_video ="card_question_video";
	    private $table_question_pdf="card_question_pdf";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}
	    
	

	    
	    
	    public function addAnswerImage(){
	        

                 
                 $query = "INSERT INTO ". $this->table_answer_image ." SET 
    			    card_id='".$this->card_id ."', 
    			    chapter_id='". $this->chapter_id ."', 
    			    course_id='". $this->course_id ."', 
    			     card_answer_image_name='".$this->name ."', 
    			    card_answer_image_url='". $this->url."'";
    			     $stmt = $this->conn->prepare($query);
    			    $stmt->execute();
	    }
	    
	   public function getAllAnswerImagesWithCardID(){
	       
    	$query = "SELECT * FROM ". $this->table_answer_image ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    			    
	        return $stmt;
	    
	   } 
	    
	    	    
	    
	    public function addAnswerAudio(){
	        

                 
                 $query = "INSERT INTO ". $this->table_answer_audio ." SET 
    			    card_id='".$this->card_id ."', 
    			    card_answer_audio_name='". $this->name ."', 
    			    card_answer_audio_url='". $this->url ."'";
    			     $stmt = $this->conn->prepare($query);
    			    $stmt->execute();
	    }
	    	    
	    public function addAnswerVideo(){

                 $query = "INSERT INTO ". $this->table_answer_video ." SET 
    			    card_id='". $this->card_id."', 
    			    chapter_id='". $this->chapter_id ."', 
    			    course_id='". $this->course_id ."', 
    			    card_answer_video_name='". $this->name ."', 
    			    card_answer_video_url='".$this->url ."'";
    			     $stmt = $this->conn->prepare($query);
    			    $stmt->execute();
	    }
	    
	   public function getAllAnswerAudiosWithCardID(){
	       
    	$query = "SELECT * FROM ". $this->table_answer_audio ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    			    
	        return $stmt;
	    
	   } 
	   
	   	    public function addAnswerPdf(){
                 $query = "INSERT INTO ". $this->table_answer_pdf ." SET 
    			    card_id='".$this->card_id ."', 
    			    chapter_id='".$this->chapter_id ."', 
    			    course_id='". $this->course_id ."', 
    			     card_answer_pdf_name='". $this->name ."', 
    			    card_answer_pdf_url='". $this->url ."'";
    			     $stmt = $this->conn->prepare($query);
    			    $stmt->execute();
	    }
	    
	   public function getAllAnswerPdfWithCardID(){
	       
    	$query = "SELECT * FROM ". $this->table_answer_pdf ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    			    
	        return $stmt;
	    
	   } 
	 	
	 	
	 		    public function addQuestionImage(){
	        

                 
                 $query = "INSERT INTO ". $this->table_question_image ." SET 
    			    card_id='".$this->card_id ."', 
    			    chapter_id='". $this->chapter_id ."', 
    			    course_id='". $this->course_id ."', 
    			     card_question_image_name='". $this->name."', 
    			    card_question_image_url='".$this->url ."'";
    			     $stmt = $this->conn->prepare($query);
    			    $stmt->execute();
	    }
	    
	   public function getAllQuestionImagesWithCardID(){
	       
    	$query = "SELECT * FROM ". $this->table_question_image ." WHERE card_id ='".$this->card_id ."'";
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    			    
	        return $stmt;
	    
	   } 
	    
	    	    
	    
	    public function addQuestionAudio(){
	        

                 
                 $query = "INSERT INTO ". $this->table_question_audio ." SET 
    			    card_id='".$this->card_id ."', 
    			    chapter_id='". $this->chapter_id ."', 
    			    course_id='". $this->course_id ."', 
    			     card_question_audio_name='". $this->name ."', 
    			    card_question_audio_url='". $this->url."'";
    			     $stmt = $this->conn->prepare($query);
    			    $stmt->execute();
	    }
	    
	   public function addQuestionVideo(){
	        

                 
                 $query = "INSERT INTO ". $this->table_question_video ." SET 
    			    card_id='".$this->card_id ."', 
    			    chapter_id='". $this->chapter_id ."', 
    			    course_id='".$this->course_id."', 
    			     card_question_video_name='".$this->name."', 
    			    card_question_video_url='".$this->url ."'";
    			     $stmt = $this->conn->prepare($query);
    			    $stmt->execute();
	    }
	    
	    
	   public function getAllQuestionAudiosWithCardID(){
	       
    	$query = "SELECT * FROM ". $this->table_question_audio ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    			    
	        return $stmt;
	    
	   } 
	   
	   	    public function addQuestionPdf(){
                 $query = "INSERT INTO ". $this->table_question_pdf ." SET 
    			    card_id='".$this->card_id ."',
    			    chapter_id='". $this->chapter_id ."', 
    			    course_id='". $this->course_id."', 
    			     card_question_pdf_name='".$this->name ."', 
    			    card_question_pdf_url='".$this->url ."'";
    			     $stmt = $this->conn->prepare($query);
    			    $stmt->execute();
	    }
	    
	   public function getAllQuestionPdfWithCardID(){
	       
    	$query = "SELECT * FROM ". $this->table_question_pdf ." WHERE card_id ='". htmlspecialchars(addslashes($this->card_id)) ."'";
    		$stmt = $this->conn->prepare($query);
    
    		$stmt->execute();
    			    
	        return $stmt;
	    
	   }     
	    
	}