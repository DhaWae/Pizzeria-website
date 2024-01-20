<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <link rel="stylesheet" href="../css/menu.css" />
  <link rel="stylesheet" href="../css/ratingModal.css" />
  <script src="../js/scripts.js" defer></script>
  <script src="../js/builder.js" defer></script>
  <script src="../js/ratingModal.js" defer></script>
</head>

<?php
  session_start();
  echo '<script>console.log(' . json_encode($_SESSION) . ')</script>';

  include_once 'ratingModal.php'; 

  $ratings = array();
  getAllRatings();

  function getAllRatings() {
      global $ratings;
      include_once '../includes/dbh.inc.php';

      // Check if the connection is successful
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT id, ROUND(COALESCE(avg_rating, 0), 1) as avg_rating FROM ginos_pizza_information";
      $result = mysqli_query($conn, $sql);

      // Check if the query was successful
      if (!$result) {
          die("Query failed: " . mysqli_error($conn));
      }

      // Check if there are any rows in the result set
      if (mysqli_num_rows($result) > 0) {
          // Fetch each row and store the pizza ID and rating in the array
          while ($row = mysqli_fetch_assoc($result)) {
              $pizzaId = $row['id'];
              $rating = $row['avg_rating'];

              // Check if the pizza ID already exists in the array
              if (array_key_exists($pizzaId, $ratings)) {
                  // If it exists, append the new rating to the existing array
                  $ratings[$pizzaId][] = $rating;
              } else {
                  // If it doesn't exist, create a new array for the pizza ID
                  $ratings[$pizzaId] = array($rating);
              }
          }

          // Close the result set
          mysqli_free_result($result);

          // Output the ratings to the console
          echo '<script>console.log(' . json_encode($ratings) . ')</script>';
      }

      // Close the database connection
      mysqli_close($conn);
  }

  function getAverageRating($pizza_id) {
      global $ratings;

      // Check if the pizza ID exists in the ratings array
      if (array_key_exists($pizza_id, $ratings)) {
          // Calculate the average rating for the specified pizza ID
          $averageRating = array_sum($ratings[$pizza_id]) / count($ratings[$pizza_id]);

          // Calculate the percentage (assuming 5 = 100% and 0 = 0%)
          $percentage = ($averageRating / 5) * 100;

          // Return the calculated percentage rounded to two decimal places
          return round($percentage, 2);
      } else {
          // No ratings found for the given pizza ID
          return 0;
      }
  }
?>

<body>
<nav class="navbar">
  <a href="index.html" class="mobile-logo"><div class="mobile-logo nav-logo-shadows">Gino's</div></a>
  <ul>
    <a href="index.html#find-us" id="find-us-btn"><li>Find Us</li></a>
    <span class="divider"></span>
    <a href="menu.html"><li>Gino's Menu</li></a>
    <a href="index.html#top"><li id="logo-nav" style="width: 200px;"><div id="nav-logo" class="nav-logo-shadows">Gino's</div></li></a>
    <a href="builder.html"><li>Pizza Builder</li></a>
    <span class="divider"></span>
    <a href="index.html#about-us" id="about-us-btn"><li>About Us</li></a>
  </ul>
  <button class="hamburger">
    <div class="bar"></div>
  </button>
</nav>
<nav class="mobile-nav">
  <div class="nav-links"></div>
  <a href="index.html#find-us">Find Us</a>
  <a href="menu.html">Gino's Menu</a>
  <a href="builder.html">Pizza Builder</a>
  <a href="index.html#about-us">About Us</a>
</nav>
  
<main>
<?php
  function getStars($numStars = 5) {
    $stars = '';
    for ($i = 0; $i < $numStars; $i++) {
      $stars .= '<img src="../assets/menu/star-filled.png" alt="star">';
    }
    return $stars;
  }
  function getEmptyStars($numStars = 5) {
    $stars = '';
    for ($i = 0; $i < $numStars; $i++) {
      $stars .= '<img src="../assets/menu/star-empty.png" alt="star">';
    }
    return $stars;
  }

  
?>
<table id="pizzas">
  <thead>
    <tr>
      <th>Nr</th>
      <th>Pizzas</th>
      <th>Contents</th>
      <th></th>
      <th></th>
      <th>($)</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $pizzaData = array(
        array(1, 'Margarita', 'Tomato, Cheese', 9),
        array(2, 'Vesuvio', 'Ham', 9),
        array(3, 'Fungi', 'Mushrooms', 10),
        array(4, 'Pescatore', 'Tuna', 10),
        array(5, 'Vegetariana', 'Bell pepper, Onion, Mushrooms', 10),
        array(6, 'Capricciosa', 'Ham, Mushrooms', 10),
        array(7, 'Mama Mia', 'Minced meat, Bell pepper', 10),
        array(8, 'La Peiotre', 'Minced meat, Pineapple', 10),
        array(9, 'Hawaii', 'Ham, Pineapple', 12),
        array(10, 'Al Capone', 'Bacon, Onion', 12)
      );

      foreach ($pizzaData as $pizza) {
        echo '<tr>';
        echo '<td>' . $pizza[0] . '</td>';
        echo '<td>' . $pizza[1] . '</td>';
        echo '<td>' . $pizza[2] . '</td>';
        if(isset($_SESSION['user_id'])) {
          echo '<td><img   class ="rating-button" src="../assets/menu/rate.png" width=32px height=32px></td>';
        } else {
          echo '<td></td>';
        }
        echo '<td><div class="star-wrapper"><div class="stars filled" style="width:'.getAverageRating($pizza[0]).'%">' . getStars() . '</div><div class="stars empty">' . getEmptyStars() . '</div></div></td>';
        
        echo '<td>' . $pizza[3] . '</td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
<table id="pizzas-baked-in">
  <thead>
    <tr>
      <th>Nr</th>
      <th>Baked in</th>
      <th>Contents</th>
      <th></th>
      <th></th>
      <th>($)</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $pizzaData = array(
        array(11, 'Calzone', 'Ham', 11),
        array(12, 'La Bussola', 'Ham, Shrimp', 11),
        array(13, 'Milano', 'Ham, Shrimp, Mushrooms', 11),
        array(14, 'Capri', 'Ham, Mushrooms', 11),
        array(15, 'Maestro', 'Chicken, Jalapeno', 12)
      );

      foreach ($pizzaData as $pizza) {
        echo '<tr>';
        echo '<td>' . $pizza[0] . '</td>';
        echo '<td>' . $pizza[1] . '</td>';
        echo '<td>' . $pizza[2] . '</td>';

        if(isset($_SESSION['user_id'])) {
          echo '<td><img   class ="rating-button" src="../assets/menu/rate.png" width=32px height=32px></td>';
        } else {
          echo '<td></td>';
        }
        
        echo '<td><div class="star-wrapper"><div class="stars filled" style="width:'.getAverageRating($pizza[0]).'%">' . getStars() . '</div><div class="stars empty">' . getEmptyStars() . '</div></div></td>';
        echo '<td>' . $pizza[3] . '</td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
<table id="rolls">
  <thead>
    <tr>
      <th>Nr</th>
      <th>Rolls</th>
      <th>Contents</th>
      <th></th>
      <th></th>
      <th>($)</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $pizzaData = array(
        array(16, 'Kebab', 'Kebab, Salad, Dressing, Onion', 15),
        array(17, 'Chicken', 'Chicken, Salad, Dressing, Onion', 15),
        array(18, 'Beef filet', 'Beef filet, Salad, Dressing, Onion', 15),
        array(19, 'Salami', 'Salami, Salad, Dressing, Onion', 15),
        array(20, 'Suovas', 'Suovas, Salad, Dressing, Onion', 15)
      );

      foreach ($pizzaData as $pizza) {
        echo '<tr>';
        echo '<td>' . $pizza[0] . '</td>';
        echo '<td>' . $pizza[1] . '</td>';
        echo '<td>' . $pizza[2] . '</td>';
        if(isset($_SESSION['user_id'])) {
          echo '<td><img   class ="rating-button" src="../assets/menu/rate.png" width=32px height=32px></td>';
        } else {
          echo '<td></td>';
        }
        echo '<td><div class="star-wrapper"><div class="stars filled" style="width:'.getAverageRating($pizza[0]).'%">' . getStars() . '</div><div class="stars empty">' . getEmptyStars() . '</div></div></td>';
        echo '<td>' . $pizza[3] . '</td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</main>
<?php
  
  echo '<script>console.log(' . getAverageRating(1) . ')</script>';
  

?>
</body>
</html>