<?php
session_start();
error_reporting(0);
include'../dbconnection.php';
include_once '../Function/delete.php';
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	$delete = new Delete($db);
if(isset($_GET['course_id'])){
$delete->course_id=$_GET['course_id'];
$delete->deleteCourse();
$_SESSION["status"]="danger";
$_SESSION["icon"]='pe-7s-junk';
$_SESSION["message"]="Dear Admin Course Deleted Successfully.";
header("Location:$baseurl/all-courses.php");
exit();
}
