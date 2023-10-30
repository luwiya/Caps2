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
  <title>Account/Change Account</title>
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
    <div class = "container-fluid">
		<div class = "panel panel-default">
			<div class = "panel-body">
				<h3><div class = "alert alert-info">Account / Change Account</div></h3>
				<?php
					$query = $mysqli->query("SELECT * FROM `user` WHERE `id` = '$_REQUEST[id]'") or die(mysqli_error());
					$fetch = $query->fetch_array();
				?>
				<br />
				<div class = "col-md-4">	
					<form method = "POST" action = "../admin_query/edit_query_account.php?id=<?php echo $fetch['id']?>">
            <div class = "form-group">
            <label>First Name </label>
            <input type = "text"  class = "form-control" value = "<?php echo $fetch['fname']?>" name = "fname" />
            </div>
            <div class = "form-group">
              <label>Last Name </label>
                <input type = "text"  class = "form-control" value = "<?php echo $fetch['lname']?>" name = "lname" />
            </div>
            <div class = "form-group">
            <label> Address </label>
              <input type = "text"  class = "form-control" value = "<?php echo $fetch['address']?>" name = "address" required/>
            </div>
            <div class = "form-group">
              <label>Mobile Number </label>
                <input type = "text"  class = "form-control"  id="mobileNumber" value = "<?php echo $fetch['mobile_number']?>" name = "mobile_number" required/>
                <small id="contactNumberError" class="form-text text-danger"></small>
            </div>
						<div class = "form-group">
							<label>Email </label>
							<input type = "text" class = "form-control" id="email" value = "<?php echo $fetch['email']?>" name = "email" />
							<small id="emailError" class="form-text text-danger"></small>
						</div>
	
						<div class="form-group">
							<label for="usertypeSelect">Status</label>
							<select class="form-control" required="required" name="usertype" id="usertypeSelect">
								<option value="" disabled selected>Select User Type</option>
								<option value="2" <?php if ($fetch['usertype'] === '2') echo 'selected'; ?>>Activate</option>
								<option value="3" <?php if ($fetch['usertype'] === '3') echo 'selected'; ?>>Deactivate</option>

                            </select>
						</div>
					
						<br />
						<div class = "form-group">
							<button name = "edit_account" class = "btn btn-warning form-control"><i class = "bx bx-save"></i>  Save Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
</body>
  <!-- Scripts -->
  <script src="../cssmainmenu/script.js"></script>
  <script>
   // ContactNumber can only input 11 numbers
   document.querySelector('#mobileNumber').addEventListener('input', function () {
        const input = this.value.toString(); // Convert the input to a string
        const contactNumberError = document.querySelector('#contactNumberError');

        if (input.length !== 11 || isNaN(input) || !input.startsWith('09')) {
            contactNumberError.textContent = 'Contact number must start with "09" and be exactly 11 digits.';
            this.setCustomValidity('Contact number must start with "09" and be exactly 11 digits.');
        } else {
            contactNumberError.textContent = '';
            this.setCustomValidity('');
        }
    });
    document.querySelector('#email').addEventListener('input', function () { //email
        const input = this.value;
        const emailError = document.querySelector('#emailError');
        
        if (input.length < 6 || input.length > 28) {
            emailError.textContent = '*Email must be 6-28 characters.';
            this.setCustomValidity('*Email must be 6-28 characters.');
        } else {
            emailError.textContent = '';
            this.setCustomValidity('');
        }
    });
</script>
<script>//MobileNumber warning
    // MobileNumber can only input 11 numbers starting with "09"
    document.querySelector('#mobileNumber').addEventListener('input', function () {
        const input = this.value.toString(); // Convert the input to a string
        const contactNumberError = document.querySelector('#contactNumberError');

        if (input.length !== 11 || isNaN(input) || !input.startsWith('09')) {
            contactNumberError.textContent = 'Mobile number must start with "09" and be exactly 11 digits.';
            this.setCustomValidity('Mobile number must start with "09" and be exactly 11 digits.');
        } else {
            contactNumberError.textContent = '';
            this.setCustomValidity('');
        }
    });
</script>
<script>
    document.querySelector('#email').addEventListener('input', function () {
        const input = this.value;
        const emailError = document.querySelector('#emailError');
        
        if (input.length > 27) {
            this.value = input.slice(0, 27); // Truncate the input to 24 characters
        }

        if (input.length < 6 || input.length > 27) {
            emailError.textContent = 'Email must be 6-24 characters.';
            emailError.style.display = 'block'; // Ensure the error message is displayed
            this.setCustomValidity('Email must be 6-24 characters.');
        } else {
            emailError.textContent = '';
            emailError.style.display = 'none'; // Hide the error message
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