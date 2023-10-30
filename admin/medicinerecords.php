<?php
session_start();
@include "../connection/connect.php";
if(isset($_SESSION['user_data'])){
  if($_SESSION['user_data']['usertype']!=1){
		header("Location:.././bhw/homemedd.php");
	}

	$data=array();
	$qr=mysqli_query($mysqli,"select * from user where usertype='2'");
	while($row=mysqli_fetch_assoc($qr)){
		array_push($data,$row);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Medicine Records</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
	<link rel = "stylesheet" type = "text/css" href = "../css/style.css" />
	
<!--theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
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
  <br>
  <div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
     <h3> <div class = "alert alert-info">Medicine Records</div></h3>
				<table id="table" class = "table table-striped table-hover">
					<thead>
						<tr>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Expiration Date</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = $mysqli->query("SELECT * FROM `medicines`") or die(mysqli_error());
							while ($fetch = $query->fetch_array()) {
							?>
								<tr>
									<td><?php echo $fetch['productName'] ?></td>
									<td><?php echo $fetch['total'] ?></td>
									<td><?php echo $fetch['expDate'] ?></td>
                  <td><?php echo $fetch['status'] ?></td>
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

<script src="../cssmainmenu/script.js"></script>
<script src="../js/jquery.js"></script>
<script src="../js/jquery.dataTables.js"></script>
<script src="../js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$("#table").DataTable();
	});
</script>
</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}