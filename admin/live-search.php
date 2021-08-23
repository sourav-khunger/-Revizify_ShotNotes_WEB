<?php
$connect = mysqli_connect("localhost", "doozyco1_Shotnotes", "Shotnotes@123!@#", "doozyco1_Shotnotes");
$output = '';
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($connect, $_POST["query"]);
	$query = "
	SELECT * FROM user_info 
	WHERE name LIKE '%".$search."%'
	OR phone_number LIKE '%".$search."%' 
	OR email LIKE '%".$search."%' 
	";
}
else
{
	$query = "
	SELECT * FROM user_info ORDER BY name limit 1,5";
}
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
	$output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>Customer Name</th>
							<th>Address</th>
							<th>City</th>
							<th>Postal Code</th>
							<th>status</th>
						</tr>';
	while($row = mysqli_fetch_array($result))
	{
		$output .= '
			<tr>
				<td>'.$row["name"].'</td>
				<td>'.$row["phone_number"].'</td>
				<td>'.$row["email"].'</td>
				<td>'.$row["id"].'</td>
				<td>'.$row["status"].'</td>
			</tr>
		';
	}
	echo $output;
}
else
{
	echo 'Data Not Found';
}
?>