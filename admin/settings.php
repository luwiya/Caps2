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
  <title>User Profile</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
 <link rel = "stylesheet" type = "text/css" href = "../css/style.css" />

<!--theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
</head>
<style>
  .cp-div{
  margin-top: 5px;
}
.mobilenumlbl, .addresslbl{
    margin-top: -15px;
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

        <?php
            $query = $mysqli->query("SELECT * FROM `user`") or die(mysqli_error());
            $fetch = $query->fetch_array();
          ?>
     
     <section class="home-section">
  <br>
  <div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
           <h3> <div class = "alert alert-info">User Profile</div></h3>
                <br>
            <?php if (isset($_GET['success'])) { ?>
              <div class="alert alert-success" role="alert">
                  <?=$_GET['success']?>
          </div>
          <?php } ?>
          <br>
        <div class="containers rounded bg-white mt-5 mb-5">
          <div class="row">
              <div class="col-md-3 border-right">
              <div class="row mt-3">
          <div class="col-md-12">
          <form method = "POST" enctype="multipart/form-data">
          <label class="">Profile Picture<br></label>
              <div class = "well" style = "height:200px; width:265px;">
                  <img src = "../photo/<?php echo $_SESSION['user_data']['photo']?>" height = "160" width = "225"/>
                  </div>
          </div>  
        </div>           
      </div>
      <div class="col-md-5 border-right">
            <div class="p-3 py-5">
            <div class="row mt-2">
                <div class="col-md-6"><label class="labels">Name</label><label class="form-control"><?php echo $_SESSION['user_data']['fname']; ?></label></div>
                <div class="col-md-6"><label class="labels">Last Name</label><label class="form-control"><?php echo $_SESSION['user_data']['lname']; ?></label></div>
                <div class="col-md-6"><label class="labels">Email</label><label class="form-control"><?php echo $_SESSION['user_data']['email']; ?> </label></div>
                <div class="col-md-6 cp-div"><label class="labels"></label><label class="form-control">  <p> <a href="edit_password.php?id=<?php echo $_SESSION['user_data']['id']; ?>">Change Password</a></p></label></div>

              </div>
              <div class="row mt-3">
                <div class="col-md-6"><label class="labels mobilenumlbl"><br>Mobile Number</label><label class="form-control"><?php echo $_SESSION['user_data']['mobile_number']; ?></label></div>
                <div class="col-md-12"><label class="labels addresslbl"><br>Address</label><label class="form-control"><?php echo $_SESSION['user_data']['address']; ?></label></div>
              </div>
              <br>
              <div class="mt-5 text-center">
              <div class="mt-5 text-center">
              <a href="edit_profile.php?id=<?php echo $_SESSION['user_data']['id']; ?>" class="btn btn-primary profile-button">Edit Profile</a>
                </div>
            </form>
              </div>
                </div>
              </div>
            </div>
        </div>
        </div>
      </div>
  </section>
</body>
<script src="../cssmainmenu/script.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Check if URL contains 'success' parameter and remove it
    if (window.location.search.includes('success')) {
        var newUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
        window.history.replaceState({ path: newUrl }, '', newUrl);
    }
});
</script>
</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}
           
