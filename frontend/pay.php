<?php

$temp_dir = "temp/";
$file = $_GET['file'];
$satsProMb = 50;
$fileSize = filesize($temp_dir . $file);
$fileSizeMb = $fileSize / 1000000;
$toPay = round($fileSizeMb * $satsProMb, 0);

echo $toPay;

?>