<?php
$uploadOk = 1;
$target_dir = "../../upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
/*$myfile = fopen("getRate.php", "r") or die("Unable to open file!");
$target_file = $target_dir . substr(fgets($myfile),4) . ".bin";
fclose($myfile);*/
if(isset($_POST["version"]) && strlen($_POST["version"])==4)
  $target_file = $target_dir . $_POST["version"] . ".bin";
else
  $uploadOk = 0;


// Check if file already exists
if (file_exists($target_file)) {
  echo "Same firmware version already exist.\n";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 200000) {
  echo "Sorry, your file is too large.\n";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "bin") {
  echo "Sorry, only BIN files are allowed.\n";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  //echo "Sorry, your file was not uploaded.";
  echo "$$0";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
	echo "$$1";
  } else {
    //echo "Sorry, there was an error uploading your file.";
	echo "Something missing$$0";
  }
}
?>