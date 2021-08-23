<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/delete.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	
	use \Firebase\JWT\JWT;
	$data = json_decode(file_get_contents("php://input"));   
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize token object

	$bearer = new Token();
    $delete= new delete($db);
	// initialize user object
	$delete->jwt =$bearer->getBearerToken();
	$delete->user_id=trim($data->user_id);
	$delete->data_type=trim($data->data_type);
	
//	if decode succeed, show user details
    try {
        $decoded = JWT::decode($delete->jwt, $key, array('HS256'));
        
    	   $delete->uid = $decoded->data->id;
    	    
             if($delete->user_id==$delete->uid){
                 
                  //Delete Course
                  
                 if($delete->data_type=="course") {
                 $delete->course_id=trim($data->course_id);       
                 $response=$delete->deleteCourse();
                 
                 }
                 
                 //Delete Chapter
                 
                 elseif($delete->data_type=="chapter"){
                 $delete->chapter_id=trim($data->chapter_id);   
                 $response=$delete->deleteChapter();
                 }
                 
                 
                 // Delete Card 
                 
                 elseif($delete->data_type=="card"){
                 $delete->card_id=trim($data->card_id);      
                 $response=$delete->deleteCard();    
                 }
                 
                 //DELETE FILES OF CARDS//
                 
                 elseif($delete->data_type=="answer_image"){
                 $delete->card_answer_image_id=trim($data->card_answer_image_id);    
                 $response=$delete->deleteAnswerImagewithID();
                 }     
                 elseif($delete->data_type=="answer_audio"){
                  $delete->card_answer_audio_id=trim($data->card_answer_audio_id);  
                  $response=$delete->deleteAnswerAudiowithID();        
                 }
                      
                elseif($delete->data_type=="answer_pdf"){
                     $delete->card_answer_pdf_id=trim($data->card_answer_pdf_id);         
                   $response=$delete->deleteAnswerPdfwithID();        
                 }
                
                elseif($delete->data_type=="answer_video"){
                     $delete->card_answer_video_id=trim($data->card_answer_video_id);         
                   $response=$delete->deleteAnswerVideowithID();        
                 }
                      
                elseif($delete->data_type=="question_image"){
                     $delete->card_question_image_id=trim($data->card_question_image_id);         
                   $response=$delete->deleteQuestionImagewithID();        
                 }
                      
                      
                elseif($delete->data_type=="question_pdf"){
                     $delete->card_question_pdf_id=trim($data->card_question_pdf_id);         
                    $response=$delete->deleteQuestionPdfwithID();       
                 }
                      
                elseif($delete->data_type=="question_audio"){
                     $delete->card_question_audio_id=trim($data->card_question_audio_id);         
                     $response=$delete->deleteQuestionAudiowithID();      
                 }
                      
                elseif($delete->data_type=="question_video"){
                      $delete->card_question_video_id=trim($data->card_question_video_id);         
                      $response=$delete->deleteQuestionVideowithID();     
                 }
                
                 
        	} 
        	else{
            $response['success'] = 0;
            $response['course_id'] ="";
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}