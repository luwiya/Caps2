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
  <title>Create Account</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
 <link rel = "stylesheet" type = "text/css" href = "../css/style.css" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 
<!--theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

</head>
<style>
  .password-input-container {
            position: relative;
        }

        .toggle-password-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            .toggle-password-btn {
                right: 5px; /* Adjust the button's position for smaller screens */
            }
        }
</style>
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
				<h3><div class = "alert alert-info">Account / Create Account</div></h3>
				<div class = "col-md-4">	
    <div class="form-container">
    <form action="" method="POST">
    <?php if (isset($_SESSION['error_message'])) { ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
    <?php } ?>
	   <br></br>
     <div class = "form-group">
			<label>First Name </label>
				<input type = "text"  class = "form-control" name = "fname" required/>
	  </div>
    <div class = "form-group">
			<label>Last Name </label>
				<input type = "text"  class = "form-control" name = "lname" required/>
	  </div>
    <div class = "form-group">
			<label> Address </label>
				<input type = "text"  class = "form-control" name = "address" required/>
	  </div>
    <div class = "form-group">
			<label>Mobile Number </label>
				<input type = "text"  class = "form-control" name = "mobile_number" id = "mobileNumber"required/>
                <small id="contactNumberError" class="form-text text-danger"></small>
	  </div>
    <div class="form-group">
        <label>Email </label>
        <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com" required/>
        <small id="emailError" class="form-text text-danger">Email must be 6-28 characters.</small>
    </div>
    <div class="form-group">
    <label>Password</label>
    <div class="password-input-container">
        <input type="password" placeholder="Enter your password" name="password" class="form-control" id="password" autocomplete="off" required style="padding-right: 40px;" oninput="validatePassword()" />
        <button type="button" id="passwordToggle" class="toggle-password-btn" onclick="togglePasswordVisibility('password')">
            <i class="fas fa-eye-slash"></i>
        </button>
    </div>
    <p id="password-validation-msg" class="form-text text-danger"></p> <!-- Add a paragraph for validation messages -->
</div>


    <div class="form-group">
        <label>Confirm Password</label>
        <div class="password-input-container">
            <input type="password" placeholder="Confirm your password" name="cpassword" class="form-control" id="cpassword" oninput="togglePasswordButton('cpasswordToggle')" autocomplete="off" required style="padding-right: 40px;" />
            <button type="button" id="cpasswordToggle" class="toggle-password-btn" onclick="togglePasswordVisibility('cpassword')">
                <i class="fas fa-eye-slash"></i>
            </button>
        </div>
    </div>	
    <label>User Type</label>
<select class="form-control" required="required" name="usertype" id="usertypeSelect">
    <option value="" disabled selected>Select User Type</option>
    <option value="2">BHW</option>
    <option value="1">Admin</option>
</select>
</div>
 <br></br>
	  <div class = "form-group">
			<button type = "submit" name="submit" id="submit-button"  class = "btn btn-success form-control"><i class = "bx bx-plus"></i> Add Account</button>
		</div>
  <?php
  if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($mysqli, $_POST['fname']);
    $lname = mysqli_real_escape_string($mysqli, $_POST['lname']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $address = $_POST['address'];
    $mobile_number = $_POST['mobile_number'];
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $usertype = $_POST['usertype'];

    // Check if "@" symbol is present in the email (email)
    if (strpos($email, "@") === false) {
        $_SESSION['error_message'] = "Invalid email address format!";
        echo '<script>window.location.href = "add_account.php?error=Invalid email address format!";</script>';
    } else {
        $select = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($mysqli, $select);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error_message'] = "email already exists!";
            echo '<script>window.location.href = "add_account.php?error=email already exists!";</script>';
        } else {
            if ($pass != $cpass) {
                $_SESSION['error_message'] = "Password not matched!";
                echo '<script>window.location.href = "add_account.php?error=Password not matched!";</script>';
            } else {
                $insert = "INSERT INTO user(fname,lname,address,mobile_number,email, password,usertype) VALUES('$fname','$lname','$address','$mobile_number','$email','$pass','$usertype')";
                mysqli_query($mysqli, $insert);
                $_SESSION['success'] = "Add Account Successfully";
                echo '<script>window.location.href = "RegisteredUserAdmin.php?success=Add Account Successfully";</script>';
            }
        }
    }
}

?>
</section>
</body>
<!-- Scripts -->
<script>
   function togglePasswordButton(buttonId) {
            var passwordInput = document.getElementById(buttonId.replace('Toggle', ''));
            var showPasswordBtn = document.getElementById(buttonId);

            if (passwordInput.value.length > 0) {
                showPasswordBtn.style.display = "block";
            } else {
                showPasswordBtn.style.display = "none";
            }
        }

        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            var showPasswordBtn = document.getElementById(inputId + "Toggle");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
            } else {
                passwordInput.type = "password";
                showPasswordBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            }
        }
</script>
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
</script>
<script>
    document.querySelector('#email').addEventListener('input', function () {
        const input = this.value;
        const emailError = document.querySelector('#emailError');
        
        if (input.length > 28) {
            this.value = input.slice(0, 28); // Truncate the input to 28 characters
        }

        if (input.length > 28) {
            emailError.textContent = 'Email must be at most 28 characters.';
            emailError.style.display = 'block'; // Ensure the error message is displayed
            this.setCustomValidity('Email must be at most 28 characters.');
        } else {
            emailError.style.display = 'none'; // Hide the error message if it's not applicable
            this.setCustomValidity(''); // Reset the custom validity
        }

    });
</script>


<script>
       function validatePassword() {
    const passwordInput = document.getElementById("password");
    const password = passwordInput.value;
    const passwordValidationMsg = document.getElementById("password-validation-msg");
    const submitButton = document.getElementById("submit-button"); // Get the submit button.

    // Define a regular expression pattern for allowed characters.
    const allowedCharacters = /^[a-zA -Z0-9 /^!@#$%^&*()\-_=+\{}|;:,<.>\/?+$/]+$/;

    if (password.length < 8) {
        passwordValidationMsg.textContent = "Password must be at least 8 characters long.";
        submitButton.disabled = true; // Disable the submit button.
        return false; // Prevent form submission
    } else if (!allowedCharacters.test(password)) {
        passwordValidationMsg.textContent = "Password contains disallowed that characters.";
        submitButton.disabled = true; // Disable the submit button.
        return false; // Prevent form submission
    } else {
        passwordValidationMsg.textContent = ""; // Clear any previous validation message.
        submitButton.disabled = false; // Enable the submit button.
        return true; // Allow form submission
    }
}

    </script>

<script src="../cssmainmenu/script.js"></script>
  <script src = "../js/jquery.js"></script>
<script src = "../js/bootstrap.js"></script>

</html>

<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}