<?php
	$baseurl="http://doozycodsys.com/Shotnotes/admin";
	class Database{
	 
		// specify your own database credentials
		private $host = "localhost";
		private $db_name = "doozyco1_Shotnotes";
		//private $db_name = "jmltechn_conn";
		private $username = "doozyco1_Shotnotes";
		//private $username = "root";
		private $password = "Shotnotes@123!@#";
		//private $password = "";
		public $conn;
	 
		// get the database connection
		public function getConnection(){
	 
			$this->conn = null;
	 
			try{
				$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
				$this->conn->exec("set names utf8");
			}catch(PDOException $exception){
				echo "Connection error: " . $exception->getMessage();
			}
	 
			return $this->conn;
		}
	}
?>

