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
  <title>Accounts</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
 <link rel = "stylesheet" type = "text/css" href = "../css/style.css" />
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

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
    <div class = "container-fluid">
		<div class = "panel panel-default">
			<div class = "panel-body">
			<h3><div class = "alert alert-info">Accounts</div></h3>
				<a class = "btn btn-success" href = "add_account.php"><i class="glyphicon glyphicon-plus"></i>  Create New Account</a>
				<br />
				<br />
				<?php if (isset($_GET['success'])) { ?>
      	      <div class="alert alert-success" role="alert">
				  <?=$_GET['success']?>
			  </div>
			  <?php } ?>
        <table id = "table" class = "table table-striped table-hover">
					<thead>
						<tr>
					  	<th>Email</th>
							<th>Name</th>
							<th>Status</th>
             				<th style="text-align: center;">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php  
						$userTypes = [2, 3];
						$userTypesString = implode(',', $userTypes); // Converts the array to a comma-separated string

						$query = $mysqli->query("SELECT * FROM `user` WHERE usertype IN ($userTypesString)") or die(mysqli_error());
													while($fetch = $query->fetch_array()){
						?>
						<tr>
						<td><?php echo $fetch['email']?></td>
            <td><?php echo $fetch['fname'] . ' ' . $fetch['lname']; ?></td>
              <td>
			  <?php
echo ($fetch['usertype'] == 2) ? 'Active' : ($fetch['usertype'] == 3 ? 'Deactivated' : '');
?>

             </td>
                <td style="text-align: center;"><a class = "btn btn-primary profile-button" href = "edit_account.php?id=<?php echo $fetch['id']?>"> Edit</a>
			</td>
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
<script src="../js/jquery.js"></script>
<script src="../js/jquery.dataTables.js"></script>
<script src="../js/dataTables.bootstrap.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Check if URL contains 'success' parameter and remove it
    if (window.location.search.includes('success')) {
        var newUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
        window.history.replaceState({ path: newUrl }, '', newUrl);
    }
});
</script>

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