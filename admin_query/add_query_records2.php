<?php
if (isset($_POST['add_rec'])) {
    @include "../connection/connect.php";
    // Include your database connection code here (e.g., $conn = new mysqli(...);)

    $residentId = isset($_GET['residentId']) ? $_GET['residentId'] : '';
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $unit = $_POST['unit'];
    $quantity_req = $_POST['quantity_req'];
    $givenDate = $_POST['givenDate'];

    // Check if quantity_req is greater than zero
    if ($quantity_req <= 0) {
        echo '<script>alert("Quantity requested must be greater than zero.");</script>';
    } else {
    // Fetch the data from the 'medicines' table
    $fetchQuery = $mysqli->query("SELECT total FROM medicines WHERE productId = '$productId'");

    if ($fetchQuery) {
        $fetch = $fetchQuery->fetch_assoc();

        if ($fetch) {
            $availableQuantity = $fetch['total'];

            if ($availableQuantity >= $quantity_req) {
                // Sufficient quantity available, update and insert
                $quantity = $availableQuantity - $quantity_req;
                $updateQuery = $mysqli->query("UPDATE medicines SET total = '$quantity' WHERE productId = '$productId'");

                if ($updateQuery) {
                    $insertQuery = $mysqli->query("INSERT INTO request_medicine (residentId,lastName,firstName,middleName, productId, productName, unit, quantity_req, givenDate) VALUES ('$residentId','$lastName','$firstName','$middleName', '$productId', '$productName', '$unit', '$quantity_req', '$givenDate')");

                    if ($insertQuery) {
                        $recordQuery = $mysqli->query("INSERT INTO record_data_graph (residentId, productId, address, productName, quantity_req, givenDate) VALUES ('$residentId', '$productId', '$address', '$productName', '$quantity_req', '$givenDate')");

                        echo '<script>alert("Request Medicine Successful. Click OK ");</script>';

                        echo '<script>window.location.href = "resident_med.php?residentId=' . $residentId . '";</script>';
                        exit();
                    } else {
                        echo "Error: " . mysqli_error($mysqli);
                    }
                } else {
                    echo "Error: Failed to update medicine quantity.";
                }
            } else {
                // Insufficient quantity, show an error message
                echo '<script>alert("Insufficient quantity available.");</script>';
            }
        } else {
            echo "Error: Medicine with productId $productId not found.";
        }
    } else {
        echo "Error: Failed to fetch medicine data.";
    }
}
}
?>
