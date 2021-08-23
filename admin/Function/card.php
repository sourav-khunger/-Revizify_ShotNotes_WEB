<?php
	class Card{
	 
		// database connection and table name
		private $conn;
		private $table_card = "card_info";
		private $table_chapter = "course_chapter";
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
		
		  public function getCardDataWithCardID(){
	            $query ="SELECT chapter.chapter_id, chapter.chapter_name,card.* FROM ". $this->table_card ." as card, ". $this->table_chapter ." as chapter WHERE card.card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."' AND chapter.chapter_id=card.chapter_id ";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    return $stmt;
	    }
	    	  public function getAnswerCardImagesWithCardID(){
	            $query ="SELECT * FROM ". $this->table_answer_image ." WHERE card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			     $num = $stmt->rowCount();
			    if($num > 0){
			    $answer_image_data=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $answer_image_data="empty";
			    }
			    return $answer_image_data;
	    }
	    
	    	 public function getAnswerCardAudioWithCardID(){
	            $query ="SELECT * FROM ". $this->table_answer_audio ." WHERE card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			    $answer_audio_data=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			     $answer_audio_data="empty";
			    }
			    return $answer_audio_data;
	    }
	     
	     public function getAnswerCardVideoWithCardID(){
	            $query ="SELECT * FROM ". $this->table_answer_video ." WHERE card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			    $answer_video_data=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $answer_video_data="empty";
			    }
			    return $answer_video_data;
	    }
	    public function getAnswerCardPdfWithCardID(){
	            $query ="SELECT * FROM ". $this->table_answer_pdf ." WHERE card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			    $answer_pdf_data=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			      $answer_pdf_data="empty";  
			    }
			    return $answer_pdf_data;
	    }
	    public function getQuestionCardImageWithCardID(){
	            $query ="SELECT * FROM ". $this->table_question_image ." WHERE card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			    $question_image_data=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $question_image_data="empty";
			    }
			    return $question_image_data;
	    }
	    public function getQuestionCardAudioWithCardID(){
	            $query ="SELECT * FROM ". $this->table_question_audio ." WHERE card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			    $question_audio_data=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $question_audio_data="empty";
			    }
			    return $question_audio_data;
	    }
	    public function getQuestionCardVideoWithCardID(){
	            $query ="SELECT * FROM ". $this->table_question_video ." WHERE card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			    $question_video_data=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $question_video_data="empty";
			    }
			    return $question_video_data;
	    }
	    public function getQuestionCardPdfWithCardID(){
	            $query ="SELECT * FROM ". $this->table_question_pdf ." WHERE card_id= '". htmlspecialchars(strip_tags($this->card_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			    $question_pdf_data=$stmt->fetchAll(PDO::FETCH_ASSOC);
			    }
			    else{
			        $question_pdf_data="empty";
			    }
			    return $question_pdf_data;
	    }
	    public function getPreviousCardwithId(){
	            $query ="SELECT card.card_id FROM ". $this->table_card ." as card, ". $this->table_chapter ." as chapter WHERE card.card_id<'". htmlspecialchars(strip_tags($this->card_id)) ."' AND card.chapter_id='".htmlspecialchars(strip_tags($this->chapter_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
		     	$prev_card=$stmt->fetch(PDO::FETCH_ASSOC);
			    $prev_card=$prev_card["card_id"];
			    }
		     	else{
				$prev_card="empty";
			    }
			    return $prev_card;
			    
			    
	    }
	    public function getNextCardwithId(){
	           $query ="SELECT card.card_id FROM ". $this->table_card ." as card, ". $this->table_chapter ." as chapter WHERE card.card_id>'". htmlspecialchars(strip_tags($this->card_id)) ."' AND card.chapter_id='".htmlspecialchars(strip_tags($this->chapter_id)) ."'";
	        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			    $next_card=$stmt->fetch(PDO::FETCH_ASSOC);
			    $next_card=$next_card["card_id"];
			    }
			    else{
			       $next_card="empty";
			    }
			    return $next_card;
	    }
}
