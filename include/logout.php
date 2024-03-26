<?php
session_start();
unset($_SESSION["loginStatus"]); 
unset($_SESSION['employeeId']);
unset($_SESSION['name']);
header("location: ../");
?>