<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/payment.php';
	include_once '../objects/user.php';
	include_once '../objects/wallet.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


	$bearer = new Token();
	$payment = new payment($db);
	$user = new user($db);
	$wallet = new wallet($db);
	$payment->user_id=$_REQUEST["user_id"];
    $payment->requested_amount=$_REQUEST["requested_amount"];
    
    if($_REQUEST["user_type"]=="admin"){
       if($payment->updatePayment())
       {
                  $wallet->user_id = 	$payment->user_id;
                  $response=$wallet->getWalletBalance();
       }
       else{
        $respone["success"]=0;
        $response["message"]="Server error Payment Not Updated.";
       }
    }
    else{
        $respone["success"]=0;
        $response["message"]="You are not Authorized user to perform this Task.";
    }
print_r($response);
?>