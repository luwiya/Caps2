<?php
	require_once '../connection/connect.php';
	if(ISSET($_POST['edit_med'])){
		$sponsor = $_POST['sponsor'];
		$productName = $_POST['productName'];
		$unit = $_POST['unit'];
		$batch = $_POST['batch'];
		$quantity1 = $_POST['quantity1'];
		$total = $_POST['quantity1'] + $_POST['total'];
		$expDate = $_POST['expDate'];
		$status = $_POST['status'];
		
		 // Check if quantity1 is zero and status is "available"
		 if ($total == 0 && $status == 'available') {
			// You can handle this case here, like displaying an error message or not updating the database.

			echo '<script>alert("Status cannot be set to available when quantity is zero.");</script>';
		} else {
			$total = $quantity1 + $_POST['total'];
			$mysqli->query("UPDATE `medicines` SET `sponsor` = '$sponsor', `productName` = '$productName', `unit` = '$unit', `batch` = '$batch', `quantity1` = '$quantity1', `total` = '$total', `expDate` = '$expDate', `status` = '$status' WHERE `productId` = '$_REQUEST[productId]'") or die(mysqli_error());
			echo '<script>window.location.href = "../bhw/medicinee.php?success=Update Successfully";</script>';
		}
	}
	?>