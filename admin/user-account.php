<?php 
include_once"template-parts/header.php";
include'dbconnection.php';
include_once 'Function/admin.php';

// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	 $admin = new Admin($db);
	 
  $stmt=$admin->getAllUserbankDetails();
  $allbanks=$stmt->fetchAll(PDO::FETCH_ASSOC);
?> 

<body>
<?php $title="User Bank Details"; ?>
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
                                    <h4 class="card-title text-center pt-2">
                                    User Bank Account</h4>
                                    <p class="card-category text-center">You can view User bank account details from here.</p>
                               
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table id="userAccount" class="table table-hover table-striped">
                                        <thead>
                                             <th>Sr No</th>
                                            <th>Account Holder Name</th>
                                            <th>Account No.</th>
                                            <th>Bank Name</th>
                                            <th>IFSC Code</th>
                                        </thead>
                                        <tbody>
<?php
$srno=1;
foreach($allbanks as $key=>$value){
        ?>
                
                                            <tr>
                                                <td><?php echo $srno++;?></td>
                                                <td><?php echo $allbanks[$key]['account_holder_name'];?></td>
                                                <td><?php echo $allbanks[$key]['account_number'];?></a></td>
                                                <td><?php echo $allbanks[$key]['account_ifsc_code'];?></td>
                                                <td><?php echo $allbanks[$key]['bank_name'];?></td>
                                                
                                              
                                    <!--   <td>Oud-Turnhout</td>-->
                                            </tr>
                                        
                                       <?php } ?>
                                       </tbody>
                                    </table>
                                  </div>
                            </div>
                        </div>
                        </div>
            </div>
        </div>

 
      <?php include_once "template-parts/footer.php"; ?>

   