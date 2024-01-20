<?php

function emptyInputSignup($email, $first_name, $last_name, $phone_number, $password) {
  $result = null;
  // Note empty() returns true if the value is 0, so we need to check for empty string like on pass if we want to allow 0 when registering
  
  if (empty($email) || empty($first_name) || empty($last_name) || empty($phone_number) || $password === "") {
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
    header("Location: ../php/index.php?error=stmtfailed");
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
    header("Location: ../php/index.php?error=stmtfailed");
    exit();
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "ssssss", $email, $first_name, $last_name, $phone_number, $hashed_password, $date);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("Location: ../php/index.php?error=none&register=success");
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
    header("Location: ../php/index.php?error=wronglogin");
    
    exit();
  }

  $hashed_password = $emailExists["password"];
  $checkPassword = password_verify($password, $hashed_password);

  if ($checkPassword === false) {
    header("Location: ../php/index.php?error=wronglogin");

    //echo $emailExists["email"];
    //echo "Password verification failed. Input password: $password, Hashed password: $hashed_password";
    exit();
  } else if ($checkPassword === true) {
    session_start();
    $_SESSION["user_id"] = $emailExists["id"];
    $_SESSION["email"] = $emailExists["email"];
    $_SESSION["first_name"] = $emailExists["first_name"];
    $_SESSION["last_name"] = $emailExists["last_name"];
    $_SESSION["phone"] = $emailExists["phone"];
    $_SESSION["registration_date"] = $emailExists["registration_date"];
    header("Location: ../php/index.php?error=none&login=success");
    exit();
  }
}

function createRating($conn, $user_id, $pizza_id, $comment, $rating, $date) {
  $sql = "INSERT INTO ginos_pizza_ratings (user_id, pizza_id, comment, rating, rating_date) VALUES (?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../php/index.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "iisis", $user_id, $pizza_id, $comment, $rating, $date);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  calculateAverageRating($conn, $pizza_id);
  header("Location: ../php/menu.php?error=none&rating=success");
  exit();
}

function calculateAverageRating($conn, $pizza_id){

  // Fetch all ratings for the given pizza ID
  $sql = "SELECT rating FROM ginos_pizza_ratings WHERE pizza_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  
  // Bind the pizza ID parameter
  mysqli_stmt_bind_param($stmt, "i", $pizza_id);
  
  // Execute the query
  mysqli_stmt_execute($stmt);
  
  // Get the result set
  $result = mysqli_stmt_get_result($stmt);

  // Check if there are any ratings
  if (mysqli_num_rows($result) > 0) {
      $totalRating = 0;
      $numRatings = 0;

      // Calculate the total rating and count the number of ratings
      while ($row = mysqli_fetch_assoc($result)) {
          $totalRating += $row['rating'];
          $numRatings++;
      }

      // Calculate the average rating
      $averageRating = $numRatings > 0 ? round($totalRating / $numRatings, 1) : 0;

      // Update the ginos_pizza_information table with the average rating
      $updateSql = "UPDATE ginos_pizza_information SET avg_rating = ? WHERE id = ?";
      $updateStmt = mysqli_prepare($conn, $updateSql);

      // Bind parameters for the update query
      mysqli_stmt_bind_param($updateStmt, "di", $averageRating, $pizza_id);

      // Execute the update query
      mysqli_stmt_execute($updateStmt);

      // Close the statements
      mysqli_stmt_close($stmt);
      mysqli_stmt_close($updateStmt);

      // Return the calculated average rating
      return $averageRating;
  } else {
      // No ratings found for the given pizza ID
      return 0;
  }

}