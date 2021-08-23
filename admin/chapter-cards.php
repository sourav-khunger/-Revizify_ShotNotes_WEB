<?php
include'dbconnection.php';
include_once 'Function/admin.php';

// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	 $admin = new Admin($db);

if(isset($_REQUEST['chapter_id'])){
 $admin->chapter_id=$_REQUEST['chapter_id'];
  $name=$admin->getChapterName();
 $allcards=$admin->getAllCardByChapterID();
}
else{
    header('location:all-courses.php');
}
?> 

<?php include_once"template-parts/header.php"; ?>
<body>
<?php $title="Chapter Cards"; ?>
<div class="wrapper">

 <?php include_once "template-parts/sidebar.php"; ?>
    <div class="main-panel">

 <?php include_once "template-parts/navbar.php"; ?>

        <div class="content">
            <div class="container-fluid">
                 <div class="row">
                       <h3 class="text-center title"><?php echo $name["chapter_name"]; ?></h3>
                     <div class="accordion" id="accordion">
                     <?php if($allcards=="empty"){ ?>  

    <h3 class="text-center no-data">There are no Cards in this Chapter.</h3> 

        <?php } else { 

       $i=0; foreach($allcards as $key=>$value){
              $i++;
        ?>
<div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <a href="card-details.php?card_id=<?php echo $allcards[$key]['card_id'] ?>"><button class="btn btn-link chapter-name collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $i;?>" aria-expanded="true" aria-controls="<?php echo $i;?>">
          <?php echo $allcards[$key]['card_ques'];?>
        </button></a>
      </h2>
    </div>
                        </div>
                        <?php } } ?>
            </div>
        </div>


      <?php include_once "template-parts/footer.php"; ?>

   
