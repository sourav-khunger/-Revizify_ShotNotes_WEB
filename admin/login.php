<?php
session_start();
error_reporting(0);
include_once 'dbconnection.php';
include_once 'Function/admin.php';
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	//$admin = new Admin($db);
//	print_r($db);
	if(isset($_REQUEST['login']))
{
 $admin = new Admin($db);
	
	$admin->username = isset($_REQUEST['username']) ? $_REQUEST['username'] : die();
	$admin->password = isset($_REQUEST['password']) ? $_REQUEST['password'] : die();
	$admin->password = md5($admin->password);
	$response = $admin->Login();
//print_r($response);
if($response['status'] == "Success")
{
$extra="index.php";
$_SESSION['login']=$_POST['username'];
$_SESSION['id']=$response['id'];
echo "<script>window.location.href='".$extra."'</script>";
exit();
}
else
{
$_SESSION['action1']="*Invalid username or password";
$extra="login.php";
echo "<script>window.location.href='".$extra."'</script>";
exit();
}
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="login-assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="login-assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="login-assets/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="login-assets/css/style.css">

    <title>ShotNOTES</title>
  </head>
  <body>
  

  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="images/undraw_remotely_2j6y.svg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <div class="logo" style="text-align:center;"> <img src="images/splashIcon.png" height="70px" width="70px"/></div>
              <h3 style="text-align:center;">Sign In to ShotNOTES</h3>
              <p class="mb-4 green text-center"><?php if(isset($_SESSION['logout'])) { echo $_SESSION['logout'];  session_unset(); } elseif(isset($_SESSION['action1'])) { ?></p><p class="mb-4 red text-center"><?php echo $_SESSION['action1']; } ?><?php echo $_SESSION['action1']="";?> </p>
            </div>
            <form action="" method="post">
              <div class="form-group first">
                <label for="username">Username</label>
                <input name="username" type="text" class="form-control" id="username">

              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input name="password" type="password" class="form-control" id="password">
                
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="reset-password.php" class="forgot-pass">Forgot Password</a></span> 
              </div>

              <input name="login" type="submit" value="Log In" class="btn btn-block btn-primary">

               <!--     <span class="d-block text-left my-4 text-muted">&mdash; or login with &mdash;</span>
              
        <div class="social-login">
                <a href="#" class="facebook">
                  <span class="icon-facebook mr-3"></span> 
                </a>
                <a href="#" class="twitter">
                  <span class="icon-twitter mr-3"></span> 
                </a>
                <a href="#" class="google">
                  <span class="icon-google mr-3"></span> 
                </a>
              </div>-->
            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  
    <script src="login-assets/js/jquery-3.3.1.min.js"></script>
    <script src="login-assets/js/popper.min.js"></script>
    <script src="login-assets/js/bootstrap.min.js"></script>
    <script src="login-assets/js/main.js"></script>
  </body>
</html>