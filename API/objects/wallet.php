<?php

	class wallet{
	    
	
	    	// database connection and table name
		private $conn;
		private $table_user ="user_info";
		private $table_payment ="course_payment";
	    private $table_wallet ="user_wallet";
	    private $table_bank ="user_bank_account_details";
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}	
		
				
	public function getWalletBalance(){
			    
	       // $query = "SELECT * FROM ". $this->table_courses ." WHERE  user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
	         
	         $query="SELECT * FROM ". $this->table_wallet ." WHERE  user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
	         	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			  	$wallet_data=$stmt->fetch(PDO::FETCH_ASSOC);
			  	$response['success'] =1;
                $response['total_amount'] =$wallet_data[total_amount];
		        $response['requested_amount'] =$wallet_data[requested_amount];
		        $query="SELECT * FROM ". $this->table_bank ." WHERE  user_id = '". htmlspecialchars(strip_tags($this->user_id)) ."'";
		        	$stmt = $this->conn->prepare($query);
			    $stmt->execute();
			    $num = $stmt->rowCount();
			    if($num > 0){
			        $response['bank_account'] =true;
			    }
		        else{
		            $response['bank_account']=false;
		        }
			    }
			    else{
			    $response['success'] =1;
                $response['total_amount'] ="0";
		        $response['requested_amount'] ="0";    
			    }
		        return $response;
	    }
}