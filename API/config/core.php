<?php
	// show error reporting
	error_reporting(E_ALL);
	 
	// set your default time-zone
	date_default_timezone_set('Asia/Manila');
	 
	// variables used for jwt
	$key = "Shotnotes_key_for_api_@_doozycode_by_vaibhav";
	$baseurl="https://www.shotnotes.dev.doozycodsystems.com";
	$iss = "http://Shotnotes.in";
	$aud = "http://Shotnotes.in";
	$iat = 1356999524;
	$nbf = 1357000000;
	
	/* Twilio API Access */
	// Find your Account Sid and Auth Token at twilio.com/console
    // DANGER! This is insecure. See http://twil.io/secure
  //  $sid    = "AC7572b2b5c4a08f88ac8d2ec436fa0f50";
   // $token  = "87b795c28ff8d3d15223d8e6e6c0edc4";
	/* Twilio API Access */
	
	$smtpSiteTitle = "Shotnotes";
	$adminemail="vaibhavr121@gmail.com";
?>