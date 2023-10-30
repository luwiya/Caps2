<?php
	require_once '../connection/connect.php';
	if(ISSET($_POST['edit_account'])){
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$address = $_POST['address'];
		$mobile_number = $_POST['mobile_number'];
		$email = $_POST['email'];
		$usertype = $_POST['usertype'];
		$query = $mysqli->query("UPDATE `user` SET `fname` = '$fname', `lname` = '$lname', `address` = '$address', `mobile_number` = '$mobile_number', `email` = '$email', `usertype` = '$usertype' WHERE `id` = '$_REQUEST[id]'") or die(mysqli_error());
	
		header("location:../admin/account.php?success=Edit Account Succesfully!");

	}	