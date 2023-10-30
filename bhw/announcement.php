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
  <title>SMS Announcements</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="../cssmainmenu/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css " />
  <link rel = "stylesheet" type = "text/css" href = "../css/style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

<!--theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

</head>
<style>
  .selected-values{
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 100%;
  }

.textmessagebox{
  width:100%;
}


* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */


/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 20px;
  text-align: center;
  background-color: #f1f1f1;


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
        <h3><div class = "alert alert-info">SMS Announcements</div></h3>
        <div class="row">
        <div class="column">
        <div class="card" style="width: 400px; margin: 0 auto;">
          <form id="messageForm" >
        <label for="number">Residents: </label>
        <button id="contacts-button"><i class="fa-solid fa-user-plus"></i></button><br /><br />
        <textarea class="selected-values" type="text" name="number" required ></textarea><br /><br />

        <div class="form-group" required="required">
            <label>Announcements</label>
                <select class="form-control" required="required" name="announcemntType" id="announcementSelect">
                <option value="" disabled selected>Types of Announcement</option>
                <option value="Medical Checkup">Medical Checkup</option>
                <option value="Maternal Health Services">Maternal Health Services</option>
                <option value="Vaccination">Vaccination</option>
                <option value="Distribution of Contraceptives">Distribution of Contraceptives</option>
              </select>
        </div>

        <label for="message">Message:</label>
        <textarea  name="message" id="message" class="textmessagebox" rows="1" required></textarea><br /><br />
        <a class="btn btn-success sendbtn" style="text-align: center;" type="submit"value="Send Message" onclick="sendMessage(event)"> Send SMS</a>
      </form>
            </div>
         
    </div>
    </div>

          <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
              <?=$_GET['success']?>
            </div>
          <?php } ?>
          <br> <br>
          <div id="table-container" style="display: none;">
            <table id="table" class="table table-striped">
                  <thead>
                      <tr>
                      <th>Select All <input type="checkbox" id="select-all"></th>
                          <th>Name</th>
                          <th>Number</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      $query = $mysqli->query("SELECT * FROM residentrecords") or die(mysqli_error());
                      while ($fetch = $query->fetch_array()) {
                      ?>
                          <tr>
                          <td><input type="checkbox" class="checkbox" name="selected_records[]" value="<?php echo $fetch['residentId']; ?>"
                     data-contact-number="<?php echo $fetch['contactNumber']; ?>">     </td>                         
                     <td><?php echo $fetch['lastName'] . ' ' . $fetch['firstName'] . ' ' . $fetch['middleName']; ?>
                              <td><?php echo $fetch['contactNumber'] ?>
                          </tr>
                      <?php
                      }
                      ?>
                  </tbody>
              </table>
            </tbody>
          </table> 
          	
          </div>
      </div>
    </div>
  </section>
  
  
</body>

<script>
    // Add JavaScript to handle the "Select All" functionality
    document.getElementById('select-all').addEventListener('change', function () {
        var checkboxes = document.querySelectorAll('input[name="selected_records[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });
</script>
<script>
     function sendMessage(event) {
  event.preventDefault(); // Prevent the default form submission

  // Get form data
  const formData = new FormData(document.getElementById("messageForm"));

  // Create a new XMLHttpRequest object
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "send_message.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Handle the request
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Display the API response to the user
        alert(xhr.responseText);

        // Redirect to "medicinee.php" after successful message send
        window.location.href = "announcement.php";
      } else {
        // Display an error message if the request fails
        alert("Failed to send the message.");
      }
    }
  }

  // Send the form data
  xhr.send(new URLSearchParams(formData).toString());
}

    </script>
    <script>
  // Function to toggle the visibility of the table-container div
  function toggleTable() {
    var tableContainer = document.getElementById("table-container");
    tableContainer.style.display = tableContainer.style.display === "none" ? "block" : "none";
  }

  // Add a click event listener to the "Contacts" button
  document.getElementById("contacts-button").addEventListener("click", toggleTable);
</script>
<script>
const selectAllCheckbox = document.getElementById('select-all');
const selectedValues = document.querySelector('.selected-values');
let listArray = [];

const checkboxes = document.querySelectorAll('.checkbox');

selectAllCheckbox.addEventListener('change', function () {
    if (this.checked) {
        listArray = Array.from(checkboxes).map((checkbox) => {
            checkbox.checked = true;
            return checkbox.getAttribute('data-contact-number');
        });
    } else {
        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
        });
        listArray = [];
    }
    selectedValues.textContent = listArray.join(', ');
});

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', function () {
        if (this.checked === true) {
            listArray.push(this.getAttribute('data-contact-number'));
        } else {
            listArray = listArray.filter((e) => e !== this.getAttribute('data-contact-number'));
        }
        selectedValues.textContent = listArray.join(', ');
    });
});
</script> 
<script>
    const announcementSelect = document.getElementById("announcementSelect");
    const messageTextarea = document.getElementById("message");

    // Create a mapping of announcement types to their messages
    const announcementMessages = {
        "Medical Checkup": "Magandang araw po! Ipinapaabot namin na andito po ang ating Doctor mayroon po tayong libreng Medical Checkup dito sa Health Center ngayong araw. Maari po kayong pumunta mula 9:00 ng umaga hanggang 4:00 ng hapon. Salamat po!",
        "Maternal Health Services": "Magandang araw po! Ipinapaabot namin na mayroon tayong libreng serbisyo para sa Kalusugan ng mga Nagdadalang-tao dito sa ating Health Center. Maaari po kayong pumunta mula 9:00 ng umaga hanggang 4:00 ng hapon tuwing Lunes at Miyerkules. Huwag kalimutang dalhin ang inyong prenatal record book para sa mga susunod na check-up. Salamat po!",
        "Vaccination": "Magandang araw po! Ipinapaabot namin na mayroon tayong libreng bakuna para sa ating mga sanggol dito sa Health Center. Ang vaccination schedule ay tuwing Martes at Huwebes lamang, mula 9:00 ng umaga hanggang 12:00 ng tanghali. Maari po kayong pumunta para sa proteksyon ng inyong mga anak. Salamat po",
        "Distribution of Contraceptives": "Magandang araw po! Ipinapaabot namin na mayroon tayong serbisyong pamamahagi ng mga kontraseptibo dito sa Health Center. Ito ay para sa mga nais kumontrol ng pagbubuntis. Ang serbisyong ito ay maaring puntahan tuwing Lunes mula 10:00 ng umaga hanggang 4:00 ng hapon. Huwag mag-atubiling magtanong sa mga healthcare professionals dito sa ating center para sa karagdagang impormasyon. Maraming salamat po!"
    };

    // Add an event listener to the announcement select box
    announcementSelect.addEventListener("change", function() {
        const selectedOption = announcementSelect.options[announcementSelect.selectedIndex].value;
        const selectedMessage = announcementMessages[selectedOption] || "";

        // Update the textarea's value and adjust its height
        messageTextarea.value = selectedMessage;
        messageTextarea.style.height = "auto"; // Reset the height to auto
        messageTextarea.style.height = messageTextarea.scrollHeight + "px"; // Set the height to fit the content
    });
</script>
 
  <!-- Scripts -->
  <script src="../cssmainmenu/script.js"></script>
  <script src = "../js/jquery.js"></script>
<script src = "../js/jquery.dataTables.js"></script>
<script src = "../js/dataTables.bootstrap.js"></script>	

<script type = "text/javascript">
	$(document).ready(function(){
		$("#table").DataTable();
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
</script>



</html>
<?php
}
else{
	header("Location:.././index.php?error=UnAuthorized Access");
}
