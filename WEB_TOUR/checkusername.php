<?php
include 'includes/userHandler.php';
$username = $_POST["username"];
$uhd = new userHandler();
$checkUsername = $uhd->checkUsername($username);
$resultChecks = mysqli_fetch_row($checkUsername);
if($resultChecks) {
  echo "true";
}
else {
  echo "false";
}
?>