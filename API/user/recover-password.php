<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/user.php';
	include_once '../vendor/autoload.php';
	require_once('../lib/PHPMailer/PHPMailerAutoload.php');
	require_once('../lib/PHPMailer/examples/smtp.php');
	
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));  
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	
	// initialize object
	$user = new user($db);
	
	$user->email = trim($data->email);
	$user->rand_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );
	$user->password = md5($user->rand_password);
        $isAuthenticated = true;
        
        if($isAuthenticated){
            if($user->doesEmailExist()){
                if($user->updatePasswordWithEmail()){
        	        /*Email code starts here*/
        	        $to = $user->email;
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
        													<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">Hello!</p>
        													<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">You just requested a new password for your account. As per your request new password for account is as below:</p>
        													<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px"><strong>Password: </strong>'. $user->rand_password .'</p>
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
        												This system email was sent to <span class="m_835363009008756331notranslate"><a href="mailto:'. $user->email .'" style="color:#555;font-weight:300;text-decoration:none" target="_blank">('. $user->email .'</a></span>) <span class="m_835363009008756331mobile-clear"></span>
        												<br/>by '. $smtpSiteTitle .'
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
        	        if($mail->Send()){
        	            $response['success'] = 1;
            		    $response['message'] = "New password sent to your registered email id";
        	        }else{
        	            $response['success'] = 0;
            		    $response['message'] = "Error sending email. Please try again.";
        	        }
                }else{
                    $response['success'] = 0;
            		$response['message'] = "Error updating new password. Please try again.";
                }
        	}else{
        	    $response['success'] = 0;
        		$response['message'] = "This email address is not associated with any account.";
        	}
        }
		else{
            $response['success'] = 0;
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    //}catch (Exception $e){ // if decode fails, it means jwt is invalid
	//	$response['status'] = "Failed";
	//	$response['message'] = "JWT was not Verified. ". $e->getMessage();
	//	
	//	echo json_encode(array(
	//		"response" => $response
	//	));
	//}
?>