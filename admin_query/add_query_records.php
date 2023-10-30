<?php

if (isset($_POST['add_rec'])) {
    $productId = $_POST['productId'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $dateBirth = $_POST['dateBirth'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $civilStatus = $_POST['civilStatus'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contactNumber'];
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
    $fetch = $fetchQuery->fetch_assoc();

    if ($fetchQuery && $fetch) {
        $availableQuantity = $fetch['total'];

        if ($availableQuantity >= $quantity_req) {
            // Sufficient quantity available, update and insert
            $quantity = $availableQuantity - $quantity_req;
            $mysqli->query("UPDATE medicines SET total = '$quantity' WHERE productId = '$productId'");
            $query = $mysqli->query("INSERT INTO residentrecords (productId, lastName, firstName,middleName, dateBirth, age, sex, civilStatus, address, contactNumber) VALUES ('$productId', '$lastName','$firstName','$middleName', '$dateBirth', '$age', '$sex','$civilStatus', '$address', '$contactNumber')");

            if ($query) {
                $residentId = mysqli_insert_id($mysqli);
                $query = $mysqli->query("INSERT INTO request_medicine (residentId, lastName, firstName, middleName, productId, productName, unit, quantity_req, givenDate) VALUES ('$residentId', '$lastName', '$firstName', '$middleName', '$productId', '$productName', '$unit', '$quantity_req', '$givenDate')");
            
                // Check if the request_medicine insertion was successful
                if ($query) {
                    // Insert data into the record_data_graph table
                    $recordQuery = $mysqli->query("INSERT INTO record_data_graph (residentId, productId, address, productName, quantity_req, givenDate) VALUES ('$residentId', '$productId', '$address', '$productName', '$quantity_req', '$givenDate')");
                    
                    if ($recordQuery) {
                        echo '<script>window.location.href = "./userRecMed.php?success=Add Request Successfully";</script>';
                        exit();
                    } else {
                        echo "Error inserting data into record_data_graph: " . mysqli_error($mysqli);
                    }
                } else {
                    echo "Error inserting data into request_medicine: " . mysqli_error($mysqli);
                }
        } else {
            // Insufficient quantity, show an error message
            echo '<script>alert("Insufficient quantity available.");</script>';
        }
    } else {
        echo "Error: Failed to fetch medicine data.";
    }
}
    }
}
?>
