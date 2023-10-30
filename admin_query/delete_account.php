<?php
	 require_once '../connection/connect.php';
	 $mysqli->query("DELETE FROM `user` WHERE `id` = '$_REQUEST[id]'") or die(mysqli_error());
	 header("location: ../admin/account.php");