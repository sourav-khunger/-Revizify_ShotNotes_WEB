<?php include_once('template-parts/header.php'); 
include'dbconnection.php';
include_once 'Function/admin.php';
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
    $admin = new Admin($db);

 $allCustomer=$admin->getAllusers();

?>




		
				<!-- /.box-header -->
			
					  <table id="example" class="">
						<thead>
							<tr>
							    <th>User-Type</th>
								<th>Name</th>
								<th>Email</th>
								<th>Contact</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
						     <?php
						     foreach($allCustomer as  $customers){?>
							<tr>
							<td><?php if($customers[user_type]=="") { echo "Not Available.";  } else { echo $customers[user_type]; } ?></td>
							<td><?php if($customers[name]=="") { echo "Not Available.";  } else { echo $customers[name]; } ?></td>
								<td><?php if($customers[email]=="") { echo "Not Available.";  } else { echo $customers[email]; } ?></td>
								<td><?php if($customers[phone_number]=="") { echo "Not Available.";  } else { echo $customers[phone_number]; } ?></td>
								<td><button type="button" class="btn btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off">
								    <div class="handle"></div>
								</td>
							</tr>
							<?php }?>
							
						</tbody>				  
						<!--<tfoot>-->
						<!--	<tr>-->
						<!--		<th>Name</th>-->
						<!--		<th>Position</th>-->
						<!--		<th>Office</th>-->
						<!--		<th>Age</th>-->
						<!--		<th>Start date</th>-->
						<!--		<th>Salary</th>-->
						<!--	</tr>-->
						<!--</tfoot>-->
					</table>
		            
			
  
	 

  <?php include_once('template-parts/footer.php'); ?>