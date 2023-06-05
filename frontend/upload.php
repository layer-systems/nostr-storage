<?php
$target_dir = "file/";
$temp_dir = "temp/";
$uploadOk = 1;
$fileNeedsPayment = 0;
$maxFreeSize = 100000; // 0.1MB
$maxSize = 1000000000; // 1000MB
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Hash the file for the filename
// $file_hash = md5($_FILES["fileToUpload"]["name"]);
$file_hash = hash_file('sha256', $_FILES["fileToUpload"]["tmp_name"]);
$target_file = $target_dir . $file_hash . "." . $imageFileType;

// Check if file already exists
if (file_exists($target_file)) {
  $fileUrl = "https://".$_SERVER['SERVER_NAME']."/file/".$file_hash . "." . $imageFileType;
  // echo $fileUrl;
  header('Location: '.$fileUrl);
  exit();
  $uploadOk = 0;
}

// Check file size
// if ($_FILES["fileToUpload"]["size"] > 50000000) { // 50MB
if ($_FILES["fileToUpload"]["size"] > $maxFreeSize) {
  $fileNeedsPayment = 1;
}
if ($_FILES["fileToUpload"]["size"] > $maxSize) { // 1000MB
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "ogg" && $imageFileType != "webm" ) {
  echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, OGG and WebM files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  // echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if($fileNeedsPayment == 1) {
    // echo "Sorry, your file is too large. Please pay to upload this file.";
    // Move file to a temp folder and redirect user to pay page
    $target_file = $temp_dir . $file_hash . "." . $imageFileType;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      // Redirect user to pay page
      header('Location: https://'.$_SERVER['SERVER_NAME'].'/pay.php?file='.$file_hash . "." . $imageFileType);
    }
    exit();
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $fileUrl = "https://".$_SERVER['SERVER_NAME']."/file/".$file_hash . "." . $imageFileType;
      // echo $fileUrl;
      header('Location: '.$fileUrl);
      exit();
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>