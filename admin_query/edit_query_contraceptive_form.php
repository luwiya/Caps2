<?php
	require_once '../connection/connect.php';
	if(ISSET($_POST['edit_rec'])){
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $dateBirth = $_POST['dateBirth'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $civilStatus = $_POST['civilStatus'];
        $address = $_POST['address'];
        $contactNumber = $_POST['contactNumber'];
     

		$mysqli->query("UPDATE `residentrecords` SET `lastName` = '$lastName', `firstName` = '$firstName', `middleName` = '$middleName', `dateBirth` = '$dateBirth', `age` = '$age', `sex` = '$sex', `civilStatus` = '$civilStatus', `address` = '$address', `contactNumber` = '$contactNumber' WHERE `residentId` = '$_REQUEST[residentId]'") or die(mysqli_error());
		echo '<script>window.location.href = "../bhw/userRecMed.php?success=Update Successfully";</script>';
		}
	
	?>