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
  <title>Edit - Family Planning Form</title>
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
                    <h3><div class="alert alert-info">Family Planning Form</div></h3>
                    <br />
                    <div class="col-md-4">
                        <?php
                        $query = $mysqli->query("SELECT * FROM `residentrecords` WHERE `residentId` = '$_REQUEST[residentId]'") or die(mysqli_error());
                        $fetch = $query->fetch_array();
                        ?>
                         <form method="POST" enctype="multipart/form-data">
                            <div class="form-group" required="required">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastName" id="lastName"  placeholder="Enter your last Name"  value="<?php echo $fetch['lastName']; ?>"/>
                            </div>
                            <div class="form-group" required="required">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstName" id ="firstName" placeholder="Enter your First Name" value="<?php echo $fetch['firstName']; ?>" />
                            </div>
                            <div class="form-group" >
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="middleName" id ="middleName" placeholder="Optional" value="<?php echo $fetch['middleName']; ?>"/>
                            </div>
                            <div class="form-group" required="required">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control" name="dateBirth" id="dateOfBirth" value="<?php echo $fetch['dateBirth']; ?>"/>
                            </div>
                            <div class="form-group" required="required">
                                <label>Age</label>
                                <input type="text" class="form-control" name="age" id ="age"value="<?php echo $fetch['age']; ?>"readonly/>
                            </div>
                            <div class="form-group" required="required" style="display: none;" >
                                <label>Gender</label>
                                <select class="form-control" required="required" name="sex" id="usertypeSelect" >
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female" selected>Female</option>
                            </select>
                            </div>
                            <div class="form-group">
                            <label>Civil Status</label>
                                <select class="form-control" required="required" name="civilStatus" >
                                  <option value="" disabled selected>Civil Status</option>
                                  <option value="single" <?php if ($fetch['civilStatus'] === 'single') echo 'selected'; ?>>Single</option>
                                  <option value="married" <?php if ($fetch['civilStatus'] === 'married') echo 'selected'; ?>>Married</option>
                                  <option value="widowed" <?php if ($fetch['civilStatus'] === 'widowed') echo 'selected'; ?>>Widowed</option>
                                  <option value="divorced" <?php if ($fetch['civilStatus'] === 'divorced') echo 'selected'; ?>>Divorced</option>
                                </select>
                            </div>
                           
                            <div class="form-group">
                                <label>Sitio</label>
                                <select class="form-control" required="required" name="address" required>
                                    <option value="" disabled selected>Select Sitio</option>
                                    <option value="IlangIlang" <?php if ($fetch['address'] === 'IlangIlang') echo 'selected'; ?>>Ilang-Ilang</option>
                                    <option value="Orchids" <?php if ($fetch['address'] === 'Orchids') echo 'selected'; ?>>Orchids</option>
                                    <option value="Sampaguita" <?php if ($fetch['address'] === 'Sampaguita') echo 'selected'; ?>>Sampaguita</option>
                                    <option value="Camia" <?php if ($fetch['address'] === 'Camia') echo 'selected'; ?>>Camia</option>
                                    <option value="Rosal" <?php if ($fetch['address'] === 'Rosal') echo 'selected'; ?>>Rosal</option>
                                    <option value="MalitamDos" <?php if ($fetch['address'] === 'MalitamDos') echo 'selected'; ?>>Malitam Dos</option>
                                    <option value="MalitamTres" <?php if ($fetch['address'] === 'MalitamTres') echo 'selected'; ?>>Malitam Tres</option>
                                    <option value="BadjCom" <?php if ($fetch['address'] === 'BadjCom') echo 'selected'; ?>>Badjao Community</option>
                                </select>
                            </div>
                            <div class="form-group" required="required">
                            <label for="contactNumber">Contact Number</label>
                            <input type="text" class="form-control" name="contactNumber" id="contactNumber" value="<?php echo $fetch['contactNumber']; ?>" placeholder="Enter your Contact Number" required />
                            <small id="contactNumberError" class="form-text text-danger"></small>
                            <small id="contactNumberSuccess" class="form-text text-success"></small>
                        </div>

                            <div class="form-group" >
                            <button name="edit_rec" class="btn btn-primary profile-button form-control"><i
                                        class="bx bx-save"></i> Update</button>
                            </div>
                            <?php require_once '../admin_query/edit_query_contraceptive_form.php'?>
						</form>
                  
                     
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initially hide the "Method Currently used" section
            $("#changingMethodSection").hide();

            // Attach change event handler to the clientType select element
            $("select[name='clientType']").change(function() {
                var selectedOption = $(this).val();
                if (selectedOption === "New User") {
                    // If "New User" is selected, hide the "Method Currently used" section
                    $("#changingMethodSection").hide();
                } else {
                    // For other options, show the "Method Currently used" section
                    $("#changingMethodSection").show();
                }
            });
        });
    </script>



    <script>
        document.getElementById("residentName").addEventListener("input", function () {
        var input = this.value;
        if (input.length > 0) {
            this.value = input.charAt(0).toUpperCase() + input.slice(1);
        }
    });
    </script>
    <script>//Date of Birth and Age Function(automatic calculation)
    var dateOfBirthInput = document.getElementById("dateOfBirth");
    var ageInput = document.getElementById("age");

    // Restrict the selection of future dates
    dateOfBirthInput.max = new Date().toISOString().split("T")[0];

    // Add an event listener to the date of birth input field
    dateOfBirthInput.addEventListener("change", function () {
    // Get the selected date of birth
    var selectedDate = new Date(dateOfBirthInput.value);

    // Calculate the age
    var today = new Date();
    var age = today.getFullYear() - selectedDate.getFullYear();

    // Check if the birthday has occurred this year
    if (
        today.getMonth() < selectedDate.getMonth() ||
        (today.getMonth() === selectedDate.getMonth() && today.getDate() < selectedDate.getDate())
    ) {
        age--;
    }

    // Update the age input field with the calculated age
    ageInput.value = age;
    });
    /*------------*/
    /*This is for the Given Date not to be select previous years.months,days*/
     // Get the given date input element
     var givenDateInput = document.getElementById("givenDate");

    // Calculate today's date
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Set hours, minutes, seconds, and milliseconds to zero

    // Set the maximum date for the input field to today
    givenDateInput.max = today.toISOString().split("T")[0];
    </script>
<script>
    // ContactNumber can only input 11 numbers
    document.querySelector('#contactNumber').addEventListener('input', function () {
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
   <script src="../cssmainmenu/script.js"></script>
</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}
