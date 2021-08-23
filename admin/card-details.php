<?php
include'dbconnection.php';
include_once 'Function/card.php';

// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	 $card = new Card($db);
	 
if(isset($_REQUEST['card_id'])){
 $card->card_id=$_REQUEST['card_id'];
 $stmt=$card->getCardDataWithCardID();
 $card_data=$stmt->fetch(PDO::FETCH_ASSOC);
 $card->chapter_id=$card_data['chapter_id'];
   $next_card=$card->getNextCardwithId();
  $prev_card=$card->getPreviousCardwithId();
// print_r($card_data);
}
else{
    header('location:all-courses.php');
}
?> 

<?php include_once"template-parts/header.php"; ?>
<body>
<?php $title="Card Details"; ?>
<div class="wrapper">

 <?php include_once "template-parts/sidebar.php"; ?>
    <div class="main-panel">

 <?php include_once "template-parts/navbar.php"; ?>

        <div class="content">
            <div class="container-fluid">
                 <div class="row">
               <div class="container">
                   <a class="previous-card card  <?php if($prev_card=='empty'){ echo "disabled";} ?>" href="card-details.php?card_id=<?php echo $prev_card;  ?>" >Previous Card</a><a class="next-card card <?php if($next_card=='empty'){ echo "disabled";} ?>" href="card-details.php?card_id=<?php echo $next_card;  ?>">Next Card</a>
  <h2 class="text-center chapter"><?php echo $card_data["chapter_name"]; ?></h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#question">Front Side</a></li>
    <li><a data-toggle="tab" href="#answer">Back Side</a></li>
  </ul>

  <div class="tab-content">
      
         <!--- Question data Starts HERE---->
         
    <div id="question" class="tab-pane fade in active">
        
      <h3><?php echo $card_data[card_ques]; ?></h3>
 
  <!--- Question Image Section Starts HERE---->
      
<div id="question_image_section">
    <h2 class="text-center">Question Images</h2>
	<div class="row">
	    <?php 
$question_image_data=$card->getQuestionCardImageWithCardID();
if($question_image_data=="empty"){ ?>
    
      <h3 class="text-center no-data">No Question Images In this Card.</h3>

<?php }

else{
foreach($question_image_data as $key=>$value)
{
    
?>  
            <div class="col-lg-3 col-md-4 col-xs-12 thumb">
                <a class="thumbnail" href="<?php echo $question_image_data[$key]["card_question_image_url"]; ?>" data-image-id="" data-title=""
                   data-image="<?php echo $question_image_data[$key]["card_question_image_url"]; ?>"
                   >
                    <img class="img-thumbnail"
                         src="<?php echo $question_image_data[$key]["card_question_image_url"]; ?>"
                         alt="Another alt text">
                </a>
            </div>
            <?php } } ?>
            
        </div>
</div>

 <!--- Question Image Section Ends HERE---->
 
<!--- Question PDF Section Starts HERE---->

<div id="question_pdf_section">
    <h2 class="text-center">Question PDF</h2>
      <div class="row">
    <?php 
$question_pdf_data=$card->getQuestionCardPdfWithCardID();
if($question_pdf_data=="empty"){ ?>
    
      <h3 class="text-center no-data">No Question PDF In this Card.</h3>

<?php }

else{
foreach($question_pdf_data as $key=>$value)
{
    
?> 
    <div class="col-md-3">      
    <div class="card text-center">
  <img class="card-img-top" src="images/placeholder-pdf.jpg" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title"><?php echo $question_pdf_data[$key]["card_question_pdf_name"]; ?></h5>
    <a href="<?php echo $question_pdf_data[$key]["card_question_pdf_url"]; ?>" target="_blank" class="btn btn-primary">View Pdf</a>
  </div>
</div>
</div>
<?php } } ?>
  </div>
	</div>
	
	<!--- Question PDF Section Starts HERE---->
	
	<!--- Question Audio Section Starts HERE---->
		
<div id="question_audio_section">
    <h2 class="text-center">Question Audio</h2>
      <div class="row">

<?php 
$question_audio_data=$card->getQuestionCardAudioWithCardID();
if($question_audio_data=="empty"){ ?>
    
      <h3 class="text-center no-data">No Question Audios In this Card.</h3>

<?php }

else{
foreach($question_audio_data as $key=>$value)
{
    
?>          
          
    <div class="col-md-3">      
    <div class="card text-center">
  <img class="card-img-top" src="images/audio.png" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title"><?php echo $question_audio_data[$key]["card_question_audio_name"]; ?></h5>
    <audio controls>
	<source src="<?php echo $question_audio_data[$key]["card_question_audio_url"]; ?>" type="audio/mpeg" />
	<a href="<?php echo $question_audio_data[$key]["card_question_audio_url"]; ?>"><?php echo $question_audio_data[$key]["card_question_audio_name"]; ?></a>
</audio>
  </div>
</div>
</div>
<?php } } ?>
    </div>
</div>

<!--- Question Audio Section Ends HERE---->
	
 <!--- Question Video Section Starts HERE---->

<div id="question_video_section">
    <h2 class="text-center">Question Videos</h2>
    
<div class="row">
        <?php 
$question_video_data=$card->getQuestionCardVideoWithCardID();
if($question_video_data=="empty"){ ?>
    
      <h3 class="text-center no-data">No Question PDF In this Card.</h3>

<?php }

else{
foreach($question_video_data as $key=>$value)
{
    
?> 
       <div class="col-lg-3 col-md-4 col-xs-12 thumb">
 <div class="embed-responsive embed-responsive-4by3" >
  <iframe class="embed-responsive-item" src="<?php echo $question_video_data[$key]["card_question_video_url"];?>" allowfullscreen></iframe>
  <span class="file-name"><?php echo $question_video_data[$key]["card_question_video_name"]; ?></span>
</div>
  </div>
  <?php } } ?>
  </div>
</div>

 <!--- Question Video Section Ends HERE---->
 
 </div>

     <!--- Question data Ends HERE---->


    <!--- ANSWER data Starts HERE---->
    
    <div id="answer" class="tab-pane fade">
       <h3><?php echo $card_data[card_answer]; ?></h3>
       
       <!--- ANSWER Image Section Starts HERE---->
       
<div id="answer_image_section">
    <h2 class="text-center">Answer Images</h2>
	<div class="row">
	    <?php 
$answer_image_data=$card->getAnswerCardImagesWithCardID();
if($answer_image_data=="empty"){ ?>
    
      <h3 class="text-center no-data">No Answer Images In this Card.</h3>

<?php }

else{
foreach($answer_image_data as $key=>$value)
{
    
?>  
            <div class="col-lg-3 col-md-4 col-xs-12 thumb">
                <a class="thumbnail" href="<?php echo $answer_image_data[$key]["card_answer_image_url"]; ?>" data-image-id="" data-title=""
                   data-image="<?php echo $answer_image_data[$key]["card_answer_image_url"]; ?>"
                   >
                    <img class="img-thumbnail"
                         src="<?php echo $answer_image_data[$key]["card_answer_image_url"]; ?>"
                         alt="Another alt text">
                </a>
            </div>
            <?php } } ?>
            
        </div>
</div>

<!--- ANSWER Image Section Ends HERE---->

<!--- ANSWER PDF Section Starts HERE---->

<div id="answer_pdf_section">
    <h2 class="text-center">Answer PDF</h2>
      <div class="row">
    <?php 
$answer_pdf_data=$card->getAnswerCardPdfWithCardID();
if($answer_pdf_data=="empty"){ ?>
    
      <h3 class="text-center no-data">No Answer PDF In this Card.</h3>

<?php }

else{
foreach($answer_pdf_data as $key=>$value)
{
    
?> 
    <div class="col-md-3">      
    <div class="card text-center">
  <img class="card-img-top" src="images/placeholder-pdf.jpg" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title"><?php echo $answer_pdf_data[$key]["card_answer_pdf_name"]; ?></h5>
    <a href="<?php echo $answer_pdf_data[$key]["card_answer_pdf_url"]; ?>" target="_blank" class="btn btn-primary">View Pdf</a>
  </div>
</div>
</div>
<?php } } ?>
  </div>
	</div>
	
	<!--- ANSWER PDF Section Starts HERE---->
	
		<!--- ANSWER Audio Section Starts HERE---->
		
<div id="answer_audio_section">
    <h2 class="text-center">Answer Audio</h2>
      <div class="row">

<?php 
$answer_audio_data=$card->getAnswerCardAudioWithCardID();
if($answer_audio_data=="empty"){ ?>
    
      <h3 class="text-center no-data">No Answer Audios In this Card.</h3>

<?php }

else{
foreach($answer_audio_data as $key=>$value)
{
    
?>          
          
    <div class="col-md-3">      
    <div class="card text-center">
  <img class="card-img-top" src="images/audio.png" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title"><?php echo $answer_audio_data[$key]["card_answer_audio_name"]; ?></h5>
    <audio controls>
	<source src="<?php echo $answer_audio_data[$key]["card_answer_audio_url"]; ?>" type="audio/mpeg" />
	<a href="<?php echo $answer_audio_data[$key]["card_answer_audio_url"]; ?>"><?php echo $answer_audio_data[$key]["card_answer_audio_name"]; ?></a>
</audio>
  </div>
</div>
</div>
<?php } } ?>
    </div>
</div>

<!--- ANSWER Audio Section Ends HERE---->

	<!--- ANSWER Video Section Starts HERE---->
	
<div id="answer_video_section">
    <h2 class="text-center">Answer Videos</h2>
    
<div class="row">
        <?php 
$answer_video_data=$card->getAnswerCardVideoWithCardID();
if($answer_video_data=="empty"){ ?>
    
      <h3 class="text-center no-data">No Answer PDF In this Card.</h3>

<?php }

else{
foreach($answer_video_data as $key=>$value)
{
    
?> 
       <div class="col-lg-3 col-md-4 col-xs-12 thumb">
 <div class="embed-responsive embed-responsive-4by3" >
  <iframe class="embed-responsive-item" src="<?php echo $answer_video_data[$key]["card_answer_video_url"];?>" allowfullscreen></iframe>
  <span class="file-name"><?php echo $answer_video_data[$key]["card_answer_video_name"]; ?></span>
</div>
  </div>
  <?php } } ?>
  </div>
</div>

	<!--- ANSWER Video Section Starts HERE---->

</div>

 <!--- ANSWER data Ends HERE---->


	
	
</div>
    </div>

    </div>
    
    <!-- answer section ends here-->
  </div>
</div>
                        </div>
            </div>
<?php include_once "template-parts/footer.php"; ?>

   
