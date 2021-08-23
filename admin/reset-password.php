<?php
session_start();
error_reporting(0);
include_once 'dbconnection.php';
include_once 'Function/admin.php';
require_once('lib/PHPMailer/PHPMailerAutoload.php');
require_once('lib/PHPMailer/examples/smtp.php');
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	if(isset($_REQUEST['forgot']))
    {
    $admin = new Admin($db);
	$admin->email = isset($_REQUEST['email']) ? $_REQUEST['email'] : die();
	$admin->rand_password = rand(11111111, 99999999);
	$admin->password = md5($admin->rand_password);
     if($admin->doesEmailExist()){
                if($admin->updatePassword()){
                  $_SESSION['success']="An email with new password sent to your email address."; 
                  
                  
                  $smtpSiteTitle="Shotes Note";
                     $to = $admin->email;
        	        $subject =  "New password for your account - ". $smtpSiteTitle;
        	        $body = '<table id="m_835363009008756331wrapper" cellpadding="20" cellspacing="0" border="0" style="width:100%;background-color:#eaeaea;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-weight:300;border-collapse:collapse;margin:0;padding:0;line-height:100%;height:100%">
        						<tbody><tr><td style="border-collapse:collapse;vertical-align:top">
        							<table id="m_835363009008756331contentTable" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff;margin:0 auto;width:680px;border:solid 1px #ddd;border-collapse:collapse">
        								<tbody><tr><td style="border-collapse:collapse;vertical-align:top">
        									<table id="m_835363009008756331header" cellspacing="0" border="0" style="border-bottom:solid 0px #ddd;width:100%;border-collapse:collapse">
        										<tbody><tr><td style="color:#444;font-size:31px;font-weight:bold;border-collapse:collapse;vertical-align:top">
        										<h2 style="margin:10px !important; padding:0px !important; text-align:center">'. $smtpSiteTitle .'</h2>
        										</td></tr></tbody>
        									</table>
        
        									<table cellpadding="30" cellspacing="0" border="0" style="width:100%;border-collapse:collapse">
        										<tbody><tr><td id="m_835363009008756331message" style="border-collapse:collapse;vertical-align:top">
        											<table cellpadding="10" cellspacing="0" border="0" style="width:100%;border-collapse:collapse">
        												<tbody><tr><td style="border-collapse:collapse;vertical-align:top">
        													<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">Hello Admin!</p>
        													<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">You just requested a new password for your account. As per your request new password for account is as below:</p>
        													<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px"><strong>Password: </strong>'. $admin->rand_password .'</p>
        												</td></tr></tbody>
        											</table>
        											
        											<table cellpadding="10" cellspacing="0" border="0" style="width:100%;border-collapse:collapse">
        												<tbody><tr><td style="border-collapse:collapse;vertical-align:top">
        													<p id="m_835363009008756331description" style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">
        														<strong>We are here to help you if you need it. Visit our support for more info or contact us.</strong><br/>
        													</p>
        												</td></tr></tbody>
        											</table>
        
        											<table cellpadding="10" cellspacing="0" border="0" style="width:100%;border-collapse:collapse">
        												<tbody><tr><td style="border-collapse:collapse;vertical-align:top">
        													<p id="m_835363009008756331description" style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">
        														- Team '. $smtpSiteTitle .'
        													</p>
        												</td></tr></tbody>
        											</table>
        										</td></tr></tbody>
        									</table>
        								</td></tr></tbody>
        							</table>
        							
        							<table id="m_835363009008756331contentTable" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;width:680px;border-collapse:collapse">
        								<tbody><tr><td style="border-collapse:collapse;vertical-align:top">
        									<table cellpadding="10" cellspacing="0" border="0" style="width:100%;text-align:center;border-collapse:collapse">
        										<tbody><tr><td style="border-collapse:collapse;vertical-align:top"><br>
        											<p style="font-size:12px;color:#555;line-height:19px;font-weight:300;margin:0 30px;text-align:center">
        												This system email was sent to <span class="m_835363009008756331notranslate"><a href="mailto:'. $driver->email .'" style="color:#555;font-weight:300;text-decoration:none" target="_blank">('. $driver->email .'</a></span>) <span class="m_835363009008756331mobile-clear"></span>
        												<br>by '. $smtpSiteTitle .'
        											</p>
        										</td></tr></tbody>
        									</table>
        								</td></tr></tbody>
        							</table>
        						</td></tr></tbody>
        					</table>';
        			$mail->IsHTML(true);
        	        $mail->addAddress($to, '');
        	        $mail->Subject = $subject;
        	        $mail->Body = $body;
        	        $mail->Send();
                }
         
     }
      
      else{ $_SESSION['failed']="This Email id is not associated with any account"; 
      }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="login-assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="login-assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="login-assets/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="login-assets/css/style.css">

    <title>Shotes Note</title>
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
              <h3 style="text-align:center;">Reset Password</h3>
              <p class="mb-4 "><?php if(!isset($_REQUEST['forgot'])){ ?>Please enter your email address. You will receive a link to create a new password via email.</p> <?php } elseif(isset($_SESSION['success'])) { ?><p class="green">
           <?php echo $_SESSION['success']; ?> </p> <?php } else { ?> <p class="red"> <?php echo($_SESSION['failed']);  } ?></p>
            </div>
            <form action="" method="post">
              <div class="form-group first">
                <label for="exampleInputEmailAddress">Email Address</label>
                <input name="email" type="text" class="form-control" id="username">

              </div>
              <input name="forgot" type="submit" value="Reset Password" class="btn btn-block btn-primary">

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
		    <p class="text-warning mb-0 mt-2 text-center">Return to the <a href="login.php">Sign In</a></p>
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