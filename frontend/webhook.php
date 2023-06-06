<?php 

// TODO:
// Get filename from path
// Get invoice from path
// Check if invoice is paid
// If paid, move file from temp to storage
// MAYBE: If not paid, redirect to pay.php

require_once("config.php");

$filename = $_GET['file'];
// $invoice = $_GET['invoice'];

rename($temp_dir . $filename, $target_dir . $filename);
?>