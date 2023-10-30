<?php
session_start();
@include "../connection/connect.php";
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
  <title>Medicines</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link rel = "stylesheet" type = "text/css" href = "../css/style.css" />
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!--theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<style>/* Style for the dropdown container */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Style for the dropdown button */
.dropbtn {
    background: transparent;
    color: #3498db;
    padding: 10px;
    border: none;
    cursor: pointer;
}

/* Style for the dropdown content (hidden by default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 20px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    left: -100%; /* Adjust the left position to -100% to make it appear to the left */
}

/* Style for the links within the dropdown content */
.dropdown-content a {
    display: block;
    padding: 8px 20px;
    text-decoration: none;
    color: #333;
}

/* Add a hover effect on links */
.dropdown-content a:hover {
    background-color: #3498db;
    color: #fff;
}

/* Show the dropdown content when the dropdown button is hovered */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Style for icons */
.dropdown-content i {
    margin-right: 10px;
}


    </style>
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
        <h3><div class = "alert alert-info">Medicines</div></h3>
          <a class="btn btn-success" href="add_med.php?"><i class="glyphicon glyphicon-plus"></i> Add Medicine</a>
          <br />
          <br />
          <?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success" role="alert">
        <?= $_GET['success'] ?>
    </div>
<?php } ?>

<table id="table" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Sponsor</th>
            <th>Product Name</th>
            <th>Unit</th>
            <th>Batch</th>
            <th>Quantity</th>
            <th>Expiration Date</th>
            <th>Status</th>
            <th style="text-align: center;">Request</th>
            <th style="text-align: center;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = $mysqli->query("SELECT * FROM medicines") or die(mysqli_error());
        while ($fetch = $query->fetch_array()) {
            $status = ($fetch['total'] == 0) ? 'unavailable' : $fetch['status']; // Check if quantity is zero

            // Check if quantity is lower than 10
            if ($fetch['total'] < 10) {
                $quantityMessage = '<span class="text-danger">Low quantity</span>';
            } else {
                $quantityMessage = ''; // No message
            }

                    // Check if the medicine is close to expiration (within 1 year)
        $expirationDate = strtotime($fetch['expDate']);
        $expirationYear = date('Y', $expirationDate); // Get the year of the expiration date
        $currentYear = date('Y'); // Get the current year

        if ($expirationYear == $currentYear) {
            $expirationMessage = '<span class="text-warning">Expires soon</span>';
        } else {
            $expirationMessage = ''; // No message
        }

        ?>
            <tr>
                <td><?php echo $fetch['sponsor'] ?></td>
                <td><?php echo $fetch['productName'] ?></td>
                <td><?php echo $fetch['unit'] ?></td>
                <td><?php echo $fetch['batch'] ?></td>
                <td><?php echo $fetch['total'] . ' ' . $quantityMessage ?></td>
                <td><?php echo $fetch['expDate'] . ' ' . $expirationMessage ?></td>
                <td><?php echo $status ?></td>
                <td style="text-align: center">
                    <?php if ($status == 'unavailable' || $fetch['total'] == 0) : ?>
                        <button class="btn btn-primary" disabled>Request</button>
                    <?php elseif ($fetch['unit'] == 'Family Planning') : ?>
                        <a class="btn btn-primary profile-button" href="contraceptives_form.php?productName=<?php echo urlencode($fetch['productName']); ?>">Request</a>
                    <?php else : ?>
                        <a class="btn btn-primary profile-button" href="request.php?productName=<?php echo urlencode($fetch['productName']); ?>">Request</a>
                    <?php endif; ?>
                </td>
                <td style="text-align: center;">
                    <div class="dropdown">
                        <button class="dropbtn"><i class="fa-solid fa-ellipsis"></i></button>
                        <div class="dropdown-content">
                            <a href="edit_med.php?productId=<?php echo $fetch['productId'] ?>"> Edit</a><br>
                            <a href="report.php?productId=<?php echo $fetch['productId'] ?>">View</a><br>
                            <a onclick="confirmationDelete(this); return false;" href="../admin_query/delete_med.php?productId=<?php echo $fetch['productId'] ?>" style="background-color: white; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='white';"> Delete</a>
                        </div>
                    </div>
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
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Check if URL contains 'success' parameter and remove it
    if (window.location.search.includes('success')) {
        var newUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
        window.history.replaceState({ path: newUrl }, '', newUrl);
    }
});
</script>
</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}