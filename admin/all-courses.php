<?php include_once"template-parts/header.php"; ?>
<?php
include'dbconnection.php';
include_once 'Function/admin.php';

// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	 $admin = new Admin($db);


 $allcourses=$admin->getAllcourses();



?>  


<body>
<?php $title="All Courses"; ?>
<div class="wrapper">

 <?php include_once "template-parts/sidebar.php"; ?>
    <div class="main-panel">

 <?php include_once "template-parts/navbar.php"; ?>
 
  
                                         <table id="example1"class="table table-hover table-striped">
                                        <thead>
                                         <th>Sr No</th>
                                            <th>Created By</th>
                                            <th>Course Name</th>
                                            <th>Course Type</th>
                                            <th>Course Price</th>
                                            <th>Delete Course</th>
                                            <th>Add to Explore</th>
                                            <th>Total Downloads</th>
                                        </thead>
                                        <tbody>

<?php if($allcourses=="empty"){ ?>  
<tr>
    <td class="text-center" colspan="8"> No Data Found </td>
</tr>
        <?php } else { ?>
<?php 
$srno=1;
        foreach($allcourses as $key=>$value){
        ?>
                                            <tr>
                                                <td><?php echo $srno++;?></td>
                                                <td><?php if($allcourses[$key][name]=="") { echo "Not Available.";  } else { echo $allcourses[$key][name]; } ?></td>
                                                <td><a href="course-chapter.php?course_id=<?php echo $allcourses[$key]['course_id'] ?>"><?php echo $allcourses[$key]['course_name'];?></a></td>
                                                <td><?php echo $allcourses[$key]['course_status'];?></td>
                                                <td><?php echo $allcourses[$key]['course_price'];?></td>
                                                
                                                <td> <a href="courses/delete-course.php?course_id=<?php echo $allcourses[$key]['course_id']?>">  
                                     <button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete this course.');"><i class="fa fa-trash-o "></i></button></a></td>
                                                 <td>
                                                       <?php if($allcourses[$key]['explore_status']=='false') { ?>
								  <a href="courses/add-to-explore.php?status=add&course_id=<?php echo $allcourses[$key]['course_id']?>">  
                                     <button class="btn btn-success btn-xs" onClick="return confirm('Do you really want to Add this Course');">Add to Explore</button></a>
                                     <?php } else { ?>
                                      <a href="courses/add-to-explore.php?status=remove&course_id=<?php echo $allcourses[$key]['course_id']?>">   <button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to Delete this Payment');">Remove from Explore</button></a>
                                     <?php } ?>
                                     </td>
                                     <td>
                                          <a href="downloads.php?course_id=<?php echo $allcourses[$key]['course_id']?>" class="download-button"><i class="pe-7s-look">View Downloads</i></a>
                                     </td>
                   
                                    <!--   <td>Oud-Turnhout</td>-->
                                            </tr>
                                             <?php $record++; } } ?>
                                        </tbody>
                                       
                                    </table>
                                        </div>
                                </div>
                            
                       
         
             
       


      <?php include_once "template-parts/footer.php"; ?>

   