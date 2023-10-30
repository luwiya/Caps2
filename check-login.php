<?php  
session_start();
include "./connection/connect.php";


if(isset($_REQUEST['email']) && isset($_REQUEST['password'])){

	//mysqli real escape prevent from sql injection which filter the user input
	$email=mysqli_real_escape_string($mysqli,$_REQUEST['email']);
	$password=mysqli_real_escape_string($mysqli,$_REQUEST['password']);
	$qr=mysqli_query($mysqli,"select * from user where email='".$email."' and password='".md5($password)."'");
	if(mysqli_num_rows($qr) > 0){
		$data = mysqli_fetch_assoc($qr);
		$_SESSION['user_data'] = $data;
		if($data['usertype'] == 1){
			header("Location: ./admin/Dashboard.php");
		}
		elseif($data['usertype'] == 3){
			header("Location: index.php?error=Your Account is Deactivated");
		}
		else{
			header("Location: ./bhw/homemedd.php");
		}
	}
	else{
		header("Location: index.php?error=Invalid Login Details");
	}
	
}
else{
	header("Location:index.php?error=Please Enter Email and Password");
}



