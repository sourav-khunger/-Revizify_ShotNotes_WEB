<?php
include_once"template-parts/header.php"; 
include'dbconnection.php';
include_once 'Function/admin.php';
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();


	$admin= new Admin($db);
	$reqpayment=$admin->requestPayment();
?>

<?php include_once"template-parts/header.php"; ?>
<body>
<?php $title="Requested Payment"; ?>
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
                                    <h4 class="card-title text-center text-warning pt-2">Requested Payments</h4>
                                    <p class="card-category text-center">You can manage Payments from here.</p>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table id="requestPayment"  class="table-requested table table-hover table-striped">
                                        <thead>
                                            
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>E-Mail</th>
                                            <th>Phone Number</th>
                                            <th>Total Amount</th>
                                            <th>Requested Amount</th>
                                            <th>Accept Payement</th>
                                            <th>Reject Payement</th>
                                            
                                        </thead>
                                        <tbody>
                                           
                                 
                 <?php if($reqpayment=="empty"){ ?>  
<tr>
    <td class="text-center" colspan="8"> No Data Found </td>
</tr>
        <?php } else { ?>
<?php 
$srno=1;
        foreach($reqpayment as $value){
        ?>
                                            <tr>
                                                <td><?php echo $srno++;?></td>
                                                <td><?php echo $value['name'];?></td>
                                                <td><?php echo $value['email'];?></td>
                                                <td><?php echo $value['phone_number'];?></td>
                                        
                                                           <td><span>&#8377;</span><?php echo $value['total_amount'];?></td>
                                             
                                                           <td><span>&#8377;</span><?php echo $value['requested_amount'];?></td>
                                                                        <td>
                                     
								  <a href="payment/manage-payment.php?status=update&user_id=<?php echo $value['id'];?>&requested_amount=<?php echo $value['requested_amount'];?>">  
                                     <button class="btn btn-success btn-xs" onClick="return confirm('Do you really want to Update this Payment');">Accept</button></a>
                                   
                                  
                     
       
             </td>
                                                  <td>
                            <a href="payment/manage-payment.php?status=reject&user_id=<?php echo $value['id'];?>&requested_amount=<?php echo $value['requested_amount'];?>&total_amount=<?php echo $row['total_amount'];?>"> 
                                     <button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to Delete this Payment');">Reject</button></a>
                                    </td>
                       
                                             <!--   <td>Oud-Turnhout</td>-->
                                            </tr>
                                        
                                        <?php } }?>
                                        </tbody>
                                    </table>
                                              
                                </div>
                            </div>
                        </div>
                        </div>
            </div>
        </div>


      <?php include_once "template-parts/footer.php"; ?>

   