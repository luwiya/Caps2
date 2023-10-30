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
  <title>Records</title>
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
        var table = $('#medicinesTable').DataTable({
            "paging": false,
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            "ajax": "server.php",
            "searching": false, // Disable searching
            dom: 'Bfrtip',
            buttons: [
                {extend: 'copy', attr: {id: 'medicines'}}, 'csv', 'excel', 'pdf'
            ]
        });
    });
</script>

    <script>
        $(document).ready(function () {
            var table = $('#request_medicineTable').DataTable({
                "paging": false,
                "processing": true,
                "serverSide": true,
                'serverMethod': 'post',
                "ajax": "server.php",
                dom: 'Bfrtip',
                buttons: [
                    {extend: 'copy', attr: {id: 'request_medicineTable'}}, 'csv', 'excel', 'pdf'
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
           <h3> <div class = "alert alert-info">Request Medicine Records</div></h3>
           <a class="btn btn-success" href="records.php"></i>Request Medicine</a>
            <a class="btn btn-success" href="resident_records.php"></i>Resident Records</a>
                <br> </br>
      <table name="medicinesTable" id="medicinesTable" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                   
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Expiration Date</th>
    
              </tr>

            </thead>
          <tbody>
                </tr>
            </thead>
        </table>

    </div>
                			
        	
            </tbody>
          </table>
        </div>
	
	</div>       
  </section>
</body>

  <!-- Scripts -->
  <script src="../cssmainmenu/script.js"></script>
  
</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}