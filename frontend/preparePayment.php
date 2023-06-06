<?php

$temp_dir = "temp/";
$file = $_GET['file'];

// Exit if file does not exist in temp folder (waiting for payment)
if(!file_exists($temp_dir . $file)) {
    echo "File does not exist";
    exit();
  }

$satsProMb = 50;
$fileSize = filesize($temp_dir . $file);
$fileSizeMb = $fileSize / 1000000;
$toPay = round($fileSizeMb * $satsProMb, 0);
$lnbitsKey = "YOUR_LNBITS_KEY_HERE";


// Define your endpoint
$url = 'https://legend.lnbits.com/api/v1/payments';

// Define your headers
$headers = array(
    'Content-Type: application/json',
    'X-Api-Key: '.$lnbitsKey,
);

// Define your payload/body
$data = array(
    'out' => false, 
    'amount' => $toPay,
    'memo' => $file, 
    'expiry' => 0, 
    'unit' => 'sat',
    // 'webhook' => '',
    'internal' => false
);
$body = json_encode($data);

// echo $body;
// exit();

// Set up your CURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
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
// echo json_decode($response, true)['payment_request'];

$invoice = json_decode($response, true)['payment_request'];

header('Location: https://'.$_SERVER['SERVER_NAME'].'/pay.php?invoice='.$invoice.'&file='.$file);

?>