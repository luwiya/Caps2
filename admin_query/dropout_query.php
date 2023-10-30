<?php
if (isset($_POST['add_rec'])) {
    @include "../connection/connect.php";
    // Include your database connection code here (e.g., $conn = new mysqli(...);)

    $residentId = isset($_GET['residentId']) ? $_GET['residentId'] : '';
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $givenDate = $_POST['givenDate'];
    $clientType = 'Dropout'; // Set the default value
    $changingMethod = $_POST['changingMethod'];
    $unit = 'None'; // Set the default value
    $productName = 'None'; // Set the default value

    // Define your condition or query here to set $updateQuery
    // For example, you can set it to true if a certain condition is met
    $updateQuery = true;

    if ($updateQuery) {
        $query = "INSERT INTO contraceptivemethod_request (residentId, lastName, firstName, middleName, givenDate, clientType, changingMethod, unit, productName) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("issssssss", $residentId, $lastName, $firstName, $middleName, $givenDate, $clientType, $changingMethod, $unit, $productName);
    
        if ($stmt->execute()) {
            echo "Record inserted successfully";
            echo '<script>alert("Dropout Successful. Click OK ");</script>';
            echo '<script>window.location.href = "individual_records_FP.php?residentId=' . $residentId . '";</script>';
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Your condition is not met, so the record was not inserted.";
    }
}
?>
