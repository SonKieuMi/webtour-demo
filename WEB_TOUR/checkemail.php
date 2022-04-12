<?php
include 'includes/userHandler.php';
$email = $_POST["email"];
$uhd = new userHandler();
$checkEmail = $uhd->checkEmail($email);
$resultCheck = mysqli_fetch_row ($checkEmail);
if($resultCheck) {
  echo "true";
}
else {
  echo "false";
}
?>