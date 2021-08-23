<?php
	// include database and object files
	include_once '../config/db.php';
	include_once '../config/core.php';
	include_once '../objects/user.php';
	include_once '../objects/card.php';
	include_once '../objects/upload-card-files.php';
	include_once '../objects/token.php';
	include_once '../vendor/autoload.php';
	
	use \Firebase\JWT\JWT;
	// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


// initialize object

	$bearer = new Token();
	$user = new user($db);
	$card = new card($db);
	$uploaddocs=new uploaddocs($db);
	
	// initialize user object
	$card->jwt =$bearer->getBearerToken();
	$card->course_id=$_REQUEST["course_id"];
	$card->chapter_id=$_REQUEST["chapter_id"];
    $card->card_ques=addslashes($_REQUEST["card_question"]);
	$card->card_answer=addslashes($_REQUEST["card_answer"]);
	//$uploaddocs->image= $_FILES["image"];
//	$uploaddocs->audio=$_FILES["audio"];
//	$uploaddocs->pdf=$_FILES["pdf"];


	// if decode succeed, show user details
    try {
        $decoded = JWT::decode($card->jwt, $key, array('HS256'));
        //print_r($decoded);
    	     $user->id = $decoded->data->id;
              if($user->doesUserExist()){
                
                $card->user_id = $decoded->data->id;
                $response=$card->addNewCard();
                $uploaddocs->card_id=$response['card_id'];
                
               if($response['success']==1) {
                   
                   
                   
                //Upload Answer Image //   
              	$uploaddocs->course_id=$_REQUEST["course_id"];
	            $uploaddocs->chapter_id=$_REQUEST["chapter_id"];
            if($_FILES['answer_image']){
              $countfiles = count($_FILES['answer_image']['name']);
                for($i=0;$i<$countfiles;$i++){
                    
               $t=time();
                $add = $i."-".$t."-card-".$uploaddocs->card_id ."-answer_image.png";

                $target_dir ="/home/doozyco1/public_html/shotnotes/API/uploads/card_files/card_answer_image/". $add;
              if(move_uploaded_file($_FILES['answer_image']['tmp_name'][$i], $target_dir)){
                 $uploaddocs->url=$baseurl."/API/uploads/card_files/card_answer_image/". $add;
                 $uploaddocs->name=$_FILES['answer_image']['name'][$i];
                    $uploaddocs->addAnswerImage(); 
              }
              else{
                  $response["answer_image_message"] ="Image Uploading Failed";
              }
              }
             /* $stmt= $uploaddocs->getAllAnswerImagesWithCardID();
                $image_data =$stmt->fetchAll(PDO::FETCH_ASSOC);
    			$response["image"] =$image_data;   */
                }
                else{
                    $response["answer_image_message"] ="Image Not Recieved";
                }
        
                
                
               //Upload Answer audio // 
               
               
                
            if($_FILES['answer_audio']){
              $countfiles = count($_FILES['answer_audio']['name']);
                for($i=0;$i<$countfiles;$i++){
                    
               $t=time();
                $add = $i."-".$t."-card-".$uploaddocs->card_id ."-answer_audio.mp3";
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/card_files/card_answer_audio/". $add;   
              if(move_uploaded_file($_FILES['answer_audio']['tmp_name'][$i], $target_dir)){
                  $uploaddocs->url=$baseurl."/API/uploads/card_files/card_answer_audio/". $add;    
                   $uploaddocs->name= $_FILES['answer_audio']['name'][$i];
                    $uploaddocs->addAnswerAudio(); 
              }
                 else{
                  $response["answer_audio_message"] ="Audio Uploading Failed";
              }
              }
               /* $stmt= $uploaddocs->getAllAnswerAudiosWithCardID();
                $audio_data =$stmt->fetchAll(PDO::FETCH_ASSOC);
    			$response["audio"] =$audio_data;   */
                }
                 else{
                    $response["answer_audio_message"] ="Audio Not Recieved";
                }
                 
                  //Upload Answer Pdf //   
                  
                   
            if($_FILES['answer_pdf']){
              $countfiles = count($_FILES['answer_pdf']['name']);
                for($i=0;$i<$countfiles;$i++){
                    
               $t=time();
                $add = $i."-".$t."-card-".$uploaddocs->card_id ."-answer_pdf.pdf";
                 //$filename = $_FILES['image']['name'][$i];
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/card_files/card_answer_pdf/". $add;   
              if(move_uploaded_file($_FILES['answer_pdf']['tmp_name'][$i], $target_dir)){
                  $uploaddocs->url=$baseurl."/API/uploads/card_files/card_answer_pdf/". $add;    
                  $uploaddocs->name= $_FILES['answer_pdf']['name'][$i];
                    $uploaddocs->addAnswerPdf(); 
              }
               else{
                  $response["answer_pdf_message"] ="PDF Uploading Failed";
              }
              }
            /*  $stmt= $uploaddocs->getAllAnswerPdfWithCardID();
                $pdf_data =$stmt->fetchAll(PDO::FETCH_ASSOC);
    			$response["pdf"] =$pdf_data;   */
                }
            else{
                  $response["answer_pdf_message"] ="PDF Not Received";
              }
                  
                         //Upload Answer Video //   
                  
                   
            if($_FILES['answer_video']){
              $countfiles = count($_FILES['answer_video']['name']);
                for($i=0;$i<$countfiles;$i++){
                    
               $t=time();
                $add = $i."-".$t."-card-".$uploaddocs->card_id ."-answer_video-".$_FILES['answer_video']['name'][$i];
                 //$filename = $_FILES['image']['name'][$i];
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/card_files/card_answer_video/". $add;   
              if(move_uploaded_file($_FILES['answer_video']['tmp_name'][$i], $target_dir)){
                  $uploaddocs->url=$baseurl."/API/uploads/card_files/card_answer_video/". $add;    
                  $uploaddocs->name= $_FILES['answer_video']['name'][$i];
                    $uploaddocs->addAnswerVideo(); 
              }
               else{
                  $response["answer_video_message"] ="Video Uploading Failed";
              }
              }
            /*  $stmt= $uploaddocs->getAllAnswerPdfWithCardID();
                $pdf_data =$stmt->fetchAll(PDO::FETCH_ASSOC);
    			$response["pdf"] =$pdf_data;   */
                }
            else{
                  $response["answer_video_message"] ="Video Not Received";
              }
              
                                 
                   
                //Upload Question Image //   
              
            if($_FILES['question_image']){
              $countfiles = count($_FILES['question_image']['name']);
                for($i=0;$i<$countfiles;$i++){
                    
               $t=time();
                $add = $i."-".$t."-card-".$uploaddocs->card_id ."-question_image.png";

            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/card_files/card_question_image/". $add;
              if(move_uploaded_file($_FILES['question_image']['tmp_name'][$i], $target_dir)){
                  $uploaddocs->url=$baseurl."/API/uploads/card_files/card_question_image/". $add;
                  $uploaddocs->name= $_FILES['question_image']['name'][$i];
                    $uploaddocs->addQuestionImage(); 
              }
                else{
                  $response["question_image_message"] ="Image Uploading Failed";
              }
              }
            /*  $stmt= $uploaddocs->getAllQuestionImagesWithCardID();
                $question_image_data =$stmt->fetchAll(PDO::FETCH_ASSOC);
    			$response["question_image"] =$question_image_data;   */
                }
                  else{
                  $response["question_image_message"] ="Image not recieved";
              }
        
                
      
               //Upload Question audio // 
               
               
                
            if($_FILES['question_audio']){
              $countfiles = count($_FILES['question_audio']['name']);
                for($i=0;$i<$countfiles;$i++){
                    
               $t=time();
                $add = $i."-".$t."-card-".$uploaddocs->card_id ."-question_audio.mp3";
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/card_files/card_question_audio/". $add;   
              if(move_uploaded_file($_FILES['question_audio']['tmp_name'][$i], $target_dir)){
                  $uploaddocs->url=$baseurl."/API/uploads/card_files/card_question_audio/". $add;
                  $uploaddocs->name= $_FILES['question_audio']['name'][$i];
                    $uploaddocs->addQuestionAudio(); 
              }
                 else{
                  $response["question_audio_message"] ="Audio Uploading Failed";
              }
              }
             /* $stmt= $uploaddocs->getAllQuestionAudiosWithCardID();
                $question_audio_data =$stmt->fetchAll(PDO::FETCH_ASSOC);
    			$response["question_audio"] =$question_audio_data;   */
                }
                 else{
                  $response["question_audio_message"] ="Audio Not Received";
              }  
                 
                  //Upload Question Pdf //   
                  
                   
            if($_FILES['question_pdf']){
              $countfiles = count($_FILES['question_pdf']['name']);
                for($i=0;$i<$countfiles;$i++){
                    
               $t=time();
                $add = $i."-".$t."-card-".$uploaddocs->card_id ."-question_pdf.pdf";
                 //$filename = $_FILES['image']['name'][$i];
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/card_files/card_question_pdf/". $add;   
              if(move_uploaded_file($_FILES['question_pdf']['tmp_name'][$i], $target_dir)){
                  $uploaddocs->url=$baseurl."/API/uploads/card_files/card_question_pdf/". $add; 
                   $uploaddocs->name= $_FILES['question_pdf']['name'][$i];
                    $uploaddocs->addQuestionPdf(); 
              }
                else{
                  $response["question_pdf_message"] ="PDF Uploading Failed";
              }
              }

                }
             else{
                  $response["question_pdf_message"] ="PDF not received";
              }
                //$response['files'] ="Files Uploaded Successfully";
                    //Upload Question Video //   
                  
                   
            if($_FILES['question_video']){
              $countfiles = count($_FILES['question_video']['name']);
                for($i=0;$i<$countfiles;$i++){
                $t=time();
                $add = $i."-".$t."-card-".$uploaddocs->card_id ."-question_video-".$_FILES['question_video']['name'][$i];
                 //$filename = $_FILES['image']['name'][$i];
            	$target_dir = "/home/doozyco1/public_html/shotnotes/API/uploads/card_files/card_question_video/". $add;   
              if(move_uploaded_file($_FILES['question_video']['tmp_name'][$i], $target_dir)){
                  $uploaddocs->url=$baseurl."/API/uploads/card_files/card_question_video/". $add;    
                  $uploaddocs->name= $_FILES['question_video']['name'][$i];
                    $uploaddocs->addQuestionVideo(); 
              }
               else{
                  $response["questionr_video_message"] ="Video Uploading Failed";
              }
              }
            /*  $stmt= $uploaddocs->getAllAnswerPdfWithCardID();
                $pdf_data =$stmt->fetchAll(PDO::FETCH_ASSOC);
    			$response["pdf"] =$pdf_data;   */
                }
            else{
                  $response["question_video_message"] ="Video Not Received";
              }  
               }
               else{
                   
                  // $response['files'] ="Files Uploading Failed";
                 
               }
             
              
        	} 
        	else{
            $response['success'] = 0;
		    $response['message'] = "You are not an authorised user to perform this action.";
        }
	    
	    echo json_encode($response);
    }catch (Exception $e){ // if decode fails, it means jwt is invalid
		$response['success'] = "0";
		 $response['url'] ="";
		$response['message'] = "JWT was not Verified. ". $e->getMessage();
		
		echo json_encode( $response
		);
	}