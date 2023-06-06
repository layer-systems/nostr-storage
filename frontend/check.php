<?php

require_once("config.php");

$filename = $_GET['file'];
$invoice = $_GET['invoice'];
$paymentHash = $_GET['paymentHash'];

$invoicePaid = 0;

// GET PAYMENT STATUS
// Define your endpoint
$url = 'https://legend.lnbits.com/api/v1/payments/'.$paymentHash;

// Define your headers
$headers = array(
    'Content-Type: application/json',
    'X-Api-Key: '.$lnbitsKey,
);

// Set up your CURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the CURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo "Error: $error_msg";
}

// Close the CURL request
curl_close($ch);

// Print the response
// echo $response;
// exit();

$invoicePaid = json_decode($response, true)['paid'];


// CHECKS
if(!file_exists($temp_dir . $filename)) {
    echo "File not found";
    exit();
}

if(!$invoicePaid) {
    header("Location: pay.php?file=$filename&invoice=$invoice&paymentHash=$paymentHash");
    exit();
} else {
    rename($temp_dir . $filename, $target_dir . $filename);
    header("Location: success.php?file=$filename");
    exit();
}

?>