<?php

if (isset($_POST["submit"])) {
  
  $email = strtolower($_POST['email']);
  $first_name = ucfirst(strtolower($_POST['first_name']));
  $last_name = ucfirst(strtolower($_POST['last_name']));
  $phone_number = str_replace('-',' ',$_POST['phone_number']);
  $password = $_POST['password'];
  $date = date('Y-m-d H:i:s');
  
  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';
  

  if (emptyInputSignup($email, $first_name, $last_name, $phone_number, $password) !== false) {
    header("Location: ../html/index.php?error=emptyinput");
    exit();
  }

  if (invalidEmail($email) !== false) {
    header("Location: ../html/index.php?error=invalidemail");
    exit();
  }

  if (invalidPhoneNumber($phone_number) !== false) {
    header("Location: ../html/index.php?error=invalidphonenumber");
    exit();
  }
  
  /* Can also add check to see if password is too short and check if first or last name contain any characters other than letters*/

  if (emailExists($conn, $email) !== false) {
    header("Location: ../html/index.php?error=emailtaken");
    exit();
  }
  
  createUser($conn, $email, $first_name, $last_name, $phone_number, $password, $date);
} else {
  // Sends user back to index if they didnt access this page through the signup button
  header("Location: ../html/index.php");
  exit();
}