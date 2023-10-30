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
    <title>Request Medicine</title>
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
                <h3>  <div class="alert alert-info">Request Medicine</div></h3>
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
                        
            <?php
                 $productName = isset($_GET['productName']) ? $_GET['productName'] : '';
                 $query = $mysqli->query("SELECT * FROM `medicines` WHERE productName = '$productName'") or die(mysqli_error());
                 $fetch = $query->fetch_array();
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
                                <label>Product ID</label>
                                <input type="text" class="form-control" name="productId"
                                    value="<?php echo $fetch['productId']; ?>" readonly />
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="productName"
                                    value="<?php echo $fetch['productName']; ?>" readonly />
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" name="unit"
                                    value="<?php echo $fetch['unit']; ?>" readonly />
                            </div>
                            <div class="form-group">
                                <label>Product Quantity</label>
                                <input type="text" class="form-control" name="total"
                                    value="<?php echo $fetch['total']; ?>" readonly />
                            </div>
                            
                            <div class="form-group" required="required" required>
                                <label>Quantity Request</label>
                                <input type="number" value=0 min="0" max="999999999" class="form-control"
                                 name="quantity_req" id="quantityInput" placeholder ="Enter Quantity Request" required />
                                    <small id="quantityInputError" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group" required="required" required>
                                <label>Given Date</label>
                                <input type="date" class="form-control" name="givenDate" id="givenDate" required/>
                            </div>
                            <div class="form-group">
                                <button name="add_rec" class="btn btn-primary profile-button form-control"><i
                                        class="bx bx-pencil"></i> Request</button>
                            </div>
                            <?php require_once '../admin_query/add_query_records2.php'?>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

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
</script>
<script>
    document.querySelector('#quantityInput').addEventListener('input', function () {
        const input = parseFloat(this.value); // Parse the input as a float
        const stockValueInput = document.querySelector('input[name="total"]');
        const stockValue = parseFloat(stockValueInput.value);
        const quantityInputError = document.querySelector('#quantityInputError');

        if (isNaN(input) || input < 0 || input > stockValue) {
            quantityInputError.textContent = 'Quantity is invalid or exceeds the stock.';
            this.setCustomValidity('Quantity is invalid or exceeds the stock.');
        } else {
            quantityInputError.textContent = '';
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
