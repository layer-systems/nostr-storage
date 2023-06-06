<?php

$temp_dir = "temp/";
$filename = $_GET['file'];
$invoice = $_GET['invoice'];

if(file_exists($temp_dir . $filename)) {
    // echo "Not paid yet";
    header("Location: pay.php?file=$filename&invoice=$invoice");
    exit();
} else {
    // echo "Paid";
    header("Location: success.php?file=$filename");
    exit();
}

?>