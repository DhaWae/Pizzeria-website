<?php /*
  $email = $_POST['email'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $phone_number = $_POST['phone_number'];
  $password = $_POST['password'];
  $date = date('Y-m-d H:i:s');

  $link = mysqli_connect("localhost", "root", "", "test");

  $sql = "INSERT INTO ginos_customer_information (email, first_name, last_name, phone_number, password, registration_date) VALUES ('$email', '$first_name', '$last_name', '$phone_number', '$password', '$date')";
  mysqli_query($link, $sql);
  if(mysqli_error($link)) {
    echo mysqli_error($link);
    header("Location: ../html/index.php?reg=failed");
  }
  session_start();
  $_SESSION['reg'] = "success";
  $_SESSION['user'] = $first_name;
  
  header("Location: ../html/index.php?reg=success");
*/?>

