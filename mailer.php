<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php'; // Include PHPMailer library

$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/connection/connect.php"; // Ensure you include your database configuration

$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($mysqli->affected_rows) {
    $mail = new PHPMailer(true); // Create a new PHPMailer instance

    try {
        // Enable debugging for detailed SMTP logs
        $mail->SMTPDebug = 2;

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';    // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'malitambarangayhealthworker@gmail.com'; // Replace with your SMTP username
        $mail->Password = 'vpxu xebq cxpg ruac'; // Replace with your SMTP password
        $mail->SMTPSecure = 'tls'; // Use 'tls' or 'ssl' based on your server's requirements
        $mail->Port = 587; // Use the correct port number

        // Email Configuration
        $mail->setFrom('noreply@example.com');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset';
        $mail->isHTML(true);
        $mail->Body = <<<END
            Click <a href="http://localhost/Caps2/reset-password.php?token=$token">here</a> 
            to reset your password.
        END;

        // Send the email
        $mail->send();
    
        header("Location:index.php?success=Message sent, please check your email inbox.");

        exit; // Make sure to exit to prevent further script execution

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer error: ' . $mail->ErrorInfo;
    }
} else {
    echo 'Error updating the database.';
}
