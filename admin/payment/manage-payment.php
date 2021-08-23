<?php
session_start();
error_reporting(0);
include'../dbconnection.php';
include_once '../Function/admin.php';
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	$admin = new Admin($db);
if(isset($_GET['status'])){
   if($_GET['status']=="update") {

$admin->user_id=$_GET['user_id'];
$admin->requested_amount=$_GET['requested_amount'];
$admin->status="Paid";
$admin->updatePayment();
$admin->addEntry();
$_SESSION["status"]="success";
$_SESSION["icon"]='pe-7s-like';
$_SESSION["message"]="Dear Admin payment updated Successfully.";
}
  elseif($_GET['status']=="reject") {

$admin->user_id=$_GET['user_id'];
$admin->total_amount=$_GET['total_amount'];
$admin->requested_amount=$_GET['requested_amount'];
$admin->status="Rejected";
$admin->rejectPayment();
$admin->addEntry();
$_SESSION["status"]="danger";
$_SESSION["icon"]='pe-7s-junk';
$_SESSION["message"]="Dear Admin payment rejected Successfully.";
}
header("Location:$baseurl/requested-payments.php");

exit();
}
