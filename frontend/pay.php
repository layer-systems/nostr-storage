<?php

$temp_dir = "temp/";

$file = $_GET['file'];

$fileSize = filesize($temp_dir . $file);

echo $fileSize;

?>