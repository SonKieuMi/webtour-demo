<?php
session_start();
unset($_SESSION['id_user']);
unset($_SESSION['tendangnhap']);
unset($_SESSION['userrole']);
session_destroy();
header("Location: login.php");
?>