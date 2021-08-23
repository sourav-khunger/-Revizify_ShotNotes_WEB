  <footer class="footer">
            <div class="container-fluid">
              <!--  <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Blog
                            </a>
                        </li>
                    </ul>
                </nav> -->
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>  <strong>Shotes Note</strong> made with love for a better web by <a href="http://www.doozycodsystems.com">DoozyCodsytems</a>
                </p>
            </div>
        </footer>
         </div>
</div>

user-accountSearch.js
</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/datatable/datatables.min.js"></script>
    <script src="assets/js/data_table_courses.js"></script>
	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>
    
        <!--  Alert Plugin    -->
    <script src="assets/js/sweetalert2.min.js"></script>
<?php
// for notification
if(isset($_SESSION['status']))
{

    	echo "<script type='text/javascript'>
    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon:'".$_SESSION['icon']."',
            	message:'".$_SESSION['message']."'

            },{
                type: '".$_SESSION['status']."',
                timer: 4000
            });

    	});
	</script>";
}
unset($_SESSION["status"]);
unset($_SESSION["message"]);
unset($_SESSION["icon"]);
?>
    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/custom.js"></script> 



</html>
