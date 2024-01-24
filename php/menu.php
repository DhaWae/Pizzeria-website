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
  <link rel="stylesheet" href="../css/testimonial-slider.css" />
  <script src="../js/scripts.js" defer></script>
  <script src="../js/builder.js" defer></script>
  <script src="../js/ratingModal.js" defer></script>
</head>

<?php
  session_start();
  echo '<script>console.log(' . json_encode($_SESSION) . ')</script>';

  include_once 'ratingModal.php'; 
  include_once '../includes/rating.functions.inc.php';
  
  getAllRatings();
  getRandomTestimonials();
  
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
      <th class="rating-amount-th"></th>
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
        echo '<td class="rating-amount-td"><div class="rating-amount-label">('.getRatingAmount($pizza[0]).')</div></td>';
        echo '<td class="star-td"><div class="star-wrapper"><div class="stars filled" style="width:'.getAverageRating($pizza[0]).'%">' . getStars() . '</div><div class="stars empty">' . getEmptyStars() . '</div></div></td>';
        
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
      <th>Bakedin</th>
      <th>Contents</th>
      <th></th>
      <th class="rating-amount-th"></th>
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
        echo '<td class="rating-amount-td"><div class="rating-amount-label">('.getRatingAmount($pizza[0]).')</div></td>';
        echo '<td class="star-td"><div class="star-wrapper"><div class="stars filled" style="width:'.getAverageRating($pizza[0]).'%">' . getStars() . '</div><div class="stars empty">' . getEmptyStars() . '</div></div></td>';
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
      <th class="rating-amount-th"></th>
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
        echo '<td class="rating-amount-td"><div class="rating-amount-label">('.getRatingAmount($pizza[0]).')</div></td>';
        echo '<td class="star-td"><div class="star-wrapper"><div class="stars filled" style="width:'.getAverageRating($pizza[0]).'%">' . getStars() . '</div><div class="stars empty">' . getEmptyStars() . '</div></div></td>';
        echo '<td>' . $pizza[3] . '</td>';
        echo '</tr>';
      }
    ?>
  </tbody>
</table>
</main>
<?php
  
  echo '<script>console.log(' . getAverageRating(1) . ')</script>';
  
  include_once 'testimonial-slider.php';
?>

</body>
</html>