<?php
session_start();
require_once'../../dbconnection.php';
require_once '../../Function/admin.php';

// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	 $admin = new Admin($db);

// checking session is valid for not 

if (isset($_REQUEST['search'])){
$admin->name=$_POST["search"];
$extra="http://doozycodsys.com/Shotnotes/admin/all-courses.php";
$stmt=$admin->getAllcoursesByuserName();
$allcourses=$stmt->fetchAll(PDO::FETCH_ASSOC);
$_SESSION["user_data"]=$allcourses;

echo "<script>window.location.href='".$extra."'</script>";
}

exit();
?>