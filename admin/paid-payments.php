<?php include_once"template-parts/header.php"; ?>
<?php
include'dbconnection.php';
include_once 'Function/admin.php';
// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
    $admin = new Admin($db);
    $paidpayment=$admin->paidPayment();
?>
<body>
<?php $title="Paid Payments"; ?>
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
                                    <h4 class="card-title text-center text-success pt-2">Paid Payments</h4>
                                    <p class="card-category text-center">You can View Paid Payments from here.</p>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table id="paidPayments" class="table-paid table table-hover table-striped">
                                        <thead>
                                            
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>E-Mail</th>
                                            <th>Phone Number</th>
                                            <th>Paid Amount</th>
                                            <th>Payment Date</th>
                                        </thead>
                                        <tbody>
                                           <?php if($paidpayment=="empty"){ ?>  
<tr>
    <td class="text-center" colspan="8"> No Data Found </td>
</tr>
        <?php } else { ?>
<?php 
$srno=1;
        foreach($paidpayment as $value){
        ?>
                                            <tr>
                                                <td><?php echo $srno++;?></td>
                                                <td><?php echo $value['name'];?></td>
                                                <td><?php echo $value['email'];?></td>
                                                <td><?php echo $value['phone_number'];?></td>
                                        
                                                           <td><span>&#8377;</span><?php echo $value['amount'];?></td>
                                             
                                                           <td><?php echo $value['payment_date'];?></td>
                       
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

   