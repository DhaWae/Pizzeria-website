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

  $sql = "SELECT rating FROM ginos_pizza_ratings WHERE pizza_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  
  mysqli_stmt_bind_param($stmt, "i", $pizza_id);
  
  mysqli_stmt_execute($stmt);
  
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
      $totalRating = 0;
      $numRatings = 0;

      while ($row = mysqli_fetch_assoc($result)) {
          $totalRating += $row['rating'];
          $numRatings++;
      }

      $averageRating = $numRatings > 0 ? round($totalRating / $numRatings, 1) : 0;

      $updateSql = "UPDATE ginos_pizza_information SET avg_rating = ? WHERE id = ?";
      $updateStmt = mysqli_prepare($conn, $updateSql);

      mysqli_stmt_bind_param($updateStmt, "di", $averageRating, $pizza_id);

      mysqli_stmt_execute($updateStmt);

      mysqli_stmt_close($stmt);
      mysqli_stmt_close($updateStmt);

      return $averageRating;
  } else {
      return 0;
  }

}

$ratings = array();

function getAllRatings() {
  global $ratings;
  include '../includes/dbh.inc.php';

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "SELECT id, ROUND(COALESCE(avg_rating, 0), 1) as avg_rating, COUNT(rating) as rating_count FROM ginos_pizza_information LEFT JOIN ginos_pizza_ratings ON ginos_pizza_information.id = ginos_pizza_ratings.pizza_id GROUP BY id";

  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
      die("Prepared statement failed: " . mysqli_error($conn));
  }

  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $pizzaId = $row['id'];
          $rating = $row['avg_rating'];
          $ratingCount = $row['rating_count'];

          if (array_key_exists($pizzaId, $ratings)) {
              $ratings[$pizzaId]['ratings'][] = $rating;
              $ratings[$pizzaId]['rating_count'] = $ratingCount;
          } else {
              $ratings[$pizzaId] = (object) array(
                  'pizza_id' => $pizzaId,
                  'avg_rating' => $rating,
                  'rating_amount' => $ratingCount
              );
          }
      }
      mysqli_free_result($result);
  }
  mysqli_stmt_close($stmt);

  echo '<script>console.log(' . json_encode($ratings) . ')</script>';
}


function getAverageRating($pizza_id) {
  global $ratings;

  if (array_key_exists($pizza_id, $ratings)) {
  
      $avgRating = $ratings[$pizza_id]->avg_rating;

      $percentage = $avgRating * 20;

      return round($percentage, 1);
  } else {
      return 0;
  }
}

function getRatingAmount($pizza_id) {
  global $ratings;

  if (array_key_exists($pizza_id, $ratings)) {
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



