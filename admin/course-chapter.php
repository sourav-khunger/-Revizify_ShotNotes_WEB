<?php
include'dbconnection.php';
include_once 'Function/admin.php';

// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	 $admin = new Admin($db);

        if(isset($_REQUEST['course_id'])){
 $admin->course_id=$_REQUEST['course_id'];
 $name=$admin->getCourseName();
 $allchapter=$admin->getAllCourseChapterByCourseID();
// print_r($allchapter);
}
else{
    header('location:all-courses.php');
}
?>  

<?php include_once"template-parts/header.php"; ?>
<body>
<?php $title="Course Chapters"; ?>
<div class="wrapper">

 <?php include_once "template-parts/sidebar.php"; ?>
    <div class="main-panel">

 <?php include_once "template-parts/navbar.php"; ?>

        <div class="content">
            <div class="container-fluid">
                 <div class="row">
                     <h3 class="text-center title"><?php echo $name["course_name"]; ?></h3>
                   
                     <div class="accordion" id="accordion">
                         
                           <?php if($allchapter=="empty"){ ?>  

    <h3 class="text-center no-data">There are no Chapters in this course.</h3> 

        <?php } else { 

       $i=0; foreach($allchapter as $key=>$value){
              $i++;
        ?>
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link chapter-name collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="true" aria-controls="<?php echo $i;?>">
          <?php echo $i.'  '.$allchapter[$key]['chapter_name'];?>
        </button>
      </h2>
    </div>

    <div id="<?php echo $i;?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
       <p>  <?php echo $allchapter[$key]['chapter_description'];?></p>
            <a href="chapter-cards.php?chapter_id=<?php echo $allchapter[$key]['chapter_id'] ?>" class="view-cards">View Cards</a>
      </div>
    </div>
  </div>
<?php } } ?>
         
                </div>
                        </div>
            </div>
        </div>


      <?php include_once "template-parts/footer.php"; ?>

   