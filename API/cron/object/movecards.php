<?php
	class moveCards{
	    
	
	    	// database connection and table name
		private $conn;
	 	private $table_deck ="new_deck";
	 	private $table_first_revision ="first_revision";
	 	private $table_second_revision ="second_revision";
	 	private $table_third_revision ="third_revision";
	 	private $table_fourth_revision ="fourth_revision";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}
			public function movingCardsToFirstRevision(){
			    
			        $query1=" INSERT INTO ".$this->table_first_revision." (card_id,user_id,course_id,chapter_id)
                        SELECT card_id,user_id,course_id,chapter_id FROM ".$this->table_deck." WHERE `timestamp` < CURRENT_TIMESTAMP - INTERVAL 2 MINUTE AND moved_status!='true'";
			
                        $stmt1 = $this->conn->prepare($query1);
		            	$stmt1->execute();
                        $query2="UPDATE ".$this->table_deck." SET moved_status='true' WHERE `timestamp` < CURRENT_TIMESTAMP - INTERVAL 2 MINUTE AND status='true'";
                			
                        $stmt2 = $this->conn->prepare($query2);
		            	$stmt2->execute();
		   
			}
			public function movingCardsToSecondRevision(){
			    
			        $query1=" INSERT INTO ".$this->table_second_revision." (card_id,user_id,course_id,chapter_id)
                        SELECT card_id,user_id,course_id,chapter_id FROM ".$this->table_first_revision." WHERE `timestamp` < CURRENT_TIMESTAMP - INTERVAL 2 MINUTE AND status='true' AND moved_status!='true'";
			
                        $stmt1 = $this->conn->prepare($query1);
		            	$stmt1->execute();
                $query2="UPDATE ".$this->table_first_revision." SET moved_status='true' WHERE `timestamp` < CURRENT_TIMESTAMP - INTERVAL 2 MINUTE AND status='true'";
                			
                        $stmt2 = $this->conn->prepare($query2);
		            	$stmt2->execute();
			}
			public function movingCardsToThirdRevision(){
			    
			        $query1=" INSERT INTO ".$this->table_third_revision." (card_id,user_id,course_id,chapter_id)
                        SELECT card_id,user_id,course_id,chapter_id FROM ".$this->table_second_revision." WHERE  `timestamp` < CURRENT_TIMESTAMP - INTERVAL  2 MINUTE AND  status='true' AND moved_status!='true'";
			
                        $stmt1 = $this->conn->prepare($query1);
		            	$stmt1->execute();
                $query2="UPDATE ".$this->table_second_revision." SET moved_status='true' WHERE `timestamp` < CURRENT_TIMESTAMP - INTERVAL  2 MINUTE AND status='true'";
                			
                        $stmt2 = $this->conn->prepare($query2);
		            	$stmt2->execute();
			}
			public function movingCardsToFourthRevision(){
			    
			        $query1=" INSERT INTO ".$this->table_fourth_revision." (card_id,user_id,course_id,chapter_id)
                        SELECT card_id,user_id,course_id,chapter_id FROM ".$this->table_third_revision." WHERE `timestamp` < CURRENT_TIMESTAMP - INTERVAL 2 MINUTE AND  status='true' AND moved_status!='true'";
			
                        $stmt1 = $this->conn->prepare($query1);
		            	$stmt1->execute();
                $query2="UPDATE ".$this->table_third_revision." SET moved_status='true' WHERE `timestamp` < CURRENT_TIMESTAMP - INTERVAL 2 MINUTE AND status='true'";
                			
                        $stmt2 = $this->conn->prepare($query2);
		            	$stmt2->execute();
			}
}