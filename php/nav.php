<body>
<?php
  if (isset($_GET['error'])) {
    if ($_GET['error'] == "emptyinput") {
      echo "<p style='color:white;'>Fill in all fields!</p>";
    } else if ($_GET['error'] == "invalidemail") {
      echo "<p style='color:white;'>Invalid email!</p>";
    } else if ($_GET['error'] == "invalidphonenumber") {
      echo "<p style='color:white;'>Invalid phone number!</p>";
    } else if ($_GET['error'] == "emailtaken") {
      echo "<p style='color:white;'>Email already taken!</p>";
    } else if ($_GET['error'] == "stmtfailed") {
      echo "<p style='color:white;'>Something went wrong, try again!</p>";
    } else if ($_GET['error'] == "wronglogin") {
      echo "<p style='color:white;'>Incorrect login information!</p>";
    } else if ($_GET['error'] == "none") {
      echo "<p style='color:white;'>You have signed up!</p>";
    }}
?>

<nav class="navbar">
  <a href="index.html" class="mobile-logo"><div class="mobile-logo nav-logo-shadows">Gino's</div></a>
  <ul>
    <a onclick="scrollToElement('find-us')" id="find-us-btn"><li>Find Us</li></a>
    <span class="divider"></span>
    <a href="menu.html"><li>Gino's Menu</li></a>
    <a href="#top"><li id="logo-nav" style="width: 200px;"><div id="nav-logo" class="nav-logo-shadows">Gino's</div></li></a>
    <a href="builder.html"><li>Pizza Builder</li></a>
    <span class="divider"></span>
    <a onclick="scrollToElement('about-us')" id="about-us-btn"><li>About Us</li></a>
  </ul>

  <button class="hamburger">
    <div class="bar"></div>
  </button>
</nav>

<nav class="mobile-nav">
  <div class="nav-links"></div>
  <a onclick="scrollToElement('find-us')">Find Us</a>
  <a href="menu.html">Gino's Menu</a>
  <a href="builder.html">Pizza Builder</a>
  <a onclick="scrollToElement('about-us')">About Us</a>
</nav>

<dialog data-register-modal id="register-modal">
  <div><h1 class="text-shadow">Come onboard!</h1></div>
  <form method="post" action="../includes/signup.inc.php">

    <div class="inputs register-inputs">
      <input type="email" placeholder="Email" name="email"/>
      <input type="text" placeholder="First Name" id="first-name" name="first_name"/>
      <input type="text" placeholder="Last Name" id="last-name" name="last_name"/>
      <input type="tel" placeholder="Phone Number" id="phone-number" name="phone_number"/>
      <input type="password" placeholder="Password" id="password1" name="password"/>
    </div>
    
    <button type="submit" name="submit" id="confirmRegistrationBtn">Register</button>
  </form>
</dialog>

<div class="login-container">
  <div class="login-background" data-login-background></div>
  <dialog data-modal id="login-modal">
    <div><h1 class="text-shadow">Gino's</h1></div>
    <form method="post" action="../includes/login.inc.php">
      <div class="inputs">
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="Password" id="password"/>
      </div>
      
      <div id="submitBtns">
        <button type="submit" name="submit" class="submitBtn">Login</button>
        <button type="button" data-open-register-modal id="registerBtn">Register</button>
      </div>
    </form>
    <a href id="guestBtn"><p>or continue as guest</p></a>
    
  </dialog>
  <div class="info-box" data-info-box style="color:white;">This is an information box</div>  
</div>

<div class="profile-container">
  <div class="profile-wrapper">
    <div class="avatar">
      <!--<img src="../assets/avatar.png" alt="avatar" width="60px" height="60px">-->
      <div class="circle"></div>
      <div class="name-letter">
        <?php
          if(isset($_SESSION['user_id'])) {
            $user = $_SESSION['first_name'];
            $firstLetter = substr($user, 0, 1);
            echo "<p class='name'>$firstLetter<p>";
          } else {
            echo "<p style='color:white; font-family: Inter;'>Guest<p>";
          }
        ?>
      </div>
    </div>
    
    <?php
      if(isset($_SESSION['user_id'])) {
        $user = $_SESSION['first_name'];
        echo "<a class='w60' href='../includes/logout.inc.php'><button class='logoutBtnNav'>Logout</button></a>";
      } else {
        echo "<button data-open-modal class='loginBtnNav'>Login</button>";
      }
    ?>
  </div>
  
</div>