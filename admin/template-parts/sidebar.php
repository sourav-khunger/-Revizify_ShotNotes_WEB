    <div class="sidebar" data-color="yellow" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo text-center">
                <img src="images/splashIcon.png" height="70px" width="70px"/>
                <a href="http://www.creative-tim.com" class="simple-text">
                    ShotNOTES
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="index.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="manage-user.php">
                        <i class="pe-7s-user"></i>
                        <p>Manage Users</p>
                    </a>
                </li>
                <li>
                    <a href="all-courses.php">
                        <i class="pe-7s-note2"></i>
                        <p>All Courses</p>
                    </a>
                </li>
                <li>
                  <a data-toggle="collapse" href="#Payments" class="collapsed" aria-expanded="false"><i class="pe-7s-cash"></i><p>Manage Payments<b class="caret"></b></p></a><!---->
                  <div class="collapse" id="Payments" aria-expanded="false" style="height: 0px;">
                      <ul class="nav">
                          <!---->
                      
                            <li routerlinkactive="active"><a href="user-account.php"><span class="sidebar-normal">User Bank Accounts</span></a></li>
                            <li routerlinkactive="active">
                          <a href="requested-payments.php"><span class="sidebar-normal"> Requested Payments</span></a></li>
                          <li routerlinkactive="active"><a href="paid-payments.php"><span class="sidebar-normal">Paid Payments</span></a></li>
                          <li routerlinkactive="active"><a href="rejected-payment.php"><span class="sidebar-normal">Rejected Payments</span></a></li>
                          
                          </ul>
                          </div>
                          </li>
                <!--
                <li>
                    <a href="icons.html">
                        <i class="pe-7s-science"></i>
                        <p>Icons</p>
                    </a>
                </li>
                <li>
                    <a href="maps.html">
                        <i class="pe-7s-map-marker"></i>
                        <p>Maps</p>
                    </a>
                </li>
                <li>
                    <a href="notifications.html">
                        <i class="pe-7s-bell"></i>
                        <p>Notifications</p>
                    </a>
                </li>
				<li class="active-pro">
                    <a href="#">
                        <i class="pe-7s-rocket"></i>
                        <p>Upgrade to PRO</p>
                    </a>
                </li> -->
            </ul>
    	</div>
    </div>