<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/payment.php';
	include_once '../objects/user.php';
	include_once '../objects/token.php';
	include_once '../objects/wallet.php';
	include_once '../vendor/autoload.php';
	require_once('../lib/PHPMailer/PHPMailerAutoload.php');
	require_once('../lib/PHPMailer/examples/smtp.php');
	
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize token object

	$bearer = new Token();
	$payment = new payment($db);
	$user = new user($db);
	$wallet = new wallet($db);
	// initialize user object
	$payment->jwt =$bearer->getBearerToken();
	$payment->requested_amount= trim($data->requested_amount);
	
	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($payment->jwt, $key, array('HS256'));
        //print_r($decoded);
    	    $user->id = $decoded->data->id;
    	    
        if($user->doesUserExist()){
              $user_data=$user->getuserDataById();
              $payment->user_id = $decoded->data->id;
              $wallet->user_id = $decoded->data->id;
              $response=$wallet->getWalletBalance();
              if($payment->requestPayemnt())
              {
                 
                  if($response['success']==1){
                      
                         /*Email code starts here*/
        	        $to =$adminemail;
        	        $url=$baseurl."/Shotnotes/API/courses/update-payment.php/?user_id=". $user_data['id']."&user_type=admin&requested_amount=".$response['requested_amount'];
        	        $username=strtoupper($user_data['name']);
        	        $subject =  "Payment Requested From- ". $username;
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
        													<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">'. $username .' just requested a payment of <b>'.$response['requested_amount'] .' </b> from his total balance of <b>'.$response['total_amount'] .'.<br/></p>
        													
        									<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px"><strong>Userdetails are below:</strong></p>
        													<p style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">Name:- '. $username .'<br/>
        								email:-'. $user_data['email'] .'<br/>
        								phone_number:-'. $user_data['phone_number'] .'</p>
        												</td></tr></tbody>
        											</table>
        											
        											<table cellpadding="10" cellspacing="0" border="0" style="width:100%;border-collapse:collapse">
        												<tbody><tr><td style="border-collapse:collapse;vertical-align:top">
        													<p id="m_835363009008756331description" style="font-size:16px;color:#555;line-height:26px;font-weight:300;margin:0 40px">
        														<strong>Dear admin after payment please click on below button to update the payment on database as well..</strong><br/>
        													</p>
        												</td></tr>
        												<tr>
        												<td style="border-collapse:collapse;vertical-align:top">
        												
<a href="'.$url.'" style="margin:0 40px; background-color: #22BC66; border-top: 10px solid #22BC66;   border-left: 18px solid #22BC66;text-decoration: none; border-right: 18px solid #22BC66; border-bottom: 10px solid #22BC66;" target="_blank"><b style="color:#ffff;">Update Payment</b></a>
        												</td>
        												</tr>
        												</tbody>
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
        												This system email was sent to <span class="m_835363009008756331notranslate"><a href="mailto:'. $adminemail .'" style="color:#555;font-weight:300;text-decoration:none" target="_blank">('. $adminemail .'</a></span>) <span class="m_835363009008756331mobile-clear"></span>
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
            		    $response['message'] = "Your Payment Requested Submited Successfully.";
        	        }else{
        	            $response['success'] = 0;
            		    $response['message'] = "Error sending email. Please try again.";
        	        }
                      
                      
                  }
              }
              else{
                  $response['success'] = 0;
		    $response['message'] = "Query Error."; 
              }
	       
        }
        else{
            $response['success'] = 0;
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "Failed";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode(
		 $response
		);
	}
?>