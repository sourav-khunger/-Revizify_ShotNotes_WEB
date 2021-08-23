<?php include_once"template-parts/header.php"; ?>

<?php
include'dbconnection.php';
include_once 'Function/admin.php';
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
    $admin = new Admin($db);
    $all_users=$admin->getAllusers();



// for deleting user
if(isset($_GET['id'])&&!isset($_GET['status']))
{
$admin->id=$_GET['id'];
if($admin->deleteUserById())
{
$_SESSION["status"]="danger";
$_SESSION["icon"]='pe-7s-junk';
$_SESSION["message"]="Dear Admin User Deleted Successfully.";  
}
}

// Update User Status
elseif(isset($_GET['id'])&&isset($_GET['status'])){
    $admin->id=$_GET['id'];
    $admin->status=$_GET['status'];
    if($admin->updateUserStatus()){
     if($_GET['status']=='0')
     {
         $_SESSION["status"]="warning";
         $_SESSION["icon"]='pe-7s-junk';
         $_SESSION["message"]="Dear Admin User deactivated Successfully."; 
     }
     elseif($_GET['status']=='1')
     {
         $_SESSION["status"]="success";
         $_SESSION["icon"]='pe-7s-junk';
         $_SESSION["message"]="Dear Admin User activated Successfully."; 
     }
    }

}

?>


<body>
<?php $title="Manage Users"; ?>
<div class="wrapper">

 <?php include_once "template-parts/sidebar.php"; ?>
    <div class="main-panel">

 <?php include_once "template-parts/navbar.php"; ?>

      
                                     <table id="example" class="table table-hover table-striped">
                                        <thead>
                                            
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>E-Mail</th>
                                            <th>Phone Number</th>
                                            <th>Delete</th>
                                            <th>Status</th>
                                            <th>Courses</th>
                                        </thead>
                                        <tbody>
  
<?php if($all_users=="empty"){ ?>  
<tr>
    <td class="text-center" colspan="8"> No Data Found </td>
</tr>
        <?php } else { ?>
<?php 
$srno=1;
        foreach($all_users as $key=>$value){
        ?>
              
                                            <tr>
                                                <td><?php echo $srno++;?></td>
                                                <td><?php if($all_users[$key][name]=="") { echo "Not Available.";  } else { echo $all_users[$key][name]; } ?></td>
                                                <td><?php if($all_users[$key][email]==""){echo "Not Available."; } else { echo $all_users[$key][email]; } ?></td>
                                               <td><?php if($all_users[$key][phone_number]==""){echo "Not Available."; } else { echo $all_users[$key][phone_number]; } ?></td>
                                                 <td>
                            <a href="manage-user.php?id=<?php echo $all_users[$key]['id'];?>"> 
                                     <button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete');"><i class="fa fa-trash-o "></i>Delete</button></a>
                                    </td>
                                    <td>
                                     
                                  <?php if($all_users[$key]['Status']==1) { ?>  
								  <a href="manage-user.php?status=0&id=<?php echo $all_users[$key]['id'];?>">  
                                     <button class="btn btn-success btn-xs" onClick="return confirm('Do you really want to Disable');">Disable</button></a>
                                  <?php } else { ?>
								   <a href="manage-user.php?status=1&id=<?php echo $all_users[$key]['id']; ?>">
								  <button class="btn btn-warning btn-xs" onClick="return confirm('Do you really want to Enable');">Enable</button></a>
								  <?php  } ?>
                                   
                                  
                     
       
             </td>
             <td><a href="user-courses.php?user_id=<?php echo $all_users[$key]['id']; ?>">View Courses</a></td>
                                             <!--   <td>Oud-Turnhout</td>-->
                                            </tr>
                                        
                                         <?php $record++; } } ?>
                                         </tbody>
                                    </table>
                                
      <?php include_once "template-parts/footer.php"; ?>

		