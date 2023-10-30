<?php
session_start();
@include "../connection/connect.php";
if(isset($_SESSION['user_data'])){
    if($_SESSION['user_data']['usertype'] != 2){
        header("Location:.././admin/Dashboard.php");
    }

    $data = array();
    $qr = mysqli_query($mysqli, "select * from user where usertype='1'");
    while($row = mysqli_fetch_assoc($qr)){
        array_push($data, $row);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Contraceptive Request</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" href="../cssmainmenu/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
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
                    <div class="alert alert-info">Request Contraceptive</div>
                    <br />
        
				<?php if (isset($_GET['success'])) { ?>
					<div class="alert alert-success" role="alert">
						<?=$_GET['success']?>
					</div>
					<?php } ?>
                   
                    <div class="col-md-4">
                    <?php
      if (isset($_GET['residentId'])) {
            $desiredResidentId = $_GET['residentId'];
            
            // Replace 'residentrecords' with your actual table name and 'resident_id' with the actual column name
            $query = $mysqli->query("SELECT * FROM residentrecords WHERE residentId = '$desiredResidentId'");
            while ($fetch = $query->fetch_assoc()) {
                
            // Display the records within the table rows
            
            // Assuming $fetch['residentName'] contains the desired name
            $lastName = isset($fetch['lastName']) ? $fetch['lastName'] : '';
            $firstName = isset($fetch['firstName']) ? $fetch['firstName'] : '';
            $middleName = isset($fetch['middleName']) ? $fetch['middleName'] : '';
            $address = isset($fetch['address']) ? $fetch['address'] : '';
        }
        } else {
            echo '<tr><td colspan="3">Resident ID not provided in the URL.</td></tr>';
        }
      ?>
                        
                 <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                         <?php
                            if (isset($_GET['residentId'])) {
                                 // Retrieve the 'residentId' value from the URL
                                $residentId = $_GET['residentId'];                                    
                                // Now, you have the 'residentId' value in the $residentId variable
                                // You can use it for database operations or any other purpose
                                echo "Resident ID: " . $residentId;
                            } else {
                              // Handle the case where 'residentId' is not provided in the URL
                                echo "Resident ID not found in the URL.";
                             }
                           ?>
                        </div>
                        <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastName" 
                                value="<?php echo $lastName; ?> "readonly />
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstName" 
                                value="<?php echo $firstName; ?> "readonly />
                            </div>
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="middleName" 
                                value="<?php echo $middleName; ?> "readonly />
                            </div>

                            <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" 
                             value="<?php echo $address; ?>" readonly />
                            </div>
                            <div class="form-group">
                                <label>Type of Client</label>
                                <input type="text" class="form-control" name="clientype" id="clientype" readonly value="Dropout" />
                            </div>
                            <div class="form-group" id="changingMethodSection" >
                            <label>Method Currently used</label>
                            <select class="form-control" name="changingMethod"> 
                                <option value="" disabled selected>Changing Method</option>
                                <option value="COC">COC (Combined Oral Contraceptives)</option>
                                <option value="IUD">IUD (Intrauterine Device)</option>
                                <option value="POP">POP (Progestogen-only Pills)</option>
                                <option value="BOM/CMM">BOM/CMM (Billings Ovulation Method)</option>
                                <option value="Injectable">Injectable</option>
                                <option value="BBT">BBT (Basal Body Temperature)</option>
                                <option value="Implant">Implant</option>
                                <option value="STM">STM (Symptothermal Method)</option>
                                <option value="LAM">LAM (Lactational Amenorrhea Method)</option>
                               
                               
                            </select>
                            <div>
                            <div class="form-group" required="required" required>
                                <label>Dropout Date</label>
                                <input type="date" class="form-control" name="givenDate" id="givenDate" required/>    
                          </div>
                     
                            <div class="form-group">
                                <button name="add_rec" class="btn btn-primary profile-button form-control"><i
                                        class="bx bx-pencil"></i> Dropout</button>
                            </div>
                            
                            <?php require_once '../admin_query/dropout_query.php'?>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <script src="../cssmainmenu/script.js"></script>
 <script>
  document.addEventListener("DOMContentLoaded", function() {
    // Check if URL contains 'success' parameter and remove it
    if (window.location.search.includes('success')) {
        var newUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
        window.history.replaceState({ path: newUrl }, '', newUrl);
    }
});
/*This is for the given date not to select previous dates*/
 // Get the current date in YYYY-MM-DD format
 var currentDate = new Date().toISOString().split('T')[0];

// Set the minimum date attribute of the input element to the current date
document.getElementById('givenDate').setAttribute('min', currentDate);

// Add an event listener to the input element to prevent selecting past dates
document.getElementById('givenDate').addEventListener('input', function() {
    var selectedDate = this.value;
    if (selectedDate < currentDate) {
        this.setCustomValidity('Please select a date on or after the current date.');
    } else {
        this.setCustomValidity('');
    }
});
</script>

</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}
