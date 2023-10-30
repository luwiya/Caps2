<?php
	require_once '../connection/connect.php';
	$mysqli->query("DELETE FROM `residentrecords` WHERE `residentId` = '$_REQUEST[residentId]'") or die(mysql_error());
	header("location:../bhw/userRecMed.php");
?>