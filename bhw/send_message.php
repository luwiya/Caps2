<?php
$number = $_POST['number'];
$message = $_POST['message'];


$ch = curl_init();
$parameters = array(
    'apikey' => 'd9a2903a64895a8d8335b87f7e486297',
    'number' => $number,
    'message' => $message,
    'sendername' => 'SEMAPHORE'
);
curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);

echo $output;
?>
