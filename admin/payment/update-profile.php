<?php
session_start();
error_reporting(0);
include'../dbconnection.php';
include_once '../Function/admin.php';
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	$admin = new Admin($db);
if(isset($_REQUEST['update-commission'])){
echo "hello";
$admin->commission=$_POST['Commission'];
if($admin->updateCommission()){
$_SESSION["status"]="success";
$_SESSION["icon"]='pe-7s-like';
$_SESSION["message"]="Commission updated Successfully.";
}
else{
    $_SESSION["status"]="failed";
    $_SESSION["icon"]='pe-7s-junk';
    $_SESSION["message"]="Commission updating Failed.";
}
}
elseif(isset($_REQUEST['update-passowrd'])){
    
$_SESSION["status"]="success";
$_SESSION["icon"]='pe-7s-like';
$_SESSION["message"]="Password updated Successfully."; 
}

elseif(isset($_REQUEST['update-passowrd'])){
    
$_SESSION["status"]="success";
$_SESSION["icon"]='pe-7s-like';
$_SESSION["message"]="Password updated Successfully."; 
}
header("Location:$baseurl/account.php");

exit();

