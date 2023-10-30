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
  <title>Reports</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
  <link rel = "stylesheet" type = "text/css" href = "../css/style.css" />
  
<!--theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">


  <script src="vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet"  href="vendor/DataTables/jquery.datatables.min.css">	
    <script src="vendor/DataTables/jquery.dataTables.min.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/jszip.min.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/pdfmake.min.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/vfs_fonts.js" type="text/javascript"></script> 
    <script src="vendor/DataTables/buttons.html5.min.js" type="text/javascript"></script> 
    <link rel="stylesheet"  href="vendor/DataTables/buttons.datatables.min.css">    
    <script src="vendor/DataTables/dataTables.buttons.min.js" type="text/javascript"></script> 
    <script>
    $(document).ready(function () {
        var table = $('#table').DataTable({
        
            "searching": false, // Disable searching
            dom: 'Bfrtip',
            buttons: [
                {extend: 'copy', attr: {id: 'medicines'}}, 'csv', 'excel', 'pdf'
            ]
        });
    });
</script>
  
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
				<h3><div class="alert alert-info">Reports</div></h3>
      <div>
        <?php
            if (isset($_GET['productId'])) {
              $desiredProductId = $_GET['productId'];
              
              // Replace 'medicine' with your actual table name and 'resident_id' with the actual column name
              $query = $mysqli->query("SELECT * FROM medicines WHERE productId = '$desiredProductId'");
              while ($fetch = $query->fetch_assoc()) {
                  
                // Display the records within the table rows
            
                echo '<h2>' . $fetch['sponsor'] . '</h2>';

            }
          } else {
              echo '<tr><td colspan="3">product ID not provided in the URL.</td></tr>';
          }
        ?>
      </div>
    <br />
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th>Resindent Name</th>
                <th>Product Name</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>Given Date</th>
              </tr>
            </thead>
          <tbody>
      <?php  
          if (isset($_GET['productId'])) {
              $desiredProductId = $_GET['productId'];
              
              // Replace 'residentrecords' with your actual table name and 'resident_id' with the actual column name
              $query = $mysqli->query("SELECT * FROM request_medicine WHERE productId = '$desiredProductId'");

              if ($query->num_rows > 0) {
                  while ($fetch = $query->fetch_assoc()) {
                    
                      echo '<tr>';
                      echo '<td>' . $fetch['lastName'] . ' ' . $fetch['firstName'] . ' ' . $fetch['middleName'] . '</td>';
                      echo '<td>' . $fetch['productName'] . '</td>';
                      echo '<td>' . $fetch['unit'] . '</td>';
                      echo '<td>' . $fetch['quantity_req'] . '</td>';
                      echo '<td>' . $fetch['givenDate'] . '</td>';
                      echo '</tr>';
                   
                  }
              } else {
                  echo '<tr><td colspan="3">No records found!.</td></tr>';
              }
          } else {
              echo '<tr><td colspan="3">Product ID not provided in the URL.</td></tr>';
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
  <script type = "text/javascript">
	function confirmationDelete(anchor){
		var conf = confirm("Are you sure you want to delete this record?");
		if(conf){
			window.location = anchor.attr("href");
		}
	} 
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
<script>
  
  </script>
</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}