<?php

	class delete{
	    
	
	    	// database connection and table name
		private $conn;
		private $table_courses = "courses";
		private $table_chapter = "course_chapter";
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
	    private $table_first_revision ="first_revision";
	    private $table_second_revision ="second_revision";
	    private $table_third_revision ="third_revision";
	    private $table_fourth_revision ="fourth_revision";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}
	    
	    public function deleteCourse(){
	        
	        $tables = array($this->table_courses,$this->table_chapter,$this->table_card,$this->table_answer_image,$this->table_answer_audio,$this->table_answer_pdf,$this->table_answer_video,$this->table_question_image,$this->table_question_audio,$this->table_question_pdf,$this->table_question_video,$this->table_deck,$this->table_first_revision,$this->table_second_revision,$this->table_third_revision,$this->table_fourth_revision);
            foreach($tables as $table) {
            $query = "DELETE FROM $table WHERE course_id='". $this->course_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            } 
            $response['success'] = 1;
    		$response['message'] = "Course removed Successfully";
	    return $response;
	        
	    }
	    
	    public function deleteChapter(){
	        
	        $tables = array($this->table_chapter,$this->table_card,$this->table_answer_image,$this->table_answer_audio,$this->table_answer_pdf,$this->table_answer_video,$this->table_question_image,$this->table_question_audio,$this->table_question_pdf,$this->table_question_video,$this->table_deck,$this->table_first_revision,$this->table_second_revision,$this->table_third_revision,$this->table_fourth_revision);
            foreach($tables as $table) {
            $query = "DELETE FROM $table WHERE chapter_id='". $this->chapter_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            } 
            $response['success'] = 1;
    		$response['message'] = "Chapter removed Successfully";
	    return $response;
	        
	    }
	    
	    public function deleteCard(){
	        
	        $tables = array($this->table_card,$this->table_answer_image,$this->table_answer_audio,$this->table_answer_pdf,$this->table_answer_video,$this->table_question_image,$this->table_question_audio,$this->table_question_pdf,$this->table_question_video,$this->table_deck,$this->table_first_revision,$this->table_second_revision,$this->table_third_revision,$this->table_fourth_revision);
            foreach($tables as $table) {
            $query = "DELETE FROM $table WHERE card_id='". $this->card_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            } 
            $response['success'] = 1;
    		$response['message'] = "Card removed Successfully";
	        return $response;
	        
	    }
	    
	   public function deleteAnswerImagewithID(){
            $query = "DELETE FROM " .$this->table_answer_image. " WHERE card_answer_image_id='". $this->card_answer_image_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            $response['success'] = 1;
    		$response['message'] = "Card Image Deleted Successfully";
	        return $response;
	        
	    }
	    
	    public function deleteAnswerAudiowithID(){
            $query = "DELETE FROM " .$this->table_answer_audio. " WHERE card_answer_audio_id='". $this->card_answer_audio_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            $response['success'] = 1;
    		$response['message'] = "Card Audio Deleted Successfully";
	        return $response;
	        
	    }
	    
	    public function deleteAnswerVideowithID(){
            $query = "DELETE FROM " .$this->table_answer_video. " WHERE card_answer_video_id='". $this->card_answer_video_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            $response['success'] = 1;
    		$response['message'] = "Card Video Deleted Successfully";
	        return $response;
	        
	    }
	    
	    public function deleteAnswerPdfwithID(){
            $query = "DELETE FROM " .$this->table_answer_pdf. " WHERE card_answer_pdf_id='". $this->card_answer_pdf_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            $response['success'] = 1;
    		$response['message'] = "Card PDF Deleted Successfully";
	        return $response;
	        
	    }
	    
	     public function deleteQuestionImagewithID(){
            $query = "DELETE FROM " .$this->table_question_image. " WHERE card_question_image_id='". $this->card_question_image_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            $response['success'] = 1;
    		$response['message'] = "Card Image Deleted Successfully";
	        return $response;
	        
	    }
	    
	    public function deleteQuestionPdfwithID(){
            $query = "DELETE FROM " .$this->table_question_pdf. " WHERE card_question_pdf_id='". $this->card_question_pdf_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            $response['success'] = 1;
    		$response['message'] = "Card Audio Deleted Successfully";
	        return $response;
	        
	    }
	    
	    public function deleteQuestionAudiowithID(){
            $query = "DELETE FROM " .$this->table_question_audio. " WHERE card_question_audio_id='". $this->card_question_audio_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            $response['success'] = 1;
    		$response['message'] = "Card Video Deleted Successfully";
	        return $response;
	        
	    }
	    
	    public function deleteQuestionVideowithID(){
            $query = "DELETE FROM " .$this->table_question_video. " WHERE card_question_video_id='". $this->card_question_video_id ."'";
            $stmt = $this->conn->prepare($query);
			$stmt->execute();
            $response['success'] = 1;
    		$response['message'] = "Card PDF Deleted Successfully";
	        return $response;
	        
	    }
	    
	    
	    
	}