<?php
function uploadFile($target_file) {
  $uploadOk = 1;
  $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  // Check if file already exists
  if (file_exists($target_file)) {
    phpAlert("Sorry, file already exists.");
    $uploadOk = 0;
  }
  
  // Check file size
  if ($_FILES["fileInput"]["size"] > 500000) {
    phpAlert("Sorry, your file is too large.");
    $uploadOk = 0;
  }
  
  if($fileType == "") {
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    phpAlert("Sorry, your file".$target_file." was not uploaded.");
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
      phpAlert("The file has been uploaded.");
    } else {
      phpAlert("Sorry, there was an error uploading your file.");
    }
  }
  return $uploadOk;
}
?>
