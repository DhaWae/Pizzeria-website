<?php
function createRating($conn, $user_id, $pizza_id, $comment, $rating, $date) {
  $rated = hasRated($conn, $user_id, $pizza_id);
  

  if ($rating > 5 || $rating < 1) {
    header("Location: ../php/index.php?error=yourenotthatguy");
    exit();
  }
  

  if ($rated) {
    $sql = "UPDATE ginos_pizza_ratings SET user_id = ?, pizza_id = ?, comment = ?, rating = ?, rating_date = ? WHERE user_id = $user_id AND pizza_id = $pizza_id;";

  } else {
    $sql = "INSERT INTO ginos_pizza_ratings (user_id, pizza_id, comment, rating, rating_date) VALUES (?, ?, ?, ?, ?);";
    //echo "<script>console.log('You have not rated this pizza before!')</script>";
  }

  //$sql = "INSERT INTO ginos_pizza_ratings (user_id, pizza_id, comment, rating, rating_date) VALUES (?, ?, ?, ?, ?);";  
  
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../php/index.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "iisis", $user_id, $pizza_id, $comment, $rating, $date);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  calculateAverageRating($conn, $pizza_id);
  header("Location: ../php/menu.php?error=none&rating=success& '$rated'");
  
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

$ratings = array();

function getAllRatings() {
  global $ratings;
  include '../includes/dbh.inc.php';

  // Check if the connection is successful
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "SELECT id, ROUND(COALESCE(avg_rating, 0), 1) as avg_rating, COUNT(rating) as rating_count FROM ginos_pizza_information LEFT JOIN ginos_pizza_ratings ON ginos_pizza_information.id = ginos_pizza_ratings.pizza_id GROUP BY id";

  // Use prepared statement
  $stmt = mysqli_prepare($conn, $sql);

  // Check if the prepared statement was successful
  if (!$stmt) {
      die("Prepared statement failed: " . mysqli_error($conn));
  }

  // Execute the prepared statement
  mysqli_stmt_execute($stmt);

  // Get result set
  $result = mysqli_stmt_get_result($stmt);

  // Check if there are any rows in the result set
  if (mysqli_num_rows($result) > 0) {
      // Fetch each row and store the pizza ID, average rating, and rating count in the array
      while ($row = mysqli_fetch_assoc($result)) {
          $pizzaId = $row['id'];
          $rating = $row['avg_rating'];
          $ratingCount = $row['rating_count'];

          // Check if the pizza ID already exists in the array
          if (array_key_exists($pizzaId, $ratings)) {
              // If it exists, append the new rating and rating count to the existing array
              $ratings[$pizzaId]['ratings'][] = $rating;
              $ratings[$pizzaId]['rating_count'] = $ratingCount;
          } else {
              // If it doesn't exist, create a new array for the pizza ID
              $ratings[$pizzaId] = (object) array(
                  'pizza_id' => $pizzaId,
                  'avg_rating' => $rating,
                  'rating_amount' => $ratingCount
              );
          }
      }

      // Close the result set
      mysqli_free_result($result);
  }

  // Close the prepared statement
  mysqli_stmt_close($stmt);



  // Output the ratings to the console
  echo '<script>console.log(' . json_encode($ratings) . ')</script>';
}


function getAverageRating($pizza_id) {
  global $ratings;

  // Check if the pizza ID exists in the $ratings array
  if (array_key_exists($pizza_id, $ratings)) {
      // Retrieve the average rating from the object
      $avgRating = $ratings[$pizza_id]->avg_rating;

      // Convert the average rating to a percentage (assuming 1 = 20%, 5 = 100%)
      $percentage = ($avgRating / 5) * 100;

      // Round the result to 1 decimal place
      return round($percentage, 1);
  } else {
      // If the pizza ID is not found, return null (or any default value)
      return 0;
  }
}

function getRatingAmount($pizza_id) {
  global $ratings;

  // Check if the pizza ID exists in the $ratings array
  if (array_key_exists($pizza_id, $ratings)) {
      // Retrieve the rating amount from the object
      $ratingAmount = $ratings[$pizza_id]->rating_amount;

      return $ratingAmount;
  } else {
      return null;
  }
}

$tetimonials = array();
function getRandomTestimonials() {
  include 'dbh.inc.php';

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "SELECT first_name, last_name, rating, comment, CONCAT(MAX(pizza_id), '. ', name) AS pizza_name
          FROM ginos_pizza_ratings
          JOIN ginos_user_information ON ginos_user_information.id = user_id
          JOIN ginos_pizza_information ON ginos_pizza_information.id = pizza_id
          WHERE comment != ''
          GROUP BY first_name
          ORDER BY RAND()
          LIMIT 3;";

  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
      die("Prepared statement failed: " . mysqli_error($conn));
  }
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  $cards = array();  

  if (mysqli_num_rows($result) > 0) {
      $i = 1;
      while ($row = mysqli_fetch_assoc($result)) {
         
          $row['rating_percentage'] = ($row['rating']) * 20;
          $cards["card_$i"] = $row;
          $i++;
      }
      mysqli_free_result($result);
  }

  mysqli_stmt_close($stmt);

  list($card_1, $card_2, $card_3) = $cards;

  echo '<script>console.log(' . json_encode($cards) . ')</script>';
  return $cards;
}

function hasRated($conn, $user_id, $pizza_id) {
  
  $sql = "SELECT * FROM ginos_pizza_ratings WHERE user_id = ? AND pizza_id = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../php/index.php?error=stmtfailed");
    exit();
  }
  
  mysqli_stmt_bind_param($stmt, "ii", $user_id, $pizza_id);
  mysqli_stmt_execute($stmt);
  
  $resultData = mysqli_stmt_get_result($stmt);
  $rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

  mysqli_stmt_close($stmt);
  echo '<script>console.log(' . json_encode($rows) . ')</script>';
  echo '<script>console.log(' . count($rows) . ')</script>';  
  if(count($rows) > 0) {
    return True;
  } else {
    return False;
  }
}



