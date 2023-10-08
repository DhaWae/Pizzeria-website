<?php

function emptyInputSignup($email, $first_name, $last_name, $phone_number, $password) {
  $result = null;
  if (empty($email) || empty($first_name) || empty($last_name) || empty($phone_number) || empty($password)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidEmail($email) {
  $result = null;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidPhoneNumber($phoneNumber) {
  $result = null;

  // Remove any spaces or other characters
  $cleanedPhoneNumber = preg_replace('/[^0-9\-]/', '', $phoneNumber);
  
  if ($cleanedPhoneNumber !== $phoneNumber) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function emailExists($conn, $email) {
  // ? is a placeholder for the email, prevents SQL injection (prepared statements)
  $sql = "SELECT * FROM ginos_user_information WHERE email = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../html/index.php?error=stmtfailed");
    exit();
  }
  
  // s means string "ss" would mean two strings
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  } else {
    $result = false;
    return $result;
  }

  mysqli_stmt_close($stmt);
}

function createUser($conn, $email, $first_name, $last_name, $phone_number, $password, $date) {
  $sql = "INSERT INTO ginos_user_information (email, first_name, last_name, phone, password, registration_date) VALUES (?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../html/index.php?error=stmtfailed");
    exit();
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "ssssss", $email, $first_name, $last_name, $phone_number, $hashed_password, $date);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("Location: ../html/index.php?error=none");
  exit();
}

function emptyInputLogin($email, $password) {
  $result = null;
  if (empty($email) || empty($password)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function loginUser($conn, $email, $password) {
  $emailExists = emailExists($conn, $email);

  if ($emailExists === false) {
    header("Location: ../html/index.php?error=wronglogin");
    
    exit();
  }

  $hashed_password = $emailExists["password"];
  $checkPassword = password_verify($password, $hashed_password);

  if ($checkPassword === false) {
    //header("Location: ../html/index.php?error=wronglogin");

    echo $emailExists["email"];
    echo "Password verification failed. Input password: $password, Hashed password: $hashed_password";
    exit();
  } else if ($checkPassword === true) {
    session_start();
    $_SESSION["user_id"] = $emailExists["id"];
    $_SESSION["email"] = $emailExists["email"];
    $_SESSION["first_name"] = $emailExists["first_name"];
    $_SESSION["last_name"] = $emailExists["last_name"];
    $_SESSION["phone"] = $emailExists["phone"];
    $_SESSION["registration_date"] = $emailExists["registration_date"];
    header("Location: ../html/index.php");
    exit();
  }
}