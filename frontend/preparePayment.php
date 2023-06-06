<?php

require_once("config.php");

$file = $_GET['file'];

// Exit if file does not exist in temp folder (waiting for payment)
if(!file_exists($temp_dir . $file)) {
    echo "File does not exist";
    exit();
  }

  $fileSize = filesize($temp_dir . $file);
  $fileSizeMb = $fileSize / 1000000;
  $toPay = round($fileSizeMb * $satsProMb, 0);

// Define your endpoint
$url = 'https://legend.lnbits.com/api/v1/payments';

// Define your headers
$headers = array(
    'Content-Type: application/json',
    'X-Api-Key: '.$lnbitsKey,
);

$webhookUrl = $httpPrefix.$_SERVER['SERVER_NAME'].'/webhook.php?file='.$file;

// Define your payload/body
$data = array(
    'out' => false, 
    'amount' => $toPay,
    'memo' => $file, 
    'expiry' => 0, 
    'unit' => 'sat',
    'webhook' => $webhookUrl,
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
// exit();

$invoice = json_decode($response, true)['payment_request'];
$paymentHash = json_decode($response, true)['payment_hash'];
$checkingId = json_decode($response, true)['checking_id'];

header('Location: '.$httpPrefix.$_SERVER['SERVER_NAME'].'/pay.php?invoice='.$invoice.'&file='.$file.'&paymentHash='.$paymentHash);

?>