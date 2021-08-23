<?php
include'dbconnection.php';
include_once 'Function/admin.php';

// instantiate database and user object
	$database = new Database();
	$db = $database->getConnection();
	 $admin = new Admin($db);
	$admin_data= $admin->getAdminData();
 ?>
<?php include_once"template-parts/header.php"; ?>
<body>
<?php $title="Profile"; ?>
<div class="wrapper">
    <!-- Adiing Sidebar  -->
     <?php include_once "template-parts/sidebar.php"; ?>
     
    <div class="main-panel">
 <?php include_once "template-parts/navbar.php"; ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">
                                 <form method="POST" action="payment/update-profile.php">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Company (disabled)</label>
                                                <input type="text" class="form-control" disabled placeholder="Company" value="ShotesNote Inc.">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Username (disabled)</label>
                                                <input type="text" class="form-control" disabled placeholder="Username" required="true" value="<?php echo $admin_data['username']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input required="true" type="email" class="form-control" placeholder="email" name="email" value="<?php echo $admin_data['email']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input required="true" type="text" class="form-control" placeholder="First Name" value="<?php echo $admin_data['fname']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input required="true" type="text" class="form-control" placeholder="Last Name" value="<?php echo $admin_data['lname']; ?>">
                                            </div>
                                        </div>
                                    </div>     <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" placeholder="City" value="Mike">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" placeholder="Country" value="Andrew">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="number" class="form-control" placeholder="ZIP Code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea rows="5" class="form-control" placeholder="Here can be your description" value="Mike">Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button name="submit" type="submit" value="update-profile" class="btn btn-info btn-fill">Update Profile</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                           <div class="card">
                                
                            <div class="header">
                                
                                <h4 class="title">Update Commision <b style="color:#ffc26d;">{%}</b></h4>
                            </div>
                            <div class="content">
 <form method="POST" action="payment/update-profile.php">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Commission In Percentage <b>%</b> </label>
                                                <input type="text" class="form-control" name="Commission" placeholder="Commission" value="<?php echo $admin_data['commission']; ?>">
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row" style="justify-content: center;text-align: center;">
                                        <button name="update-commission" type="submit"  class="btn btn-info btn-fill">Update Commission</button>
                                    </div>
                                    
                                    </form>
                    </div>
</div>
                  <div class="card">
                                
                            <div class="header">
                                
                                <h4 class="title">Update Password</h4>
                            </div>
                            <div class="content">
 <form method="POST" action="payment/update-profile.php">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Current Password </label>
                                                <input type="password" class="form-control" name="current-password" placeholder="Current Password" value="****************">
                                            </div>
                                        </div>
                                        </div>
                                          <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>New Password </label>
                                                <input type="password" class="form-control" name="new-password" placeholder="New Password" value="****************">
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row" style="justify-content: center;text-align: center;">
                                        <button name="update-passowrd" type="submit"class="btn btn-info btn-fill">Update Password</button>
                                    </div>
                                    
                                    </form>
                    </div>
</div>
</div>
                </div>
            </div>
        </div>

      <?php include_once "template-parts/footer.php"; ?>
