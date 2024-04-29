<?php

if (isset($_POST["submit"])) {
  
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';
  
  if (emptyInputLogin($email, $password) !== false) {
    header("Location: ../php/index.php?error=emptyinput");
    exit();
  }
  
  loginUser($conn, $email, $password);
} else {
  // Sends user back to index if they didnt access this page through the login button
  header("Location: ../php/index.php");
  exit();
}