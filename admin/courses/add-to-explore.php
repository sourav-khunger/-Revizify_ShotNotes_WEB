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
   if($_GET['status']=="add") {

$admin->course_id=$_GET['course_id'];
$admin->status='true';
$admin->updateExploreStatus();
$_SESSION["status"]="success";
$_SESSION["icon"]='pe-7s-like';
$_SESSION["message"]="Dear Admin Course Added Successfully.";
header("Location:$baseurl/all-courses.php");
}
elseif($_GET['status']=="remove") {

$admin->course_id=$_GET['course_id'];
$admin->status='false';
$admin->updateExploreStatus();
$_SESSION["status"]="danger";
$_SESSION["icon"]='pe-7s-junk';
$_SESSION["message"]="Dear Admin Course Removed Successfully.";
header("Location:$baseurl/all-courses.php");
}


exit();
}
