<?php
session_start();
include "../connection/connect.php";
if(isset($_SESSION['user_data'])){
	if($_SESSION['user_data']['usertype']!=2){
		header("Location:.././admin/Dashboard.php");
	}

	$data=array();
	$qr=mysqli_query($mysqli,"select * from user where usertype='1'");
	while($row=mysqli_fetch_assoc($qr)){
		array_push($data,$row);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Responsive Sidebar</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
  <link rel = "stylesheet" type = "text/css" href = "../css/style.css" />

</head>
<body>
<?php try {
    include_once('side_menu.php');
} catch (Exception $e) {
    // Handle the error, e.g., log it or display a user-friendly message.
    echo "Error: " . $e->getMessage();
}
 ?>
  <section class="home-section">
    <div class="text">Records</div>
    <div class = "container-fluid">
		<div class = "panel panel-default">
			<div class = "panel-body">
				<div class = "alert alert-info">Records</div>
				<br />
				<?php if (isset($_GET['success'])) { ?>
					<div class="alert alert-success" role="alert">
						<?=$_GET['success']?>
					</div>
					<?php } ?>
				<br />
				<table id = "table" class = "table table-bordered">
					<thead>
						<tr>
							<th>Resident Name</th>
							<th>Date of Birth</th>
							<th>Age</th>
							<th>Sex</th>
							<th>Address</th>
							<th>Contact Number</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Given Date</th>							
						</tr>
					</thead>
				<tbody>
					<?php
						$query = $mysqli->query("SELECT * FROM `residentrecords`") or die(mysqli_error());
						while($fetch = $query->fetch_array()){
					?>	
						<tr>
							<td><?php echo $fetch['lastName'] . ' ' . $fetch['firstName'] . ' ' . $fetch['middleName']; ?></td>
							<td><?php echo $fetch['dateBirth']?></td>
							<td><?php echo $fetch['age']?></td>
							<td><?php echo $fetch['sex']?></td>
							<td><?php echo $fetch['address']?></td>
							<td><?php echo $fetch['contactNumber']?></td>
							<td><?php echo $fetch['productName']?></td>
							<td><?php echo $fetch['quantity_req']?></td>
							<td><?php echo $fetch['givenDate']?></td>
						</tr>
					<?php
						}
					?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
 </section>
</body>

<!-- Scripts -->
<script src="../cssmainmenu/script.js"></script>
  <script type = "text/javascript">
	function confirmationDelete(anchor){
		var conf = confirm("Are you sure you want to delete this record?");
		if(conf){
			window.location = anchor.attr("href");
		}
	} 
</script>
<script src = "../js/jquery.js"></script>
<script src = "../js/jquery.dataTables.js"></script>
<script src = "../js/dataTables.bootstrap.js"></script>	
<script type = "text/javascript">
	$(document).ready(function(){
		$("#table").DataTable();
	});
</script>

</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}