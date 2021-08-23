<?php 
include_once"template-parts/header.php";
include'dbconnection.php';
include_once 'Function/admin.php';

// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	 $admin = new Admin($db);
	  if (isset($_GET['pageno'])) {
              $pageno = $_GET['pageno'];
          } else {
              $pageno = 1;
         } 
	 if(isset($_REQUEST['course_id'])){

        
        $no_of_records_per_page = 10;
        $admin->offset = ($pageno-1) * $no_of_records_per_page; 
        
        $conn=mysqli_connect("localhost","doozyco1_Shotnotes","Shotnotes@123!@#","doozyco1_Shotnotes");
        $total_pages_sql = "SELECT COUNT(*) FROM course_payment WHERE course_id=".$_REQUEST['course_id'];
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);
        $srno= $admin->offset+1;
        $admin->no_of_records_per_page=$no_of_records_per_page;
        $record=0;

  $admin->course_id=$_REQUEST['course_id'];
  $stmt=$admin->getAllDownloadedCourses();
  $alldownloads=$stmt->fetchAll(PDO::FETCH_ASSOC);
}
else{
    header('location:all-courses.php');
}
?> 

<body>
<?php $title="Course Downloads"; ?>
<div class="wrapper">

 <?php include_once "template-parts/sidebar.php"; ?>
    <div class="main-panel">

 <?php include_once "template-parts/navbar.php"; ?>

        <div class="content">
            <div class="container-fluid">
                 <div class="row">
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header ">
                                    <h4 class="card-title text-center pt-2"><?php echo $alldownloads[1][course_name] ?></h4>
                                    <p class="card-category text-center">You can view all Downloads from here for this Course.</p>
                                    <div class="serach"><form action="" method="post">
                        <select data-trigger="" name="choices">
                <option placeholder="">Created By</option>
                <option>Free</option>
                <option>Paid</option>
                <option>Course Name</option>
              </select>
<input type="text" name="search">
<input type="submit" name="submit" value="Search">
</form></div>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            
                                            <th>Sr No</th>
                                            <th>Created By</th>
                                            <th>Purchased By</th>
                                            <th>Course Type</th>
                                            <th>Course Price</th>
                                            <th>Teacher Earning</th>
                                            <th>Admin Commission</th>
                                            <th>Purchased On</th>
                                        </thead>
                                        <tbody>
<?php
$srno=1;
foreach($alldownloads as $key=>$value){
        ?>
                  <tr>
                                            <tr>
                                                <td><?php echo $srno++;?></td>
                                                <td><?php echo $alldownloads[$key]['created_by'];?></td>
                                                <td><?php echo $alldownloads[$key]['purchased_by'];?></a></td>
                                                <td><?php echo $alldownloads[$key]['course_type'];?></td>
                                                <td><?php echo $alldownloads[$key]['course_price'];?></td>
                                                 <td><?php echo $alldownloads[$key]['amount'];?></td>
                                               <td><?php echo $alldownloads[$key]['admin_commission'];?></td> 
                                                 <td><?php echo $alldownloads[$key]['purchased_on'];?></td>
                                                
                                              
                                    <!--   <td>Oud-Turnhout</td>-->
                                            </tr>
                                        </tbody>
                                        <?php $record++;}?>
                                    </table>
                                        <div class="clearfix">
                <div class="hint-text pt-5">
                   <ul class="pagination float-left">
        <li class="page-item  <?php if($pageno <= 1){ echo 'disabled'; } ?>"><a class="page-link" href="?pageno=1">First</a></li>
        <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"> <i class="fa fa-angle-double-left"></i></a>
        </li>
        <li class="page-item <?php if($pageno>=$total_pages){ echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($pageno>=$total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><i class="fa fa-angle-double-right"></i></a>
        </li>
        <li class="page-link <?php if($pageno>=$total_pages){ echo 'disabled'; } ?>" class="page-item">
            <a href="?pageno=<?php echo $total_pages; ?>">Last</a>
            </li>
    </ul>
                <p class="float-right">Showing <?php echo $record; ?> <b></b> out of <b><?php echo $total_rows; ?></b> entries</p>
                </div>
            </div>
                                </div>
                            </div>
                        </div>
                        </div>
            </div>
        </div>


      <?php include_once "template-parts/footer.php"; ?>

   