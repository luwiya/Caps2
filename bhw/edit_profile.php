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
  <title>Edit User Profile</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
  <link rel = "stylesheet" type = "text/css" href = "../css/style.css" />
  
<!--theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

</head>
<style>
.form-control:focus {
    box-shadow: none;
    border-color: #04c487;
}

/* Simplify button styles */
.profile-button {
    background: #04c487;
    border: none;
    color: #fff;
}

/* Change button background on hover and focus */
.profile-button:hover,
.profile-button:focus {
    background: #04c487;
}

/* Adjust hover effect for back link */
.back:hover {
    color: #04c487;
    cursor: pointer;
}

/* Increase font size for labels on smaller screens */
@media (max-width: 768px) {
    .labels {
        font-size: 14px;
    }
}

/* Adjust hover effect for add-experience button */
.add-experience:hover {
    background: #04c487;
    color: #fff;
    cursor: pointer;
    border: solid 1px #04c487;
}
.emaillbl, .mobilenumlbl, .addresslbl{
    margin-top: -20px;
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
          <div class="container-fluid">
            <div class="panel panel-default">
            <div class="panel-body">
            <h3> <div class = "alert alert-info">User Profile</div></h3>
            <?php if (isset($_GET['success'])) { ?>
              <div class="alert alert-success" role="alert">
                  <?=$_GET['success']?>
          </div>
          <?php } ?>
          <br></br>
        <div class="containers rounded bg-white mt-5 mb-5">
          <div class="row">
              <div class="col-md-3 border-right">
              <div class="row mt-3">
          <div class="col-md-12">
          <form method = "POST" enctype = "multipart/form-data">
            <label class="text-centered">Profile Picture<br></label>
              <div class = "well" style = "height:200px; width:265px;">
                  <img src = "../photo/<?php echo $_SESSION['user_data']['photo']?>" height = "160" width = "225"/>
                  </div>
                  <input type="file" name="photo" id="photo" class="form-control" accept="image/png, image/jpeg" value="../photo/<?php echo $_SESSION['user_data']['photo']?>">
          </div>  
        </div>           
      </div>
          <div class="col-md-5 border-right">
              <div class="p-3 py-5">
                <div class="row mt-2">
                  <div class="col-md-6"><label class="labels">Name</label><input type="text" name="fname" value = "<?php echo $_SESSION['user_data']['fname']; ?>" class="form-control" placeholder="First Name" required readonly></div>
                  <div class="col-md-6"><label class="labels">Last Name</label><input type="text" class="form-control" name="lname" value = "<?php echo $_SESSION['user_data']['lname']; ?>" placeholder="Last Name" required readonly></div>
                  <div class="col-md-6"><label class="labels emaillbl"><br>Email</label><input type="text" name="email" value = "<?php echo $_SESSION['user_data']['email']; ?>" class="form-control" value="" placeholder="Example@gmail.com" required>
                  <small id="emailError" class="form-text text-danger">Email must be 24 characters only.</small>
                </div>
              </div>
                    <div class="row mt-3">
                    <div class="col-md-6"><label class="labels mobilenumlbl"><br>Mobile Number</label><input type="text" id="mobile_number" name="mobile_number" value = "<?php echo $_SESSION['user_data']['mobile_number']; ?>" class="form-control" placeholder="Ex.0946" required>
                    <small id="mobile_numberError" class="form-text text-danger"></small>

                </div>
                    <div class="col-md-12"><label class="labels addresslbl"><br>Address</label><input type="text" name="address" value = "<?php echo $_SESSION['user_data']['address']; ?>" class="form-control" placeholder="Address" required></div>
              </div>
                <br>
                    <div class="mt-5 text-center">
                   <button type = "submit" name="submit" class = "btn btn-primary profile-button"> Save Profile</button></div>
              </div>
            </form>
            <?php
                if (isset($_POST['submit'])) {
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $address = $_POST['address'];
                    $mobile_number = $_POST['mobile_number'];
                    $email = $_POST['email'];

                    // Check if the email (presumably an email address) contains the "@" symbol
                    if (strpos($email, "@") === false) {
                        $_SESSION['error_message'] = "Invalid email address format!";
                        echo '<script>window.location.href = "edit_profile.php?id=' . $_SESSION['user_data']['id'] . '&error=Invalid email address format!";</script>';
                    } else {
                        $photo_name = $_SESSION['user_data']['photo']; // Keep the current photo if not updated

                        // Check if a new photo was uploaded
                        if (!empty($_FILES['photo']['tmp_name'])) {
                            $photo = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
                            $photo_name = addslashes($_FILES['photo']['name']);
                            $photo_size = getimagesize($_FILES['photo']['tmp_name']);
                            move_uploaded_file($_FILES['photo']['tmp_name'], "../photo/" . $_FILES['photo']['name']);
                        }

                        $query = $mysqli->query("UPDATE `user` SET `fname` = '$fname', `lname` ='$lname', `address` = '$address', `mobile_number` = '$mobile_number', `email` = '$email', `photo` = '$photo_name' WHERE `id` = '$_REQUEST[id]'") or die(mysqli_error());

                        // Update session variables with new data
                        $_SESSION['user_data']['fname'] = $fname;
                        $_SESSION['user_data']['lname'] = $lname;
                        $_SESSION['user_data']['address'] = $address;
                        $_SESSION['user_data']['mobile_number'] = $mobile_number;
                        $_SESSION['user_data']['email'] = $email;
                        $_SESSION['user_data']['photo'] = $photo_name;

                        echo '<script>alert("Update Successfully.");</script>';
                        echo '<script>window.location.href = "settings.php";</script>';
                    }
                }
                ?>

                </div>
                </div>
              </div>
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
    document.querySelector('#mobile_number').addEventListener('input', function () {
        const input = this.value.toString(); // Convert the input to a string
        const mobile_numberError = document.querySelector('#mobile_numberError');

        if (input.length !== 11 || isNaN(input) || !input.startsWith('09')) {
            mobile_numberError.textContent = 'Contact number must start with "09" and be exactly 11 digits.';
            this.setCustomValidity('Contact number must start with "09" and be exactly 11 digits.');
        } else {
            mobile_numberError.textContent = '';
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
document.addEventListener("DOMContentLoaded", function() {
    // Check if URL contains 'success' parameter and remove it
    if (window.location.search.includes('success')) {
        var newUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
        window.history.replaceState({ path: newUrl }, '', newUrl);
    }
});
function validateFileType(){
        var fileName = document.getElementById("photo").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
        }else{
            alert("Only jpg/jpeg and png files are allowed!");
        }   
    }
</script> 
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const emailInput = document.querySelector('input[name="email"]');
        const charCount = document.getElementById('charCount');
        const emailError = document.getElementById('emailError');
        const maxChars = 24;

        emailInput.addEventListener('input', function () {
            const currentChars = this.value.length;

            if (currentChars > maxChars) {
                this.value = this.value.substring(0, maxChars); // Truncate input if it exceeds the limit
                emailError.textContent = 'Email must be at most 24 characters.';
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }

            charCount.textContent = `${currentChars}/${maxChars} characters`;

            if (currentChars === maxChars) {
                emailInput.setAttribute('disabled', 'disabled'); // Disable input once it reaches the limit
            } else {
                emailInput.removeAttribute('disabled');
            }
        });
    });
</script>
</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}
           
  